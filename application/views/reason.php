<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h2><em class="glyphicon glyphicon-th-list"></em>
                Alasan Kedatangan</h2>
            <hr>
            <div class="card">
                <a class="btn btn-info btn-sm add" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#modalForm">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Tambah Data</a>
                <a class="btn btn-warning btn-sm import" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#modalImport">
                    <span class="glyphicon glyphicon-upload" aria-hidden="true"></span>
                    Import Data</a>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-lg-12">
            <table class="table table-striped" id="tableData">
                <thead class="bg-primary">
                    <tr>
                        <th>No</th>
                        <th>Sort</th>
                        <th>Kode</th>
                        <th>Alasan</th>
                        <th>Format</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<?php $this->load->view('include/modal/reason/form'); ?>
<?php $this->load->view('include/modal/reason/import'); ?>

<script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>

<script>
    $(document).ready(function() {

        $.fn.dataTable.ext.errMode = 'throw';
        $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings) {
            return {
                "iStart": oSettings._iDisplayStart,
                "iEnd": oSettings.fnDisplayEnd(),
                "iLength": oSettings._iDisplayLength,
                "iTotal": oSettings.fnRecordsTotal(),
                "iFilteredTotal": oSettings.fnRecordsDisplay(),
                "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
                "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
            };
        };

        var table = $("#tableData").dataTable({
            initComplete: function() {
                var api = this.api();
                $('#tableData_filter input')
                    .off('.DT')
                    .on('input.DT', function() {
                        api.search(this.value).draw();
                    });
            },
            "scrollX": true,
            "processing": true,
            "language": {
                "processing": "<span class='glyphicon glyphicon-repeat fa-spinner' aria-hidden='true'></span> Sedang memuat....."
            },
            "serverSide": true,
            "ajax": {
                "url": "<?php echo base_url() . 'md/reason/collect' ?>",
                "type": "POST"
            },
            "deferRender": true,
            "columns": [{
                    "data": null,
                    "orderable": true,
                    "searchable": false
                },
                {
                    "data": "rv_reason_sort"
                },
                {
                    "data": "rv_reason_code"
                },
                {
                    "data": "rv_reason_name",
                    "render": function(data, type, row, meta) {
                        var stts = (!row.rv_reason_status ? '' : (row.rv_reason_status == 1 ? `<em class="glyphicon glyphicon-ok-circle text-success"></em>` : '<em class="glyphicon glyphicon-remove-circle text-danger"></em>'))
                        return stts + `<em class="get-in-class" data-status_ = "` + (!row.rv_reason_status ? '' : row.rv_reason_status) + `" data-class_="` + (!row.rv_reason_class ? '' : row.rv_reason_class) + `"></em> ` + row.rv_reason_name
                    }
                },
                {
                    "data": "rv_reason_type",
                    "render": function(data, type, row, meta) {
                        return (data == 1 ? 'Nominal' : 'Rupiah') + ` <span class="badge label-success">` + (row.rv_reason_sum == 1 ? 'counted' : '') + `</span>`;
                    }
                },
                {
                    "data": "view"
                }
            ],
            "order": [
                [1, 'asc']
            ],
            "rowCallback": function(row, data, iDisplayIndex) {
                var info = this.fnPagingInfo();
                var page = info.iPage;
                var length = info.iLength;
                var index = page * length + (iDisplayIndex + 1);
                $('td:eq(0)', row).html(index);
            }
        });

        form(table)
        formImport(table)
        add()
        imports()
        edit(table)
        remove(table)
    });

    function _select(id, param) {
        var id_ = id || ''

        $.ajax({
            url: '<?php echo base_url() . 'md/reason/option' ?>?param=' + param,
            type: 'GET',
            dataType: 'json',
        }).done(function(response) {
            if (response.code == 500) {
                toastr.warning(response.mess, 'Peringatan')
            } else {
                var opt = ``

                if (param == 'parent') {
                    opt += `<option value="" disabled selected>Pilih...</option>`
                    $.each(response.data, function(e, i) {
                        var selected = id_ == i.rv_id ? 'selected' : ''

                        opt += `<option ` + selected + ` value="` + i.rv_id + `">` + i.rv_reason_name + `</option>`
                    })
                }

                if (param == 'class') {
                    opt += `<option value="" disabled selected>Pilih...</option>`
                    $.each(response.data, function(e, i) {
                        var selected = id_ == i.c_id ? 'selected' : ''

                        opt += `<option ` + selected + ` value="` + i.c_id + `">` + i.c_name + `</option>`
                    })
                }

                $("#s_" + param).html(opt)
            }
        }).fail(function() {
            toastr.error('Kesalahan sistem!', 'Error')
        });
    }

    function add() {
        $('.add').on('click', function(e) {
            $("#editID").remove()
            $('[name="rv_reason_code"]').val('').removeAttr('readonly')
            $('[name="rv_reason_parent"]').val('').change();
            $('[name="rv_reason_name"]').val('');
            $('[name="rv_reason_sum"]').val('');
            $('[name="rv_reason_sort"]').val('');
            $('[name="rv_reason_shortname"]').val('');
            $('[name="rv_reason_group"]').prop('checked', false);
            $('[name="rv_reason_type"]').prop('checked', false);
            $('[name="rv_reason_status"]').val('').change();

            $("#form-reason").attr('action', '<?php echo base_url() . 'md/reason/store' ?>');
            $("h4#modalTitle").find('em').addClass('glyphicon-plus').removeClass('glyphicon-pencil')

            _select('', 'parent')
            _select('', 'class')
        });
    }

    function imports() {
        $('.import').on('click', function(e) {
            $("#form-reason-import").attr('action', '<?php echo base_url() . 'md/reason/import' ?>');
            $("#file-input").val('')
        });

        $("#file-input").on('change', function() {
            checkExt()
        })
    }

    function checkExt() {
        if (document.formUpload.scsv.value != '' && document.formUpload.scsv.value.lastIndexOf(".csv") == -1) {
            toastr.warning('File harus berformat .csv!', 'Peringatan')
            $("#file-input").val('')
            return false;
        }
    }

    function edit(table) {
        $('#tableData').on('click', '.edit', function() {
            var code = $(this).data('code');
            var parent = $(this).data('parent');
            var name = $(this).data('name');
            var type = $(this).data('type');
            var sum = $(this).data('sum');
            var sort = $(this).data('sort');
            var group = $(this).data('group');
            var s_name = $(this).data('sh-name');

            var _class = $(this).closest('tr').find('em.get-in-class').attr('data-class_');
            var sv_status = $(this).closest('tr').find('em.get-in-class').attr('data-status_');

            var inUse = parseInt($(this).data('inuse'));

            $('#modalForm').modal({
                backdrop: 'static',
                keyboard: false
            });
            $("#form-reason").attr('action', '<?php echo base_url() . 'md/reason/edit' ?>')
            $("h4#modalTitle").find('em').addClass('glyphicon-pencil').removeClass('glyphicon-plus')

            $("#editID").remove()
            $("#modalForm").find('.modal-body').append('<input id="editID">')
            $("#editID").attr('type', 'hidden')
                .attr('name', 'id')
                .attr('value', $(this).data('id'))
                .attr('form', 'form-reason')
            if (inUse > 0) {
                $('[name="rv_reason_code"]').val(code).attr('readonly', true);
            } else {
                $('[name="rv_reason_code"]').val(code).removeAttr('readonly');
            }

            $('[name="rv_reason_parent"]').val('').change();
            _select(parent, 'parent')

            $('[name="rv_class"]').val('').change();
            _select(_class, 'class')

            $('[name="rv_reason_name"]').val(name);
            $('[name="rv_reason_shortname"]').val(s_name);

            var radios = $("input[name=rv_reason_type]").removeAttr('checked');
            var length = radios.length;

            for (var i = 0; i < length; i++) {
                if (radios[i].value == type) {
                    $(radios[i]).attr('checked', true).prop('checked', true);
                    break;
                }
            }

            $('[name="rv_reason_sort"]').val(sort);
            $('[name="rv_reason_sum"]').val(sum);

            $('[name="rv_reason_status"]').val(sv_status).change();

            if (group == 1 && group) {
                $('[name="rv_reason_group"]').prop('checked', true);
            } else {
                $('[name="rv_reason_group"]').prop('checked', false);
            }

        });
    }

    function remove(table) {

        $('#tableData').on('click', '.remove', function(e) {
            e.preventDefault()
            var kode = $(this).data('id');
            var used = parseInt($(this).data('inuse'));

            if (used > 0) {
                toastr.warning('Anda tidak diperkenankan menghapus data!', 'Peringatan')
                return false;
            }

            swal({
                    title: "Anda ingin menghapus data ini?",
                    text: "Data yang terhapus tidak dapat dikembalikan!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                    buttons: ["Batal", "Delete"],
                })
                .then((willDelete) => {
                    if (willDelete) {

                        var post_url = '<?php echo base_url() . 'md/reason/remove' ?>';
                        var request_method = "POST";

                        $.ajax({
                            url: post_url,
                            type: request_method,
                            data: {
                                "id": kode
                            },
                            dataType: "JSON",
                        }).done(function(response) {
                            if (response.code == 500) {
                                toastr.warning(response.mess, 'Peringatan')
                            } else {
                                table.api().ajax.reload()
                                toastr.success(response.mess, 'Sukses')
                            }
                        }).fail(function() {
                            toastr.error('Kesalahan sistem!', 'Error')
                        });

                    } else {
                        swal.close()
                    }
                });

            return true;

        });
    }

    function form(table) {
        $("#form-reason").submit(function(e) {
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
                if (response.code == 500) {
                    toastr.warning(response.mess, 'Peringatan')
                } else {
                    $('#modalForm').modal('hide');
                    table.api().ajax.reload()
                    toastr.success(response.mess, 'Sukses')
                }
            }).fail(function() {
                toastr.error('Kesalahan sistem!', 'Error')
            });
        })
    }

    function disabledFormUp() {
        $("button[type=button]").attr('disabled', true);
        $("button[type=submit]").attr('disabled', true).html(`<em class="glyphicon glyphicon-repeat fa-spinner"></em> loading...`);
        $('.image-upload').css({
            'background': '#fff',
            'pointer-events': 'none',
            'opacity': '0.5'
        });
    }

    function enabledFormUp() {
        $("button[type=button]").removeAttr('disabled');
        $("button[type=submit]").removeAttr('disabled').html(`<em class="glyphicon glyphicon-send"></em> Simpan`)
        $('.image-upload').removeAttr('style')
    }

    function formImport(table) {
        $("#form-reason-import").submit(function(e) {
            e.preventDefault()

            var post_url = $(this).attr("action");
            var request_method = $(this).attr("method");
            var form_data = new FormData(this);

            var fileInput = $("#file-input").val()
            if (!fileInput) {
                toastr.warning("Silakan pilih file Anda !", 'Peringatan')
                return false;
            }

            disabledFormUp()

            $.ajax({
                url: post_url,
                type: request_method,
                data: form_data,
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                async: true,
            }).done(function(response) {
                if (response.code == 500) {
                    toastr.warning(response.mess, 'Peringatan')
                } else {
                    $('#modalImport').modal('hide');
                    $("#modalImport").on('hidden.bs.modal', function() {
                        $("input[type=file]").val('').change()
                    });
                    table.api().ajax.reload()
                    toastr.success(response.mess, 'Sukses')
                }
            }).fail(function() {
                toastr.error('Kesalahan sistem!', 'Error')
            }).always(function() {
                enabledFormUp()
            });
        })
    }
</script>