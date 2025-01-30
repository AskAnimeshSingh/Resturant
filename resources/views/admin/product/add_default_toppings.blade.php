<?php use App\Http\Controllers\Admin\Product; ?>
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
                        <h4>Add Product Defaults</h4>
                    </div>
                    <div class="card-body">
                        <form class="add_product_default" method="POST">
                            <div class="card-header">
                                <h4>Add Product Defaults</h4>
                            </div>
                            <div class="card-body">
                                  <div class="row">


                                      <div class="col-md-12">
                                          <div class="row">
                                              @foreach ($properties as $pr)
                                                  @if(in_array($pr->id, $ppr))
                                                      <div class="col-md-3">
                                                          <label for="">{{$pr->name}}</label>
                                                          <select class="form-control" name="pi_items[]">
                                                              @foreach(Product::getPropertyItemsByPropertyId($pr->id) as $pi)
                                                                  <option value="{{$pi->id}}" @if(in_array($pi->id, json_decode($products->default_toppings))) selected @endif>{{$pi->name}}</option>
                                                              @endforeach
                                                          </select>
                                                      </div>
                                                  @endif
                                              @endforeach
                                          </div>
                                          <div class="row">
                                              <div class="col-md-6">
                                                  <div class="form-group">
                                                      <label>Select Variations</label>
                                                      <select type="text" class="form-control" name="variations" required>
                                                          <option value="" disabled>Select Type</option>
                                                          @foreach ($variations as $pr)
                                                              @if(in_array($pr->id, $vvr))
                                                              <option value="{{$pr->id}}" @if($products->default_varients === $pr->id) selected @endif>{{$pr->name}}</option>
                                                              @endif
                                                          @endforeach
                                                      </select>
                                                  </div>
                                              </div>
                                              <div class="col-md-6">
                                                  <div class="form-group">
                                                      <label>Select Crust</label>
                                                      <select type="text" class="form-control" name="crust" id="crust" required>
                                                          <option value="" disabled>Select Type</option>
                                                          @foreach ($productCrursts as $cr)
                                                                  <option value="{{$cr->id}}" @if($products->default_crust === $cr->id) selected @endif>{{$cr->name}}</option>
                                                          @endforeach
                                                      </select>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>

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
        // $('#properties').select2({
        //         multiple: true,
        //         disabled:'readonly'
        //     })
        // $('#variations').select2({
        //         multiple: false,
        // })
        $("body").on("submit", ".add_product_default", function(e) {
            e.preventDefault()
            let fd = new FormData(this)
            fd.append('_token', "{{ csrf_token() }}");
            $.ajax({
                url: "{{ route('admin.product.update.default') }}",
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
    });
</script>
@endsection
@endsection
