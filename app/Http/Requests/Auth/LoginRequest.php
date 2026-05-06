<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $supabaseUrl = config('services.supabase.url', env('SUPABASE_URL'));
        $supabaseKey = config('services.supabase.key', env('SUPABASE_KEY'));

        if (!$supabaseUrl || !$supabaseKey) {
            throw ValidationException::withMessages([
                'email' => 'Supabase credentials are not configured.',
            ]);
        }

        $response = \Illuminate\Support\Facades\Http::withHeaders([
            'apikey' => $supabaseKey,
            'Authorization' => 'Bearer ' . $supabaseKey,
        ])->post("{$supabaseUrl}/auth/v1/token?grant_type=password", [
            'email' => $this->email,
            'password' => $this->password,
        ]);

        if ($response->failed()) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => $response->json('error_description', trans('auth.failed')),
            ]);
        }

        $authData = $response->json();
        $userId = $authData['user']['id'] ?? null;

        if (!$userId) {
             throw ValidationException::withMessages([
                'email' => 'Failed to retrieve user data from Supabase.',
            ]);
        }

        $profile = \App\Models\Profile::find($userId);

        if (!$profile) {
             throw ValidationException::withMessages([
                'email' => 'User profile not found in database.',
            ]);
        }

        Auth::login($profile, $this->boolean('remember'));

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')).'|'.$this->ip());
    }
}
