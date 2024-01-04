<?php

namespace App\Helper;

use App\Models\Seo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class tubuHelper
{

    public static function dateParse($date, $format = '')
    {
        $date = Carbon::parse($date, 'Europe/Istanbul');
        if ($format) {
            return $date->format($format);
        }
        return $date;
    }

    public static function seoreplacer($word)
    {
        $replace = str_replace(
            ['Ç', 'ç', 'Ğ', 'ğ', 'İ', 'ı', 'Ö', 'ö', 'Ş', 'ş', 'Ü', 'ü', ' '],
            ['c', 'c', 'g', 'g', 'i', 'i', 'o', 'o', 's', 's', 'u', 'u', '-'], $word);
        return strtolower($replace);
    }

    public static function mobileNullChecker($datas)
    {
        foreach ($datas as $index => $data) {
            $datas[$index]->rating = $datas[$index]->rating == null ? 0 : $datas[$index]->rating;
            $datas[$index]->currency = $datas[$index]->currency == null ? '₺' : $datas[$index]->currency;
            $datas[$index]->last_login = $datas[$index]->last_login == null ? '' : $datas[$index]->last_login;
            $datas[$index]->seo = $datas[$index]->seo == null ? ' ' : $datas[$index]->seo;
            $datas[$index]->username = $datas[$index]->username == null ? ' ' : $datas[$index]->username;
        }
        return $datas;
    }

    public static function currency($currency = 'try')
    {
        $connect_web = simplexml_load_file('http://www.tcmb.gov.tr/kurlar/today.xml');
        $cur = [];
        $cur['₺'] = 1;
        $cur['$'] = $connect_web->Currency[0]->BanknoteSelling;
        $cur['€'] = $connect_web->Currency[3]->BanknoteSelling;
        return (float)$cur[$currency];
    }

    public static function smsSend($message, $phones, $header = '')
    {
        $phones = trim(str_replace(' ', '', $phones));
        $xml = '<?xml version="1.0" encoding="UTF-8"?>
                <mainbody>
                    <header>
                        <company dil="TR">' . Config::get('isim.netgsm.username') . '</company>
                        <usercode>' . Config::get('isim.netgsm.username') . '</usercode>
                        <password>' . Config::get('isim.netgsm.password') . '</password>
                        <type>1:n</type>
                        <msgheader>' . (empty($header) ? Config::get('isim.netgsm.title') : $header) . '</msgheader>
                    </header>
                    <body>
                        <msg><![CDATA[' . $message . ']]></msg>
                        <no>' . $phones . '</no>
                    </body>
                </mainbody>';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.netgsm.com.tr/sms/send/xml');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: text/xml"));
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        $result = curl_exec($ch);
        \DB::table('sms')->insert([
            'phone' => $phones,
            'message' => $message,
            'response' => (string)$result,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $is_error = false;
        if ($result) {
            if (substr($result, 0, 2) != "00") {
                $is_error = true;
            }
        } else {
            $is_error = true;
        }
        if ($is_error) {
            try {
                if (strlen($phones) == 10 || strlen($phones) == 11) {
                    TelegramBotProvider::_send('<b>SMS GÖNDERİMİNDE HATA</b>' . $result . "\n<b>Mesaj:</b> $message \n<b>Numara:</b> $phones\n $result");
                }
            } catch (\Exception $e) {
            }
        }
        return $result;
    }

    public static function smsBalance($stip = 1)
    {
        //stip:1 kalan paket bilgisi | stip:2 kalan bakiye
        $xml = '<?xml version="1.0"?>
                <mainbody>
                    <header>
                        <usercode>8503029428</usercode>
                        <password>Q5DSYFBE</password>
                        <stip>' . $stip . '</stip>
                    </header>
                </mainbody>';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.netgsm.com.tr/balance/list/xml');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: text/xml"));
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        $result = curl_exec($ch);

        return $result;
    }

    public static function mathProggress($small, $big): int
    {
        return ($small / $big) * 100;;
    }


    protected function _getBase32LookupTable(): array
    {
        return array(
            'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', //  7
            'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', // 15
            'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', // 23
            'Y', 'Z', '2', '3', '4', '5', '6', '7', // 31
            '='  // padding char
        );
    }


    public static function makerDater($date)
    {
        return empty($date) ? '2022-05-01 00:00' : date('Y-m-d H:i:s', strtotime($date));
    }

    public static function parentCatter($catid, $advert_id)
    {
        if ($catid == 0) {
            return false;
        } else {
            DB::table('advert_to_category')->insert(['advert_id' => $advert_id, 'category_id' => $catid]);
            $parent_id = DB::table('category')->where("id", $catid)->first(['id', 'parent_id']);
            if ($parent_id) {
                IDHelper::parentCatter($parent_id->parent_id, $advert_id);
                echo ($parent_id->id) . ",";
            } else {
                return false;
            }
        }
    }

    public static function confirmationStatusHtml($name, $value)
    {
        return '<select class="form-control" name="confirmation[' . $name . '][status]"><option value="0" ' . ($value == 0 ? 'selected' : '') . '>Beklemede</option><option value="1" ' . ($value == 1 ? 'selected' : '') . '>Onaylı</option><option value="2" ' . ($value == 2 ? 'selected' : '') . '>Red</option></select>';
    }

    public static function htmlCleaner($content)
    {
        $content = strip_tags($content);
        $content = str_replace("&rsquo;", "'", $content);
        $content = preg_replace("/&#?[a-z0-9]{2,8};/i", "", $content);
        return $content;
    }


    public static function langSaver($instance, $parentid, $request, $seomodule = null)
    {
        // $modelName = "App\Models\\" . $model;
        foreach (Config::get('mersin.langs') as $lCode => $vvvv) {
            // $instance = new $modelName();
            if ($seomodule) {
                $keyword = $request[$lCode]['meta_seo'];
                $keyword = empty($keyword) ? $request[$lCode]['meta_title'] . '-' . time() : $keyword;
                unset($request[$lCode]['meta_seo']);
                Seo::addseo($seomodule, $parentid, $keyword, $lCode);
            }

            $instance->updateOrCreate(['lang' => $lCode, 'parent_id' => $parentid], $request[$lCode]);

        }

    }
}


