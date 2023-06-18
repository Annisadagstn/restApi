<?php

namespace App\Http\Controllers;

use App\Models\Sampah;
use Illuminate\Http\Request;
use App\Helpers\ApiFormatter;
use Exception;

class SampahController extends Controller
{
    public function index()
    {
        $sampah = Sampah::all();

        if ($sampah) {
            return ApiFormatter::createApi(200, 'success', $sampah);
        } else{
            return ApiFormatter::createApi(400, 'failed');
        }
    }

    public function create()
    {
        //
    }

    public function generateToken()
    {
        return csrf_token();
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'kepala_keluarga' => 'required',
                'no_rumah' => 'required|numeric',
                'rt_rw' => 'required',
                'total_karung_sampah' => 'required',
                'kriteria' => 'required',
                'tanggal' => 'required',
            ]);
            
            $sampah = Sampah::create([
                'kepala_keluarga' => $request->kepala_keluarga,
                'no_rumah' => $request->no_rumah,
                'rt_rw' => $request->rt_rw,
                'total_karung_sampah' => $request->total_karung_sampah,
                'kriteria' => $request->kriteria,
                'tanggal' => \Carbon\Carbon::parse($request->tanggal)->format('Y-m-d'),
            ]);

            $hasilTambahData = Sampah::where('id', $sampah->id)->first();
            if ($hasilTambahData) {
                return ApiFormatter::createAPI(200, 'success',  $hasilTambahData);
            }else {
                return ApiFormatter::createAPI(400, 'failed');
            }
            } catch (Exception $error) {

            return ApiFormatter::createAPI(400, 'error', $error->getMessage());
        }
    }

    public function createToken()
    {
        return response()->json(csrf_token());
    }

    public function show($id)
    {
        try {
            $sampah = Sampah::find($id);
            if ($sampah) {
                return ApiFormatter::createAPI(200, 'success', $sampah);
            }else {
                return ApiFormatter::createAPI(400, 'failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createAPI(400, 'error', $error->getMessage());
        }
    }

    public function edit(Sampah $sampah)
    {
        //
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'kepala_keluarga' => 'required',
                'no_rumah' => 'required|numeric',
                'rt_rw' => 'required',
                'total_karung_sampah' => 'required',
                'kriteria' => 'required',
                'tanggal' => 'required',
            ]);

            $sampah = Sampah::find($id);
            $sampah->update([
                'kepala_keluarga' => $request->kepala_keluarga,
                'no_rumah' => $request->no_rumah,
                'rt_rw' => $request->rt_rw,
                'total_karung_sampah' => $request->total_karung_sampah,
                'kriteria' => $request->kriteria,
                'tanggal' => \Carbon\Carbon::parse($request->tanggal)->format('Y-m-d'),
            ]);
            $dataTerbaru = Sampah::where('id', $sampah->id)->first();
            if ($dataTerbaru) {
                return ApiFormatter::createAPI(200, 'success', $dataTerbaru);
            }else {
                return ApiFormatter::createAPI(400, 'failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createAPI(400, 'error', $error->getMessage()); 
        }
    }

    public function destroy($id)
    {
        try {
            $sampah = Sampah::find($id);
            $cekBerhasil = $sampah->delete();
            if ($cekBerhasil) {
                return ApiFormatter::createAPI(200, 'success', 'Data terhapus!');
            }else {
                return ApiFormatter::createAPI(400, 'failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createAPI(400, 'error', $error->getMessage());
        }
    }

    public function trash()
    {
        try {
            $sampah = Sampah::onlyTrashed()->get();
            if ($sampah) {
                return ApiFormatter::createAPI(200, 'success', $sampah);
            }else {
                return ApiFormatter::createAPI(400, 'failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createAPI(400, 'error', $error->getMessage());
        }
    }

    public function restore($id)
    {
        try {
            $sampah = Sampah::onlyTrashed()->where('id', $id);
            $sampah->restore();
            $dataKembali =   Sampah::where('id', $id)->first();
            if ($dataKembali) {
                return ApiFormatter::createAPI(200, 'success', $dataKembali);
            }else {
                return ApiFormatter::createAPI(400, 'failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createAPI(400, 'error', $error->getMessage());
        }
    }

    public function permanentDelete($id)
    {
        try {
            $sampah = Sampah::onlyTrashed()->where('id', $id);
            $proses = $sampah->forceDelete();
            if ($proses) {
                return ApiFormatter::createApi(200, 'success', 'permanent');
            }else{
                return ApiFormatter::createApi(400, 'failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createAPI(400, 'error', $error->getMessage());
        }
    }
}


