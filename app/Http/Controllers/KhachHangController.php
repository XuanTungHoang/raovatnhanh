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
        $rules = [ 'image' => 'image|max:1024' ]; 
        $posts = [ 'image' => $request->file('HinhAnh') ];
        $valid = Validator::make($posts, $rules);
        if ($valid->fails()) {
            // Có lỗi, trả lỗi
            return response()->json(['Thongbao'=>'Hình ảnh không hợp lệ !'],400);
        }else{
            if($request->file('HinhAnh')->isValid()){
                // Lay file
                $file = $request->file('HinhAnh');
                // Lay ten file
                $file_name = $file->getClientOriginalName();
                // Lay duoi file
                $file_extension = $file->getClientOriginalExtension();
                // Doi ten
                $new_name = $file_name ."_" . time() ."_" . rand(0, 999999). ".".$file_extension;
                // Lay path de luu
                $uploadPath = public_path('/upload/cus');
                // Di chuyen va luu file
                $file->move($uploadPath,$new_name);

                $khachhang=new KhachHang();
                $khachhang->Email=$this->request['Email'];
                $khachhang->MatKhau=Hash::make($this->request['MatKhau']);
                $khachhang->TenKhachHang=$this->request['TenKhachHang'];
                $khachhang->HinhAnh=$new_name;
                $khachhang->DiaChi=$this->request['DiaChi'];
                $khachhang->SoDienThoai=$this->request['SoDienThoai'];
                $khachhang->TrangThai=$this->request['TrangThai'];
                $khachhang->save();
                if(!empty($khachhang)){
                    return response()->json($khachhang,201);
                }else{
                    return response()->json(0,400);
                }
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\KhachHang  $khachHang
     * @return \Illuminate\Http\Response
     */
    public function show( $id)
    {
        $khachhang = KhachHang::where('IDKhachHang', $id)->get();
        return response()->json($khachhang,200);
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
        $rules = [ 'image' => 'image|max:1024' ]; 
        $posts = [ 'image' => $request->file('HinhAnh') ];
        $valid = Validator::make($posts, $rules);

        if ($valid->fails()) {
            // Có lỗi, trả lỗi
            return response()->json(['Thongbao'=>'Hình ảnh không hợp lệ !'],400);
        }else{
            if($request->file('HinhAnh')->isValid()){
                // Lay file
                $file = $request->file('HinhAnh');
                // Lay ten file
                $file_name = $file->getClientOriginalName();
                // Lay duoi file
                $file_extension = $file->getClientOriginalExtension();
                // Doi ten
                $new_name = $file_name ."_" . time() ."_" . rand(0, 999999). ".".$file_extension;
                // Lay anh cu ra xoa no di
                $taikhoan = KhachHang::where('IDKhachHang',$id)->first();
                $old_name_image=$taikhoan->HinhAnh;
                //return response()->json($old_name_image,400);

                // Update data
                $update = DB::table('khachhang')->where('IDKhachHang',$id)->update(array(
                    'TenKhachHang'=>$this->request['TenKhachHang'],
                    'HinhAnh'=>$new_name,
                    'DiaChi'=>$this->request['DiaChi'],
                    'SoDienThoai'=>$this->request['SoDienThoai'],
                    'TrangThai'=>$this->request['TrangThai'],
                ));
                if($update){
                    // Lay path de luu
                    $uploadPath = public_path('/upload/cus');
                    // Di chuyen va luu file
                    $file->move($uploadPath,$new_name);
                    //Xoa anh cu
                    $image_path = "public/upload/cus/".$old_name_image;  // Value is not URL but directory file path
                    if(File::exists($image_path)) {
                        File::delete($image_path);
                        return response()->json(['thongbao'=>'Success'],200);
                    }else{
                        return response()->json(0,400);
                    }
                }
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KhachHang  $khachHang
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        $khachhang = KhachHang::where('IDKhachHang',$id)->first();
        $old_name_image=$khachhang->HinhAnh;
        $delete = DB::table('khachhang')->where('IDKhachHang', $id)->delete();
        if($delete){
            $image_path = "public/upload/cus/".$old_name_image;  
            if(File::exists($image_path)) {
                File::delete($image_path);
            }
            return response()->json(['thongbao'=>'Success']);
        }else{
            return response()->json(0,400);
        }
    }
}
