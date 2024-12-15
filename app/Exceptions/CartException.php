<?php

namespace App\Exceptions;

use Exception;

class CartException extends Exception
{
    protected $message = 'Sản phẩm không có trong giỏ hàng!';
}