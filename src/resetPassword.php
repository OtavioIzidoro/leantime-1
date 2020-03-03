<!DOCTYPE html>
<html dir="<?php echo $language->__("language.direction"); ?>" lang="<?php echo $language->__("language.code"); ?>">
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="theme-color" content="#<?php echo $_SESSION["companysettings.mainColor"] ?>">
    <meta name="identifier-URL" content="<?=BASE_URL?>">

    <link rel="shortcut icon" href="<?=BASE_URL?>/favicon.ico"/>
    <link rel="apple-touch-icon" href="<?=BASE_URL?>/apple-touch-icon.png">

    <title><?php echo $_SESSION["companysettings.sitename"]; ?></title>

    <?php echo $frontController->includeAction('general.header'); ?>

    <link rel="stylesheet" href="<?=BASE_URL?>/css/main.css?v=<?php echo $settings->appVersion; ?>"/>
    <link rel="stylesheet" href="<?=BASE_URL?>/css/style.default.css?v=<?php echo $settings->appVersion; ?>" type="text/css" />
    <link rel="stylesheet" href="<?=BASE_URL?>/css/style.custom.php?color=<?php echo $_SESSION["companysettings.mainColor"]; ?>&v=<?php echo $settings->appVersion; ?>" type="text/css" />

    <script src="<?=BASE_URL?>/js/compiled-libs-login.min.js?v=<?php echo $settings->appVersion; ?>"></script>

</head>

<script type="text/javascript">
    jQuery(document).ready(function(){
        
        if(jQuery('.login-alert .alert-error').text() != ''){
            jQuery('.login-error').fadeIn();
        }
        
        if(jQuery('.login-alert .alert-success').text() != ''){
            jQuery('.login-success').fadeIn();
        }

    });
</script>
</head>

<body class="loginpage" style="height:100%;">

<div class="header hidden-gt-sm">

    <div class="logo" style="margin-left:0px;">
        <a href="<?=BASE_URL ?>" style="background-image:url(<?php echo $config->logoPath; ?>">&nbsp;</a>
    </div>

</div>

<div class="row " style="height:100%; width: 99%;">
    <div class="col-md-6 hidden-phone regLeft" style="background:#<?php echo $_SESSION["companysettings.mainColor"]; ?>" >
        <div class="row">
            <div class="col-md-5">

            </div>
            <div class="col-md-6" style="position:relative;">
                <a href="<?=BASE_URL ?>/" target="_blank"><img src="<?php echo $_SESSION["companysettings.logoPath"]; ?>" /></a>
                <h1 style="font-family:Exo;  font-size: 64px; padding-left:15px; font-weight:400;">Drive Impact</h1>
                <span class="iq-objects-04 iq-fadebounce">
				    <span class="iq-round"></span>
                </span>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-sm-12 regRight"  style="box-shadow: -2px 0px 2px #494949; padding-top:14%; border-left: 1px solid #ddd;">

        <div class="regpanel">
            <div class="regpanelinner">
                <div class="pageheader">
                    <div class="pageicon"><span class="iconfa-signin"></span></div>
                    <div class="pagetitle">
                        <h5><?php echo $_SESSION["companysettings.sitename"]; ?></h5>
                        <h1>Reset Password</h1>
                    </div>
                </div>
                <div class="regcontent"  style="margin-left: 90px;">
        
                    <form id="resetPassword" action="" method="post">
            
                        <div class="inputwrapper login-alert login-error">
                            <div class="alert alert-error"><?php echo $login->error;?></div>
                        </div>
                        <div class="inputwrapper login-alert login-success">
                            <div class="alert alert-success"><?php echo $login->success;?></div>
                        </div>

                        <?php
                        if((isset($_GET["hash"]) === true && $login->validateResetLink()) || $login->resetInProgress === true) { ?>

                            <p>Enter your new password to reset it. <br /><br /></p>
                            <div class="">
                                <input type="password" name="password" id="password" placeholder="Enter New Password" />
                            </div>
                            <div class=" ">
                                <input type="password" name="password2" id="password2" placeholder="Confirm Password" />
                            </div>
                            <div class="">
                                <a href="<?=BASE_URL ?>/" style="float:right; margin-top:10px;">Back to login</a>
                                <input type="submit" name="resetPassword" value="Reset Password" />
                            </div>

                        <?php }else{ ?>
                            <p>Enter your email address to reset your password. <br /><br /></p>
                            <div class="">
                                <input type="text" name="username" id="username" placeholder="Enter Email Address" />
                            </div>

                            <div class="">
                                <a href="<?=BASE_URL ?>/" style="float:right; margin-top:10px;">Back to login</a>
                                <input type="submit" name="resetPassword" value="Reset Password" />
                            </div>
                        <?php } ?>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
