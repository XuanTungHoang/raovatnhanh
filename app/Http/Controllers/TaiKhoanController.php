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
                $uploadPath = public_path('/upload/admin');
                // Di chuyen va luu file
                $file->move($uploadPath,$new_name);

                $taikhoan=new TaiKhoan();
                $taikhoan->TenDangNhap=$this->request['TenDangNhap'];
                $taikhoan->MatKhau=Hash::make($this->request['MatKhau']);
                $taikhoan->TenTaiKhoan=$this->request['TenTaiKhoan'];
                $taikhoan->HinhAnh=$new_name;
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
                $taikhoan = TaiKhoan::where('IDTaiKhoan',$id)->first();
                $old_name_image=$taikhoan->HinhAnh;
                //return response()->json($old_name_image,400);

                // Update data
                $update = DB::table('taikhoan')->where('IDTaiKhoan',$id)->update(array(
                    'TenTaiKhoan'=>$this->request['TenTaiKhoan'],
                    'HinhAnh'=>$new_name,
                    'GioiTinh'=>$this->request['GioiTinh'],
                    'SoDienThoai'=>$this->request['SoDienThoai'],
                    'IDLoaiTaiKhoan'=>$this->request['IDLoaiTaiKhoan'],
                    'TrangThai'=>$this->request['TrangThai'],
                ));
                if($update){
                    // Lay path de luu
                    $uploadPath = public_path('/upload/admin');
                    // Di chuyen va luu file
                    $file->move($uploadPath,$new_name);
                    //Xoa anh cu
                    $image_path = "public/upload/admin/".$old_name_image;  // Value is not URL but directory file path
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
     * @param  \App\Models\TaiKhoan  $taiKhoan
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        $taikhoan = TaiKhoan::where('IDTaiKhoan',$id)->first();
        $old_name_image=$taikhoan->HinhAnh;
        $delete = DB::table('taikhoan')->where('IDTaiKhoan', $id)->delete();
        if($delete){
            $image_path = "public/upload/admin/".$old_name_image;  
            if(File::exists($image_path)) {
                File::delete($image_path);
            }
            return response()->json(['thongbao'=>'Success']);
        }else{
            return response()->json(0,400);
        }
    }
}
