<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class UploadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:png,jpg,jpeg'
        ]);

        $now = Carbon::now();
        // $year = $now->addYear(543)->format('Y');
        $year = $now->format('Y');
        $month = $now->format('m');
        $day = $now->format('d');
        
        $image = $request->file('file');                                                 //ดึงไฟล์รูปภาพ 
        $image_name = uniqid() . '.png';                                            //uniqid() สุ่มชื่อใหม่ให้รูปภาพ / ถ้าเป็น blob ก็ตั้งนามสกุลไปให้มันได้เลย

        $serv_path = "http://202.28.34.39:8081/storage/img/". $year . '/' . $month . '/'. $day;                                                 //สร้าง Path สำหรับ save file 

        $chkPath = public_path($serv_path);                                             //public_path ตือ folder public

        if (!File::exists($chkPath)) File::makeDirectory($chkPath, 0777, true);         //Check ว่ามี folder ไหม ถ้าไม่มีให้สร้าง folder ขึ้นมาใหม่

        $image->move($chkPath, $image_name);                                           //ถ้าไม่ได้ resize ให้ใช้คำสั่ง move และ , พร้อมตั้งชื่อไฟล์

        return response()->json($image_name);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
