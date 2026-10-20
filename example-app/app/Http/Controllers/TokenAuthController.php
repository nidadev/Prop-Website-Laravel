<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class TokenAuthController extends Controller {
    public function login(Request $request) {
        $data = $request->validate(['email' => 'required|email', 'password' => 'required|string']);
        $user = User::where('email', $data['email'])->first();
        abort_unless($user && !$user->is_banned && Hash::check($data['password'], $user->password), 401, 'Unable to sign in.');
        return $this->issue($user);
    }
    public function refresh(Request $request) {
        $token = $request->user()->currentAccessToken();
        abort_unless($token instanceof \Laravel\Sanctum\PersonalAccessToken, 401);
        $token->delete();
        return $this->issue($request->user());
    }
    public function logout(Request $request) {
        $token = $request->user()->currentAccessToken();
        if ($token instanceof \Laravel\Sanctum\PersonalAccessToken) { $token->delete(); }
        return response()->json(['message' => 'Signed out.']);
    }
    private function issue(User $user) {
        return response()->json(['token' => $user->createToken('propelyze', ['profile:read', 'profile:write', 'property:read'], now()->addDay())->plainTextToken,
            'token_type' => 'Bearer', 'expires_in' => 86400]);
    }
}
