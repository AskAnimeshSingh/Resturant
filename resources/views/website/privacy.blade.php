@extends('website.layout.layout')
@section('extra_css')
@endsection
@section('content')

<section class="contactus py-80 pb-0">
   <div class="container">
       <div class="row">
           <div class="col-lg-12">
                <h4>{{$privacy->heading1}}</h4>
                <p>{!! $privacy->answer1 !!}</p>
                <h4>{{$privacy->heading2}}</h4>
                <p>{!! $privacy->answer2 !!}</p>
                <h4>{{$privacy->heading3}}</h4>
                <p>{!! $privacy->answer3 !!}</p>
                <h4>{{$privacy->heading4}}</h4>
                <p>{!! $privacy->answer4 !!}</p>
                <h4>{{$privacy->heading5}}</h4>
                <p>{!! $privacy->answer5 !!}</p>
                <h4>{{$privacy->heading6}}</h4>
                <p>{!! $privacy->answer6 !!}</p>
           </div>
       </div>
   </div>
</section>
@section('extra_js')

@endsection
@endsection