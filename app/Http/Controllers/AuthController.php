<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
    /**
     * Show login form
     *
     * @return string
     */
    public function login(): string
    {
        return view('pages.auth.login')
            ->render();
    }

    /**
     * Show registration form
     *
     * @return string
     */
    public function register(): string
    {
        return view('pages.auth.register')
            ->render();
    }

    /**
     * Handle login
     *
     * @param \App\Http\Requests\LoginRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeLogin(LoginRequest $request): RedirectResponse
    {
        if (auth()->attempt(['email' => $request->email, 'password' => $request->password], true)) {
            return redirect()->route('platform.index');
        }

        return redirect()
            ->back()
            ->with(['error' => trans('login.alerts.wrong_credentials')]);
    }

    /**
     * Handle register
     *
     * @param \App\Http\Requests\RegisterRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeRegister(RegisterRequest $request): RedirectResponse
    {
        try {
            $validated = array_merge($request->validated(), ['role_id' => Role::client()->id]);

            User::query()->create($validated);

            return redirect()
                ->route('platform.index');
        } catch (\Throwable $t) {
            logger()->error($t->getMessage());

            return redirect()
                ->back()
                ->withInput($request->all())
                ->with([
                    'error' => trans('register.alerts.error'),
                ]);
        }
    }
}
