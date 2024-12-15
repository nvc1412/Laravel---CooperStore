<?php

namespace App\Exceptions;

use Exception;

class BillPrintException extends Exception
{
    protected $message = 'Vui lòng chọn đơn hàng cần in!';
}