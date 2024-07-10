<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\SubCategory;


class SubCategoryController extends Controller
{
    public function list()
    {
        $data['getRecord'] = SubCategory::getRecord();
        $data['header_title'] = "Sub Category";
        return view("admin.sub_category.list", $data);
    }
    public function add()
    {
        $data['getCategory'] = Category::getRecord();
        $data['header_title'] = "Add New Sub Category";
        return view("admin.sub_category.add", $data);
    }
    public function insert(Request $req)
    {
        request()->validate([
            'slug' => 'required|unique:sub_categories',
        ]);
        $sub_category = New SubCategory();
        $sub_category->category_id = trim($req->category_id);
        $sub_category->name = trim($req->name);
        $sub_category->slug = trim($req->slug);
        $sub_category->status = trim($req->status);
        $sub_category->meta_title = trim($req->meta_title);
        $sub_category->meta_description = trim($req->meta_description);
        $sub_category->meta_keywords = trim($req->meta_keywords);
        $sub_category->created_by = Auth::user()->id;
        $sub_category->save();

        return redirect('admin/sub_category/list')->with("success","Sub Category successfully created");
    }

    public function edit($id)
    {
        $data['getCategory'] = Category::getRecord();
        $data['getRecord'] = SubCategory::getSingle($id);
        $data['header_title'] = "Edit Sub Category";
        return view("admin.sub_category.edit", $data);
    }

    public function update($id, Request $req)
    {
        request()->validate([
            'slug' => 'required|unique:sub_categories,slug,'.$id,
        ]);
        $sub_category = SubCategory::getSingle($id);
        $sub_category->category_id = trim($req->category_id);
        $sub_category->name = trim($req->name);
        $sub_category->slug = trim($req->slug);
        $sub_category->status = trim($req->status);
        $sub_category->meta_title = trim($req->meta_title);
        $sub_category->meta_description = trim($req->meta_description);
        $sub_category->meta_keywords = trim($req->meta_keywords);
        $sub_category->save();

        return redirect('admin/sub_category/list')->with("success","Sub Category successfully updated");
    }
    public function delete($id)
    {
        $sub_category = SubCategory::getSingle($id);
        $sub_category->is_delete = 1;
        $sub_category->save();
        return redirect()->back()->with("success","Sub Category successfully deleted");
    }

    public function get_sub_category(Request $req)
    {
        $category_id = $req->id;
        $get_sub_category = SubCategory::getRecordSubCategory($category_id);
        $html = '';
        $html .= '<option value="">Select</option>';

        foreach ($get_sub_category as $value)
        {
            $html .= '<option value="'.$value->id.'">'.$value->name.'</option>';

        }

        $json['html'] = $html;
        echo json_encode($json);
    }

}
