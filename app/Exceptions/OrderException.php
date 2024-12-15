<?php

namespace App\Exceptions;

use Exception;

class OrderException extends Exception
{
    protected $message = 'Phương thức thanh toán không hợp lệ!';
}