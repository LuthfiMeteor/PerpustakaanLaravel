<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\KategoriModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;


class KategoriController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $kategori = KategoriModel::query();
            return DataTables::of($kategori)
                ->addIndexColumn()
                ->addColumn('name', function ($kategori) {
                    return $kategori->kategori;
                })
                ->addColumn('action', function ($kategori) {
                    return '<button href="#" id="editModal" data-id=' . $kategori->id . ' class="editKategori btn btn-warning">Edit</button> <button href="#" id="deleteKategori" data-id=' . $kategori->id . ' class="deleteKategori btn btn-danger">Hapus</button>';
                })
                ->rawColumns(['action'])
                ->make();
        }
        return view('dashboard.kategori.index');
    }
    public function create(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $kategori = KategoriModel::create([
                'kategori' =>  $request->nama_kategori,
            ]);
            DB::commit();
            return back()->with('message', 'Sukses Tambah');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
        }
    }
    public function edit(Request $request)
    {
        $kategori = KategoriModel::where('id', $request->id)->first();
        return response($kategori);
    }
    public function update(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required'
        ]);
        DB::beginTransaction();
        try {
            $kategori = KategoriModel::find($request->idKategori);
            $kategori->kategori = $request->nama_kategori;
            $kategori->update();
            DB::commit();
            return redirect(route('managemenKategori'))->with('success', 'sukses Uppdate');
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }
    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);
        DB::beginTransaction();
        try {
            $kategori = DB::table('kategori')->where('id', $request->id)->delete();
            DB::commit();
            return redirect(route('managemenKategori'))->with('success', 'sukses Uppdate');
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }
}
