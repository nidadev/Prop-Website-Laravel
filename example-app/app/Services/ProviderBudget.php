<?php
namespace App\Services;
use Illuminate\Support\Facades\DB;
class ProviderBudget {
    public function period(): string {
        $date=now()->utc();
        if ($date->day < (int) config('prycd.billing_anchor_day',3)) { $date->subMonthNoOverflow(); }
        return $date->format('Y-m');
    }
    public function remaining(string $service): int {
        $used=DB::table('provider_usage')->where('service',$service)->where('period',$this->period())->value('requests');
        return max(0,(int) config('prycd.'.$service.'_request_limit')-(int)($used ?? config('prycd.'.$service.'_initial_usage',0)));
    }
    public function exhausted(string $service): void {
        DB::table('provider_usage')->updateOrInsert(['service'=>$service,'period'=>$this->period()],
            ['requests'=>(int)config('prycd.'.$service.'_request_limit'),'created_at'=>now(),'updated_at'=>now()]);
    }
    public function reserve(string $service): void {
        $period=$this->period();
        DB::table('provider_usage')->insertOrIgnore(['service'=>$service,'period'=>$period,
            'requests'=>(int)config('prycd.'.$service.'_initial_usage',0),'created_at'=>now(),'updated_at'=>now()]);
        $reserved=DB::table('provider_usage')->where('service',$service)->where('period',$period)
            ->where('requests','<',(int)config('prycd.'.$service.'_request_limit'))->increment('requests',1,['updated_at'=>now()]);
        if (!$reserved) { throw new \RuntimeException('The data allowance is used for this billing period. Contact support before placing an order.'); }
    }
}
