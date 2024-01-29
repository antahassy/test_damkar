@extends('admin_layout/index')
@section('content')
<style>
    .list_count{
        margin: 5px 0; 
        cursor: pointer;
    }
    .list_count:hover, .list_count:focus{
        background-color: #4cbb17;
        color: rgb(25,25,25);
        border-radius: 100px;
    }
</style>
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
                            <h3 class="card-title font-weight-bolder text-dark">Daftar {{ $active_menu }}</h3>
                        </div>
                        <div class="card-body pt-0">
                            <div class="col-md-12">
                                <table>
                                    <tr>
                                        <td style="border-bottom-color: transparent !important; font-size: 16px;">Tanggal</td>
                                        <td style="border-bottom-color: transparent !important; font-size: 16px;">
                                            <input type="text" name="tanggal" id="tanggal" class="form-control" readonly="" value="" style="font-size: 16px;">
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div style="min-height: 54vh;">
                                <div id="result_content" class="text_data" style="padding: 25px; font-size: 20px;">
                                
                                </div>
                                <div id="detail_content" class="text_data" style="padding: 25px;">

                                </div>
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
<script src="{{ asset('project/antahassy/admin/js/apel.js?t=').mt_rand() }}"></script>
@endsection