<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Product;
use App\Models\Color;
use App\Models\ProductColor;
use App\Models\Brand;
use App\Models\ProductSize;
use App\Models\ProductImage;




use Str;


class ProductController extends Controller
{
    public function list()
    {
        $data['getRecord'] = Product::getRecord();
        $data['header_title'] = "Product";
        return view("admin.product.list", $data);
    }
    public function add()
    {
        // $data['getCategory'] = Category::getRecord();
        $data['header_title'] = "Add New Product";
        return view("admin.product.add", $data);
    }
    public function insert(Request $req)
    {
        // request()->validate([
        //     'slug' => 'required|unique:sub_categories',
        // ]);

        $title = trim($req->title);

        $product = new Product();
        $product->title = $title;
        $product->created_by = Auth::user()->id;
        $product->save();
        $slug = Str::slug($title,"-");

        $chckSlug = Product::checkSlug($slug);
        if(empty($chckSlug))
        {
            $product->slug = $slug;
            $product->save();
        }
        else
        {
            $new_slug = $slug."-".$product->id;
            $product->slug = $new_slug;
            $product->save();
        }

        return redirect('admin/product/list')->with("success","Product successfully created");
    }

    public function edit($product_id)
    {
        $product = Product::getSingle($product_id);
        if(!empty($product))
        {
            $data['getCategory'] = Category::getRecordActive();
            $data['getBrand'] = Brand::getRecordActive();
            $data['getColor'] = Color::getRecordActive();

            $data['product'] = $product;

            $data['getSubCategory'] = SubCategory::getRecordSubCategory($product->category_id);

            $data['header_title'] = "Edit Product";
            return view("admin.product.edit", $data);
        }
    }

    public function update($product_id, Request $req)
    {

        $product = Product::getSingle($product_id);
        if(!empty($product))
        {

            $product->title = trim($req->title);
            $product->sku = trim($req->sku);
            $product->category_id = trim($req->category_id);
            $product->sub_category_id = trim($req->sub_category_id);
            $product->brand_id = trim($req->brand_id);
            $product->price = trim($req->price);
            $product->old_price = trim($req->old_price);
            $product->short_description = trim($req->short_descriptiodescription);
            $product->description = trim($req->description);
            $product->additional_information = trim($req->additional_information);
            $product->shipping_returns = trim($req->shipping_returns);
            $product->status = trim($req->status);
            $product->save();

            ProductColor::deleteRecord($product->id);

            if(!empty($req->color_id))
            {
                foreach ($req->color_id as $color_id)
                {
                    $color = new ProductColor();
                    $color->color_id = $color_id;
                    $color->product_id = $product_id;
                    $color->save();
                }
            }
            ProductSize::deleteRecord($product->id);

            if(!empty($req->size))
            {
                foreach ($req->size as $size)
                {
                    if(!empty($size["name"]))
                    {
                        $saveSize = new ProductSize();
                        $saveSize->name = $size['name'];
                        $saveSize->price = !empty($size['price']) ? $size['price'] : 0;
                        $saveSize->product_id = $product->id;
                        $saveSize->save();
                    }

                }
            }

            if(!empty($req->file('image')))
            {
                foreach($req->file('image') as $value)
                {
                    if($value->isValid())
                    {
                        $ext = $value->getClientOriginalExtension();
                        $randomStr = $product->id .Str::random(20);
                        $filename = strtolower($randomStr) .'.'. $ext;
                        $value->move('upload/product/', $filename);

                        $imageupload = new ProductImage();
                        $imageupload->image_name = $filename;
                        $imageupload->image_extension = $ext;
                        $imageupload->product_id = $product->id;
                        $imageupload->save();
                    }
                }
            }


            return redirect()->back()->with("success","Product successfully updated");

        }
        else
        {
            abort(404);
        }


    }
    public function delete($id)
    {
        $sub_category = SubCategory::getSingle($id);
        $sub_category->is_delete = 1;
        $sub_category->save();
        return redirect()->back()->with("success","Sub Category successfully deleted");
    }

    public function image_delete($id)
    {
        $image = ProductImage::getSingle($id);
        if(!empty($image->getLogo()))
        {
            unlink('upload/product/'.$image->image_name);
        }
        $image->delete();
        return redirect()->back()->with('success','Product successfully deleted');
    }

    public function product_image_sortable(Request $req)
    {
        if(!empty($req->photo_id))
        {
            $i = 1;
            foreach($req->photo_id as $photo_id)
            {
                $image = ProductImage::getSingle($photo_id);
                $image->order_by = $i;
                $image->save();
                $i++;
            }
        }
        $json['success'] = true;
        echo json_encode($json);
    }
}
