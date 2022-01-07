<?php
require_once("header.php");
$server->login_session_Check();
?>
<body class="hold-transition login-page bg-secondary">
<div class="login-box">
  
  <!-- /.login-logo -->
  <div class="card">
    <div class="login-logo mt-3">
    <a href="index.php"><b>Admin Login</b></a>
  </div>
    <div class="card-body login-card-body">
     <!--  <p class="login-box-msg">Sign in to start your session</p> -->

      <form method="post" id="Admin_login_form">
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="Userame" placeholder="UserName" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="Password" id="Password" placeholder="Password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Show Password
              </label>
             <!--  | <a href="javascript:void(0)" data-toggle="modal" data-target="#staticBackdrop">Forget Password ?</a> -->
            </div>
          </div>
          <!-- /.col -->
          <div class="col-12 mt-3">
            <input type="hidden" name="page" value="Admin_form">
            <input type="hidden" name="action" value="Admin_form">
            <button type="submit" id="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

     <!--  <div class="social-auth-links text-center mb-3">
        <p>- OR -</p>
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
        </a>
      </div> -->
      <!-- /.social-auth-links -->

      <!-- <p class="mb-1">
        <a href="forgot-password.html">I forgot my password</a>
      </p> -->
      <!-- <p class="mb-0">
        <a href="register.html" class="text-center">Register a new membership</a>
      </p> -->
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="password_sending_form">
      <div class="modal-header" style="background-color: #0B166A;">
        <h5 class="modal-title text-light" id="staticBackdropLabel">Forget Password</h5>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"><i class="fas fa-times-circle"></i></button>
      </div>
      <div class="modal-body">
        
           <div class="form-group">
             <label>Register Email*</label>
             <input type="email" name="email" placeholder="Enter Register E-Mail" class="form-control" required>
           </div>
         
      </div>
      <div class="modal-footer bg-secondary">
        <input type="hidden" name="page" value="_Email_Forget_Password_Form">
        <input type="hidden" name="action" value="_Email_Forget_Password_Form">
        <button type="submit" class="btn btn-warning" id="submit1">Submit</button>
      </div>
      </form>
    </div>
  </div>
</div>

</body>
<?php
require_once("footer.php");
?>
<script type="text/javascript">
  $(document).ready(function(){
        $('#Admin_login_form').parsley();
        $('#Admin_login_form').on('submit',function(event){
          if($('#Admin_login_form').parsley().validate())
          {
            $.ajax({
              url:"action-page/admin_ajax_action.php",
              method:"post",
              data : $(this).serialize(),
              dataType:"json",
              beforeSend:function()
              {
                $('#submit').html('Please Wait..');
                $('#submit').attr('disabled',true);
              },
              success:function(data)
              {
              if(data.success)
                  {
                     toastr.options = {
                        "closeButton": true,  // true or false
                        "debug": false,
                        "newestOnTop": false,
                        "progressBar": true,  // true or false
                        "rtl": false,
                        "positionClass": "toast-top-right",
                        "preventDuplicates": false, // true or false
                        "showDuration": 300,
                        "hideDuration": 1000,
                        "timeOut": 5000,
                        "extendedTimeOut": 1000,
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                      }
                    toastr["success"](data.success, "Message");
                    setTimeout(function(){
                    location.href='Dashboard/dashboard.php';
                  }, 1000);
                   }
                   else
                   {
                      toastr.options = {
                        "closeButton": true,  // true or false
                        "debug": false,
                        "newestOnTop": false,
                        "progressBar": true,  // true or false
                        "rtl": false,
                        "positionClass": "toast-top-right",
                        "preventDuplicates": false, // true or false
                        "showDuration": 300,
                        "hideDuration": 1000,
                        "timeOut": 5000,
                        "extendedTimeOut": 1000,
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                      }
                     toastr["error"](data.error, "Message");
                     $('#submit').html('Sign In');
                     $('#submit').attr('disabled',false);
                   }
              }
            });
          }
        event.preventDefault();
        });

    $('#remember').on('change',function(event){
       
       if($('#remember').is(":checked"))
       {
         $('#Password').attr('type','text');
       }
       else
       {
         $('#Password').attr('type','password');
       }

     event.preventDefault()
    });


    $('#password_sending_form').parsley();
        $('#password_sending_form').on('submit',function(event){
          if($('#password_sending_form').parsley().validate())
          {
            $.ajax({
              url:"../action-page/admin_ajax_action.php",
              method:"post",
              data : $(this).serialize(),
              dataType:"json",
              beforeSend:function()
              {
                $('#submit1').html('Please Wait..');
                $('#submit1').attr('disabled',true);
              },
              success:function(data)
              {
              if(data.success)
                  {
                     toastr.options = {
                        "closeButton": true,  // true or false
                        "debug": false,
                        "newestOnTop": false,
                        "progressBar": true,  // true or false
                        "rtl": false,
                        "positionClass": "toast-top-right",
                        "preventDuplicates": false, // true or false
                        "showDuration": 300,
                        "hideDuration": 1000,
                        "timeOut": 5000,
                        "extendedTimeOut": 1000,
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                      }
                    toastr["success"](data.success, "Message");
                    $('#submit1').html('Submit');
                    $('#submit1').attr('disabled',false);
                    $('#password_sending_form')[0].reset();
                    $('#staticBackdrop').modal('hide');
                   }
                   else
                   {
                      toastr.options = {
                        "closeButton": true,  // true or false
                        "debug": false,
                        "newestOnTop": false,
                        "progressBar": true,  // true or false
                        "rtl": false,
                        "positionClass": "toast-top-right",
                        "preventDuplicates": false, // true or false
                        "showDuration": 300,
                        "hideDuration": 1000,
                        "timeOut": 5000,
                        "extendedTimeOut": 1000,
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                      }
                     toastr["error"](data.error, "Message");
                     $('#submit1').html('Submit');
                     $('#submit1').attr('disabled',false);
                   }
              }
            });
          }
        event.preventDefault();
        });
  });
</script>
