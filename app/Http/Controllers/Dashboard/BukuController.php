<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\BukuModel;
use App\Models\KategoriModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class BukuController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $buku = BukuModel::query();
            return DataTables::of($buku)
                ->addindexColumn()
                ->addColumn('judul', function ($buku) {
                    return $buku->judul;
                })->addColumn('kategori', function ($buku) {
                    return $buku->Kategori->kategori;
                })->addColumn('gambar', function ($buku) {
                    return "<img src='" . asset('storage/uploads/cover/' . $buku->gambarCover) . "' alt='' style='width: 130px;'>";
                })
                ->addColumn('file', function ($buku) {
                    return "<a href='" . asset('storage/uploads/isiBuku/' . $buku->isiBuku) . "' >$buku->isiBuku</a>";
                })
                ->addColumn('penulis', function ($buku) {
                    return $buku->penulis;
                })
                ->addColumn('penerbit',  function ($buku) {
                    return $buku->penerbit;
                })
                ->addColumn('tahunterbit', function ($buku) {
                    return date('d-m-Y', strtotime($buku->tahunTerbit));
                })
                ->addColumn('action', function ($buku) {
                    return '<a href="' . route('editBuku', $buku->id) . '" class="btn btn-warning">Edit</a> <button id="deleteBuku" data-id="' . $buku->id . '" class="deleteBuku btn btn-danger">Hapus</button>';
                })
                ->rawColumns(['gambar', 'file', 'action'])
                ->make();
        }
        $kategori = KategoriModel::all();
        return view('dashboard.buku.index', compact('kategori'));
    }
    public function create(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'kategori' => 'required',
            'gambarCover' => 'required|file|mimes:jpeg,png,jpg,webp',
            'isiBuku' => 'required|file|mimes:pdf',
            'penulis' => 'required',
            'penerbit' => 'required',
            'tahunTerbit' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $buku = new BukuModel();
            $buku->judul = $request->judul;
            $buku->kategori = $request->kategori;
            $buku->penulis = $request->penulis;
            $buku->penerbit = $request->penerbit;
            $buku->tahunTerbit = $request->tahunTerbit;

            if ($request->hasFile('gambarCover')) {
                $file = $request->file('gambarCover');
                $filename = uniqid() . '-' . $file->getClientOriginalExtension();
                $path = $file->storeAs('uploads/Cover', $filename);
                $buku->gambarCover = $filename;
            }

            if ($request->hasFile('isiBuku')) {
                $file = $request->file('isiBuku');
                $filename = uniqid() . '-' . $file->getClientOriginalExtension();
                $path = $file->storeAs('uploads/isiBuku', $filename);
                $buku->isiBuku = $filename;
            }
            // dd($request->all());
            $buku->save();
            DB::commit();
            return redirect(route('managemenBuku'))->with('success', 'Sukses');
        } catch (\Throwable $th) {
            //throw $
            DB::rollBack();
        }
    }
    public function edit($id)
    {
        $buku = BukuModel::find($id);
        $kategori = KategoriModel::all();
        return view('dashboard.buku.edit', compact('buku', 'kategori'));
    }
    public function update($id, Request $request)
    {
        $buku = BukuModel::find($id);

        if (!$buku) {
            return "Buku not found";
        }

        $request->validate([
            'judul' => 'required',
            'kategori' => 'required',
            'penulis' => 'required',
            'penerbit' => 'required',
            'tahunTerbit' => 'required',
        ]);

        DB::beginTransaction();

        try {
            $buku->judul = $request->judul;
            $buku->kategori = $request->kategori;
            $buku->penulis = $request->penulis;
            $buku->penerbit = $request->penerbit;
            $buku->tahunTerbit = $request->tahunTerbit;

            if ($request->hasFile('gambarCover')) {
                $file = $request->file('gambarCover');
                $filename = uniqid() . '-' . $file->getClientOriginalExtension();
                $path = $file->storeAs('uploads/Cover', $filename);
                $buku->gambarCover = $filename;
            }

            if ($request->hasFile('isiBuku')) {
                $file = $request->file('isiBuku');
                $filename = uniqid() . '-' . $file->getClientOriginalExtension();
                $path = $file->storeAs('uploads/isiBuku', $filename);
                $buku->isiBuku = $filename;
            }

            $buku->save(); // Save the changes to the database

            DB::commit();
            return redirect()->route('managemenBuku');
        } catch (\Throwable $th) {
            // Handle exceptions
            DB::rollBack();
            // Optionally, you can return an error message or redirect back with an error message
            return back()->with('error', 'Failed to update book');
        }
    }
    public function delete(Request $request)
    {
        $buku = BukuModel::where('id', $request->id)->delete();
        return response(200);
    }
}
