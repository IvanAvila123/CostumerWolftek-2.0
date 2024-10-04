<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Fortify;

class AuthenticateUser
{
    public function __invoke($request)
    {
        Validator::make($request->all(), [
            Fortify::username() => 'required|string',
            'password' => 'required|string',
        ])->validate();

        $user = User::where(Fortify::username(), $request->{Fortify::username()})->first();

        if ($user &&
            Hash::check($request->password, $user->password) &&
            $user->is_active
        ) {
            return $user;
        }

        if ($user && !$user->is_active) {
            throw ValidationException::withMessages([
                Fortify::username() => __('Su usuario está desactivado. Favor de hablar con el administrador.'),
            ]);
        }

        throw ValidationException::withMessages([
            Fortify::username() => __('Las credenciales proporcionadas son incorrectas.'),
        ]);
    }
}
