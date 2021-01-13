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
        $list = DB::table('baidang')
            ->where('TrangThai', '1')
            ->orderBy('NgayDang', 'desc')
            ->get();
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

        $NgayDang = Carbon::now();
        $NgayDang = $NgayDang->toDateTimeString();

        $baidang = DB::table('baidang')->insert([
            'IDKhachHang' => $this->request['IDKhachHang'],
            'TieuDe' => $this->request['TieuDe'],
            'NoiDung' => $this->request['NoiDung'],
            'HinhAnh' => $this->request['HinhAnh'],
            'IDTheLoaiSP' => $this->request['IDTheLoaiSP'],
            'IDModel' => $this->request['IDModel'],
            'GiaBan' => $this->request['GiaBan'],
            'TinhThanh' => $this->request['TinhThanh'],
            'QuanHuyen' => $this->request['QuanHuyen'],
            'NgayDang' => $NgayDang,
            'TrangThai' => 1,
        ]);
        if ($baidang) {
            return response()->json(1, 201);
        } else {
            return response()->json(0, 400);
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
        $baidang = DB::table('baidang')
            ->join('khachhang', 'khachhang.IDKhachHang', '=', 'baidang.IDKhachHang')
            ->join('province','province.id','=','baidang.TinhThanh')
            ->join('district','district.id','=','baidang.QuanHuyen')
            ->select('khachhang.*', 'baidang.*','province._name as TenTinhThanh','district._name as TenQuanHuyen')
            ->where('IDBaiDang', $id)
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
        $update = DB::table('baidang')->where('IDBaiDang', $id)->update(array(
            'TieuDe' => $this->request['TieuDe'],
            'NoiDung' => $this->request['NoiDung'],
            'HinhAnh' => $this->request['HinhAnh'],
            'IDTheLoaiSP' => $this->request['IDTheLoaiSP'],
            'IDModel' => $this->request['IDModel'],
            'GiaBan' => $this->request['GiaBan'],
            'TinhThanh' => $this->request['TinhThanh'],
            'QuanHuyen' => $this->request['QuanHuyen'],
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
     * @param  \App\Models\BaiDang  $baiDang
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = DB::table('baidang')->where('IDBaiDang', $id)->delete();
        if ($delete) {
            return response()->json(['thongbao' => 'Success']);
        } else {
            return response()->json(0, 400);
        }
    }

    public function baidangkhachhang($id_kh)
    {
        $baidang = DB::table('baidang')
            ->where('IDKhachHang', $id_kh)
            ->where('TrangThai','1')
            ->orderBy('NgayDang', 'desc')
            ->get();
        return response()->json($baidang, 200);
    }
    public function theloaisp()
    {
        $theloaisp = DB::table('theloaisanpham')->get();
        return response()->json($theloaisp, 200);
    }

    public function hangsx($id)
    {
        if ($id == 1) {
            $hangsx = DB::table('dienthoai')
                ->get();
            return response()->json($hangsx, 200);
        }
        if ($id == 2) {
            $hangsx = DB::table('laptop')
                ->get();
            return response()->json($hangsx, 200);
        }
        if ($id == 3) {
            $hangsx = DB::table('linhkiendidong')->get();
            return response()->json($hangsx, 200);
        }
        if ($id == 4) {
            $hangsx = DB::table('linhkienmaytinh')->get();
            return response()->json($hangsx, 200);
        }
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
            $models = DB::table('thongtinlaptop')->where('IDHangSX', $id_hangsx)
                ->get();
            return response()->json($models, 200);
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

    public function baidangtinhthanh()
    {
        $keys = $this->request['TuKhoa'];
        $id = $this->request['IDTinhThanh'];
        $baidang = DB::table('baidang')->where('TinhThanh', $id)
            ->where('TieuDe', 'like', '%' . $keys . '%')
            ->get();
        $count = $baidang->count();
        return response()->json(['data' => $baidang, $count => $count], 200);
    }

    public function locbaidang()
    {
        $tuychon = $this->request['tuychon'];
        $mucgia = $this->request['mucgia'];
        $tinhthanh = $this->request['tinhthanh'];

        if ($mucgia == 1) {
            $tu = 0;
            $den = 1000000;
        }
        if ($mucgia == 2) {
            $tu = 1000000;
            $den = 3000000;
        }
        if ($mucgia == 3) {
            $tu = 3000000;
            $den = 5000000;
        }
        if ($mucgia == 4) {
            $tu = 5000000;
            $den = 8000000;
        }
        if ($mucgia == 5) {
            $tu = 5000000;
            $den = 50000000;
        }
        // gia tu thap den cao
        if ($tuychon == 1) {
            $baidang = DB::table('baidang')->where('TinhThanh', $tinhthanh)
                ->whereBetween('GiaBan', [$tu, $den])
                ->orderBy('GiaBan', 'asc')
                ->get();

            return response()->json($baidang, 200);
        }
        if ($tuychon == 2) {
            $baidang = DB::table('baidang')->where('TinhThanh', $tinhthanh)
                ->whereBetween('GiaBan', [$tu, $den])
                ->orderBy('GiaBan', 'desc')
                ->get();

            return response()->json($baidang, 200);
        }
    }
}
