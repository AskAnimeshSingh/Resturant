<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from www.radixtouch.in/templates/admin/otika/source/light/auth-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 23 Jan 2020 05:40:04 GMT -->
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Otika - Delivery Boy Dashboard Template</title>
  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{ asset('assets/admin/assets/css/app.min.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/admin/assets/bundles/bootstrap-social/bootstrap-social.css')}}">
  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('assets/admin/assets/css/style.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/admin/assets/css/components.css')}}">
  <!-- Custom style CSS -->
  <link rel="stylesheet" href="{{ asset('assets/admin/assets/css/custom.css')}}">
  <link rel='shortcut icon' type='image/x-icon' href='{{ asset('assets/admin/assets/img/favicon.ico')}}' />
  <link rel="stylesheet" href="{{ asset('assets/admin/assets/bundles/izitoast/css/iziToast.min.css')}}">
</head>

<body>
  <div class="loader"></div>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="card card-primary">
              <div class="card-header">
                <h4>Login</h4>
              </div>
              <div class="card-body">
                <form method="POST" class="needs-validation login-submit" novalidate="">
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" class="form-control" name="email" tabindex="1" required autofocus>
                    <div class="invalid-feedback">
                      Please fill in your email
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="d-block">
                      <label for="password" class="control-label">Password</label>
                      <div class="float-right">
                        {{-- <a href="{{ route('admin.forget_password')}}" class="text-small"> --}}
                          Forgot Password?
                        </a>
                      </div>
                    </div>
                    <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
                    <div class="invalid-feedback">
                      please fill in your password
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me">
                      <label class="custom-control-label" for="remember-me">Remember Me</label>
                    </div>
                  </div>
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                      Login
                    </button>
                  </div>
                </form>
          </div>
        </div>
      </div>
    </section>
  </div>
  <!-- General JS Scripts -->
  <script src="{{ asset('assets/admin/assets/js/app.min.js')}}"></script>
  <!-- JS Libraies -->
  <!-- Page Specific JS File -->
  <!-- Template JS File -->
  <script src="{{ asset('assets/admin/assets/js/scripts.js')}}"></script>
  <!-- Custom JS File -->
  <script src="{{ asset('assets/admin/assets/js/custom.js')}}"></script>
  <script src="{{ asset('assets/admin/assets/bundles/izitoast/js/iziToast.min.js')}}"></script>
 <script src="{{ asset('assets/admin/assets/js/page/toastr.js')}}"></script>
  <script>

     $(function (){

    $('.login-submit').on('submit', function(e){
        e.preventDefault()

        let fd = new FormData(this)
        fd.append('_token',"{{ csrf_token() }}");
        $.ajax({
            url: "{{ route('deliveryboy.submit_login') }}",
            type:"POST",
            data: fd,
            dataType: 'json',
            processData: false,
            contentType: false,
            beforeSend: function () {
                $('#login-button').prop('disabled', true);
                $('.loader').show();
            },
            success:function(result){
                if(result.status)
                {
                    iziToast.success({
                      title: '',
                      message: result.msg,
                      position: 'topRight'
                    });
                    setTimeout(function(){
                        window.location.href = result.location;
                    }, 500);
                }
                else
                {
                  iziToast.error({
                      title: '',
                      message: result.msg,
                      position: 'topRight'
                    });
                }
            },
            complete: function () {
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
</body>


<!-- Mirrored from www.radixtouch.in/templates/admin/otika/source/light/auth-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 23 Jan 2020 05:40:04 GMT -->
</html>
