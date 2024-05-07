<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Checkin;
use App\Models\Checkout;
use App\Models\Record;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EditController extends Controller
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

    public function editin($id)
    {
        $data = Checkin::find($id); 
        return response()->json($data);
    }

    public function editout($id)
    {
        $data = Checkout::find($id); 
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    public function updatein(Request $request) 
    {
        $request->validate([
            'id' => 'required',
            'timein' => 'required',
            'otherin' => 'required'
        ]);

        $data = Checkin::find($request['id']);

        // บันทึกลง table Record ก่อน
        $res = new Record();
        $res->ref_id = $request['id'];
        $res->type = 1;
        $res->created_by = Auth::user()->name . ' ' . Auth::user()->surname;
        $res->uid = $data->uid;
        $res->pic = $data->pic;
        $res->name = $data->name;
        $res->surname = $data->surname;
        $res->local = $data->local;
        $res->dat = $data->dat;
        $res->d = $data->d;
        $res->m = $data->m;
        $res->y = $data->y;
        $res->timetype = 'เข้างาน';
        $res->timeold = $data->timein;
        $res->timenew = $request['timein'];
        $res->other = $request['otherin'];

        $res->save();

        // update ข้อมูล
        $data->timein = $request['timein'];
        $data->otherin = $request['otherin'];
        $data->update();

        return response()->json($data);        

    }

    public function updateout(Request $request) 
    {
        $request->validate([
            'id' => 'required',
            'timeout' => 'required',
            'otherout' => 'required'
        ]);

        $data = Checkout::find($request['id']);

        // บันทึกลง table Record ก่อน
        $res = new Record();
        $res->ref_id = $request['id'];
        $res->type = 2;
        $res->created_by = Auth::user()->name . ' ' . Auth::user()->surname;
        $res->uid = $data->uid;
        $res->pic = $data->pic;
        $res->name = $data->name;
        $res->surname = $data->surname;
        $res->local = $data->local;
        $res->dat = $data->dat;
        $res->d = $data->d;
        $res->m = $data->m;
        $res->y = $data->y;
        $res->timetype = 'ออกงาน';
        $res->timeold = $data->timeout;
        $res->timenew = $request['timeout'];
        $res->other = $request['otherout'];

        $res->save();


        // update ข้อมูล
        $data->timeout = $request['timeout'];
        $data->otherout = $request['otherout'];
        $data->update();

        return response()->json($data);        

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
