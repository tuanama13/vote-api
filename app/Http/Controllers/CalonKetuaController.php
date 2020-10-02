<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;

class CalonKetuaController extends Controller
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
        $getData = DB::table('tbcalonketua')->get();
 
        $out = [
            "message" => "list_calonketua",
            "results" => $getData
        ];
 
        return response()->json($out, 200);
    }

    public function detail($id) {        
        $getData = DB::table('tbcalonketua')
                     ->select(DB::raw('id, nama, ttl, gambar, visi, misi'))          
                     ->where('id', $id)
                     ->get();
 
        $out = [
            "message" => "detail_calonketua",
            "results" => $getData
        ];
 
        return response()->json($out, 200);
    }
    public function tambah(Request $request) {
        if ($request->isMethod('post')) {
 
            $this->validate($request, [
                'nama' => 'required',
                'ttl' => 'required',
                'gambar' => 'required',
                'visi' => 'required',
                'misi' => 'required',
            ]);
 
            $nama = $request->input('nama');
            $ttl = $request->input('ttl');
            $gambar = $request->input('gambar');
            $visi = $request->input('visi');
            $misi = $request->input('misi');

            $data = [
                'nama' => $nama,
                'ttl' => $ttl,
                'gambar' => $gambar,
                'visi' => $visi,
                'misi' => $misi
            ];

            $insert = DB::table('tbcalonketua')->insert($data);
 
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
                'nama' => 'required',
                'ttl' => 'required',
                'gambar' => 'required',
                'visi' => 'required',
                'misi' => 'required',
            ]);

            $id = $request->input('id');
            $nama = $request->input('nama');
            $ttl = $request->input('ttl');
            $gambar = $request->input('gambar');
            $visi = $request->input('visi');
            $misi = $request->input('misi');
 
            $patch = DB::table('tbcalonketua')->where('id', $id);
 
            $data = [
                'nama' => $nama,
                'ttl' => $ttl,
                'gambar' => $gambar,
                'visi' => $visi,
                'misi' => $misi
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

    public function hapus($id) {
        $hapus = DB::table('tbcalonketua')->where('id', $id);
        
        if (!$hapus) {
            $data = [
                "message" => "id tidak ditemukan",
            ];
        } else {
            $hapus->delete();
            $data = [
                "message" => "berhasil hapus data"
            ];
        }
 
        return response()->json($data, 200);
    }
}
