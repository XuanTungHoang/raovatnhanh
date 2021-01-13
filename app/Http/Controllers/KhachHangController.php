<?php

namespace App\Http\Controllers;

use App\Models\KhachHang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class KhachHangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list = KhachHang::all();
        return response()->json($list, 200);
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
        $khachhang = new KhachHang();
        $khachhang->Email = $this->request['Email'];
        $khachhang->MatKhau = Hash::make($this->request['MatKhau']);
        $khachhang->TenKhachHang = $this->request['TenKhachHang'];
        $khachhang->HinhAnh = $this->request['HinhAnh'];
        $khachhang->DiaChi = $this->request['DiaChi'];
        $khachhang->SoDienThoai = $this->request['SoDienThoai'];
        $khachhang->TrangThai = $this->request['TrangThai'];
        $khachhang->save();
        if (!empty($khachhang)) {
            return response()->json($khachhang, 201);
        } else {
            return response()->json(0, 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\KhachHang  $khachHang
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $khachhang = KhachHang::where('IDKhachHang', $id)->get();
        return response()->json($khachhang, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\KhachHang  $khachHang
     * @return \Illuminate\Http\Response
     */
    public function edit(KhachHang $khachHang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\KhachHang  $khachHang
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $id)
    {
        // Update data
        $update = DB::table('khachhang')->where('IDKhachHang', $id)->update(array(
            'TenKhachHang' => $this->request['TenKhachHang'],
            'HinhAnh' => $this->request['HinhAnh'],
            'DiaChi' => $this->request['DiaChi'],
            'SoDienThoai' => $this->request['SoDienThoai'],
            'TrangThai' => $this->request['TrangThai'],
        ));
        if ($update) {
            return response()->json(['thongbao' => 'Success'], 200);
        } else {
            return response()->json(0, 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KhachHang  $khachHang
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = DB::table('khachhang')->where('IDKhachHang', $id)->delete();
        if ($delete) {
            return response()->json(['thongbao' => 'Success']);
        } else {
            return response()->json(0, 400);
        }
    }
}
