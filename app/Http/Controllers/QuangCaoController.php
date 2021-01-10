<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class QuangCaoController extends Controller
{

    public function baidangtheloai($id){
        $list = DB::table('baidang')->where('IDTheLoaiSP', $id)->get();
        return response()->json($list,200);
    }

    public function dsquangcao(){
        $list = DB::table('quangcao')
        ->orderBy('created_at','desc')
        ->get();

        return response()->json($list,200);
    }

    public function themquangcao(){
        $current_time = Carbon::now();
        $hinhanh = $this->request['HinhAnh'];
        $check = DB::table('quangcao')->where('HinhAnh',$hinhanh)->first();
        if(!empty($check)){
            return response()->json(['thongbao'=>'Quang cao da ton tai !'],400);
        }
        $qc = DB::table('quangcao')->insert([
            'IDTheLoaiSP'=>$this->request['IDTheLoaiSP'],
            'HinhAnh'=>$this->request['HinhAnh'],
            'GhiChu'=>$this->request['GhiChu'],
            'TrangThai'=>1,
            'created_at'=>$current_time,
            'updated_at'=>$current_time,
        ]);

        if($qc){
            return response()->json(1,201);
        }else{
            return response()->json(0,400);
        }
    }

    public function timquangcao($id){
        $qc =DB::table('quangcao')->where('IDQuangCao',$id)->get();
        return response()->json($qc,200);
    }

    public function suaquangcao($id){
        $hinhanh = $this->request['HinhAnh'];
        $qc_cu = DB::table('quangcao')->where('IDQuangCao',$id)->first();
        $qc_cu_hinhanh = $qc_cu->HinhAnh;
        //return response()->json($qc_cu_hinhanh,201);
        if($qc_cu_hinhanh===$hinhanh){
            $qc = DB::table('quangcao')->where('IDQuangCao',$id)->update(array(
                'IDTheLoaiSP'=>$this->request['IDTheLoaiSP'],
                'GhiChu'=>$this->request['GhiChu'],
            ));
            if($qc){
                return response()->json(1,201);
            }else{
                return response()->json(0,400);
            }
        }

        $check = DB::table('quangcao')->where('HinhAnh',$hinhanh)->first();
        if(!empty($check)){
            return response()->json(['thongbao'=>'Quang cao da ton tai !'],400);
        }
        $qc = DB::table('quangcao')->where('IDQuangCao',$id)->update(array(
            'IDTheLoaiSP'=>$this->request['IDTheLoaiSP'],
            'HinhAnh'=>$this->request['HinhAnh'],
            'GhiChu'=>$this->request['GhiChu'],
        ));
        if($qc){
            return response()->json(1,201);
        }else{
            return response()->json(0,400);
        }
    }

    public function xoaquangcao($id){
        $current_time = Carbon::now();
        $qc = DB::table('quangcao')->where('IDQuangCao',$id)->update(array(
            'TrangThai'=> 0,
            'updated_at'=>$current_time,
        ));
        if($qc){
            return response()->json(1,200);
        }else{
            return response()->json(0,400);
        }
    }
}
