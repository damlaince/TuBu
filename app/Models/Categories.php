<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;

    protected $table = 'categories';
    protected $guarded = [];

    public function seo() {
        return $this->hasOne(Seo::class, 'item_id', '_id');
    }

    public function childs()
    {
        return $this->hasMany(self::class, 'parent_id', 'id')->with(['seo']);
    }

    public static function altcategories($id) {
        $categories = Categories::where('parent_id', '!=', 0)->where('parent_id', $id)->where('status', 1)->get(['_id']);
        $altcategory_id = [];
        foreach ($categories as $category) {
            $altcategory_id[] = $category->_id;
        }

        return $altcategory_id;
    }

}
