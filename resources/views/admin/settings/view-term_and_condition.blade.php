@extends('admin.layout.layouts')
@section('extra_css')
<style>
</style>
@endsection

@section('content')
<section class="section">
  <div class="section-body">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header float-right">
            {{-- <h4>Language List</h4> --}}
            <a href="{{route('admin.form.term_and_condition')}}" class="btn btn-primary float-left"><i class="fa fa-plus"></i>&nbsp; Update Terms and Condition</a>
          </div>
          <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class=""><h3 style="font-family: sans-serif; color:rgb(64, 64, 64); font-size:24px"><span>Terms and Condition</span></h3></div>
                    <div class=""><span>Last Updated:  {!! htmlspecialchars_decode(date('j<\s\up>S</\s\up> F Y', strtotime($terms->updated_at)))!!}</span></div>
                    <hr>
                    <div class=""><h5 style="font-family: sans-serif; color:rgb(64, 64, 64); font-size:20px"><span>{{$terms->heading1}}</span></h5></div>
                    <div class=""><span>{!! html_entity_decode($terms->answer1) !!}</span></div>
                    <hr>
                    <div class=""><h5 style="font-family: sans-serif; color:rgb(64, 64, 64); font-size:20px"><span>{{$terms->heading2}}</span></h5></div>
                    <div class=""><span>{!! html_entity_decode($terms->answer2) !!}</span></div>
                    <hr>
                    <div class=""><h5 style="font-family: sans-serif; color:rgb(64, 64, 64); font-size:20px"><span>{{$terms->heading3}}</span></h5></div>
                    <div class=""><span>{!! html_entity_decode($terms->answer3) !!}</span></div>
                    <hr>
                    <div class=""><h5 style="font-family: sans-serif; color:rgb(64, 64, 64); font-size:20px"><span>{{$terms->heading4}}</span></h5></div>
                    <div class=""><span>{!! html_entity_decode($terms->answer4) !!}</span></div>
                    <hr>

                </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>


</section>
@section('extra_js')
<script>


</script>
@endsection
@endsection
