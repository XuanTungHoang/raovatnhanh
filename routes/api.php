<?php

use App\Http\Controllers\BaiDangController;
use App\Http\Controllers\LoaiTKController;
use App\Http\Controllers\TaiKhoanController;
use App\Http\Controllers\KhachHangController;
use App\Http\Controllers\QuangCaoController;
use App\Http\Controllers\ThongBaoController;
use App\Http\Controllers\TinhThanhController;
use App\Http\Controllers\TinLuuController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Loai tai khoan
Route::get('/loaitaikhoan',[LoaiTKController::class,'index']);
Route::post('/loaitaikhoan',[LoaiTKController::class,'store']);
Route::get('/loaitaikhoan/{id}',[LoaiTKController::class,'show']);
Route::put('/loaitaikhoan/{id}',[LoaiTKController::class,'update']);
Route::delete('/loaitaikhoan/{id}',[LoaiTKController::class,'destroy']);

// Tai khoan
Route::get('/taikhoan',[TaiKhoanController::class,'index']);
Route::post('/taikhoan',[TaiKhoanController::class,'store']);
Route::get('/taikhoan/{id}',[TaiKhoanController::class,'show']);
Route::put('/taikhoan/{id}',[TaiKhoanController::class,'update']);
Route::delete('/taikhoan/{id}',[TaiKhoanController::class,'destroy']);

// Khach hang
Route::get('/khachhang',[KhachHangController::class,'index']);
Route::post('/khachhang',[KhachHangController::class,'store']);
Route::get('/khachhang/{id}',[KhachHangController::class,'show']);
Route::put('/khachhang/{id}',[KhachHangController::class,'update']);
Route::delete('/khachhang/{id}',[KhachHangController::class,'destroy']);

// Thong bao
Route::post('/thongbao',[ThongBaoController::class,'themthongbao']);
// Thong bao theo id khach hang
Route::get('/thongbao/{id}',[ThongBaoController::class,'dsthongbao']);
Route::delete('/thongbao/{id}',[ThongBaoController::class,'xoathongbao']);

// Bai dang
Route::get('/baidang',[BaiDangController::class,'index']);
Route::post('/baidang',[BaiDangController::class,'store']);
Route::get('/baidang/{id}',[BaiDangController::class,'show']);
Route::put('/baidang/{id}',[BaiDangController::class,'update']);
Route::delete('/baidang/{id}',[BaiDangController::class,'destroy']);
    // -- Bai dang cua tung khach hang
Route::get('/bdkh/{id}',[BaiDangController::class,'baidangkhachhang']);
    // --  The loai san pham --
Route::get('/theloaisp',[BaiDangController::class,'theloaisp']);
   // --  Hang san xuat theo id loai san pham --
Route::get('/hangsx/{id}',[BaiDangController::class,'hangsx']);
    // -- Model san pham theo the loai san pham va hang sx --
Route::post('/modelsp',[BaiDangController::class,'modelsp']);
    //-- Chi tiet model --
Route::post('/chitietmodel',[BaiDangController::class,'chitietsp']);
    // -- Bai dang theo tinh thanh
Route::post('/bdtt',[BaiDangController::class,'baidangtinhthanh']);
    // -- Bai dang theo muc gia + tinh thanh
Route::post('/locbaidang',[BaiDangController::class,'locbaidang']);

// Tin da luu
Route::post('/tinluu',[TinLuuController::class,'themtinluu']);
Route::get('/tinluu/{id}',[TinLuuController::class,'dstinluu']);
Route::delete('/tinluu/{id}',[TinLuuController::class,'xoatinluu']);

// Quang cao
Route::get('/baidangtheloai/{id}',[QuangCaoController::class,'baidangtheloai']);
Route::get('/quangcao',[QuangCaoController::class,'dsquangcao']);
Route::get('/quangcao/{id}',[QuangCaoController::class,'timquangcao']);
Route::post('/quangcao',[QuangCaoController::class,'themquangcao']);
Route::put('/quangcao/{id}',[QuangCaoController::class,'suaquangcao']);
Route::delete('/quangcao/{id}',[QuangCaoController::class,'xoaquangcao']);

// Tinh thanh - quan huyen
Route::get('/tinhthanh',[TinhThanhController::class,'dstinhthanh']);
Route::get('/quanhuyen/{id}',[TinhThanhController::class,'quanhuyen']);






