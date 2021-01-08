<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoaiTKController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list = DB::table('loaitaikhoan')->get();
        return response()->json($list,200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $current_time= Carbon::now();
        $check= DB::table('loaitaikhoan')
        ->where('TenLoaiTaiKhoan', $this->request['TenLoaiTaiKhoan'])
        ->first();
        if(!empty($check->TenLoaiTaiKhoan)){
            return response()->json(['thongbao'=>'Tên loại tài khoản đã tồn tại'],400);
        }else{
            $loaitk = DB::table('loaitaikhoan')->insert([
                'TenLoaiTaiKhoan'=>$this->request['TenLoaiTaiKhoan'],
                'MoTa'=>$this->request['MoTa'],
                'created_at'=>$current_time,
                'updated_at'=>$current_time,
            ]);
            if($loaitk){
                return response()->json(1,201);
            }else{
                return response()->json(0,404); 
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $loaitk= DB::table('loaitaikhoan')->where('IDLoaiTaiKhoan',$id)->get();
        return response()->json($loaitk,200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $current_time=Carbon::now();
        $loaitk = DB::table('loaitaikhoan')
        ->where('IDLoaiTaiKhoan', $id)
        ->update(array(
            'TenLoaiTaiKhoan'=>$this->request['TenLoaiTaiKhoan'],
            'MoTa'=>$this->request['MoTa'],
            'updated_at'=>$current_time,
        ));
        if($loaitk){
            return response()->json(1,200);
        }else{
            return response()->json(0,400);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $loaitk=DB::table('loaitaikhoan')->where('IDLoaiTaiKhoan',$id)->delete();
        if($loaitk){
            return response()->json(1,204);
        }else{
            return response()->json(0,400);
        }
    }
}
