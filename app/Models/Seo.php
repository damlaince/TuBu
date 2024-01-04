<?php

namespace App\Models;

use App\Helper\tubuHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class Seo extends Model
{
    use HasFactory;

    protected $table = 'seo';
    protected $guarded = [];

    public static function addseo($id, $module, $keyword) {
        self::where('item_id',$id)->updateOrCreate([
            'item_id' => $id,
            'module' => $module,
            'keyword' => tubuHelper::seoreplacer($keyword).rand(0,100)
        ]);
    }

    public static function categoryid($altcategory, $module) {
        $category_id = Seo::where('module',$module)->where('keyword',$altcategory)->first();

        if (isset($category_id->item_id)) {
            return $category_id->item_id;
        }

    }

    public static function keywordSeo($id, $module) {
        $seo = self::where('module', $module)->where('item_id', $id)->first();

        if (isset($seo->keyword)) {
            return $seo->keyword;
        }
    }


}
