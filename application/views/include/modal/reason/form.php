<form id="form-reason" method="post"></form>

<style>
    select:required:invalid {
        color: #999;
    }

    option {
        color: #777;
        font-weight: bolder;
    }

    option[value=""][disabled] {
        display: none;
    }

    .input-group-prepend {
        position: absolute;
        margin: px;
        display: block;
        background: #cccccc;
        padding: 6px 10px;
        width: auto;
    }

    input[name=rv_reason_name] {
        padding: 6px 10px 6px 41px !important;
    }
</style>

<div class="modal fade" id="modalForm" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modalTitle">
                    <em class="glyphicon glyphicon-plus"></em> Alasan Kedatangan
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="row">
                            <div class="col-lg-12">
                                <h3>Form
                                    <sup>
                                        <small>
                                            <em class="glyphicon glyphicon-exclamation-sign text-info"></em>
                                            <em>Yang bertanda bintang ( <em class="text-danger">*</em> ) wajib diisi!</em>
                                        </small>
                                    </sup>
                                </h3>

                                <hr>

                                <div class="row">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="control-label">Urutan <em class="text-danger">*</em></label>
                                            <input type="number" form="form-reason" name="rv_reason_sort" maxlength="3" class="form-control" placeholder="Urutan..." required>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="form-group">
                                            <label class="control-label">Nama Singkat </label>
                                            <input type="text" form="form-reason" name="rv_reason_shortname" class="form-control" placeholder="Nama Singkat...">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="control-label">Kode <em class="text-danger">*</em></label>
                                            <input type="number" form="form-reason" name="rv_reason_code" class="form-control" placeholder="Kode..." required>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="form-group">
                                            <label class="control-label">Parent</label>
                                            <select id="s_parent" name="rv_reason_parent" class="form-control" form="form-reason">
                                                <option value="" disabled selected>Pilih...</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label">Nama <em class="text-danger">*</em></label>
                                    <div class="input-group-prepend">
                                        <input type="checkbox" form="form-reason" name="rv_reason_group" title="Checkbox" value="1" readonly>
                                    </div>
                                    <input type="text" form="form-reason" name="rv_reason_name" class="form-control" placeholder="Nama..." required>
                                    <p><small><em class="glyphicon glyphicon-exclamation-sign text-info"></em> Klik pada bagian checkbox di atas untuk mengaktifkan Revenue</small></p>
                                </div>

                                <div class="form-group">
                                    <label class="control-label">Status <em class="text-danger">*</em></label>
                                    <select id="sv_status" name="rv_reason_status" class="form-control" form="form-reason" required>
                                        <option value="" disabled selected>Pilih...</option>
                                        <option value="1">Aktif</option>
                                        <option value="2">Non Aktif</option>
                                    </select>
                                    <p><small><em class="glyphicon glyphicon-exclamation-sign text-info"></em> Digunakan untuk mengatur aktif atau non aktif inputan dan tampilan dilaporan UE</small></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="row">
                            <div class="col-lg-12">
                                <h3>Atribut
                                    <sup>
                                        <small>
                                            <em class="glyphicon glyphicon-exclamation-sign text-info"></em>
                                            <em>Pilih atribute format form upload UE (Unit Entry).</em>
                                        </small>
                                    </sup>
                                </h3>

                                <hr>

                                <div class="form-group">
                                    <label class="control-label">Format Input <em class="text-danger">*</em></label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" form="form-reason" name="rv_reason_type" id="type1" value="1" required>
                                        <label class="form-check-label" for="type1">Nominal ( default )</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" form="form-reason" name="rv_reason_type" id="type2" value="2" required>
                                        <label class="form-check-label" for="type2">Nominal ( Format Rupiah )</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label">Unit Entry <em class="text-danger">*</em></label>
                                    <select id="s_status" name="rv_reason_sum" class="form-control" form="form-reason" required>
                                        <option value="" disabled selected>Pilih...</option>
                                        <option value="1">Dihitung</option>
                                        <option value="2">Tidak Dihitung</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="control-label">Kelas</label>
                                    <select id="s_class" name="rv_class" class="form-control" form="form-reason">
                                        <option value="" disabled selected>Pilih...</option>
                                    </select>
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
                        <button type="submit" form="form-reason" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 btn btn-success">
                            <em class="glyphicon glyphicon-send"></em> Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>