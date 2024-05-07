<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Carbon\Carbon;

use App\Models\Member;
use Illuminate\Support\Facades\DB;

use App\Models\Checkin;
use App\Models\Checkout;
use App\Models\Otin;
use App\Models\Otout;

class CheckinController extends Controller
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
            'uid' => 'required',
            'capture' => 'required'
        ]);

        $now = Carbon::now();
        // $dat = $now->addYear(543)->format('Y-m-d');
        $dat = $now->format('Y-m-d');
        $y = $now->format('Y');
        $m = $now->format('m');
        $d = $now->format('d');
        $time = $now->format('H:i:s');

        $res = Member::where('uid', $request['uid'])->first();

        if (empty($res)) {

            return response()->json([
                'message' => 'ข้อมูลไม่ถูกต้อง. กรุณาตรวจสอบ'
            ], 422);
        } else {

            $data = new Checkin();

            $data->uid = $request['uid'];
            $data->pic = $request['capture'];
            $data->name = $res->name;
            $data->surname = $res->surname;
            $data->local = null;
            $data->dat = $dat;
            $data->d = $d;
            $data->m = $m;
            $data->y = $y;
            $data->timein = $time;
            $data->otherin = null;
            $data->created = null;

            $data->save();
        }

        return response()->json($data);
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'uid' => 'required',
            'capture' => 'required'
        ]);

        $now = Carbon::now();
        // $dat = $now->addYear(543)->format('Y-m-d');
        $dat = $now->format('Y-m-d');
        $y = $now->format('Y');
        $m = $now->format('m');
        $d = $now->format('d');
        $time = $now->format('H:i:s');

        $res = Member::where('uid', $request['uid'])->first();

        if (empty($res)) {

            return response()->json([
                'message' => 'ข้อมูลไม่ถูกต้อง. กรุณาตรวจสอบ'
            ], 422);
        } else {

            $data = new Checkout();

            $data->uid = $request['uid'];
            $data->pic = $request['capture'];
            $data->name = $res->name;
            $data->surname = $res->surname;
            $data->local = null;
            $data->dat = $dat;
            $data->d = $d;
            $data->m = $m;
            $data->y = $y;
            $data->timeout = $time;
            $data->otherout = null;
            $data->created = null;

            $data->save();
        }

        return response()->json($data);
    }

    public function otin(Request $request)
    {
        $request->validate([
            'uid' => 'required',
            'capture' => 'required'
        ]);

        $now = Carbon::now();
        $dat = $now->format('Y-m-d');
        $y = $now->format('Y');
        $m = $now->format('m');
        $d = $now->format('d');
        $time = $now->format('H:i:s');

        $res = Member::where('uid', $request['uid'])->first();


        if (empty($res)) {

            return response()->json([
                'message' => 'ข้อมูลไม่ถูกต้อง. กรุณาตรวจสอบ'
            ], 422);
        } else {

            $data = new Otin();

            $data->uid = $request['uid'];
            $data->pic = $request['capture'];
            $data->name = $res->name;
            $data->surname = $res->surname;
            $data->local = null;
            $data->dat = $dat;
            $data->d = $d;
            $data->m = $m;
            $data->y = $y;
            $data->timein = $time;
            $data->otherin = null;
            $data->created = null;

            $data->save();
        }

        return response()->json($data);
    }


    public function otout(Request $request)
    {
        $request->validate([
            'uid' => 'required',
            'capture' => 'required'
        ]);

        $now = Carbon::now();
        // $dat = $now->addYear(543)->format('Y-m-d');
        $dat = $now->format('Y-m-d');
        $y = $now->format('Y');
        $m = $now->format('m');
        $d = $now->format('d');
        $time = $now->format('H:i:s');

        $res = Member::where('uid', $request['uid'])->first();

        if (empty($res)) {

            return response()->json([
                'message' => 'ข้อมูลไม่ถูกต้อง. กรุณาตรวจสอบ'
            ], 422);
        } else {

            $data = new Otout();

            $data->uid = $request['uid'];
            $data->pic = $request['capture'];
            $data->name = $res->name;
            $data->surname = $res->surname;
            $data->local = null;
            $data->dat = $dat;
            $data->d = $d;
            $data->m = $m;
            $data->y = $y;
            $data->timeout = $time;
            $data->otherout = null;
            $data->created = null;

            $data->save();
        }

        return response()->json($data);
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
