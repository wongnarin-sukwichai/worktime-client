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
        //
    }

    public function addin(Request $request)
    {
        $request->validate([
            'uid' => 'required',
            'name' => 'required',
            'surname' => 'required',
            'dat' => 'required',
            'timein' => 'required'
        ]);

        $d = Carbon::createFromFormat('Y-m-d', $request['dat'])->format('d');
        $m = Carbon::createFromFormat('Y-m-d', $request['dat'])->format('m');
        $y = Carbon::createFromFormat('Y-m-d', $request['dat'])->format('Y');

        $data = new Checkin();

        $data->uid = $request['uid'];
        $data->name = $request['name'];
        $data->surname = $request['surname'];
        $data->local = null;
        $data->dat = $request['dat'];
        $data->d = $d;
        $data->m = $m;
        $data->y = $y;
        $data->timein = $request['timein'];
        $data->otherin = $request['other'];
        $data->created = Auth::user()->name . ' ' . Auth::user()->surname;

        $data->save();

        // บันทึกลง table Record ก่อน
        $res = new Record();
        $res->ref_id = null;
        $res->type = 1;
        $res->created_by = Auth::user()->name . ' ' . Auth::user()->surname;
        $res->uid = $request['uid'];
        $res->pic = null;
        $res->name = $request['name'];
        $res->surname = $request['surname'];
        $res->local = 'arec';
        $res->dat = $request['dat'];
        $res->d = $d;
        $res->m = $m;
        $res->y = $y;
        $res->timetype = 'เข้างาน';
        $res->timeold = null;
        $res->timenew = $request['timein'];
        $res->other = $request['other'];

        $res->save();

        return response()->json($data);
    }

    public function addout(Request $request)
    {
        $request->validate([
            'uid' => 'required',
            'name' => 'required',
            'surname' => 'required',
            'dat' => 'required',
            'timeout' => 'required'
        ]);

        $d = Carbon::createFromFormat('Y-m-d', $request['dat'])->format('d');
        $m = Carbon::createFromFormat('Y-m-d', $request['dat'])->format('m');
        $y = Carbon::createFromFormat('Y-m-d', $request['dat'])->format('Y');

        $data = new Checkout();

        $data->uid = $request['uid'];
        $data->name = $request['name'];
        $data->surname = $request['surname'];
        $data->local = null;
        $data->dat = $request['dat'];
        $data->d = $d;
        $data->m = $m;
        $data->y = $y;
        $data->timeout = $request['timeout'];
        $data->otherout = $request['other'];
        $data->created = Auth::user()->name . ' ' . Auth::user()->surname;

        $data->save();

        // บันทึกลง table Record ก่อน
        $res = new Record();
        $res->ref_id = null;
        $res->type = 2;
        $res->created_by = Auth::user()->name . ' ' . Auth::user()->surname;
        $res->uid = $request['uid'];
        $res->pic = null;
        $res->name = $request['name'];
        $res->surname = $request['surname'];
        $res->local = 'arec';
        $res->dat = $request['dat'];
        $res->d = $d;
        $res->m = $m;
        $res->y = $y;
        $res->timetype = 'ออกงาน';
        $res->timeold = null;
        $res->timenew = $request['timeout'];
        $res->other = $request['other'];

        $res->save();

        return response()->json($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function showname(string $uid)
    {
        $data = Member::where('uid', $uid)->first();

        return response()->json($data);
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
