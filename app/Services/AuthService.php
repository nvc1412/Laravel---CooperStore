<?php

namespace App\Services;

use App\Exceptions\AccountActiveException;
use App\Exceptions\AdminRoleException;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function login($data)
    {
        if (!auth()->attempt($data)) {
            throw ValidationException::withMessages([
                'password' => ['Mật khẩu không chính xác!'],
            ]);
        }

        if (!isAdmin()) {
            auth()->logout();
            throw new AdminRoleException();
        }

        if (!isActive()) {
            auth()->logout();
            throw new AccountActiveException();
        }

        return true;
    }
}