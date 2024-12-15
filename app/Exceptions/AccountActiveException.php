<?php

namespace App\Exceptions;

use Exception;

class AccountActiveException extends Exception
{
    protected $message = 'Tài khoản của bạn đang bị khóa!';
}