<?php

namespace App\Http\Controllers;

use App\Models\TaiKhoan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $user = TaiKhoan::where('TenDangNhap', $request->TenDangNhap)->first();
        if (!empty($user)) {
            if ($user->MatKhau = Hash::make($this->request['MatKhau'])) {
                DB::table('taikhoan')->where('TenDangNhap', $request->TenDangNhap)->update(array(
                    'TrangThai' => 1,
                ));
                return $user;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }

    public function doimatkhau($id){
        $tk=DB::table('taikhoan')->where('IDTaiKhoan',$id)->first();
        $old_pass=$tk->MatKhau;
       // return response()->json($old_pass,200);
        $req_old_pass=Hash::check($this->request['MatKhau'],$old_pass);
        if($req_old_pass){
           // return response()->json($req_old_pass,200);
            $update_pass = DB::table('taikhoan')->where('IDTaiKhoan',$id)->update(array(
                'MatKhau'=>Hash::make($this->request['MatKhauMoi']),
            ));
            if($update_pass){
                return response()->json(['Thongbao'=>'Success'],200);
            }
        }else{
            return response()->json(0,400);
        }
        
    }
}
