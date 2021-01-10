<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TinhThanhController extends Controller
{
    public function dstinhthanh()
    {
        $tinhthanh = DB::table('province')->get();
        return response()->json($tinhthanh,200);
    }
    public function quanhuyen($id){
        $quanhuyen = DB::table('district')
        ->where('_province_id',$id)
        ->get();
        return response()->json($quanhuyen,200);
    }
}
