@extends('admin.layout.layouts')
@section('extra_css')
<style>
</style>
@endsection

@section('content')
<section class="section">
    <div class="section-body">
        <form class="add_gen" method="POST">
      <div class="row">
        <div class="col-12">
          <div class="card" style="padding-top:104px;">
            <div class="card-header col-12 col-md-3 col-lg-3">
              <h4>General Settings</h4>
            </div>
            <div class="card-body">
              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-8 col-md-4 col-lg-4">Site's Name</label>
                <div class="col-sm-12 col-md-7">
                  <input type="text" name="name" class="form-control">
                </div>
              </div>

              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-8 col-md-4 col-lg-4">Address</label>
                <div class="col-sm-12 col-md-7">
                  <input type="text" name="address" class="form-control">
                </div>
              </div>

              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-8 col-md-4 col-lg-4">Phone Number</label>
                <div class="col-sm-12 col-md-7">
                  <input type="text" name="phone" class="form-control">
                </div>
              </div>

              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-8 col-md-4 col-lg-4">Background of Logo</label>
                <div class="col-sm-12 col-md-7">
                  <input type="color" name="back_logo_colo" class="form-control">
                </div>
              </div>

              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-8 col-md-4 col-lg-4">Background of Footer Clock</label><br>
                <div class="col-sm-8 col-md-7">
                  <input type="color" name="back_foot_colo" class="form-control">
                </div>
              </div>


              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-8 col-md-4 col-lg-4">Text Color of Currency,Clock</label>
                <div class="col-sm-12 col-md-7">
                  <input type="color" name="text_colo" class="form-control">
                </div>
              </div>


              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-8 col-md-4 col-lg-4">Logo</label>
                <div class="col-sm-12 col-md-7">
                  <input type="file" name="image" class="form-control" required onchange="readURL(this);">
                </div>
              </div>

              {{-- <div class="input-group  row mb-4">
                <label class="col-form-label text-md-right col-8 col-md-4 col-lg-4">Preview</label>
                <div class="col-sm-12 col-md-7">
                    <img class="img-thumbnail image-width mt-4 mb-3" id="previewImage" src="{{ asset('assets/admin/assets/img/default_cate.jpeg') }}" alt="your image" />
                </div>
              </div> --}}

                <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-8 col-md-4 col-lg-4">Favicon</label>
                    <div class="col-sm-12 col-md-7">
                      <input type="file" name="favicon" class="form-control" required onchange="readURL(this);">
                    </div>
              </div>



              <div class="form-group row mb-2 ">
                <label class="col-form-label text-md-right col-8 col-md-4 col-lg-4">VAT System</label>
                <div class="col-sm-12 col-md-7">
                <select class="input-style form-control" name="tax" >
                    <option value="" selected></option>
                    <option value="Vat Tax">Vat tax</option>
                    <option value="Tax">Tax</option>
                    <option value="cgst+sgst">cgst+sgst</option>
                </select>
                <input type="number" name="taxval" class="form-control" placeholder="Enter value in percentage (%)">
                </div>
            </div>

              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-8 col-md-4 col-lg-4">Time Zone</label>
                <div class="col-sm-12 col-md-7">
                  <input type="text" name="time" class="form-control">
                </div>
              </div>

              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-8 col-md-4 col-lg-4">Service charge & Discount Type</label>
                <div class="col-sm-12 col-md-7">
                  <input type="text" name="discount" class="form-control">
                </div>
              </div>

              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-8 col-md-4 col-lg-4">Print Bill heading</label>
                <div class="col-sm-12 col-md-7">
                  <input type="text" name="bill_header" class="form-control">
                </div>
              </div>

              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-8 col-md-4 col-lg-4">Print Bill Footer</label>
                <div class="col-sm-12 col-md-7">
                  <input type="text" name="bill_footer" class="form-control">
                </div>
              </div>

              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-8 col-md-4 col-lg-4">Website Footer Text</label>
                <div class="col-sm-12 col-md-7">
                  <input type="text" name="web_footer" class="form-control">
                </div>
              </div>

              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-8 col-md-7 col-lg-5">Print Order Details in Kitchen?</label>
                <div class="col-sm-12 col-md-7">
                  <input type="checkbox" name="print_detail" class="form-control">
                </div>
              </div>

              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-8 col-md-7 col-lg-5">Play beep sound in POS?</label>
                <div class="col-sm-12 col-md-7">
                  <input type="checkbox" name="sound" class="form-control">
                </div>
              </div>

              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-8 col-md-7 col-lg-5">Show Table,Waiter selection option in POS?</label>
                <div class="col-sm-12 col-md-7">
                  <input type="checkbox" name="selection" class="form-control">
                </div>
              </div>

              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-8 col-md-4 col-lg-4"></label>
                <div class="col-sm-12 col-md-7">
                  <button name="submit" class="btn btn-primary">Save</button>
                </div>
              </div>

            </div>
          </div>
        </div>
    </div>
        </form>
    </div>
  </section>
@section('extra_js')
<script>
// Image preview
// function readURL(input) {
//     if (input.files && input.files[0]) {
//       var reader = new FileReader();
//       reader.onload = function(e) {
//         $('#previewImage').attr('src', e.target.result);
//       };
//       reader.readAsDataURL(input.files[0]);
//     }
//   }
  // Blogs Create
  $("body").on("submit", ".add_gen", function(e) {
    e.preventDefault()
    let fd = new FormData(this)
    fd.append('_token', "{{ csrf_token() }}");
    $.ajax({
      url: "{{ route('admin.setting.store') }}",
      type: "POST",
      data: fd,
      dataType: 'json',
      processData: false,
      contentType: false,
      beforeSend: function() {
        $('#login-button').prop('disabled', true);
        $('.loader').show();
      },
      success: function(result) {
        if (result.status) {
          iziToast.success({
            title: '',
            message: result.msg,
            position: 'topRight'
          });
          setTimeout(() => {
            window.location.href = "{{ url('admin/general-settings')}}"
          }, 500);

        } else {
          iziToast.error({
            title: '',
            message: result.msg,
            position: 'topRight'
          });
        }
      },
      complete: function() {
        $('.loader').hide();
      },
      error: function(jqXHR, exception) {
        $('.loader').hide();
        console.log(jqXHR.responseText);
      }
    });
  })

</script>
@endsection
@endsection
