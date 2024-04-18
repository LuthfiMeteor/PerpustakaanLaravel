<?php

namespace App\Http\Controllers;

use App\Models\BukuModel;
use App\Models\FavoritModel;
use App\Models\KomentarModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class LandingPageController extends Controller
{
    public function bukuPage()
    {
        $buku = BukuModel::all();
        return view('landingPage.bukuPage', compact('buku'));
    }
    public function detailBuku($id)
    {
        try {
            $decrypted = Crypt::decrypt($id);
            $buku = BukuModel::with('Kategori')->where('id', $decrypted)->first();
            // dd($buku);
            return view('landingPage.detailBuku', compact('buku'));
        } catch (\Throwable $th) {
        }
    }
    public function baca($id)
    {
        try {
            $decrypted = Crypt::decrypt($id);
            $check_member = DB::table('member')->where('user_id', Auth::user()->id)->count();
            // dd($check_member);
            $bukuPDF = BukuModel::find($decrypted);
            return view('LandingPage.baca', compact('bukuPDF', 'check_member'));
        } catch (\Throwable $th) {
        }
    }
    public function daftarMember(Request $request)
    {
        $request->validate([
            'no_telp' => 'required',
            'tgllahir' => 'required|date',
            'alamat' => 'required'
        ]);

        $member = DB::table('member')->insert([
            'user_id' => Auth::id()
        ]);
        $updateUser = User::find(Auth::id());
        $updateUser->noTelp = $request->no_telp;
        $updateUser->tgl_lahir = $request->tgllahir;
        $updateUser->alamat = $request->alamat;
        $updateUser->save();
        return back()->with('success', 'Berhasil');
    }
    public function favorit(Request $request)
    {
        // $fav = BukuModel::with('favorit')->first();
        // dd($request->all());
        try {
            $decrypted = Crypt::decrypt($request->id);
            $fav = FavoritModel::where('user_id', Auth::id())->where('buku_id', $decrypted)->first();
            // dd($fav->id);
            if (!$fav) {
                $addFav = FavoritModel::create([
                    'user_id' => Auth::id(),
                    'buku_id' => $decrypted,
                ]);
                return response()->json([
                    'message' => 'sukses',
                ], 200);
            } else {
                $removeFav = DB::table('favorit')->where('id', $fav->id)->delete();
                return response()->json(
                    [
                        'message' => 'sukses hapus',
                    ]
                );
            }
            // dd($fav);
        } catch (\Throwable $th) {
        }
    }
    public function favList()
    {
        $favorit = DB::table('favorit')
            ->join('users', 'favorit.user_id', '=', 'users.id')
            ->join('buku', 'favorit.buku_id', '=', 'buku.id')
            ->where('favorit.user_id', Auth::id())
            ->get();
        // dd($favorit);
        return view('LandingPage.favorit', compact('favorit'));
    }
    public function komentar(Request $request)
    {
        try {
            $decrypted = Crypt::decrypt($request->buku_id);
            $komentar = KomentarModel::create([
                'user_id' => Auth::id(),
                'buku_id' => $decrypted,
                'komentar' => $request->komentar,
            ]);
            return back();
        } catch (\Throwable $th) {
        }
    }
}
