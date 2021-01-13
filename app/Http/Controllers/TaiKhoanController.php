<?php

namespace App\Http\Controllers;

use App\Models\TaiKhoan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class TaiKhoanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return response()->json('abc',200);

        $list = TaiKhoan::all();
        return response()->json($list,200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       // $current_time = Carbon::now();
                $taikhoan=new TaiKhoan();
                $taikhoan->TenDangNhap=$this->request['TenDangNhap'];
                $taikhoan->MatKhau=Hash::make($this->request['MatKhau']);
                $taikhoan->TenTaiKhoan=$this->request['TenTaiKhoan'];
                $taikhoan->HinhAnh=$this->request['HinhAnh'];
                $taikhoan->GioiTinh=$this->request['GioiTinh'];
                $taikhoan->SoDienThoai=$this->request['SoDienThoai'];
                $taikhoan->IDLoaiTaiKhoan=$this->request['IDLoaiTaiKhoan'];
                $taikhoan->TrangThai=$this->request['TrangThai'];
                $taikhoan->save();
                if(!empty($taikhoan)){
                    return response()->json($taikhoan,201);
                }else{
                    return response()->json(0,400);
                }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TaiKhoan  $taiKhoan
     * @return \Illuminate\Http\Response
     */
    public function show( $id)
    {
        $taikhoan = TaiKhoan::where('IDTaiKhoan', $id)->get();
        return response()->json($taikhoan,200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TaiKhoan  $taiKhoan
     * @return \Illuminate\Http\Response
     */
    public function edit(TaiKhoan $taiKhoan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TaiKhoan  $taiKhoan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {  
                $update = DB::table('taikhoan')->where('IDTaiKhoan',$id)->update(array(
                    'TenTaiKhoan'=>$this->request['TenTaiKhoan'],
                    'HinhAnh'=>$this->request['HinhAnh'],
                    'GioiTinh'=>$this->request['GioiTinh'],
                    'SoDienThoai'=>$this->request['SoDienThoai'],
                    'IDLoaiTaiKhoan'=>$this->request['IDLoaiTaiKhoan'],
                    'TrangThai'=>$this->request['TrangThai'],
                ));
                if($update){
                        return response()->json(['thongbao'=>'Success'],200);
                    }else{
                        return response()->json(0,400);
                    }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TaiKhoan  $taiKhoan
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        $delete = DB::table('taikhoan')->where('IDTaiKhoan', $id)->delete();
        if($delete){
            return response()->json(['thongbao'=>'Success']);
        }else{
            return response()->json(0,400);
        }
    }
}
