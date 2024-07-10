@extends('admin.layouts.app')

@section('style')
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/summernote/summernote-bs4.min.css') }}">
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h1>Edit Product</h1>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">

                        @include('admin.layouts.message')

                        <!-- general form elements -->
                        <div class="card card-primary">
                            <!-- form start -->
                            <form action="" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Title <span style="color: red">*</span></label>
                                                <input type="text" class="form-control"
                                                    value="{{ old('title', $product->title) }}" name="title" required
                                                    placeholder="Title">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>SKU <span style="color: red">*</span></label>
                                                <input type="text" class="form-control"
                                                    value="{{ old('sku', $product->sku) }}" name="sku" required
                                                    placeholder="SKU">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Category Name <span style="color: red">*</span></label>
                                                <select class="form-control" value="" name="category_id"
                                                    id="changeCategory" required placeholder="Category Name">
                                                    <option value="">Select</option>
                                                    @foreach ($getCategory as $category)
                                                        <option
                                                            {{ $product->category_id == $category->id ? 'selected' : '' }}
                                                            value="{{ $category->id }}">{{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Sub Category Name <span style="color: red">*</span></label>
                                                <select class="form-control" value="" name="sub_category_id"
                                                    id="getSubCategory" required placeholder="Sub Category Name">
                                                    <option value="">Select</option>
                                                    @foreach ($getSubCategory as $subcategory)
                                                        <option
                                                            {{ $product->sub_category_id == $subcategory->id ? 'selected' : '' }}
                                                            value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Brand <span style="color: red">*</span></label>
                                                <select class="form-control" value="" name="brand_id" required
                                                    placeholder="Brand Name">
                                                    <option value="">Select</option>
                                                    @foreach ($getBrand as $brand)
                                                        <option {{ $product->brand_id == $brand->id ? 'selected' : '' }}
                                                            value="{{ $brand->id }}">{{ $brand->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Color <span style="color: red">*</span></label>
                                                @foreach ($getColor as $color)
                                                    @php
                                                        $checked = '';
                                                    @endphp
                                                    @foreach ($product->getColor as $pcolor)
                                                        @if ($pcolor->color_id == $color->id)
                                                            @php
                                                                $checked = 'checked';
                                                            @endphp
                                                        @endif
                                                    @endforeach
                                                    <div>
                                                        <label><input {{ $checked }} type="checkbox" name="color_id[]"
                                                                value="{{ $color->id }}">{{ $color->name }}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Price ($)<span style="color: red">*</span></label>
                                                <input type="text" class="form-control"
                                                    value="{{ !empty($product->price) ? $product->price : '' }}"
                                                    name="price" required placeholder="Price">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Old Price ($)<span style="color: red">*</span></label>
                                                <input type="text" class="form-control"
                                                    value="{{ !empty($product->old_price) ? $product->old_price : '' }}"
                                                    name="old_price" required placeholder="Old Price">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Size <span style="color: red">*</span></label>
                                                <div>
                                                    <table class="table table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>Name</th>
                                                                <th>Price ($)</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="appendSize">
                                                            @php
                                                                $i_s = 1;
                                                            @endphp
                                                            @foreach ($product->getSize as $size)
                                                                <tr id="deleteSize{{ $i_s }}">
                                                                    <td>
                                                                        <input type="text" class="form-control"
                                                                            value="{{ $size->name }}"
                                                                            name="size[{{ $i_s }}][name]"
                                                                            id="" placeholder="Name">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control"
                                                                            value="{{ $size->price }}"
                                                                            name="size[{{ $i_s }}][price]"
                                                                            id="" placeholder="Price">
                                                                    </td>
                                                                    <td>
                                                                        <button type="button" id="{{ $i_s }}"
                                                                            class="btn btn-danger deleteSize">Delete</button>
                                                                    </td>
                                                                </tr>
                                                                @php
                                                                    $i_s++;
                                                                @endphp
                                                            @endforeach
                                                            <tr>
                                                                <td>
                                                                    <input type="text" class="form-control"
                                                                        name="size[100][name]" id=""
                                                                        placeholder="Name">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control"
                                                                        name="size[100][price]" id=""
                                                                        placeholder="Price">
                                                                </td>
                                                                <td>
                                                                    <button type="button"
                                                                        class="btn btn-primary addSize">Add</button>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Image<span style="color: red">*</span></label>
                                                <input type="file" name="image[]" class="form-control" multiple
                                                    style="padding:5px;" accept="image/*" id="">
                                            </div>
                                        </div>
                                    </div>
                                    @if (!empty($product->getImage->count()))
                                        <div class="row" id="sortable">
                                            @foreach ($product->getImage as $image)
                                                @if (!empty($image->getLogo()))
                                                    <div class="col-md-1 sortable_image" id="{{ $image->id }}"
                                                        style="text-align: center">
                                                        <img src=" {{ $image->getLogo() }}"
                                                            style="width: 100%;height:100px;" alt="">
                                                        <a onclick="return confirm('Are you sure wnant to delete ?');"
                                                            href="{{ url('admin/product/image_delete/' . $image->id) }}"
                                                            style="margin-top: 10px;"
                                                            class="btn btn-danger btn-sm">Delete</a>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    @endif
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Short Description</label>
                                                <textarea class="form-control" name="short_description" placeholder="Short Description">{{ $product->short_description }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Description</label>
                                                <textarea class="form-control editor" name="description" placeholder="Description">{{ $product->description }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Additional Information</label>
                                                <textarea class="form-control editor" name="additional_information" placeholder="Additional Information">{{ $product->additional_information }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Shipping & Returns</label>
                                                <textarea class="form-control editor" name="shipping_returns" placeholder="Shipping & Returns">{{ $product->shipping_returns }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Status<span style="color: red">*</span></label>
                                                <select class="form-control" name="status" required>
                                                    <option {{ $product->status == 0 ? 'selected' : '' }} value="0">
                                                        Active</option>
                                                    <option {{ $product->status == 1 ? 'selected' : '' }} value="1">
                                                        InActive</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.card -->

                    </div>
                </div>
                <!-- /.row -->

            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection

@section('script')
    <!-- summernote -->
    <script src="{{ asset('AdminLTE/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('AdminLTE/plugins/jquery-ui.js') }}"></script>

    {{-- tinymce --}}
    {{-- <script src="{{asset('AdminLTE/tinymce-jquery.min.js')}}"></script> --}}
    <script type="text/javascript">
        $(document).ready(function() {
            $("#sortable").sortable({
                update: function(event, ui) {
                    var photo_id = new Array();
                    $('.sortable_image').each(function() {
                        var id = $(this).attr('id');
                        photo_id.push(id);
                    });
                    $.ajax({

                        type: "POST",
                        url: "{{ url('admin/product_image_sortable') }}",
                        data: {
                            "photo_id": photo_id,
                            "_token": "{{ csrf_token() }}"
                        },
                        dataType: "json",
                        success: function(data) {
                        },
                        error: function(data) {

                        }
                    });
                }
            });
        });
        // Summernote
        $('.editor').summernote({
            height: 200
        });
        //   $('.editor').tinymce({
        //         height: 500,
        //         menubar: false,
        //         plugins: [
        //            'a11ychecker','advlist','advcode','advtable','autolink','checklist','markdown',
        //            'lists','link','image','charmap','preview','anchor','searchreplace','visualblocks',
        //            'powerpaste','fullscreen','formatpainter','insertdatetime','media','table','help','wordcount'
        //         ],
        //         toolbar: 'undo redo | a11ycheck casechange blocks | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist checklist outdent indent | removeformat | code table help'
        //       });
        var i = 100;
        $('body').delegate('.addSize', 'click', function() {
            var html = '<tr id="deleteSize' + i + '">\n\
                                                    <td>\n\
                                                        <input type="text" class="form-control" name="size[' + i + '][name]" placeholder="Name" id="">\n\
                                                    </td>\n\
                                                    <td>\n\
                                                        <input type="text" class="form-control" name="size[' + i + '][price]" placeholder="Price" id="">\n\
                                                    </td>\n\
                                                    <td>\n\
                                                        <button type="button" id="' + i + '" class="btn btn-danger deleteSize">Delete</button>\n\
                                                    </td>\n\
                                                </tr>';
            i++;

            $('#appendSize').append(html);
        });
        $('body').delegate('.deleteSize', 'click', function() {
            var id = $(this).attr('id');
            $('#deleteSize' + id).remove();
        });

        $('body').delegate('#changeCategory', 'change', function(e) {
            var id = $(this).val();
            $.ajax({

                type: "POST",
                url: "{{ url('admin/get_sub_category') }}",
                data: {
                    "id": id,
                    "_token": "{{ csrf_token() }}"
                },
                dataType: "json",
                success: function(data) {
                    $('#getSubCategory').html(data.html);
                },
                error: function(data) {

                }
            });
        });
    </script>
@endsection
