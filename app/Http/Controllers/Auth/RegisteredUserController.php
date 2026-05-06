<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $supabaseUrl = config('services.supabase.url', env('SUPABASE_URL'));
        $supabaseKey = config('services.supabase.key', env('SUPABASE_KEY'));

        if (!$supabaseUrl || !$supabaseKey) {
            throw ValidationException::withMessages([
                'email' => 'Supabase credentials are not configured.',
            ]);
        }

        $response = Http::withHeaders([
            'apikey' => $supabaseKey,
            'Authorization' => 'Bearer ' . $supabaseKey,
        ])->post("{$supabaseUrl}/auth/v1/signup", [
            'email' => $request->email,
            'password' => $request->password,
            'data' => [
                'full_name' => $request->full_name,
            ]
        ]);

        if ($response->failed()) {
            throw ValidationException::withMessages([
                'email' => $response->json('msg', 'Registration failed.'),
            ]);
        }

        $authData = $response->json();
        $userId = $authData['user']['id'] ?? null;

        if (!$userId) {
            throw ValidationException::withMessages([
                'email' => 'Failed to retrieve user ID from Supabase.',
            ]);
        }

        // Delay slightly to ensure trigger completes
        usleep(500000); 

        $profile = Profile::find($userId);

        if (!$profile) {
            // Fallback if trigger didn't run
            $profile = Profile::create([
                'id' => $userId,
                'full_name' => $request->full_name,
                'role' => 'customer'
            ]);
        }

        Auth::login($profile);

        return redirect(route('dashboard', absolute: false));
    }
}
