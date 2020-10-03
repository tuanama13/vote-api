<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Hasil;
use App\Models\CalonKetua;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;

class HasilController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index() {        
        $getData = DB::table('tbhasil')->get();
        $getHasil = Hasil::get();
        $getTotal = DB::table('tbhasil')->sum('jumlah');
        $getCalon = array();

        foreach ($getHasil as $key => $value) {
            $value->calonketua = DB::table('tbcalonketua')->where('id', $value->idcalonketua)->first();
            // $value->calonketua = 'tomat';
            // array_push($getCalon, $value->calonketua = DB::table('tbcalonketua')->where('id', $value->idcalonketua)->get());
        }
        $out = [
            "message" => "list_hasil",
            "results" => $getHasil,
            "total" => $getTotal
        ];
 
        return response()->json($out, 200);
    }

    public function detail($id) {        
        $getData = DB::table('tbhasil')
                     ->select(DB::raw('id, idcalonketua, jumlah'))          
                     ->where('id', $id)
                     ->first();
 
        $out = [
            "message" => "detail_hasil",
            "results" => $getData,
        ];
 
        return response()->json($out, 200);
    }
    public function tambah(Request $request) {
        if ($request->isMethod('post')) {
 
            $this->validate($request, [
                'idcalonketua' => 'required',
                'jumlah' => 'required',
            ]);
 
            $idcalonketua = $request->input('idcalonketua');
            $jumlah = $request->input('jumlah');

            $data = [
                'idcalonketua' => $idcalonketua,
                'jumlah' => $jumlah,
            ];

            $insert = DB::table('tbhasil')->insert($data);
 
            if ($insert) {
                $out  = [
                    "message" => "berhasil",
                    "results" => $data,
                    "code"    => 200
                ];
            } else {
                $out  = [
                    "message" => "gagal",
                    "results" => $data,
                    "code"    => 404,
                ];
            }
 
            return response()->json($out, $out['code']);
        }
    }

    public function edit(Request $request) { 
        if ($request->isMethod('patch')) {
 
            $this->validate($request, [
                'id' => 'required',
                'idcalonketua' => 'required',
                'jumlah' => 'required',
            ]);

            $id = $request->input('id');
            $idcalonketua = $request->input('idcalonketua');
            $jumlah = $request->input('jumlah');
 
            $patch = DB::table('hasil')->where('id', $id);
 
            $data = [
                'idcalonketua' => $idcalonketua,
                'jumlah' => $jumlah,
            ];
 
            $update = $patch->update($data);
 
            if ($update) {
                $out  = [
                    "message" => "berhasil",
                    "results" => $data,
                    "code"    => 200
                ];
            } else {
                $out  = [
                    "message" => "gagal",
                    "results" => $data,
                    "code"   => 404,
                ];
            }
 
            return response()->json($out, $out['code']);

        }
    }

    public function vote(Request $request) { 
        if ($request->isMethod('patch')) {
 
            $this->validate($request, [
                'idcalonketua' => 'required',
            ]);

            $idcalonketua = $request->input('idcalonketua');
            
            $hasil= Hasil::where('idcalonketua', $idcalonketua)->first();
            
            // // update data hasil
            $hasil->jumlah = $hasil->jumlah + 1;
            $hasil->save();


            if ($hasil) {
                $out  = [
                    "message" => "berhasil",
                    "code"    => 200
                ];
            } else {
                $out  = [
                    "message" => "gagal",
                    "code"    => 404,
                ];
            }
            
            return response()->json($out, $out['code']);
        }
    }

    

    public function hapus($id) {
        $hapus = DB::table('tbhasil')->where('id', $id);
        
        if (!$hapus) {
            $data = [
                "message" => "id_tidak_ditemukan",
            ];
        } else {
            $hapus->delete();
            $data = [
                "message" => "berhasil_hapus_data"
            ];
        }
 
        return response()->json($data, 200);
    }
}
