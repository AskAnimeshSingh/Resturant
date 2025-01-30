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
            <h4>Delivery Feedback List </h4>
            {{-- <button class="btn btn-primary float-left" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus"></i></button> --}}
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped" id="userfeedback">
                <thead>
                  <tr>
                    <th class="text-center">#</th>
                    <th>User Name</th>
                    <th>Product Name</th>
                    <th>Rating</th>
                    <th>Message</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($ratings as $key => $r )
                        <tr>
                            <td class="p-0 text-center">
                                {{ ++$key }}
                            </td>
                            <td>{{$r->name}}</td>
                            <td>{{$r->product_name}}</td>
                            <td>

                                @for ($i = 0; $i < 5; $i++)
                                @if (floor($r->rating) - $i >= 1)

                                    <i class="fas fa-star text-warning"> </i>
                                @elseif ($r->rating - $i > 0)

                                    <i class="fas fa-star-half-alt text-warning"> </i>
                                @else

                                    <i class="far fa-star text-warning"> </i>
                                @endif
                            @endfor

                            <span style="font-size: 10px">{{$r->rating}}</span>
                            </td>
                            <td>{{$r->rating_message}}</td>

                        </tr>
                    @endforeach
                </tbody>
              </table>
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
