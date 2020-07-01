<!DOCTYPE html>
<html>
<head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>SVNTH | <?=$pages;?></title>
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
                  <a href="<?=base_url();?>dashboard/auth/forgot_password"><?php echo lang('forgot_password_heading');?></a>
            </div>
            <div class="card">
                  <div class="card-body login-card-body">
                        <p class="login-box-msg"><?php echo $message;?></p>

                        <?php echo form_open("dashboard/auth/forgot_password");?>
                              <div class="input-group mb-3">
                                    <?php echo form_input($identity);?>
                                    <div class="input-group-append">
                                          <div class="input-group-text">
                                                <span class="fas fa-envelope"></span>
                                          </div>
                                    </div>
                              </div>
                              <div class="row">
                                    <div class="col-12">
                                          <button type="submit" class="btn btn-primary btn-block">Request new password</button>
                                    </div>
                              </div>
                        <?php echo form_close();?>
                        <p class="mt-3 mb-1">
                              <a href="<?=base_url('dashboard/auth/login')?>">Login</a>
                        </p>
                        <!-- <p class="mb-0">
                              <a href="register.html" class="text-center">Register a new membership</a>
                        </p> -->
                  </div>
            </div>
      </div>
      
      <script src="<?=base_url();?>/assets/back/plugins/jquery/jquery.min.js"></script>
      <script src="<?=base_url();?>/assets/back/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
      <script src="<?=base_url();?>/assets/back/dist/js/adminlte.min.js"></script>
</body>
</html>


<!-- <h1><?php echo lang('forgot_password_heading');?></h1>
<p><?php echo sprintf(lang('forgot_password_subheading'), $identity_label);?></p>

<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open("dashboard/auth/forgot_password");?>

      <p>
      	<label for="identity"><?php echo (($type=='email') ? sprintf(lang('forgot_password_email_label'), $identity_label) : sprintf(lang('forgot_password_identity_label'), $identity_label));?></label> <br />
      	<?php echo form_input($identity);?>
      </p>

      <p><?php echo form_submit('submit', lang('forgot_password_submit_btn'));?></p>

<?php echo form_close();?> -->
