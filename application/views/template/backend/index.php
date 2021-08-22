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

    <title>Apotek Bersama | <?php echo $title; ?></title>

    <link href="<?php echo base_url('assets/css/select2/select2.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/bootstrap.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('assets/css/dataTables.bootstrap.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('assets/css/jquery.datatables.min.css'); ?>" rel="stylesheet" type="text/css" />

    <link href="<?php echo base_url('assets/css/toast/toastr.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/pace/pace.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/daterangepicker/daterangepicker.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/offline.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/offline.language.css'); ?>" rel="stylesheet">

    <style>
        body {
            min-height: 500px;
            padding-top: 70px;
        }

        @media (min-width:768px) {
            .container-header {
                margin: 0px 25px 0px 25px;
            }
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

        .fa-spinner {
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body>
    <div id="page_overlay"></div>
    <nav class="navbar navbar-default navbar-fixed-top">
        <?php echo $headernya; ?>
    </nav>

    <div>
        <?php echo $contentnya; ?>
    </div>
    <?php $this->load->view('template/backend/modal/changePassword'); ?>
</body>

<script src="<?php echo base_url('assets/js/select2/select2.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.datatables.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.bootstrap.js'); ?>"></script>

<script src="<?php echo base_url('assets/js/sweetalert/sweetalert.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/toast/toastr.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/pace/pace.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/daterangepicker/moment.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/daterangepicker/daterangepicker.min.js'); ?>"></script>

<script src="<?php echo base_url('assets/js/modernizr.min.js'); ?>"></script>
<script type="text/javascript">
    try {
        Typekit.load();
    } catch (e) {}
</script>
<script src="<?php echo base_url('assets/js/offline.min.js'); ?>"></script>

<script src="https://js.pusher.com/4.4/pusher.min.js"></script>

<script>
    $(document).keydown(function(event) {
        if (event.keyCode == 123) {
            // $("html").remove()
            return false;
        } else if (event.ctrlKey && event.shiftKey && event.keyCode == 73) {
            // $("html").remove()
            return false;
        }
    });

    function rtclickcheck(keyp) {
        if (navigator.appName == "Netscape" && keyp.which == 3) {
            return false;
        }

        if (navigator.appVersion.indexOf("MSIE") != -1 && event.button == 2) {
            return false;
        }
    }

    document.onmousedown = rtclickcheck;

    $(document).ready(function() {

        var checkStatus;

        var element = new Image();
        element.__defineGetter__('id', function() {
            checkStatus = 'on';
        });

        setInterval(function() {
            checkStatus = 'off';

            // console.log(element);
            // console.clear();

            if (checkStatus == 'on') {
                // $('html').remove();

                return false;
            }
        }, 1000)

        if (event.keyCode == 123) {
            return false;
        }

        <?php if ($this->session->userdata('role') != 'ahass') { ?>
            // Pusher.logToConsole = false;

            // var pusher = new Pusher('fb03a91b81a46786b723', {
            //     cluster: 'ap1',
            //     forceTLS: true
            // });

            // var channel = pusher.subscribe('my-channel');
            // channel.bind('my-event', function(data) {
            //     if (data.code === 'success') {
            //         var snd = new Audio('/assets/sound/welcome.mp3?v=2');

            //         snd.onended = function() {
            //             toastr.info(`<small>` + data.message + `</small>`, 'Informasi', {
            //                 "closeButton": true,
            //                 "progressBar": true,
            //                 "timeOut": 5000,
            //                 "extendedTimeOut": 1000,
            //             })

            //             $("#tableData").dataTable().api().ajax.reload()
            //         };

            //         snd.play();
            //     }
            // });

        <?php } ?>

        document.addEventListener("contextmenu", function(e) {
            e.preventDefault();
        }, false);

        document.onkeydown = function(e) {
            if (e.ctrlKey &&
                (e.keyCode === 67 ||
                    e.keyCode === 85 ||
                    e.keyCode === 117
                    // || e.keyCode === 73
                )) {
                return false;
            } else {
                return true;
            }
        };

        $(document).keypress("u", function(e) {
            if (e.ctrlKey) {
                return false;
            } else {
                return true;
            }
        });

        Pace.on("done", function() {
            $('#page_overlay').delay(300).fadeOut(600);
        });

        toastr.info('<small>Memory Usage: {memory_usage} <br> Ellapsed Time: {elapsed_time}</small>', 'Informasi')

        $(".auth-logout").on('click', function() {

            swal({
                    title: "Apakah anda yakin ingin keluar ?",
                    text: "Anda akan diarahkan ke halaman login!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                    buttons: ["Batal", "Keluar"],
                })
                .then((willClosed) => {
                    if (willClosed) {

                        var post_url = '<?php echo base_url() . 'auth/logout' ?>';
                        var request_method = "POST";

                        $.ajax({
                            url: post_url,
                            data: {
                                out: 'yes'
                            },
                            type: request_method,
                            dataType: "JSON",
                        }).done(function(response) {
                            if (response.code == 500) {
                                toastr.warning(response.mess, 'Peringatan')
                            } else {
                                var snd = new Audio('/assets/sound/out.mp3');
                                snd.onended = function() {
                                    window.location.href = response.redirect
                                }
                                snd.play();
                                toastr.success(response.mess, 'Sukses', {
                                    timeOut: 3000,
                                    fadeOut: 3000
                                })
                            }
                        }).fail(function() {
                            toastr.error('Kesalahan sistem!', 'Error')
                        });

                    } else {
                        swal.close()
                    }
                });

            return true;
        })
    });

    if (localStorage.getItem('sound-welcome') == 'yes') {
        var snd = new Audio('/assets/sound/welcome.mp3?v=1');
        snd.onended = function() {
            localStorage.removeItem('sound-welcome')
        };
        snd.play();
    }
</script>

</html>