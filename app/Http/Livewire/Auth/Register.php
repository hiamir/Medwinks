<?php

namespace App\Http\Livewire\Auth;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Component;

class Register extends Component
{
    public $name, $email,$password,$password_confirmation;


    protected $messages = [
        'name.required' => 'The Name cannot be empty.',
        'name.string' => 'The Name must be a string.',
        'name.max' => 'The Name cannot exceed more than 255 characters.',
        'email.required' => 'The Email Address cannot be empty.',
        'email.string' => 'The Email must be a string.',
        'email.max' => 'The Email cannot exceed more than 255 characters.',
        'email.email' => 'The Email Address format is not valid.',
        'email.unique' => 'This Email Address already exists!.',
        'password.required' => 'The Password cannot be empty.',
        'password.confirmed' => 'The two Password do not match.',
    ];

    public function register()
    {

        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);
        $user->assignRole('user');
        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
    public function render()
    {
        return view('livewire.auth.register')->layout('layouts.guest');
    }
}
