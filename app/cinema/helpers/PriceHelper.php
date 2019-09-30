<?php

namespace cinema\helpers;

class PriceHelper
{
    public static function format($price): string
    {
        return number_format($price, 0, '.', ' ');
    }
} 