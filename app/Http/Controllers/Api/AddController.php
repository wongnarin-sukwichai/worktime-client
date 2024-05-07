<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;
use App\Models\Checkin;
use App\Models\Checkout;
use App\Models\Member;
use App\Models\Record;

class AddController extends Controller
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
            'name' => 'required',
            'surname' => 'required',
            'dat' => 'required',
            'time' => 'required',
            'code' => 'required'
        ]);

        if($request['code'] == 1) {
            $data = new Checkin();
            $code = 'timein';
            $result = 'otherin';
        } else {
            $data = new Checkout();
            $code = 'timeout';
            $result = 'otherout';
        }

        $data->uid = $request['uid'];
        $data->name = $request['name'];
        $data->surname = $request['surname'];
        $data->local = 'arec';
        $data->dat = $request['dat'];
        $data->d = Carbon::createFromFormat('Y-m-d', $request['dat'])->format('d');
        $data->m = Carbon::createFromFormat('Y-m-d', $request['dat'])->format('m');
        $data->y = Carbon::createFromFormat('Y-m-d', $request['dat'])->format('Y');
        $data->$code = $request['time'];
        $data->$result = $request['other'];
        $data->created = Auth::user()->name . ' ' . Auth::user()->surname;

        $data->save();

        $res = new Record();

        $res->type = '3';
        $res->created_by = Auth::user()->name . ' ' . Auth::user()->surname;
        $res->uid = $request['uid'] ;
        $res->name = $request['name'];
        $res->surname = $request['surname'];
        $res->local = 'arec';
        $res->dat = $request['dat'];
        $res->d = Carbon::createFromFormat('Y-m-d', $request['dat'])->format('d');
        $res->m = Carbon::createFromFormat('Y-m-d', $request['dat'])->format('m');
        $res->y = Carbon::createFromFormat('Y-m-d', $request['dat'])->format('Y');
        $res->timenew = $request['time'];
        $res->other = $request['other'];

        $res->save();

        return response()->json([
            'message' => 'แก้ไขข้อมูลเรียบร้อย'
        ]);
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
