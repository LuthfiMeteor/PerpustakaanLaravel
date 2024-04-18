<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\PetugasModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PetugasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $petugas = User::role('petugas')->get();
            return DataTables::of($petugas)
                ->addColumn('action', function ($petugas) {
                    return '<a href="' . route('editPetugas', Crypt::encrypt($petugas->id)) . '" class="btn btn-warning">Edit</a> <button id="deletePetugas" data-id="' . Crypt::encrypt($petugas->id) . '" class="deletePetugas btn btn-danger">Hapus</button>';
                })
                ->addColumn('tgllahir', function ($petugas) {
                    return date('d-m-Y', strtotime($petugas->tgl_lahir));
                })
                ->rawColumns(['action'])
                ->make();
        }
        return view('dashboard.petugas.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|unique:users',
            'username' => 'required|unique:users',
            'password' => 'required',
            'tglLahir' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $petugas = new User();
            $petugas->name = $request->nama;
            $petugas->email = $request->email;
            $petugas->username = $request->username;
            $petugas->password = $request->password;
            $petugas->tgl_lahir = $request->tglLahir;
            $petugas->save();
            $petugas->assignRole('petugas');
            DB::commit();
            return redirect(route('managemenPetugas'))->with('successTambah', 'berhasil');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $decID = Crypt::decrypt($id);
            $petugas = User::find($decID);
            return view('dashboard.petugas.edit', compact('petugas'));
        } catch (\Throwable $th) {
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required',
            'username' => 'required',
            'tglLahir' => 'required',
        ]);
        try {
            $decID = Crypt::decrypt($id);
            DB::beginTransaction();
            try {
                $petugas = User::find($decID);
                $petugas->name = $request->nama;
                $petugas->email = $request->email;
                $petugas->username = $request->username;
                if ($request->password) {
                    $petugas->password = $request->password;
                }
                $petugas->tgl_lahir = $request->tglLahir;
                $petugas->save();
                DB::commit();
                return redirect(route('managemenPetugas'))->with('successEdit', 'berhasil');
            } catch (\Throwable $th) {
                //throw $th;
                DB::rollBack();
            }
        } catch (\Throwable $th) {
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        // dd($request->all());
        try {
            $decID = Crypt::decrypt($request->id);
            $petugas = User::find($decID)->delete();
            return response(200);
        } catch (\Throwable $th) {
        }
    }
}
