<?php

namespace App\Http\Controllers\Auth;

use App\Events\NewUserRegisterEvent;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;

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
    public function store(Request $request): RedirectResponse
    {
        $recaptcha = $request->input('g-recaptcha-response');

        if (is_null($recaptcha)) {
            $request->session()->flash('message', "  Please complete the recaptcha again to proceed. ");
            return redirect()->back();
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            //'g-recaptcha-response' => 'required|captcha',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        event(new NewUserRegisterEvent($user));
        //event(new Registered($user));

        // $role = Role::create(['name' => 'buyer']);
        // $user->assignRole($role);
        

        Auth::login($user);
        


        return redirect(route('dashboard', absolute: false));
    }
}
