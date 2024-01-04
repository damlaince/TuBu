<?php

namespace App\Helper;

use App\Models\Seo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class tubuHelper
{


    public static function seoreplacer($word)
    {
        $replace = str_replace(
            ['Ç', 'ç', 'Ğ', 'ğ', 'İ', 'ı', 'Ö', 'ö', 'Ş', 'ş', 'Ü', 'ü', ' '],
            ['c', 'c', 'g', 'g', 'i', 'i', 'o', 'o', 's', 's', 'u', 'u', '-'], $word);
        return strtolower($replace);
    }






}


