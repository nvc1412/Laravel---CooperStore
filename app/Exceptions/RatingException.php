<?php

namespace App\Exceptions;

use Exception;

class RatingException extends Exception
{
    protected $message = "Bạn đã đánh giá sản phẩm này! Bạn chỉ được đánh giá 1 lần duy nhất!";
}