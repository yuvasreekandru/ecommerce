<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = "products";

    static public function getSingle($id)
    {
        return self::find($id);
    }

    static public function getRecord()
    {
        return self::select('products.*', 'users.name as created_by_name')
            ->join('users', 'users.id', '=', 'products.created_by')
            ->where('products.is_delete', '=', 0)
            ->orderBy('products.id', 'desc')
            ->paginate(20);

    }

    static public function checkSlug($slug)
    {
        return self::where("slug", "=", $slug)->count();
    }

    public function getColor()
    {
        return $this->hasMany(ProductColor::class, "product_id");
    }

    public function getSize()
    {
        return $this->hasMany(ProductSize::class, "product_id");
    }
    public function getImage()
    {
        return $this->hasMany(ProductImage::class, "product_id")->orderBy('order_by', 'asc');
    }

}
