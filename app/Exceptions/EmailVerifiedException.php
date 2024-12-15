<?php

namespace App\Exceptions;

use Exception;

class EmailVerifiedException extends Exception
{
    protected $message = 'Tài khoản chưa được xác thực! Vui lòng kiểm tra email của bạn để xác thực tài khoản!';
}