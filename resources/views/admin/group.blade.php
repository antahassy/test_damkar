@extends('admin_layout/index')
@section('content')
<style>
    tbody tr td a, .dataTables_wrapper .dataTable td a{
        padding: 0.55rem 0.75rem;
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
                            <table id="table_data" class="table table-vcenter" style="width: 100%;">
                                <thead>
                                    <tr> 
                                        <th width="7.5%">No</th>
                                        <th>Group</th>
                                        <th>Deskripsi</th>
                                        <th>Tindakan</th> 
                                        <th width="12.5%">Dibuat</th> 
                                        <th width="12.5%">Diupdate</th> 
                                    </tr>
                                </thead>
                                <tbody id="tbody_data">
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal animated" id="modal_form" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
            </div>
            <div class="modal-body"> 
                <form id="form_data">
                    <input type="hidden" id="id_data" name="id_data">
                    <input type="hidden" name="_method" id="_method">
                    <div class="form-group">
                        <div class="col-md-12">
                            <label>Group<span style="color: red;">*</span></label>
                            <input type="text" name="level" id="level" class="form-control">

                            <label>Deskripsi<span style="color: red;">*</span></label>
                            <input type="text" name="deskripsi" id="deskripsi" class="form-control">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-outline-primary" id="btn_process"></button>
            </div>
        </div>
    </div>
</div>
<script>
    var hak_akses = @json($akses_menu);
    hak_akses = hak_akses.map(Number);
</script>
<script src="{{ asset('project/antahassy/admin/js/group.js?t=').mt_rand() }}"></script>
@endsection