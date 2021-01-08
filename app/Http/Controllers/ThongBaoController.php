<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ThongBaoController extends Controller
{


    public function themthongbao(){
        $noidung = $this->request['NoiDung'];
        $IDKhachHang = $this->request['IDKhachHang'];
        $NgayTao = Carbon::now();
        $NgayTao = $NgayTao->toDateTimeString();

        $them = DB::table('thongbao')->insert([
            'NoiDung'=> $noidung,
            'IDKhachHang'=>$IDKhachHang,
            'NgayTao'=>$NgayTao,
            'TrangThai'=>$this->request['TrangThai'],
        ]); 
        if($them){
            return response()->json(1,201);
        }
    }

    public function dsthongbao($id){
        $list = DB::table('thongbao')
        ->where('IDKhachHang',$id)
        ->where('TrangThai',1)
        ->get();
        return response()->json($list,200);
    }

    public function xoathongbao($id){
        $xoa = DB::table('thongbao')->where('IDThongBao',$id)->update(['TrangThai'=>-1]);
        if($xoa){
            return response()->json(1,200);
        }
    }
}
