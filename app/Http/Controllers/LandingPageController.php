<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function bukuPage(){
        return view('landingPage.bukuPage');
    }
    public function detailBuku(){
        return view('landingPage.detailBuku');
    }
}
