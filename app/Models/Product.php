<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $guarded = [];

    public function category() {
        return $this->hasOne(Categories::class, '_id', 'category_id');
    }

    public function seo() {
        return $this->hasOne(Seo::class, 'item_id', '_id');
    }
}
