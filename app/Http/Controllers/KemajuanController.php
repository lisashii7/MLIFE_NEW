<?php

namespace App\Http\Controllers;

use App\Models\Kemajuan;
use App\Models\Pengurus;
use App\Models\Santri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KemajuanController extends Controller
{
    public function index()
    {
        $data['kemajuans'] = Kemajuan::all();
        return view('dashboard.kemajuan', $data);
    }

    public function showFormTambah()
    {
        $data['santris'] = Santri::all();
        $data['pengurus'] = Pengurus::all();

        return view('dashboard.tambahKemajuan', $data);
    }

    public function tambah(Request $request)
    {
        $validation = $request->validate([
            "id_santri" => ["required"],
            "id_pengurus" => ["required"],
            "tanggal" => ["required", "date"],
            "status" => ["required", "in:Y,N"]
        ]);

        DB::beginTransaction();
        try {
            Kemajuan::create($validation);
            DB::commit();

            return redirect("/dashboard/kemajuan");
        } catch (QueryException $err) {
            DB::rollback();
            dd($err->errorInfo);
        }
    }
}
