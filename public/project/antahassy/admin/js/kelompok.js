$(document).ready(function(){
    $.ajaxSetup({
        headers     : {
            'X-CSRF-TOKEN'  : $('meta[name="csrf-token"]').attr('content')
        }
    });
    var nama_bulan = new Array();
    nama_bulan[1] = 'Januari';
    nama_bulan[2] = 'Februari';
    nama_bulan[3] = 'Maret';
    nama_bulan[4] = 'April';
    nama_bulan[5] = 'Mei';
    nama_bulan[6] = 'Juni';
    nama_bulan[7] = 'Juli';
    nama_bulan[8] = 'Agustus'; 
    nama_bulan[9] = 'September'; 
    nama_bulan[10] = 'Oktober';
    nama_bulan[11] = 'November'; 
    nama_bulan[12] = 'Desember';
    var table_data = '';
    swal({
        showConfirmButton   : false,
        allowOutsideClick   : false,
        allowEscapeKey      : false,
        background          : 'transparent',
        onOpen  : function(){
            swal.showLoading();
            setTimeout(function(){
                data_table();
            },300);
        }
    });
    function main(){
        $('#form_data').attr('method', 'post');
        $('#_method').val('post');
        $('#form_data').attr('action', site + '/p_kelompok');
        var mindate, maxdate;
        if(id_group == 2){
            mindate = new Date();
            maxdate = new Date();
        }else{
            mindate = new Date(date_range[0].tanggal);
            maxdate = new Date();
        }
        $('#tanggal').datepicker({
            minDate: mindate,
            maxDate: maxdate,
            yearRange : '-1:+1',
            changeMonth: true,
            changeYear: true,
            dateFormat: 'dd MM yy',
            dayNames: ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'],
            dayNamesMin: ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'],
            monthNamesShort: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
            monthNames: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
            beforeShow: function() {
                $(document).off('focusin.bs.modal');
            },
            onClose: function(){
                $(document).on('focusin.bs.modal');
            }
        });
        $('#tanggal').on('change', function(event){
            event.preventDefault();
            event.stopImmediatePropagation();
            var value = $(this).val();
            if(value != ''){
                swal({
                    showConfirmButton   : false,
                    allowOutsideClick   : false,
                    allowEscapeKey      : false,
                    background          : 'transparent',
                    onOpen  : function(){
                        swal.showLoading();
                        setTimeout(function(){
                            data_table();
                        },300);
                    }
                });
            }
        });
        $('#table_data').on('change', '.status_piket', function(){
            var status_val = $(this).val();
            if(status_val == 'D'){
                $(this).parent().parent().find('.keterangan').attr({'readonly': false, 'style': 'background-color: transparent !important; margin: 5px 0;'})
            }else{
                $(this).parent().parent().find('.keterangan').val('').attr({'readonly': true, 'style': 'background-color: #7E8299  !important; margin: 5px 0;'})
            }
              
        });
        $('#btn_process').on('click', function(event){
            event.preventDefault();
            event.stopImmediatePropagation();
            var ajax_method     = $('#form_data').attr('method');
            var ajax_url        = $('#form_data').attr('action');
            var form_data       = $('#form_data')[0];
            form_data           = new FormData(form_data);
            var errormessage    = '';
            if(! $('#tanggal').val()){
                 errormessage += 'Tanggal dibutuhkan \n';
            }
            if(errormessage !== ''){
                swal({
                    background  : 'transparent',
                    html        : '<pre>' + errormessage + '</pre>'
                });
            }else{
                var list_data = [];
                for(i = 0; i < $('.nama').length; i ++){
                    list_data.push({
                        id              : $('.nama')[i].id,
                        nama            : $('.nama')[i].innerText,
                        jabatan         : $('.jabatan')[i].innerText,
                        status_piket    : $('.status_piket')[i].value,
                        keterangan      : $('.keterangan')[i].value
                    });
                }
                swal({
                    background          : 'transparent',
                    html                : '<pre>Apakah data sudah benar ?</pre>',
                    type                : 'question',
                    showCancelButton    : true,
                    cancelButtonText    : 'Tidak',
                    confirmButtonText   : 'Ya'
                }).then((result) => {
                    if(result.value){
                        swal({
                            showConfirmButton   : false,
                            allowOutsideClick   : false,
                            allowEscapeKey      : false,
                            background          : 'transparent',
                            onOpen  : function(){
                                swal.showLoading();
                                setTimeout(function(){
                                    $.ajax({
                                        type           : 'ajax',
                                        method         : ajax_method,
                                        url            : ajax_url,
                                        data           : {
                                            tanggal         : $('#tanggal').val(),
                                            list_data       : list_data
                                        },
                                        async          : true,
                                        dataType       : 'json',
                                        success        : function(response){
                                            if(response.success){
                                                $('#modal_form').modal('hide');
                                                $('#form_data')[0].reset();
                                                swal({
                                                    html                : '<pre>Data berhasil ' + response.type + '</pre>',
                                                    type                : "success",
                                                    background          : 'transparent'
                                                }).then(function(){
                                                    swal({
                                                        showConfirmButton   : false,
                                                        allowOutsideClick   : false,
                                                        allowEscapeKey      : false,
                                                        background          : 'transparent',
                                                        onOpen  : function(){
                                                            swal.showLoading();
                                                            setTimeout(function(){
                                                                data_table();
                                                            },300);
                                                        }
                                                    });
                                                });
                                            }
                                        },
                                        error   : function(){
                                            swal({
                                                background  : 'transparent',
                                                html        : '<pre>Koneksi terputus' + '<br>' + 
                                                              'Cobalah beberapa saat lagi</pre>',
                                                type        : "warning"
                                            });
                                        }
                                    });
                                },300);
                            }
                        });     
                    }
                });
            }
            return false;
        });
    }
    function data_table(){
        $.ajax({
            type           : 'ajax',
            method         : 'post',
            url            : site + '/p_kelompok/cek_tanggal_absen',
            data           : {tanggal : $('#tanggal').val()},
            async          : true,
            dataType       : 'json',
            success        : function(response){
                if(response.data == true){
                    $('#tanggal_value').text($('#tanggal').val());
                    $('#message_content').show();
                    $('#table_content').hide();
                    swal.close();
                    main();
                }
                if(response.data == ''){
                    $('#table_content').show();
                    $('#message_content').hide();
                    if(table_data != ''){
                        table_data.ajax.reload();
                        swal.close();
                    }else{
                        table_data = $('#table_data').DataTable({
                            lengthMenu          : [ [-1], ["All"] ],
                            processing          : true, 
                            destroy             : true,
                            serverSide          : true, 
                            scrollX             : true,
                            scrollCollapse      : true,
                            fixedColumns        : true, 
                            info                : false,
                            paging              : false,
                            initComplete: function(){
                                swal.close();
                                $('#submit_content').show();
                                main();
                            },
                            ajax            : {
                                url         : site + '/p_kelompok',
                                method      : 'get'
                            },
                            columns             : [
                                {data   : 'DT_RowIndex'},
                                {data   : 'nama',
                                    render: function(data, type, row){
                                        return '<span class="nama" id="' + row.id + '">' + row.nama + '</span>';
                                    }
                                },
                                {data   : 'jabatan',
                                    render: function(data, type, row){
                                        return '<span class="jabatan">' + row.jabatan + '</span>';
                                    }
                                },
                                {defaultContent: '',
                                        render: function(data, type, row){
                                            var option = '';
                                            if(row.piket == 'A'){
                                                option =
                                                '<option value="A" selected>Piket Hadir</option>' +
                                                '<option value="B">Cadangan Piket</option>' +
                                                '<option value="C">Lepas Piket</option>' +
                                                '<option value="D">Tidak Hadir</option>';
                                            }
                                            if(row.piket == 'B'){
                                                option =
                                                '<option value="A">Piket Hadir</option>' +
                                                '<option value="B" selected>Cadangan Piket</option>' +
                                                '<option value="C">Lepas Piket</option>' +
                                                '<option value="D">Tidak Hadir</option>';
                                            }
                                            if(row.piket == 'C'){
                                                option =
                                                '<option value="A">Piket Hadir</option>' +
                                                '<option value="B">Cadangan Piket</option>' +
                                                '<option value="C" selected>Lepas Piket</option>' +
                                                '<option value="D">Tidak Hadir</option>';
                                            }else{
                                                '<option value="A">Piket Hadir</option>' +
                                                '<option value="B">Cadangan Piket</option>' +
                                                '<option value="C">Lepas Piket</option>' +
                                                '<option value="D" selected>Tidak Hadir</option>';
                                            }
                                            return '<select class="form-control status_piket" style="border: none;">' + option + '</select>';
                                        }
                                },
                                {defaultContent: '',
                                        render: function(data, type, row){
                                            return '<input type="text" class="form-control keterangan" readonly="" style="background-color: #7E8299 !important; margin: 5px 0;">';
                                        }
                                }
                            ]
                        });
                    }
                }
            },
            error   : function(){
                swal({
                    background  : 'transparent',
                    html        : '<pre>Koneksi terputus' + '<br>' + 
                                  'Cobalah beberapa saat lagi</pre>',
                    type        : "warning"
                });
            }
        });
    }
});