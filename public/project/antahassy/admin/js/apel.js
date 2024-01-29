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

    main();
    function main(){
        var mindate = new Date(date_range[0].tanggal);
        $('#tanggal').datepicker({
            minDate: mindate,
            maxDate: new Date(),
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
            $('#result_content').empty();
            $('#detail_content').empty();
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
                            data_result();
                        },300);
                    }
                });
            }
        });
    }
    function data_result(){
        $.ajax({
            type           : 'ajax',
            method         : 'post',
            url            : site + '/p_apel/data_result',
            data           : {tanggal : $('#tanggal').val()},
            async          : true,
            dataType       : 'json',
            success        : function(data){
                if(data.length == 0){
                    swal({
                        background  : 'transparent',
                        html        : '<pre>Data Absen Kelompok' + '<br>' + 
                                      'Belum Di Submit</pre>'
                    });
                }else{
                    var result_content = '<div class="row">';
                    for(i = 0; i < data.length; i ++){
                        result_content +=
                        '<div class="col-md-6 list_count" data="' + data[i].piket + '" title="' + data[i].text + '">' +
                            data[i].text + ' : <span>' + data[i].jumlah + '</span>' +
                        '</div>';
                        if(i == (data.length - 1)){
                            result_content += '</div>';
                        }
                    }
                    $('#result_content').html(result_content);
                    data_detail();
                    swal.close();
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
    function data_detail(){
        $('.list_count').on('click', function(event){
            event.preventDefault();
            event.stopImmediatePropagation();
            var clicked = $(this);
            var piket = clicked.attr('data');
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
                            method         : 'post',
                            url            : site + '/p_apel/data_detail',
                            data           : {
                                tanggal : $('#tanggal').val(),
                                piket : piket
                            },
                            async          : true,
                            dataType       : 'json',
                            success        : function(data){
                                if(data.length == 0){
                                    swal({
                                        background  : 'transparent',
                                        html        : '<pre>Data tidak tersedia' + '<br>' + 
                                                      clicked.text() + '</pre>'
                                    });
                                }else{
                                    var detail_content = 
                                    '<div style="font-size: 20px;">' + clicked.attr('title') + '</div>' +
                                    '<table style="width: 100%; margin-top: 25px; font-size: 14px;">' +
                                        '<thead>' +
                                            '<tr>' +
                                                '<th>Nama</th>' +
                                                '<th>Jabatan</th>' +
                                                '<th>Group Piket</th>' +
                                                '<th>Ijin/Sakit/DLL</th>' +
                                            '</tr>' +
                                        '</thead>' +
                                        '<tbody>';
                                    for(i = 0; i < data.length; i ++){
                                        detail_content +=
                                        '<tr>' +
                                            '<td>' + data[i].nama + '</td>' +
                                            '<td>' + data[i].jabatan + '</td>' +
                                            '<td>' + data[i].piket + '</td>' +
                                            '<td>' + data[i].keterangan + '</td>' +
                                        '</tr>';
                                        if(i == (data.length - 1)){
                                            detail_content += 
                                                '</tbody>' +
                                            '</table>';
                                        }
                                    }
                                    $('#detail_content').html(detail_content);
                                    swal.close();
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
        });
    }
});