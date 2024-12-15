<?php

namespace App\Exceptions;

use Exception;

class AdminRoleException extends Exception
{
    protected $message = 'Tài khoản không có quyền truy cập!';
}