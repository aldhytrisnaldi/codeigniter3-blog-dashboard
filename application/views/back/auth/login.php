<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?=$pages;?> | TECHNOCT</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="<?=base_url();?>/assets/svnth/logo.PNG" type="image/x-icon">
  <link rel="stylesheet" href="<?=base_url();?>/assets/back/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="<?=base_url();?>/assets/back/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="<?=base_url();?>/assets/back/dist/css/adminlte.min.css">
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <a href="<?php base_url('dashboard/auth/login');?>"><img src="<?=base_url();?>/assets/svnth/logo.PNG" alt="" width="100px"></a>
      <p>TECHNOCT</p>
    </div>
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg"><?php echo $message;?></p>
        <?php echo form_open("dashboard/auth/login");?>
          <div class="input-group mb-4">
            <?php echo form_input($identity);?>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-4">
            <?php echo form_input($password);?>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-8">
              <div class="icheck-primary">
                <?php echo form_checkbox('remember', '1', FALSE, 'id="remember"');?>
                <label for="remember">
                  Remember Me
                </label>
              </div>
            </div>
            <div class="col-4 mb-4">
              <?php echo form_submit('submit', lang('login_submit_btn'),'class="btn btn-primary btn-block"');?>
            </div>
          </div>
          <div class="row">
            <div class="col-4 mb-4" >
              <?php echo $script_captcha;?>
              <?php echo $captcha ?>
            </div>
          </div>
        <?php echo form_close();?>
        <p class="text-center">
          <a href="<?=base_url('dashboard/auth/forgot_password');?>"><?php echo lang('login_forgot_password');?></a>
        </p>
      </div>
    </div>
  </div>

  <script src="<?=base_url();?>/assets/back/plugins/jquery/jquery.min.js"></script>
  <script src="<?=base_url();?>/assets/back/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?=base_url();?>/assets/back/dist/js/adminlte.min.js"></script>

</body>
</html>