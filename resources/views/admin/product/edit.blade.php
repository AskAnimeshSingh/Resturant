@extends('admin.layout.layouts')
@section('extra_css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-container--default .select2-selection--multiple .select2-selection__choice, .select2-container--default .select2-results__option[aria-selected="true"], .select2-container--default .select2-results__option--highlighted[aria-selected] {
        color: #403838;
        font-weight: bold;
    }

    .select2-selection__choice__remove {
        color: #403838 !important;
        font-weight: bold !important;
    }

    .select2-search__field {
        vertical-align: middle !important;
    }
</style>
@endsection
@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header float-right">
                        <a href="{{ route('admin.product.list')}}" class="btn btn-primary" title="Back"><i class="fa fa-arrow-left "></i></a>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <h4>Edit Product</h4>
                    </div>
                    <div class="card-body">
                        <form class="update_product" method="POST">
                            <div class="card-header">
                                <h4>Edit Product</h4>
                            </div>
                            <div class="card-body">
                                  <div class="row">
                                    <div class="col-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label>Product Name <em class="text-danger">*</em></label>
                                            <input type="text" class="form-control" required="" placeholder="Product Name" name="product_name" value="{{$products->product_name}}">
                                        </div>
                                    </div>
                                    <div class="col-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label>Category <em class="text-danger">*</em></label>
                                            <select class="form-control" name="category" required id="category">
                                                <option value="" selected disabled>Select Product Category</option>
                                                @foreach ($category as $item)
                                                    <option value="{{$item->id}}" {{$item->id == $products->category ? 'selected' : ''}}>{{$item->cate_name}} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4 col-md-6 col-sm-12">
                                      <div class="form-group">
                                          <label>Sub Category</label>
                                          <select class="form-control" name="sub_category" id="sub_category">
                                             <option value="{{$products->sub_category}}">{{$products->subname}}</option>
                                          </select>
                                      </div>
                                    </div>
                                    <div class="col-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label>Price <em class="text-danger">*</em></label>
                                            <input type="number" min="0" step="any" class="form-control" required="" placeholder="Product Price" name="price" value="{{$products->price}}">
                                        </div>
                                    </div>
                                    <div class="col-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label>Tax(%) <em class="text-danger">*</em></label>
                                            <input type="number" min="0" step="any" class="form-control"  placeholder="Product Tax " name="tax" value="{{$products->tax}}">
                                        </div>
                                    </div>


                                      <div class="col-md-12">
                                          <div class="form-group">
                                              <div class="custom-control custom-checkbox">
                                                  <input type="checkbox" class="custom-control-input" id="has_properties" @if($products->has_properties == 1) checked @endif name="properties_check">
                                                  <label class="custom-control-label" for="has_properties">Has properties ?</label>
                                              </div>
                                          </div>
                                          <div class="row">
                                              <div class="col-md-12" id="append-properties">

                                              </div>
                                          </div>
                                      </div>

                                      <div class="col-md-12">
                                          <div class="form-group">
                                              <div class="custom-control custom-checkbox">
                                                  <input type="checkbox" class="custom-control-input" id="has_variations" @if($products->has_varients == 1) checked @endif name="variations_check">
                                                  <label class="custom-control-label" for="has_variations">Has variations ?</label>
                                              </div>
                                          </div>
                                          <div class="row">
                                              <div class="col-md-12" id="append-variations">

                                              </div>
                                          </div>
                                          <div class="row">
                                              <div class="col-md-12" id="append-variations-prices">
                                                  @foreach($vvr as $keyV => $v)
                                                  <div id="vv-{{$v}}" class="form-group">
                                                      <label for="">Price of {{$vvName[$keyV]}} variant</label>
                                                      <input type="text" name="variant_price[]" value="{{$vvrP[$keyV]}}" class="form-control variant_price">
                                                  </div>
                                                  @endforeach
                                              </div>
                                          </div>
                                      </div>

{{--                                    <div class="col-4 col-md-6 col-sm-12">--}}
{{--                                      <div class="form-group">--}}
{{--                                        <label>Size</label>--}}
{{--                                        <select type="text" class="form-control" name="size">--}}
{{--                                          @foreach ($sizes as $size)--}}
{{--                                            <option value="{{$size->size}}" {{$products->size == $size->size ? 'selected' : ''}}>{{$size->size}}</option>--}}
{{--                                          @endforeach--}}
{{--                                        </select>--}}
{{--                                      </div>--}}
{{--                                    </div>--}}

