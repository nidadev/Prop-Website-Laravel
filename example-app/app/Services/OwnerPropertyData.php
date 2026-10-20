<?php
namespace App\Services;
use Illuminate\Support\Facades\Http;

class OwnerPropertyData
{
    public function fetch(string $apn, string $fips): array
    {
        if (!config('property.datatree_enabled') || !config('app.client_id') || !config('app.client_secret')) {
            throw new \RuntimeException('Property data access is unavailable.');
        }
        $login = Http::connectTimeout(10)->timeout(30)->acceptJson()->post(DataTreeEndpoint::url('Login/AuthenticateClient'), [
            'ClientId' => config('app.client_id'), 'ClientSecretKey' => config('app.client_secret'),
        ])->throw()->json();
        if (!is_string($login) || $login === '') { throw new \RuntimeException('Invalid provider authentication response.'); }
        $client = Http::connectTimeout(10)->timeout(45)->acceptJson()->withToken($login);
        $lookup = $client->post(DataTreeEndpoint::url('Report/GetReport'), [
            'ProductNames' => ['PropertyDetailReport'], 'SearchType' => 'APN',
            'ApnDetail' => ['APN' => $apn, 'StateFips' => substr($fips, 0, 2), 'CountyFips' => $fips],
        ])->throw()->json();
        $id = data_get($lookup, 'LitePropertyList.0.PropertyId') ?? data_get($lookup, 'Reports.0.PropertyId') ?? data_get($lookup, 'Reports.0.Data.SubjectProperty.PropertyId');
        if (!is_scalar($id) || !preg_match('/^\d+$/', (string) $id)) { throw new \RuntimeException('No matching property returned.'); }
        $payload = $client->post(DataTreeEndpoint::url('Report/GetReport'), [
            'ProductNames' => ['TotalViewReport'], 'SearchType' => 'PROPERTY', 'PropertyId' => (string) $id,
        ])->throw()->json();
        $data = data_get($payload, 'Reports.0.Data');
        if (!is_array($data) || !is_array($data['SubjectProperty'] ?? null) || empty($data['SubjectProperty']['SitusAddress'])) {
            throw new \RuntimeException('Property details were not supplied.');
        }
        $returnedApn = data_get($data, 'SubjectProperty.SitusAddress.APN');
        if (!is_scalar($returnedApn) || trim((string) $returnedApn) === '' || strtolower(preg_replace('/[^a-z0-9]/i', '', (string) $returnedApn)) !== strtolower(preg_replace('/[^a-z0-9]/i', '', $apn))) {
            throw new \RuntimeException('The provider returned a different parcel.');
        }
        $returnedState = data_get($data, 'SubjectProperty.SitusAddress.State');
        $expectedState = config('counties.'.$fips.'.state');
        if (is_scalar($returnedState) && $expectedState && strtolower(trim((string) $returnedState)) !== strtolower($expectedState)) {
            throw new \RuntimeException('The provider returned a different state.');
        }
        $scalar = fn ($path) => is_scalar(data_get($data, $path)) ? (string) data_get($data, $path) : null;
        return [
            'property_id' => (string) $id, 'source' => 'DataTree', 'retrieved_at' => now()->toIso8601String(),
            'address' => $scalar('SubjectProperty.SitusAddress.StreetAddress'), 'city' => $scalar('SubjectProperty.SitusAddress.City'),
            'state' => $scalar('SubjectProperty.SitusAddress.State'), 'zip' => $scalar('SubjectProperty.SitusAddress.Zip9'),
            'owner_name' => $scalar('OwnerInformation.Owner1FullName'), 'owner_2' => $scalar('OwnerInformation.Owner2FullName'),
            'mailing_address' => $scalar('OwnerInformation.MailingAddress.StreetAddress'), 'mailing_city' => $scalar('OwnerInformation.MailingAddress.City'),
            'mailing_state' => $scalar('OwnerInformation.MailingAddress.State'), 'mailing_zip' => $scalar('OwnerInformation.MailingAddress.Zip9'),
            'assessed_value' => $scalar('TaxInformation.AssessedValue') ?? $scalar('TaxStatusData.Taxes.AssessedValue'),
            'tax_market_value' => $scalar('TaxInformation.MarketValue'), 'tax_land_value' => $scalar('TaxInformation.MarketLandValue'),
            'tax_details' => $this->flatten($data['TaxInformation'] ?? $data['TaxStatusData'] ?? []),
            'property_details' => $this->flatten($data['SubjectProperty'] ?? []),
        ];
    }
    private function flatten(array $data, string $prefix = '', int $depth = 0): array
    {
        if ($depth > 5) { return []; }
        $out = [];
        foreach (array_slice($data, 0, 100, true) as $key => $value) {
            $name = $prefix.(string) $key;
            if (is_array($value)) { $out += $this->flatten($value, $name.' / ', $depth + 1); }
            elseif (is_scalar($value) && (string) $value !== '') { $out[$name] = mb_substr((string) $value, 0, 1000); }
            if (count($out) >= 200) { break; }
        }
        return $out;
    }
}
