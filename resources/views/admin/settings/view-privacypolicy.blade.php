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
            <a href="{{route('admin.form.privacy_policy')}}" class="btn btn-primary float-left"><i class="fa fa-plus"></i>&nbsp; Update Privacy Policy</a>
          </div>
          <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class=""><h3 style="font-family: sans-serif; color:rgb(64, 64, 64); font-size:24px"><span>Privacy Policy</span></h3></div>
                    <div class=""><span>Last Updated:  {!! htmlspecialchars_decode(date('j<\s\up>S</\s\up> F Y', strtotime($privacypolicy->updated_at)))!!}</span></div>
                    <hr>
                    <div class=""><h5 style="font-family: sans-serif; color:rgb(64, 64, 64); font-size:20px"><span>{{$privacypolicy->heading1}}</span></h5></div>
                    <div class=""><span>{{$privacypolicy->answer1}}</span></div>
                    <hr>
                    <div class=""><h5 style="font-family: sans-serif; color:rgb(64, 64, 64); font-size:20px"><span>{{$privacypolicy->heading2}}</span></h5></div>
                    <div class=""><span>{!! html_entity_decode($privacypolicy->answer2) !!}</span></div>
                    <hr>
                    <div class=""><h5 style="font-family: sans-serif; color:rgb(64, 64, 64); font-size:20px"><span>{{$privacypolicy->heading3}}</span></h5></div>
                    <div class=""><span>{!! html_entity_decode($privacypolicy->answer3) !!}</span></div>
                    <hr>
                    <div class=""><h5 style="font-family: sans-serif; color:rgb(64, 64, 64); font-size:20px"><span>{{$privacypolicy->heading4}}</span></h5></div>
                    <div class=""><span>{!! html_entity_decode($privacypolicy->answer4) !!}</span></div>
                    <hr>
                    <div class=""><h5 style="font-family: sans-serif; color:rgb(64, 64, 64); font-size:20px"><span>{{$privacypolicy->heading5}}</span></h5></div>
                    <div class=""><span>{!! html_entity_decode($privacypolicy->answer5) !!}</span></div>
                    <hr>
                    <div class=""><h5 style="font-family: sans-serif; color:rgb(64, 64, 64); font-size:20px"><span>{{$privacypolicy->heading5}}</span></h5></div>
                    <div class=""><span>{!! html_entity_decode($privacypolicy->answer5) !!}</span></div>
                    <hr>
                    <div class=""><h5 style="font-family: sans-serif; color:rgb(64, 64, 64); font-size:20px"><span>{{$privacypolicy->heading6}}</span></h5></div>
                    <div class=""><span>{!! html_entity_decode($privacypolicy->answer6) !!}</span></div>
                    <hr>
                    <div class=""><h5 style="font-family: sans-serif; color:rgb(64, 64, 64); font-size:20px"><span>{{$privacypolicy->heading7}}</span></h5></div>
                    <div class=""><span>{!! html_entity_decode($privacypolicy->answer7) !!}</span></div>
                    <hr>
                    <div class=""><h5 style="font-family: sans-serif; color:rgb(64, 64, 64); font-size:20px"><span>{{$privacypolicy->heading8}}</span></h5></div>
                    <div class=""><span>{!! html_entity_decode($privacypolicy->answer8) !!}</span></div>
                    <hr>
                    <div class=""><h5 style="font-family: sans-serif; color:rgb(64, 64, 64); font-size:20px"><span>{{$privacypolicy->heading9}}</span></h5></div>
                    <div class=""><span>{!! html_entity_decode($privacypolicy->answer9) !!}</span></div>
                    {{-- <hr> --}}
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
