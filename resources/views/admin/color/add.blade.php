
@extends('admin.layouts.app')

@section('style')

@endsection

 @section('content')

 <div class="content-wrapper">
     <!-- Content Header (Page header) -->
     <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-12">
              <h1>Add New Color</h1>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-primary">
                  <!-- form start -->
                  <form action="" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label>Color Name <span style="color: red">*</span></label>
                            <input type="text" class="form-control" value="{{ old('name') }}" name="name" required placeholder="Color Name">
                        </div>
                        <div class="form-group">
                            <label>Color Code<span style="color: red">*</span></label>
                            <input type="color" class="form-control" value="{{ old('code') }}" name="code" required placeholder="Color Code">
                        </div>
                      <div class="form-group">
                        <label>Status<span style="color: red">*</span></label>
                        <select class="form-control"  name="status" required>
                            <option {{ (old('status') == 0) ? 'selected' : '' }} value="0">Active</option>
                            <option {{ (old('status') == 1) ? 'selected' : '' }} value="1">InActive</option>
                        </select>
                      </div>

                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary">Submit</button>
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
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{asset('AdminLTE/dist/js/pages/dashboard3.js')}}"></script>
@endsection