{{--                                    <div class="col-4 col-md-6 col-sm-12">--}}
{{--                                      <div class="form-group">--}}
{{--                                        <label>Type</label>--}}
{{--                                        <select type="text" class="form-control" name="type" required>--}}
{{--                                          @foreach ($types as $type)--}}
{{--                                            <option value="{{$type->type}}" {{$products->type == $type->type ? 'selected' : ''}}>{{$type->type}}</option>--}}
{{--                                          @endforeach--}}
{{--                                        </select>--}}
{{--                                      </div>--}}
{{--                                    </div>--}}

                                    <div class="col-4 col-md-6 col-sm-12">
                                      <div class="form-group">
                                          <label>Description</label>
                                          <textarea type="text" class="form-control"  placeholder="Description " name="description">{{$products->product_des}}</textarea>
                                      </div>
                                    </div>

{{--                                    <div class="col-4 col-md-6 col-sm-12">--}}
{{--                                      <div class="form-group">--}}
{{--                                          <label>Extra</label>--}}
{{--                                          <br>--}}
{{--                                          @foreach ($extras as $key => $extra)--}}
{{--                                          <input type="checkbox" name="extra[]" value="{{$extra->name}}" checked>&nbsp;<b>{{$extra->name}}</b> &nbsp; &nbsp;--}}
{{--                                          @endforeach--}}
{{--                                      </div>--}}
{{--                                    </div>--}}

                                    <div class="col-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label>Product Image <em class="text-danger">*</em></label>
                                            <input type="file" class="form-control" name="product_image"  onchange="readURL(this);"></textarea>
                                        </div>
                                    </div>



                                </div>
                                <div class="row justify-content-left">
                                    <div class="col-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <img class="img-thumbnail image-width mt-4 mb-3" id="previewImage" src="{{$products->product_img != "" ? url($products->product_img) :  asset('assets/admin/assets/img/default_cate.jpeg') }}" alt="your image" />
                                        </div>
                                    </div>
                                </div>

                                <!-- Add Product Variant-->
{{--                                <div class="col-12 col-md-12 col-sm-12">--}}
{{--                                  <div class="form-group">--}}
{{--                                    Add Topping &nbsp;&nbsp;<input type="checkbox" class="switch_1 check product_promotion" name="product_promotion" value="1" {{$products->addon == 1 ? 'checked' : ''}}>--}}
{{--                                  </div>--}}
{{--                                </div>--}}



{{--                                  @if($addon->count() > 0)--}}
{{--                                  @php($i = 0)--}}
{{--                                    @foreach ($addon as $item)--}}
{{--                                      @php($i++)--}}
{{--                                      @if($i == 1)--}}
{{--                                      <div class="col-4 col-md-6 col-sm-12 my-2" id="promotion_input">--}}
{{--                                        <label>Topping</label>--}}
{{--                                      <div class="input-group ">--}}
{{--                                        <input type="text" class="form-control" name="addon[]" placeholder="Add Variant" value="{{$item->variant}}">--}}
{{--                                        <a href="javascript:void(0)" class="input-group-text text-decoration-none add_button_more btn btn-primary">Add More</a>--}}
{{--                                      </div>--}}
{{--                                      </div>--}}
{{--                                      @else--}}
{{--                                      <div class="col-4 col-md-6 col-sm-12 my-2" id="promotion_input">--}}
{{--                                      <div class="input-group my-2">--}}
{{--                                        <input type="text" class="form-control" name="addon[]" placeholder="Add Variant" value="{{$item->variant}}">--}}
{{--                                        <a href="javascript:void(0)" class="input-group-text text-decoration-none remove-addon btn btn-danger">Remove</a>--}}
{{--                                      </div>--}}
{{--                                      </div>--}}
{{--                                      @endif--}}
{{--                                    @endforeach--}}
{{--                                  @else--}}
{{--                                  <div class="col-4 col-md-6 col-sm-12 my-2" id="promotion_input">--}}
{{--                                    <label>Addon</label>--}}
{{--                                  <div class="input-group ">--}}
{{--                                    <input type="text" class="form-control" name="addon[]" placeholder="Add Variant">--}}
{{--                                    <a href="javascript:void(0)" class="input-group-text text-decoration-none add_button_more btn btn-primary">Add More</a>--}}
{{--                                  </div>--}}
{{--                                </div>--}}
{{--                                  @endif--}}

                                <span class="add_more"></span>

                                <input type="hidden" value="{{$products->id}}" name="product_id">
                                <input type="hidden" value="{{$products->product_img}}" name="oldimage">
                            </div>
                            <div class="card-footer text-right">
                                <button class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>

