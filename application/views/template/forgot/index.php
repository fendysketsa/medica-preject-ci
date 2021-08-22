<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="<?php echo base_url('assets/img/logo.png'); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo $title; ?></title>

    <link rel="shortcut icon" href="<?php echo base_url('assets/img/favicon.png') ?>">

    <link rel="stylesheet" href="<?php echo base_url('assets/plugins/fontawesome/css/fontawesome.min.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/plugins/fontawesome/css/all.min.css') ?>">

    <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/style-adding.css') ?>">

    <link href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/toast/toastr.min.css'); ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/pace//pace.min.css') ?>">

    <style>
        .login-body {
            height: 100%;
            background-image: radial-gradient(circle at center, rgb(18 96 204 / 0) 5%, rgb(104 115 125 / 0%) 0%, rgb(91 178 228) 85%);
            background-repeat: no-repeat, repeat;
            background-size: 100% 100%, 30px 30px;
            background-attachment: scroll;
        }

        html {
            height: 100%;
        }

        #page_overlay {
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #000;
            opacity: 0.95;
            z-index: 9999;
        }
    </style>

    <?php echo $script_captcha; ?>
</head>

<body>
    <div id="page_overlay"></div>

    <div class="main-wrapper login-body preload">
        <div class="login-wrapper">
            <div class="container">

                <img class="img-fluid logo-dark mb-2" src="assets/img/logo.png" alt="Logo">
                <div class="loginbox">
                    <?php echo $contentnya; ?>
                </div>
            </div>
        </div>
    </div>
</body>

<script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/toast/toastr.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/pace/pace.min.js'); ?>"></script>

<script src="<?php echo base_url('assets/js/jquery-3.6.0.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap.bundle.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/form-validation.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/script.js'); ?>"></script>

</html>