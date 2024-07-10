<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Product;
use App\Models\Brand;
use Str;

class BrandController extends Controller
{
    public function list()
    {
        $data['getRecord'] = Brand::getRecord();
        $data['header_title'] = "Brand";
        return view("admin.brand.list", $data);
    }
    public function add()
    {
        $data['header_title'] = "Add New Brand";
        return view("admin.brand.add", $data);
    }
    public function insert(Request $req)
    {
        request()->validate([
            'slug' => 'required|unique:brands',
        ]);
        $brand = New Brand();
        $brand->name = trim($req->name);
        $brand->slug = trim($req->slug);
        $brand->status = trim($req->status);
        $brand->meta_title = trim($req->meta_title);
        $brand->meta_description = trim($req->meta_description);
        $brand->meta_keywords = trim($req->meta_keywords);
        $brand->created_by = Auth::user()->id;
        $brand->save();
        return redirect('admin/brand/list')->with("success","Brand successfully created");
    }

    public function edit($id)
    {
        $data['getRecord'] = Brand::getSingle($id);
        $data['header_title'] = "Edit Brand";
        return view("admin.brand.edit", $data);
    }

    public function update($id, Request $req)
    {
        request()->validate([
            'slug' => 'required|unique:brands,slug,'.$id,
        ]);
        $brand = Brand::getSingle($id);
        $brand->name = trim($req->name);
        $brand->slug = trim($req->slug);
        $brand->status = trim($req->status);
        $brand->meta_title = trim($req->meta_title);
        $brand->meta_description = trim($req->meta_description);
        $brand->meta_keywords = trim($req->meta_keywords);
        $brand->save();

        return redirect('admin/brand/list')->with("success","Brand successfully updated");
    }
    public function delete($id)
    {
        $brand = Brand::getSingle($id);
        $brand->is_delete = 1;
        $brand->save();
        return redirect()->back()->with("success","Brand successfully deleted");
    }
}