</section>
@section('extra_js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>

    $(function (){
        if($('#has_properties').prop('checked') == true){
            $('#append-properties').html(`<div class="form-group">
                            <label>Properties</label>
                            <select type="text" class="form-control" name="properties[]" id="properties" multiple>
                                <option value="" disabled>Select Type</option>
                                @foreach ($properties as $pr)
            <option value="{{$pr->id}}" @if(in_array($pr->id, $ppr)) selected @endif>{{$pr->name}}</option>
                                @endforeach
            </select>
        </div>`)
            $('#properties').select2({
                multiple: true,
            })
        }else{
            $('#append-properties').html('')
        }

        if($('#has_variations').prop('checked') == true){
                $('#append-variations').html(`<div class="form-group">
                            <label>Variations</label>
                            <select type="text" class="form-control" name="variations[]" id="variations" multiple>
                                <option value="" disabled>Select Type</option>
                                @foreach ($variations as $pr)
                <option value="{{$pr->id}}" @if(in_array($pr->id, $vvr)) selected @endif>{{$pr->name}}</option>
                                @endforeach
                </select>
            </div>`)
                $('#variations').select2({
                    multiple: true,
                })
                $("#variations").on("select2:select", function (e) {
                    var lastSelectedItem = e.params.data.id;
                    var lastSelectedItemText = e.params.data.text;
                    $('#append-variations-prices').append(`<div id="vv-${lastSelectedItem}" class="form-group">
                                    <label for="">Price of ${lastSelectedItemText} variant</label>
                                    <input type="text" name="variant_price[]" class="form-control variant_price">
                                </div>`)
                })

                $("#variations").on("select2:unselect", function (e) {
                    var lastSelectedItem = e.params.data.id;
                    $('#vv-'+lastSelectedItem).remove()
                })
            }else{
                $('#append-variations').html('')
            }

        $('#has_properties').click(function (e){
            if($(this).prop('checked') == true){
                $('#append-properties').html(`<div class="form-group">
                            <label>Properties</label>
                            <select type="text" class="form-control" name="properties[]" id="properties" multiple>
                                <option value="" disabled>Select Type</option>
                                @foreach ($properties as $pr)
                <option value="{{$pr->id}}">{{$pr->name}}</option>
                                @endforeach
                </select>
            </div>`)
                $('#properties').select2({
                    multiple: true,
                })
            }else{
                $('#append-properties').html('')
            }
        })

        $('#has_variations').click(function (e){
            if($(this).prop('checked') == true){
                $('#append-variations').html(`<div class="form-group">
                            <label>Variations</label>
                            <select type="text" class="form-control" name="variations[]" id="variations" multiple>
                                <option value="">Select Type</option>
                                @foreach ($variations as $pr)
                <option value="{{$pr->id}}">{{$pr->name}}</option>
                                @endforeach
                </select>
            </div>`)
                $('#variations').select2({
                    multiple: true,
                })
                $("#variations").on("select2:select", function (e) {

                    //this returns all the selected item
                    var items= $(this).val();

                    //Gets the last selected item
                    var lastSelectedItem = e.params.data.id;
                    var lastSelectedItemText = e.params.data.text;
                    $('#append-variations-prices').append(`<div id="vv-${lastSelectedItem}" class="form-group">
                                    <label for="">Price of ${lastSelectedItemText} variant</label>
                                    <input type="text" name="variant_price[]" class="form-control variant_price">
                                </div>`)


                })

                $("#variations").on("select2:unselect", function (e) {

                    //this returns all the selected item
                    var items= $(this).val();

                    //Gets the last selected item
                    var lastSelectedItem = e.params.data.id;
                    $('#vv-'+lastSelectedItem).remove()

                })
                // $('#variations').change(function (e){
                //     e.preventDefault()
                //     alert($('#variations').select2('val'))
                // })
            }else{
                $('#append-variations').html('')
            }
        })

    })

if ($('.product_promotion:checkbox:checked').length > 0) {
  $('#promotion_input').show()
}else
{
  $('#promotion_input').hide()
}


  $('.product_promotion').on('click', function() {
    if ($('.product_promotion:checkbox:checked').length > 0) {
      $('#promotion_input').show();
    } else {
      $('#promotion_input').hide();
    }
  });

    // Image preview
      function readURL(input) {
        if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function(e) {
            $('#previewImage').attr('src', e.target.result);
          };
          reader.readAsDataURL(input.files[0]);
        }
      }


    // Product Store
      $("body").on("submit", ".update_product", function(e) {
        e.preventDefault()
        let fd = new FormData(this)
        fd.append('_token', "{{ csrf_token() }}");
        $.ajax({
          url: "{{ route('admin.product.update') }}",
          type: "POST",
          data: fd,
          dataType: 'json',
          processData: false,
          contentType: false,
          beforeSend: function() {
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
                window.location.href = "{{url('admin/product/list')}}"
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

      // get Sub Category help of Category Id
      $('#category').on('change', function(e) {
        let fd = new FormData();
        var cateid = $(this).val();

        fd.append('cateid', cateid);
        fd.append('_token', "{{ csrf_token() }}");
        $.ajax({
          url: "{{route('common.get_sub_category')}}",
          type: "POST",
          data: fd,
          dataType: 'json',
          processData: false,
          contentType: false,
          beforeSend: function() {
            $('.loader').show();
          },
          success: function(result) {
            var datas = '';

            if (result.data.length > 0) {
              let j = 1;
              datas += '<option value="" selected disabled>Please Select</option>';
              $.each(result.data, function(i, val) {
                datas += '<option value="' + val.id + '">' + val.name+ '</option>';
                j++;
              });
            } else {
              datas += '<option value="">Sub Category Found</option>';
            }
            $('#sub_category').html(datas);
            $('#child_category').html('');
          },
          complete: function() {
            // $("#sub_category").hide()
            $('.loader').hide();
          },
          error: function(jqXHR, exception) {
            console.log(jqXHR.responseText);
            $('.loader').hide();
          }
        });
      });

      // Get child Category help of sub category id
      $('#sub_category').on('change', function(e) {
        let fd = new FormData();
        var cateid = $(this).val();

        fd.append('cateid', cateid);
        fd.append('_token', "{{ csrf_token() }}");
        $.ajax({
          url: "{{route('common.get_child_category')}}",
          type: "POST",
          data: fd,
          dataType: 'json',
          processData: false,
          contentType: false,
          beforeSend: function() {
            $('.loader').show();
          },
          success: function(result) {
            var datas = '';
            if (result.data.length > 0) {
              let j = 1;
              datas += '<option value="">Please Select</option>';
              $.each(result.data, function(i, val) {
                datas += '<option value="' + val.id + '">' + val.name+ '</option>';
                j++;
              });
            } else {
              datas += '<option value="">Sub Category Found</option>';
            }
            $('#child_category').html(datas);

          },
          complete: function() {
            // $("#sub_category").hide()
            $('.loader').hide();
          },
          error: function(jqXHR, exception) {
            console.log(jqXHR.responseText);
            $('.loader').hide();
          }
        });
      });


      $(document).ready(function() {
    var maxField1 = 10;
    var addButton1 = $('.add_button_more');
    var wrapper1 = $('.add_more');
    var x = 1;



    $(addButton1).click(function() {

        var fieldHTML1 ='<div class="col-4 col-md-6 col-sm-12 my-2">'+
                        // '<label>Addon</label>'+
                        '<div class="input-group">'+
                        '<input type="text" class="form-control" name="addon[]" placeholder="Topping">'+
                        '<a href="javascript:void(0)" class="input-group-text text-decoration-none remove-addon btn btn-danger">Remove</a>'+
                        '</div>'+
                        '</div>';
        $(wrapper1).append(fieldHTML1);
    });



    $("body").on('click', '.remove-addon', function(e) {
      e.preventDefault();
      $(this).parent('div').remove();
      x--;
    });
  });
</script>
@endsection
@endsection
