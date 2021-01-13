<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ThongKeController extends Controller
{
    public function sobaidang(){
        $dem = DB::table('baidang')->count();
        return response()->json($dem,200);
    }
    public function sokhachhang(){
        $dem = DB::table('khachhang')->count();
        return response()->json($dem,200);
    }
    public function baidangbaocao(){
        $dem = DB::table('baidang')->where('TrangThai','0')->count();
        return response()->json($dem,200);
    }
    public function baidangtheothang($year){
        $hoadon=DB::table('baidang')->whereYear('NgayDang','=',$year)->select(
            DB::raw('count(IDBaiDang) as SoBaiDang'), 
            DB::raw("MONTH(NgayDang) as Thang"),
        )->groupBy('Thang')->orderBy('Thang','ASC')->get();

        return response()->json($hoadon,200);
    }
    public function khachhangtheothang($year){
        $hoadon=DB::table('khachhang')->whereYear('created_at','=',$year)->select(
            DB::raw('count(IDKhachHang) as SoKhachHang'), 
            DB::raw("MONTH(created_at) as Thang"),
        )->groupBy('Thang')->orderBy('Thang','ASC')->get();

        return response()->json($hoadon,200);
    }

    public function bieudotheloai(){
        $sobaidang = DB::table('baidang')->count();
        $dienthoai = (DB::table('baidang')->where('IDTheLoaiSP','1')->count())/$sobaidang*100;
        $lap = (DB::table('baidang')->where('IDTheLoaiSP','2')->count())/$sobaidang*100;
        $lkdd = (DB::table('baidang')->where('IDTheLoaiSP','3')->count())/$sobaidang*100;
        $lkmt = 100 - $dienthoai - $lap -$lkdd;

        return response()->json(['dt'=>$dienthoai,'lap'=>$lap,'lkdd'=>$lkdd,'lkmt'=>$lkmt],200);
    }

    public function bieudotinhthanh(){
       // $sub = DB::table('province')->where('id',$)
        $sobaidang = DB::table('baidang')->count();
        $data = DB::table('baidang')->join('province', 'province.id','=','baidang.TinhThanh')
        ->select(
            DB::raw('count(IDBaiDang) as SoBaiDang'), 
            DB::raw("_name as IDTinhThanh"),
        )
        ->groupBy('IDTinhThanh')->orderBy('SoBaiDang','desc')->take(5)->get();
        
        $arr =[];
        $daco=0;
        foreach ($data as $item){
            $chiso = $item->SoBaiDang/$sobaidang*100;
            $chiso = round($chiso,2);
            array_push($arr,['SL'=>$item->SoBaiDang,'Tinh'=>$item->IDTinhThanh,'ChiSo'=>$chiso]);
            $daco+=$chiso;
           // return response()->json($arr);
        }
        $conlai = 100-$daco;
        array_push($arr,['Tinh'=>'Khác','ChiSo'=>$conlai]);
        return response()->json($arr);
    }
}