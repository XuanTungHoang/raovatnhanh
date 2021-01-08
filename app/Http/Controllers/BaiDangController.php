<?php

namespace App\Http\Controllers;

use App\Models\BaiDang;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class BaiDangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $list = DB::table('baidang')->where('IDKhachHang',$id_kh)->get();

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
        $rules = ['image' => 'image|max:1024'];
        $posts = ['image' => $request->file('HinhAnh')];
        $valid = Validator::make($posts, $rules);
        if ($valid->fails()) {
            // Có lỗi, trả lỗi
            return response()->json(['Thongbao' => 'Hình ảnh không hợp lệ !'], 400);
        } else {
            if ($request->file('HinhAnh')->isValid()) {
                // Lay file
                $file = $request->file('HinhAnh');
                // Lay ten file
                $file_name = $file->getClientOriginalName();
                // Lay duoi file
                $file_extension = $file->getClientOriginalExtension();
                // Doi ten
                $new_name = $file_name . "_" . time() . "_" . rand(0, 999999) . "." . $file_extension;
                // Lay path de luu
                $uploadPath = public_path('/upload/postss');
                // Di chuyen va luu file
                $file->move($uploadPath, $new_name);

                $NgayDang = Carbon::now();
                $NgayDang = $NgayDang->toDateTimeString();

                $baidang = DB::table('baidang')->insert([
                    'IDKhachHang' => $this->request['IDKhachHang'],
                    'TieuDe' => $this->request['TieuDe'],
                    'NoiDung' => $this->request['NoiDung'],
                    'HinhAnh' => $new_name,
                    'IDTheLoaiSP' => $this->request['IDTheLoaiSP'],
                    'IDModel' => $this->request['IDModel'],
                    'GiaBan' => $this->request['GiaBan'],
                    'TinhThanh' => $this->request['TinhThanh'],
                    'QuanHuyen' => $this->request['QuanHuyen'],
                    'NgayDang' => $NgayDang,
                    'TrangThai' => $this->request['TrangThai'],
                ]);
                if ($baidang) {
                    return response()->json(1, 201);
                } else {
                    return response()->json(0, 400);
                }
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BaiDang  $baiDang
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $baidang = DB::table('baidang')->where('IDBaiDang', $id)
            ->orderBy('NgayDang', 'desc')
            ->get();
        return response()->json($baidang, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BaiDang  $baiDang
     * @return \Illuminate\Http\Response
     */
    public function edit(BaiDang $baiDang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BaiDang  $baiDang
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = ['image' => 'image|max:1024'];
        $posts = ['image' => $request->file('HinhAnh')];
        $valid = Validator::make($posts, $rules);
        //return response()->json($posts);
        if ($valid->fails()) {
            // Có lỗi, trả lỗi
            return response()->json(['Thongbao' => 'Hình ảnh không hợp lệ !'], 400);
        } else {
            if ($request->file('HinhAnh')->isValid()) {
                // Lay file
                $file = $request->file('HinhAnh');
                // Lay ten file
                $file_name = $file->getClientOriginalName();
                // Lay duoi file
                $file_extension = $file->getClientOriginalExtension();
                // Doi ten
                $new_name = $file_name . "_" . time() . "_" . rand(0, 999999) . "." . $file_extension;
                // Lay path de luu
                $baidang = BaiDang::where('IDBaiDang', $id)->first();
                $old_name_image = $baidang->HinhAnh;
               // return response()->json($old_name_image, 400);


                $update = DB::table('baidang')->where('IDBaiDang', $id)->update(array(
                    'TieuDe' => $this->request['TieuDe'],
                    'NoiDung' => $this->request['NoiDung'],
                    'HinhAnh' => $new_name,
                    'IDTheLoaiSP' => $this->request['IDTheLoaiSP'],
                    'IDModel' => $this->request['IDModel'],
                    'GiaBan' => $this->request['GiaBan'],
                    'TinhThanh' => $this->request['TinhThanh'],
                    'QuanHuyen' => $this->request['QuanHuyen'],

                ));
                if ($update) {
                    // Lay path de luu
                    $uploadPath = public_path('/upload/postss');
                    // Di chuyen va luu file
                    $file->move($uploadPath, $new_name);
                    //Xoa anh cu
                    $image_path = "public/upload/postss/" . $old_name_image;  // Value is not URL but directory file path
                    if (File::exists($image_path)) {
                        File::delete($image_path);
                        return response()->json(['thongbao' => 'Success'], 200);
                    } else {
                        return response()->json(0, 400);
                    }
                }
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BaiDang  $baiDang
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        $baidang = BaiDang::where('IDBaiDang',$id)->first();
        $old_name_image=$baidang->HinhAnh;
        $delete = DB::table('baidang')->where('IDBaiDang', $id)->delete();
        if($delete){
            $image_path = "public/upload/postss/".$old_name_image;  
            if(File::exists($image_path)) {
                File::delete($image_path);
            }
            return response()->json(['thongbao'=>'Success']);
        }else{
            return response()->json(0,400);
        }
    }

    public function baidangkhachhang($id_kh){
        $baidang = DB::table('baidang')->where('IDKhachHang', $id_kh)
            ->orderBy('NgayDang', 'desc')
            ->get();
        return response()->json($baidang, 200);
    }
    public function theloaisp()
    {
        $theloaisp = DB::table('theloaisanpham')->get();
        return response()->json($theloaisp, 200);
    }

    public function modelsp()
    {
        $id_theloai = $this->request['IDTheLoaiSP'];
        $id_hangsx = $this->request['IDHangSX'];
        if ($id_theloai == 1) {
            $models = DB::table('thongtindienthoai')->where('IDHangSX', $id_hangsx)
                ->get();
            return response()->json($models, 200);
        }
        if ($id_theloai == 2) {
            $hangsx = DB::table('thongtinlaptop')->where('IDHangSX', $id_hangsx)
                ->get();
            return response()->json($hangsx, 200);
        }
        if ($id_theloai == 3) {
            $hangsx = DB::table('linhkiendidong')->get();
            return response()->json($hangsx, 200);
        }
        if ($id_theloai == 4) {
            $hangsx = DB::table('linhkienmaytinh')->get();
            return response()->json($hangsx, 200);
        }
    }

    public function chitietsp()
    {
        $id_theloai = $this->request['IDTheLoaiSP'];
        // $id_hangsx=$this->request['IDHangSX'];
        $id_model = $this->request['IDModel'];
        if ($id_theloai == 1) {
            $models = DB::table('ctdienthoai')
                ->where('IDModelDT', $id_model)
                ->get();
            return response()->json($models, 200);
        } else {
            return response()->json(0, 200);
        }
    }
}
