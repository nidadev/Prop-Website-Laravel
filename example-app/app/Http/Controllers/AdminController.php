<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function index()
    {
        $stats = ['Registered users' => User::count(), 'Paid users' => DB::table('payments')->where('payment_status', 'paid')->where('amount', '>', 0)->distinct()->count('user_id'),
            'Generated reports' => DB::table('price_reports')->count() + DB::table('price_house_reports')->count() + DB::table('land_valuations')->count() + DB::table('comp_searches')->count(),
            'Completed exports' => DB::table('exports')->where('status', 'completed')->count()];
        $users = User::orderByDesc('id')->paginate(30);
        $settings = DB::table('site_settings')->pluck('value', 'key');
        $plans = app(\App\Services\PricingCatalog::class)->plans();
        return view('admin', compact('stats', 'users', 'settings', 'plans'));
    }

    public function importComparables(Request $request)
    {
        $request->validate(['file' => 'required|file|mimes:csv,txt|max:10240', 'data_rights' => 'accepted']);
        $exit = \Illuminate\Support\Facades\Artisan::call('comparables:import', ['file' => $request->file('file')->getRealPath()]);
        $message = trim(\Illuminate\Support\Facades\Artisan::output());
        return back()->with($exit === 0 ? 'success' : 'error', $message);
    }

    public function createUser(Request $request)
    {
        $data = $request->validate(['name' => 'required|string|max:255', 'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:12|max:255']);
        User::create($data);
        return back()->with('success', 'User created. Email verification is required before accessing property services.');
    }

    public function updateUser(Request $request, User $user)
    {
        $data = $request->validate(['name' => 'required|string|max:255', 'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'is_banned' => 'required|boolean']);
        abort_if($data['is_banned'] && ($user->id === auth()->id() || $user->usertype === 'admin'), 422, 'Administrator accounts cannot be banned here.');
        if ($user->email !== $data['email']) { $user->forceFill(['is_verified' => 0, 'email_verified_at' => null]); }
        $user->forceFill($data)->save();
        return back()->with('success', 'User updated.');
    }

    public function settings(Request $request)
    {
        $data = $request->validate(['contact_email' => 'nullable|email|max:255', 'contact_phone' => 'nullable|string|max:100',
            'contact_address' => 'nullable|string|max:500', 'seo_title' => 'nullable|string|max:100',
            'seo_description' => 'nullable|string|max:300', 'copyright' => 'nullable|string|max:255',
            'map_embed_url' => 'nullable|url:https|max:2000',
            'coverage_embed_url' => 'nullable|url:https|max:2000', 'market_ratio_embed_url' => 'nullable|url:https|max:2000',
            'youtube_embed_url' => 'nullable|url:https|max:1000',
            'research_embed_url' => 'nullable|url:https|max:2000',
            'hero_image' => 'nullable|string|max:200']);
        foreach (['research_embed_url', 'coverage_embed_url', 'market_ratio_embed_url'] as $embedKey) {
        if (!empty($data[$embedKey])) {
            abort_unless(strtolower(parse_url($data[$embedKey], PHP_URL_HOST)) === 'public.tableau.com'
                && str_starts_with(parse_url($data[$embedKey], PHP_URL_PATH) ?? '', '/views/'), 422, 'Use a Tableau Public view URL.');
        }}
        if (!empty($data['youtube_embed_url'])) {
            abort_unless(in_array(strtolower(parse_url($data['youtube_embed_url'], PHP_URL_HOST)), ['www.youtube.com', 'www.youtube-nocookie.com'], true)
                && preg_match('~^/embed/[A-Za-z0-9_-]{11}$~', parse_url($data['youtube_embed_url'], PHP_URL_PATH) ?? ''), 422, 'Use a YouTube video embed URL.');
        }
        if (!empty($data['hero_image'])) {
            abort_unless(preg_match('~^img/[A-Za-z0-9 _.-]+\.(jpg|jpeg|png|webp)$~i', $data['hero_image'])
                && !str_contains($data['hero_image'], '..') && is_file(public_path($data['hero_image'])), 422, 'Choose an existing image in the img directory.');
        }
        if (!empty($data['map_embed_url'])) {
            $host = strtolower(parse_url($data['map_embed_url'], PHP_URL_HOST));
            abort_unless(in_array($host, ['www.google.com', 'maps.google.com'], true) && str_starts_with(parse_url($data['map_embed_url'], PHP_URL_PATH) ?? '', '/maps'), 422, 'Use a Google Maps embed URL.');
        }
        DB::transaction(function () use ($data) {
            foreach ($data as $key => $value) { DB::table('site_settings')->updateOrInsert(['key' => $key], ['value' => $value, 'updated_at' => now(), 'created_at' => now()]); }
        });
        return back()->with('success', 'Site details saved.');
    }

    public function pricing(Request $request)
    {
        $rules = [];
        foreach (array_keys(config('pricing.plans')) as $key) { $rules['plan_'.$key] = ['required', 'numeric', 'min:1', 'max:10000', 'regex:/^\d+(\.\d{1,2})?$/']; }
        foreach (array_keys(config('pricing.services')) as $key) { $rules['service_'.$key] = ['required', 'numeric', 'min:0.01', 'max:100', 'regex:/^\d+(\.\d{1,2})?$/']; }
        $data = $request->validate($rules);
        DB::transaction(function () use ($data) {
            // Lock the existing price catalog to serialize concurrent edits.
            DB::table('plan_price_versions')->lockForUpdate()->get();
            foreach (config('pricing.plans') as $key => $plan) {
                DB::table('plan_price_versions')->where('plan', $key)->update(['active' => false]);
                DB::table('plan_price_versions')->updateOrInsert(['plan' => $key, 'amount' => (int) round($data['plan_'.$key] * 100), 'interval' => $plan['interval']],
                    ['active' => true, 'updated_at' => now(), 'created_at' => now()]);
            }
            foreach (array_keys(config('pricing.services')) as $key) {
                DB::table('site_settings')->updateOrInsert(['key' => 'price_'.$key], ['value' => (string) round($data['service_'.$key] * 100), 'created_at' => now(), 'updated_at' => now()]);
            }
        });
        return back()->with('success', 'Prices updated for new checkouts. Existing subscriptions keep their agreed price.');
    }
}
