<form id="form-profile" method="post"></form>

<style>
    .help-blocks {
        width: 100%;
    }
</style>
<div class="modal fade" id="modalProfile" tabindex="-1" role="dialog" aria-labelledby="modalProfile" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modalProfile">
                    <em class="glyphicon glyphicon-user"></em> Profile
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-12">
                                <h3>Edit Profil <?= $this->session->userdata['nama'] ?></h3>
                                <hr>

                                <div class="mb-1">
                                    <label>Nama Lengkap</label>
                                    <input type="nama" form="form-profile" name="u_fname" class="form-control" value="<?= $this->session->userdata['nama'] ?>" placeholder="Nama Lengkap" minlength="3" maxlength="50" required>
                                </div>

                                <div class="mb-1">
                                    <label>Username</label>
                                    <input disabled type="text" form="form-profile" name="u_name" class="form-control" value="<?= $this->session->userdata['username'] ?>" placeholder="Username" minlength="5" maxlength="20" required>
                                </div>

                                <div class="mb-1">
                                    <label>Password Baru</label>
                                    <input type="password" form="form-profile" name="u_pass" class="form-control" placeholder="Password Baru" minlength="5" required>
                                </div>

                                <div class="mb-1">
                                    <label>Konfirmasi Password</label>
                                    <input type="password" form="form-profile" name="u_passconf" class="form-control" placeholder="Konfirmasi Password" minlength="5" required>
                                </div>

                                <div class="mb-1">
                                    <div class="">
                                        <small class="help-blocks">
                                            <em class="glyphicon glyphicon-info-sign"></em>
                                            Silakan memperbarui password, Anda akan diminta melakukan login ulang.</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer bg-warning">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <button type="button" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 btn btn-warning" data-dismiss="modal">
                            <em class="glyphicon glyphicon-remove"></em> Batal</button>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <button class="col-lg-12 col-md-12 col-sm-12 col-xs-12 btn change-profile">
                            <em class="glyphicon glyphicon-send"></em> Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>

<script>
    $(document).ready(function() {

        $("#form-profile").attr('action', '<?php echo base_url() . 'md/access/profile' ?>');

        function checkPasswordMatch() {
            var password = $("input[name=u_pass]").val()
            var confirmPassword = $("input[name=u_passconf]").val()

            if ((password === confirmPassword) && password.length > 5 && confirmPassword.length > 5)
                $(".change-profile")
                .attr('type', 'submit')
                .attr('form', 'form-profile')
                .addClass('btn-success')
                .removeClass('btn-disabled')
            else
                $(".change-profile")
                .removeAttr('type')
                .removeAttr('form')
                .addClass('btn-disabled')
                .removeClass('btn-success')
        }

        $("input[type=password]").on('keyup', function() {
            checkPasswordMatch()
        })

        $("#form-profile").submit(function(e) {
            e.preventDefault()

            var post_url = $(this).attr("action");
            var request_method = $(this).attr("method");
            var form_data = new FormData(this);

            $.ajax({
                url: post_url,
                type: request_method,
                data: form_data,
                dataType: "JSON",
                contentType: false,
                cache: false,
                processData: false
            }).done(function(response) {
                console.log(response)
                if (response.code == 500) {
                    toastr.warning(response.mess, 'Peringatan')
                } else {
                    $('#modalProfile').modal('hide');
                    $("#modalProfile").on('hidden.bs.modal', function() {
                        toastr.info("Setelah password direset, Anda perlu login ulang!", 'Sukses', {
                            timeOut: 3000,
                            fadeOut: 3000,
                            onHidden: function() {

                                var post_url = response.redirect
                                var request_method = "POST";

                                $.ajax({
                                    url: post_url,
                                    type: request_method,
                                    data: {
                                        out: 'yes'
                                    },
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
                            }
                        })
                    });
                    toastr.success(response.mess, 'Sukses')
                }
            }).fail(function() {
                toastr.error('Kesalahan sistem!', 'Error')
            });
        })
    });
</script>