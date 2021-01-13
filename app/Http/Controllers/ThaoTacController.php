<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ThaoTacController extends Controller
{
    public function dsbaocao(){
        $bc = DB::table('baocaobaidang')
        ->join('baidang','baidang.IDBaiDang','=','baocaobaidang.IDBaiDang')
        ->join('khachhang','khachhang.IDKhachHang','=','baocaobaidang.IDNguoibaoCao')
        ->select('baidang.TieuDe','baidang.IDKhachHang','baocaobaidang.*','khachhang.TenKhachHang as NguoiBaoCao')
        ->orderBy('NgayBaoCao','desc')->get();
        return response()->json($bc,200);
    }

    public function thembaocao(){

        $date = Carbon::now();
        $bc = DB::table('baocaobaidang')->insert([
            'IDBaiDang'=>$this->request['IDBaiDang'],
            'IDNguoibaoCao'=>$this->request['IDNguoibaoCao'],
            'NgayBaoCao'=>$date,
        ]);

        if($bc){
            return response()->json(1,201);
        }
    }

    public function chitietbaocao($id){
        $bc = DB::table('baocaobaidang')
        ->join('baidang','baidang.IDBaiDang','=','baocaobaidang.IDBaiDang')
        ->join('khachhang','khachhang.IDKhachHang','=','baocaobaidang.IDNguoibaoCao')
        ->where('IDBaoCao', $id)
        ->select('baidang.*','baocaobaidang.NgayBaoCao','khachhang.TenKhachHang as NguoiBaoCao')
        ->get();
        $a=$bc[0]->IDKhachHang;
      //  return response()->json($a);
        $nguoidangbai= DB::table('khachhang')->where('IDKhachHang',$a)->get();
        return response()->json(['baidang'=>$bc,'$nguoidangbai'=>$nguoidangbai],200);
    }

    public function anbaidang($id){
        $baidang = DB::table('baidang')->where('IDBaiDang',$id)->update(array(
            'TrangThai'=>0,
        ));

        if($baidang){
            return response()->json('An thanh cong',200);
        }
    }

    public function khoiphucbaidang($id){
        $baidang = DB::table('baidang')->where('IDBaiDang',$id)->update(array(
            'TrangThai'=>1,
        ));

        if($baidang){
            return response()->json('Khoi phuc thanh cong',200);
        }
    }
}
