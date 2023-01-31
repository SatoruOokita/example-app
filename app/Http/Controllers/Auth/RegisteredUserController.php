<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

// テキストp183の内容
use App\Mail\NewUserIntroduction;
use Illuminate\Contracts\Mail\Mailer;

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
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request, Mailer $mailer): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        // メールの送信処理を追加(p184)
        // $mailer->to('test@example.com')
        //     ->send(new NewUserIntroduction());

        // 登録済みのユーザーを取得して、全員にメールを送る処理を追加(p185)
        $allUser = User::get();
        foreach ($allUser as $user) {
            $mailer->to($user->email)
                ->send(new NewUserIntroduction());
        }

        return redirect(RouteServiceProvider::HOME);
    }
}