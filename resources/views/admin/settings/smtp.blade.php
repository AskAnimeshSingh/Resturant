@extends('admin.layout.layouts')
@section('extra_css')
<style>
</style>

@endsection

@section('content')
<section class="section">
    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <div class="title text-center">
                <h5>Update SMTP </h5>
                <h6>Please be carefull when you are configuring SMTP, For incorrect configuration you may get error in few features</h6>
                </div>
            </div>
            <div class="card-body">
                <form class="store_smtp" method="POST">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label>Mail mailer*</label>
                                <div class="input-group">
                                  <input type="text" class="form-control" placeholder="" name="mailer" >
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Mail host*</label>
                                <div class="input-group">
                                  <input type="text" class="form-control" placeholder="" name="host" >
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Mail port*</label>
                                <div class="input-group">
                                  <input type="text" class="form-control" placeholder="" name="port" >
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Mail username*</label>
                                <div class="input-group">
                                  <input type="text" class="form-control" placeholder="" name="name" >
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Mail password*</label>
                                <div class="input-group">
                                  <input type="text" class="form-control" placeholder="" name="password" >
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Mail encryption*</label>
                                <div class="input-group">
                                  <input type="text" class="form-control" placeholder="" name="encryption" >
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Mail from address*</label>
                                <div class="input-group">
                                  <input type="text" class="form-control" placeholder="" name="address" >
                                </div>
                            </div>

                        </div>
                        <div class="col-6">

                            <div class="form-group">
                                <label>For NON-SSL</label>
                                <div class="input-group">
                                  <li class="list-group-item text-dark">"Select 'sendmail' for Mail Mailer if you face any issue after configuring 'smtp' as Mail Mailer
                                  " name="mailer" </li>
                                <div class="input-group">
                                  <li class="list-group-item text-dark">"Set Mail Host according to your server Mail Client Manual Settings" name="mailer" </li>
                                </div>
                                <div class="input-group">
                                    <li class="list-group-item text-dark">"Set Mail port as '587'" name="mailer" </li>
                                </div>
                                <li class="list-group-item text-dark">"Set Mail Encryption as 'ssl' if you face issue with 'tls'" name="mailer" </li>

                                </div>
                            </div>

                            <div class="form-group">
                                <label>For SSL</label>
                                <div class="input-group">
                                  <li class="list-group-item text-dark">"Select 'sendmail' for Mail Mailer if you face any issue after configuring 'smtp' as Mail Mailer" name="mailer" </li>
                                  <br>
                                </div>
                                  <div class="input-group">
                                  <li class="list-group-item text-dark">"Set Mail Host according to your server Mail Client Manual Settings" name="mailer" </li>
                                </div>


                                  <div class="input-group">
                                  <li class="list-group-item text-dark">"Set Mail port as '465'
                                  " name="mailer" </li>

                                </div>



                            </div>
                            <button type="submit" class="btn btn-primary m-t-20waves-effect">Save</button>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>


</section>
@section('extra_js')
<script>

$("body").on("submit", ".store_smtp", function(e) {
    e.preventDefault()
    let fd = new FormData(this)
    fd.append('_token', "{{ csrf_token() }}");
    $.ajax({
      url: "{{ route('admin.smtp.store') }}",
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
            window.location.href = "{{ url('admin/smtp-settings')}}"
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
