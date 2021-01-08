<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuangCaoController extends Controller
{
    public function baidangtheloai($id){
        $list = DB::table('baidang')->where('IDTheLoaiSP', $id)->get();
        return response()->json($list,200);
    }
}
