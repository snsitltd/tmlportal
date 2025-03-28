<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title><?php echo WEB_PAGE_TITLE; ?> | Admin System Log in</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('assets/dist/css/AdminLTE.min.css'); ?>" rel="stylesheet" type="text/css" />
    <script src='https://www.google.com/recaptcha/api.js'></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="login-page">
    <div class="login-box">
      <div class="login-logo"></div>
      <div class="login-box-body">
        <p class="login-box-msg"><a href="#"><img src="<?php echo site_url('assets/Uploads/Logo/'.WEB_PAGE_LOGO)?>" alt="<?php echo WEB_PAGE_TITLE; ?>" width="100" ></a><br>Sign In</p>
        <?php $this->load->helper('form'); ?>
        <div class="row">
            <div class="col-md-12">
                <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
            </div>
        </div>
        <?php
        $this->load->helper('form');
        $error = $this->session->flashdata('error');
        if($error){?>
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?php echo $error; ?>                    
            </div>
        <?php }
        $success = $this->session->flashdata('success');
        if($success){ ?>
            <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?php echo $success; ?>                    
            </div> 
        <?php } ?>
        
        <form action="<?php echo base_url('loginMe'); ?>" method="post">
          <div class="form-group has-feedback">
            <input type="email" class="form-control" placeholder="Email" name="email" required />
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
                 <?php /*
			$encrypted_password = '$2y$10$dT42p.Ge.YWQ7rcgEZzjM.f9qWfmMjXXxwYb2ncTI/IddKdlxTcQC';
			$key = 'asjkrue*$djasfl134213';

			echo "hi".  $decrypted_string = $this->encrypt->decode($encrypted_password, $key); */
?>

          <div class="form-group has-feedback">
            <input type="password" class="form-control" placeholder="Password" name="password" required />
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <?php if(GOOGLE_RECAPTCHA_STATUS){ ?>
            <div class="col-xs-12">  
              <div class="g-recaptcha" data-sitekey="<?php echo GOOGLE_RECAPTCHA_SITEKEY; ?>"></div>  
                <!-- <div class="checkbox icheck">
                  <label>
                    <input type="checkbox"> Remember Me
                  </label>
                </div>  -->                       
              </div><!-- /.col -->
            <?php } ?>
			
            <div class="col-xs-4">
			  <div class="g-recaptcha" data-sitekey="<?php echo $this->config->item('google_key') ?>"></div>  <br>
              <input type="submit" class="btn btn-primary btn-block btn-flat" value="Sign In" />
            </div><!-- /.col -->
          </div>
        </form>

        <a href="<?php echo base_url() ?>forgotPassword">Forgot Password</a><br>
        
      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

    <script src="<?php echo base_url(); ?>assets/js/jQuery-2.1.4.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>

<script>
    function recaptchaCallback() {
        var btnSubmit = document.getElementById("btnSubmit");

        if ( btnSubmit.classList.contains("hidden") ) {
            btnSubmit.classList.remove("hidden");
            btnSubmitclassList.add("show");
        }
    }
</script>
</body>
</html>
