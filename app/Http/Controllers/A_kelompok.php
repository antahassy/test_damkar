<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use \App\Models\MA_piket;
use \App\Models\MA_admin;

class A_kelompok extends Controller
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
            ->where('tb_admin_menu.url', 'p_kelompok')
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

                    $data = DB::table('tb_bantuan_anggota')
                    ->select(
                        'tb_bantuan_anggota.id',
                        'tb_bantuan_anggota.nama',
                        'tb_bantuan_anggota.jabatan',
                        'tb_bantuan_anggota.piket',
                    )
                    ->where('tb_bantuan_anggota.deleted_at', null)
                    ->orderBy('piket', 'asc')
                    ->get();
                    
                    if($request->ajax()){
                        return datatables()->of($data)->addIndexColumn()->toJson();
                        //return response()->json($data);
                    }
                    return view('admin.kelompok')
                    ->with('active_menu', 'Kelompok')
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
        $sess_id = Session::get('admin.id');
        $sess_username = MA_admin::select('username')->where('id', $sess_id)->first()->username;

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
        $arr = $request->list_data;
        for($i = 0; $i < count($arr); $i ++){
            $saved = MA_piket::create(
                [
                    'id_anggota'        => $arr[$i]['id'],
                    'tanggal'           => $date,
                    'piket'             => $arr[$i]['status_piket'],
                    'keterangan'        => $arr[$i]['keterangan'],
                    'created_by'        => $sess_id,
                    'created_at'        => date('Y-m-d H:i:s')
                ]
            );
            if($i == (count($arr) - 1) && $saved){
                return response()->json([
                    'success'   => true,
                    'type'      => 'disimpan'
                ]);
            }
        }
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

    public function cek_tanggal_absen(Request $request){
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
        

        $data = DB::table('tb_piket')
        ->select(
            'tb_piket.*',
            'tb_bantuan_anggota.nama',
            'tb_bantuan_anggota.jabatan'
        )
        ->where('tb_piket.tanggal', $date)
        ->leftJoin('tb_bantuan_anggota', 'tb_piket.id_anggota', '=', 'tb_bantuan_anggota.id')
        ->orderBy('id', 'asc')
        ->get();
        
        if(count($data) != 0){
            return response()->json([
                'data'      => true,
                'list'      => $data
            ]);
        }else{
            return response()->json([
                'data'      => ''
            ]);
        }
    }
}
