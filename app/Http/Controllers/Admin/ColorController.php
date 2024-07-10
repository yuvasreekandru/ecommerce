<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Color;

use Str;

class ColorController extends Controller
{
    public function list()
    {
        $data['getRecord'] = Color::getRecord();
        $data['header_title'] = "Color";
        return view("admin.color.list", $data);
    }
    public function add()
    {
        $data['header_title'] = "Add New Color";
        return view("admin.color.add", $data);
    }
    public function insert(Request $req)
    {

        $color = New Color();
        $color->name = trim($req->name);
        $color->code = trim($req->code);
        $color->status = trim($req->status);
        $color->created_by = Auth::user()->id;
        $color->save();
        return redirect('admin/color/list')->with("success","Color successfully created");
    }

    public function edit($id)
    {
        $data['getRecord'] = Color::getSingle($id);
        $data['header_title'] = "Edit Color";
        return view("admin.color.edit", $data);
    }

    public function update($id, Request $req)
    {

        $color = Color::getSingle($id);
        $color->name = trim($req->name);
        $color->code = trim($req->code);
        $color->status = trim($req->status);
        $color->save();

        return redirect('admin/color/list')->with("success","Color successfully updated");
    }
    public function delete($id)
    {
        $color = Color::getSingle($id);
        $color->is_delete = 1;
        $color->save();
        return redirect()->back()->with("success","Color successfully deleted");
    }
}
