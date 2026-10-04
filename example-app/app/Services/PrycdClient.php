<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class PrycdClient
{
    public function priceLand(string $apn, string $countyFips): array
    {
        Validator::make(['apn' => $apn, 'county_fips' => $countyFips], [
            'apn' => 'required|string|max:100', 'county_fips' => ['required', 'regex:/^\d{5}$/'],
        ])->validate();
        $data = $this->request('prycd-pricing.p.rapidapi.com', '/priceProperty', ['apn' => $apn, 'county_fips' => $countyFips]);
        $pricing = $data['pricing'] ?? [];
        if (($data['apn'] ?? '') !== $apn || !is_numeric($pricing['price'] ?? null) || $pricing['price'] <= 0) {
            throw new \RuntimeException('The provider did not return a verified price for this APN.');
        }
        return ['market_value' => (float) $pricing['price'],
            'price_per_acre' => is_numeric($pricing['price_per_acre'] ?? null) ? (float) $pricing['price_per_acre'] : null,
            'model' => $pricing['pricing_source'] ?? null, 'confidence' => $pricing['confidence'] ?? null,
            'acres' => is_numeric($pricing['meta']['acreage'] ?? null) ? (float)$pricing['meta']['acreage'] : null,
            'latitude' => $pricing['meta']['latitude'] ?? null, 'longitude' => $pricing['meta']['longitude'] ?? null,
            'source' => 'PRYCD', 'retrieved_at' => $data['_retrieved_at'] ?? now()->toIso8601String()];
    }

    public function countyComps(string $state, string $county, float $minAcres, float $maxAcres): array
    {
        Validator::make(compact('state', 'county', 'minAcres', 'maxAcres'), [
            'state' => 'required|string|max:100', 'county' => 'required|string|max:100',
            'minAcres' => 'required|numeric|min:0', 'maxAcres' => 'required|numeric|gte:minAcres',
        ])->validate();
        $data = $this->request('prycd-comps.p.rapidapi.com', '/compsByCounty', [
            'user_id' => 'propelyze',
            'counties' => [['name' => $county, 'state' => $state]],
            'acreages' => [['min' => $minAcres, 'max' => $maxAcres]],
            'comp_options' => ['remove_duplicates' => true, 'get_historical' => false],
        ]);
        $comps = [];
        foreach ($data['data'] ?? [] as $location) {
            foreach ($location['comps'] ?? [] as $band) {
                foreach ($band['comps'] ?? [] as $comp) {
                    $price = str_replace(['$', ','], '', (string) ($comp['price'] ?? ''));
                    $acres = str_replace(',', '', (string) ($comp['acreage'] ?? ''));
                    if (!is_numeric($price) || $price <= 0 || !is_numeric($acres) || $acres <= 0) { continue; }
                    $comps[] = ['id' => $comp['id'] ?? null, 'price' => (float) $price, 'acres' => (float) $acres,
                        'status' => $comp['status'] ?? null, 'source' => $comp['source'] ?? null,
                        'source_url' => $comp['url'] ?? null, 'address' => $comp['address'] ?? null,
                        'city' => $comp['city'] ?? null, 'latitude' => $comp['latitude'] ?? null,
                        'longitude' => $comp['longitude'] ?? null, 'sold_date' => $comp['sold_date'] ?? null,
                        'updated_date' => $comp['updated_date'] ?? null];
                }
            }
        }
        return $comps;
    }

    private function request(string $host, string $path, array $body): array
    {
        $key = hash('sha256', $host.$path.json_encode($body));
        return \Illuminate\Support\Facades\Cache::lock('prycd-request-'.$key, 90)->block(3,
            fn () => $this->performRequest($host, $path, $body));
    }

    private function performRequest(string $host, string $path, array $body): array
    {
        if (!config('prycd.enabled') || !config('prycd.key')) {
            throw new \RuntimeException('PRYCD API access has not been configured.');
        }
        $cacheKey=hash('sha256',$host.$path.json_encode($body));
        $cached=\Illuminate\Support\Facades\DB::table('provider_responses')->where('cache_key',$cacheKey)->where('expires_at','>',now())->first();
        if ($cached) { return json_decode($cached->payload,true,512,JSON_THROW_ON_ERROR); }
        app(ProviderBudget::class)->reserve(str_contains($host,'pricing')?'pricing':'comps');
        // Do not retry automatically: a retry could consume another paid request.
        $response = Http::timeout(60)->acceptJson()->withHeaders([
            'X-RapidAPI-Key' => config('prycd.key'), 'X-RapidAPI-Host' => $host,
        ])->post('https://'.$host.$path, $body);
        $data = $response->json();
        if (!$response->successful() || !is_array($data) || ($data['status'] ?? null) != 200) {
            throw new \RuntimeException('PRYCD could not supply this result. Please try again later.');
        }
        if (str_contains($host,'pricing') && (($data['apn'] ?? '') !== ($body['apn'] ?? '')
            || !is_numeric($data['pricing']['price'] ?? null) || $data['pricing']['price'] <= 0)) {
            throw new \RuntimeException('The provider did not return a verified price for this APN.');
        }
        $data['_retrieved_at']=now()->toIso8601String();
        \Illuminate\Support\Facades\DB::table('provider_responses')->updateOrInsert(['cache_key'=>$cacheKey],
            ['payload'=>json_encode($data),'expires_at'=>now()->addDays(30),'created_at'=>now(),'updated_at'=>now()]);
        return $data;
    }
}
