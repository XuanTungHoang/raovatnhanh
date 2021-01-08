<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TinLuuController extends Controller
{
    public function themtinluu(){

        $tin =  DB::table('tindaluu')->insert([
            'IDBaiDang'=>$this->request['IDBaiDang'],
            'IDKhachHang'=>$this->request['IDKhachHang'],
        ]);
        if($tin){
            return response()->json(1,201);
        }
    }

    public function dstinluu($id_kh){
        $list = DB::table('tindaluu')
        ->select('baidang.*','tindaluu.IDKhachHang as nguoiluutin','tindaluu.IDTinLuu')
        ->join('baidang','baidang.IDBaiDang','=','tindaluu.IDBaiDang')
        ->where('tindaluu.IDKhachHang',$id_kh)
        ->get();
        return response()->json($list,200);
    }

    public function xoatinluu($id){
        $delete = DB::table('tindaluu')->where('IDTinLuu',$id)->delete();
        if($delete){
            return response()->json(['thongbao'=>'Success'],201);
        }
    }
}
