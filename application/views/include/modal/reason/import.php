<form id="form-reason-import" name="formUpload" action="" accept-charset="utf-8" method="POST"></form>

<style>
    .image-upload>input {
        display: none;
    }

    .image-upload img {
        width: 65px;
        cursor: pointer;
        margin-right: 10px;
    }

    .help-block {
        width: 70%;
        float: right;
    }

    .down-sample-reason {
        float: left;
        width: 100%;
        display: contents;
    }

    .modal-body.import {
        height: 120px;
    }

    .close {
        font-size: 27px;
        color: #fff;
        font-weight: bold;
    }
</style>

<div class="modal fade" id="modalImport" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header bg-primary text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modalTitle">
                    <em class="glyphicon glyphicon-upload"></em> Alasan Kedatangan
                </h4>
            </div>
            <div class="modal-body import">
                <div class="row">
                    <div class="col-lg-12">

                        <div class="form-group">
                            <label>
                                Import Data
                                <sup>
                                    <small>
                                        <p class="down-sample-reason">
                                            ( <em class="glyphicon glyphicon-list-alt"></em> sample )
                                        </p>
                                    </small>
                                </sup>
                            </label>
                            <div class="image-upload">
                                <label for="file-input">
                                    <img src="<?php echo base_url('assets/img/csv.png') ?>" alt="">
                                    <small class="help-block">Pilih file berformat *.csv dengan ukuran maksimal 2 MB.</small>
                                </label>
                                <input type="file" id="file-input" name="scsv" accept=".csv" form="form-reason-import" accept=".csv" >
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
                        <button type="submit" form="form-reason-import" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 btn btn-success">
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
        $(".down-sample-reason").on('click', function() {
            $.ajax({
                url: '<?= base_url('assets/sample/format_import_alasan_kedatangan.csv') ?>',
                method: 'GET',
                xhrFields: {
                    responseType: 'blob'
                },
                success: function(data) {
                    var a = document.createElement('a');
                    var url = window.URL.createObjectURL(data);
                    a.href = url;
                    a.download = 'format_alasan_kedatangan.csv';
                    document.body.append(a);
                    a.click();
                    a.remove();
                    window.URL.revokeObjectURL(url);
                }
            });
        });
    })
</script>