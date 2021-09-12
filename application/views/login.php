<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<style>
    .fa-spinner {
        animation: spin 4s linear infinite;
    }

    form {
        display: contents;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    .mt-20 {
        margin-top: 20px;
    }

    input[id=password] {
        padding-right: 53px !important;
    }

    .icon-eyes {
        z-index: 9;
        margin: 1px;
        margin-right: 10px !important;
        color: #999;
    }

    #forgot {
        color: #000;
    }
</style>

<form method="post" id="form-login" class="needs-validation" novalidate>

    <div class="login-right">
        <div class="login-right-wrap">
            <h1>APOTEK BERSAMA</h1>
            <p class="account-subtitle">Silakan login dengan menggunakan email dan password anda.</p>

            <div class="form-group input-group">
                <label class="form-control-label" for="email">Email: </label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><em class="fas fa-envelope"></em></span>
                    </div>
                    <input type="email" id="email" autocomplete="off" form="form-login" class="form-control form-control-sm" placeholder="Email" name="email" required autofocus>
                    <div class="invalid-feedback">
                        Please type email.
                    </div>
                </div>
            </div>

            <div class="form-group input-group">
                <label class="form-control-label" for="password">Password: </label>
                <div class="pass-group input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><em class="fas fa-lock"></em></span>
                    </div>
                    <input type="password" id="password" name="password" autocomplete="off" form="form-login" class="form-control form-control-sm pass-input" placeholder="Password" required>
                    <span class="fas fa-eye icon-eyes toggle-password"></span>
                    <div class="invalid-feedback">
                        Please type password.
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-lg-12">
                        <?php echo $captcha; ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-6">
                        <div class="custom-control custom-checkbox">
                            <input id="remember-me" type="checkbox" class="custom-control-input">
                            <label class="custom-control-label" for="remember-me">Remember me</label>
                        </div>
                    </div>
                    <div class="col-6 text-right">
                        <a class="forgot-link" href="<?php echo site_url('forgot-password') ?>">Lupa Password ?</a>
                    </div>
                </div>
            </div>
            <button class="btn btn-md btn-block btn-primary" form="form-login" type="submit"><em class="fas fa-sign-in-alt"></em> Login</button>
        </div>
    </div>

</form>

<script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>

<script>
    $(document).ready(function() {

        cekPassIsNull('')

        function cekPassIsNull(isNullPass) {

            if (!isNullPass) {
                $(".icon-eyes").hide()
            } else {
                $(".icon-eyes").show()
            }
        }

        $(function() {

            $("#password").on('input', function() {
                var isNullPass = $(this).val()
                cekPassIsNull(isNullPass)
            });

            if (localStorage.chkbx && localStorage.chkbx != '') {
                $('#remember-me').attr('checked', 'checked');
                $('#email').val(localStorage.usrname);
                $('#password').val(localStorage.pass);
            } else {
                $('#remember-me').removeAttr('checked');
                $('#email').val('');
                $('#password').val('');
            }

            $('#remember-me').click(function() {

                if ($('#remember-me').is(':checked')) {
                    localStorage.usrname = $('#email').val();
                    localStorage.pass = $('#password').val();
                    localStorage.chkbx = $('#remember-me').val();
                } else {
                    localStorage.usrname = '';
                    localStorage.pass = '';
                    localStorage.chkbx = '';
                }
            });

        });

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

            $(".g-recaptcha-response").attr('form', 'form-login')
        });

        $('#password').attr('pass-shown', 'false')

        // Show hide password
        $('.icon-eyes').on('click', function() {
            if ($('#password').attr('pass-shown') == 'false') {
                $('#password').removeAttr('type');
                $('#password').attr('type', 'text');
                $('#password').removeAttr('pass-shown');
                $('#password').attr('pass-shown', 'true');
                $(this).removeClass('fa-eye');
                $(this).addClass('fa-eye-slash');
            } else {
                $('#password').removeAttr('type');
                $('#password').attr('type', 'password');
                $('#password').removeAttr('pass-shown');
                $('#password').attr('pass-shown', 'false');
                $(this).removeClass('fa-eye-slash');
                $(this).addClass('fa-eye');
            }
        });

        $("#form-login").attr('action', '<?php echo base_url() . 'auth/login' ?>')
        $("#form-login").submit(function(e) {
            e.preventDefault()

            var post_url = $(this).attr("action");
            var request_method = $(this).attr("method");
            var form_data = new FormData(this);

            $.ajax({
                type: request_method,
                url: post_url,
                data: form_data,
                dataType: "JSON",
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {

                    $("button[type=submit]")
                        .attr('disabled', true)
                        .html(`<em class="fas fa-spinner"></em>`);
                },
                success: function(response) {
                    if (response.code == 200) {
                        var snd = new Audio('/assets/sound/success.mp3');
                        snd.onended = function() {
                            toastr.info('Jika Anda tidak dialihkan secara otomatis, silakan resfresh browser Anda.', 'Informasi', {
                                timeOut: 3000,
                                fadeOut: 3000,
                                onHidden: function() {
                                    localStorage.setItem('sound-welcome', 'yes')
                                    window.location.href = response.redirect
                                }
                            });
                        }
                        snd.play();
                        toastr.success(response.mess, 'Success', {
                            timeOut: 2000,
                            fadeOut: 2000
                        });
                    } else {
                        var snd = new Audio('/assets/sound/failed.mp3');
                        snd.onended = function() {
                            $("button[type=submit]").removeAttr('disabled').html(`<em class="fas fa-sign-in-alt"></em> Login`);
                        }
                        snd.play();
                        toastr.warning(response.mess, 'Peringatan', {
                            timeOut: 1000,
                            fadeOut: 1000,
                            onHidden: function() {
                                localStorage.removeItem('sound-welcome')
                            }
                        })
                    }
                },
                error: function() {
                    var snd = new Audio('/assets/sound/failed.mp3');
                    snd.onended = function() {
                        $("button[type=submit]").removeAttr('disabled').html(`<em class="fas fa-sign-in-alt"></em> Login`);
                    }
                    snd.play();
                    toastr.error('Kesalahan system!', 'Error', {
                        timeOut: 2000,
                        fadeOut: 2000,
                        onHidden: function() {
                            localStorage.removeItem('sound-welcome')
                        }
                    })
                },
                complete: function() {
                    grecaptcha.reset();
                }
            });

            return false;
        });
    });
</script>