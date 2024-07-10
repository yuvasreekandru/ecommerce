<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = "categories";

    static public function getSingle($id)
    {
        return self::find($id);
    }
    static public function getRecord()
    {
        return self::select('categories.*', 'users.name as created_by_name')
            ->join('users', 'users.id', '=', 'categories.created_by')
            ->where('categories.is_delete', '=', 0)
            ->orderBy('categories.id', 'desc')
            ->get();
    }
    static public function getRecordActive()
    {
        return self::select('categories.*')
            ->join('users', 'users.id', '=', 'categories.created_by')
            ->where('categories.is_delete', '=', 0)
            ->where('categories.status', '=', 0)
            ->orderBy('categories.name', 'asc')
            ->get();
    }
    static public function getRecordMenu()
    {
        return self::select('categories.*')
            ->join('users', 'users.id', '=', 'categories.created_by')
            ->where('categories.is_delete', '=', 0)
            ->where('categories.status', '=', 0)
            ->get();
    }

    public function getSubCategory()
    {
        return $this->hasMany(SubCategory::class, "category_id")
            ->where('sub_categories.status', '=', 0)
            ->where('sub_categories.is_delete', '=', 0);
    }

}
