@extends('admin_layout/index')
@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-2">
                <?php
					if(in_array('2', $akses_menu)){
						echo '<h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">' . $active_menu . '</h5>';
						echo '<div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>';
						echo '<a href="#" class="btn btn-light-success font-weight-bolder btn-sm" id="btn_add">Tambah Data</a>';
					}else{
						echo '<h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">' . $active_menu . '</h5>';
					}
				?>
            </div>
            <div class="d-flex align-items-center">
                <!-- <a href="#" id="d_daily" class="btn btn-clean btn-sm font-weight-bold font-size-base mr-1">Daily</a>
                <a href="#" id="d_monthly" class="btn btn-clean btn-sm font-weight-bold font-size-base mr-1">Monthly</a>
                <a href="#" id="d_yearly" class="btn btn-clean btn-sm font-weight-bold font-size-base mr-1">Yearly</a>
                <a href="#" class="btn btn-sm btn-light font-weight-bold mr-2" id="kt_dashboard_daterangepicker" data-toggle="tooltip" title="Select Daterange" data-placement="left">
                    <span class="text-muted font-size-base font-weight-bold mr-2" id="kt_dashboard_daterangepicker_title"></span>
                    <span class="text-primary font-size-base font-weight-bolder" id="kt_dashboard_daterangepicker_date"></span>
                </a> -->
            </div>
        </div>
    </div>
    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="row" id="main_content">
                <div class="col-lg-12 col-xxl-4 order-1 order-xxl-2">
                    <div class="card card-custom card-stretch gutter-b">
                        <div class="card-header border-0">
                            <h3 class="card-title font-weight-bolder text-dark">Daftar Nama {{ $active_menu }}</h3>
                        </div>
                        <div class="card-body pt-0">
                            <div class="col-md-12">
                                <form id="form_data">
                                    <table style="font-size: 16px;">
                                        <tr>
                                            <td style="border-bottom-color: transparent !important;">Tanggal</td>
                                            <td style="border-bottom-color: transparent !important;">
                                                <input style="font-size: 16px;" type="text" name="tanggal" id="tanggal" class="form-control" readonly="" value="{{ $today }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="border-bottom-color: transparent !important;">Piket Hadir</td>
                                            <td style="border-bottom-color: transparent !important;">: A</td>
                                        </tr>
                                        <tr>
                                            <td style="border-bottom-color: transparent !important;">Cadangan Piket</td>
                                            <td style="border-bottom-color: transparent !important;">: B</td>
                                        </tr>
                                        <tr>
                                            <td style="border-bottom-color: transparent !important;">Lepas Piket</td>
                                            <td style="border-bottom-color: transparent !important;">: C</td>
                                        </tr>
                                        <tr>
                                            <td style="border-bottom-color: transparent !important;">Tidak Hadir</td>
                                            <td style="border-bottom-color: transparent !important;">: D</td>
                                        </tr>
                                    </table>
                                </form>
                            </div>
                            <div id="message_content" class="text_data" style="display: none;">
                                <center style="margin-top: 100px; font-size: 25px;">
                                    Data Absen Tanggal <span id="tanggal_value"></span> Telah Di Submit <br>
                                    Silahkan Pilih Tanggal Lain Jika Memungkinkan
                                </center>
                            </div>
                            <div id="table_content" style="display: none;">
                                <table id="table_data" class="table table-vcenter" style="width: 100%;">
                                    <thead>
                                        <tr> 
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Jabatan</th>
                                            <th>Status_Piket</th> 
                                            <th>Keterangan (Sakit/Ijin/DLL)</th> 
                                        </tr>
                                    </thead>
                                </table>
                                <center id="submit_content" style="display: none;">
                                    <button type="button" class="btn btn-sm" id="btn_process" style="font-weight: 800;">Submit</button>
                                </center>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var hak_akses = @json($akses_menu);
    hak_akses = hak_akses.map(Number);
    var id_group = <?php echo $id_group ?>;
    var date_range = @json($date_range);
</script>
<script src="{{ asset('project/antahassy/admin/js/kelompok.js?t=').mt_rand() }}"></script>
@endsection