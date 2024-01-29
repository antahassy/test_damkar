<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class A_apel extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(! Session::get('admin.id')) {
            return Redirect("admin"); 
        }else{
            $sess_id = Session::get('admin.id');
            $sess_id_group = DB::table('tb_admin_group_2')->where('id_admin', $sess_id)->first()->id_group;
            $akses = DB::table('tb_admin_menu')
            ->select('tb_admin_rel_group.akses')
            ->where('tb_admin_menu.url', 'p_apel')
            ->where('tb_admin_menu.deleted_at', null)
            ->where('tb_admin_rel_group.id_group', $sess_id_group)
            ->where('tb_admin_rel_group.deleted_at', null)
            ->join('tb_admin_rel_group', 'tb_admin_menu.id', '=', 'tb_admin_rel_group.id_menu')
            ->get();
            if(count($akses) != 0){
                $akses_temp = array();
                foreach ($akses as $key) {
                    array_push($akses_temp, $key->akses);
                }
                if (in_array('1', $akses_temp)){
                    $month_format = array (1 => 
                        'Januari',
                        'Februari',
                        'Maret',
                        'April',
                        'Mei',
                        'Juni',
                        'Juli',
                        'Agustus',
                        'September',
                        'Oktober',
                        'November',
                        'Desember'
                    );
                    $now = date('Y-m-d');
                    $s_now = explode('-', $now);
                    $today = $s_now[2] . ' ' . $month_format[(int)$s_now[1]] . ' ' . $s_now[0];

                    $date_range = DB::table('tb_bantuan_piket')
                    ->select(
                        'tb_bantuan_piket.tanggal'
                    )
                    ->where('tb_bantuan_piket.deleted_at', null)
                    ->orderBy('tb_bantuan_piket.tanggal', 'asc')
                    ->get();

                    if($request->ajax()){
                        return response()->json($date_range);
                    }

                    return view('admin.apel')
                    ->with('active_menu', 'Apel')
                    ->with('akses_menu', $akses_temp)
                    ->with('id_group', $sess_id_group)
                    ->with('today', $today)
                    ->with('date_range', $date_range);
                }else{
                    return view('unauthorized');
                }
            }else{
                return view('unauthorized');
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function data_result(Request $request){
        $month_format = array (
            'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $tgl = $request->tanggal;
        $s_tgl = explode(' ', $tgl);
        $month_number = array_search($s_tgl[1], $month_format) + 1;
        if(strlen($tgl) == 1){
            $date = $s_tgl[2] . '-0' . $month_number . '-' . $s_tgl[0]; 
        }else{
            $date = $s_tgl[2] . '-' . $month_number . '-' . $s_tgl[0];
        }

        $data = DB::table('tb_bantuan_piket')->select('piket')->orderBy('piket', 'asc')->get();
        $data_piket = DB::table('tb_piket')->where('tanggal', $date)->get();
        if(count($data_piket) != 0){
            foreach ($data as $row) {
                $row->jumlah = DB::table('tb_piket')->where('piket', $row->piket)->where('tanggal', $date)->count();
                // $data = DB::table('tb_piket')
                // ->select(
                //     DB::raw('count(*) as jumlah'),
                //     'piket'
                // )
                // ->where('tanggal', $date)
                // ->groupBy('piket')
                // ->get();
            }
        }else{
            $data = array();
        }
        
        if(count($data) != 0){
            foreach ($data as $row) {
                if($row->piket == 'A'){
                    $row->text = 'Total Piket Hadir';
                }
                if($row->piket == 'B'){
                    $row->text = 'Total Cadangan Piket';
                }
                if($row->piket == 'C'){
                    $row->text = 'Total Lepas Piket';
                }
                if($row->piket == 'D'){
                    $row->text = 'Total Tidak Hadir';
                }
            }
        }
        return response()->json($data);
    }

    public function data_detail(Request $request){
        $month_format = array (
            'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $tgl = $request->tanggal;
        $s_tgl = explode(' ', $tgl);
        $month_number = array_search($s_tgl[1], $month_format) + 1;
        if(strlen($tgl) == 1){
            $date = $s_tgl[2] . '-0' . $month_number . '-' . $s_tgl[0]; 
        }else{
            $date = $s_tgl[2] . '-' . $month_number . '-' . $s_tgl[0];
        }

        $group_piket = $request->piket;
        $data = DB::table('tb_piket')
        ->select(
            'tb_piket.keterangan',
            'tb_piket.piket',
            'tb_bantuan_anggota.nama',
            'tb_bantuan_anggota.jabatan'
        )
        ->where('tb_piket.tanggal', $date)
        ->where('tb_piket.piket', $group_piket)
        ->leftJoin('tb_bantuan_anggota', 'tb_piket.id_anggota', '=', 'tb_bantuan_anggota.id')
        ->orderBy('tb_piket.id', 'asc')
        ->get();

        if($data){
            foreach ($data as $row) {
                if($row->keterangan == ''){
                    $row->keterangan = '-';
                }
            }
        }

        return response()->json($data);
    }
}
