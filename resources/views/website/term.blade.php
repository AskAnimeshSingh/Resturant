@extends('website.layout.layout')
@section('extra_css')
@endsection
@section('content')

<section class="contactus py-80 pb-0">
   <div class="container">
       <div class="row">
           <div class="col-lg-12">
            <h4>{{$terms->heading1}}</h4>
            <p>{!! $terms->answer1 !!}</p>
            <h4>{{$terms->heading2}}</h4>
            <p>{!! $terms->answer2 !!}</p>
            <h4>{{$terms->heading3}}</h4>
            <p>{!! $terms->answer3 !!}</p>
            <h4>{{$terms->heading4}}</h4>
            <p>{!! $terms->answer4 !!}</p>
       </div>
   </div>
</section>
@section('extra_js')

@endsection
@endsection