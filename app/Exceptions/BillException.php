<?php

namespace App\Exceptions;

use Exception;

class BillException extends Exception
{
    protected $message = 'Không tìm thấy đơn hàng của bạn!';
}