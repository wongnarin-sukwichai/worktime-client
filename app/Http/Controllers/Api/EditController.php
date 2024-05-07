<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Checkin;
use App\Models\Checkout;
use App\Models\Record;
use Carbon\Carbon;
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

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        if ($request['code'] == 1) {
            $data = Checkin::find($request['id']);

            $result = $data->timein;

            $data->timein = $request['time'];
            $data->otherin = $request['other'];
        } else {
            $data = Checkout::find($request['id']);

            $result = $data->timeout;

            $data->timeout = $request['time'];
            $data->otherout = $request['other'];
        }

        $data->update();

        $res = new Record();
        $res->ref_id = $request['id'];
        $res->type = $request['code'];
        $res->created_by = Auth::user()->name . ' ' . Auth::user()->surname;
        $res->uid = $data->uid;
        $res->name = $request['name'];
        $res->surname = $request['surname'];
        $res->local = 'arec';
        $res->dat = $request['dat'];
        $res->d = Carbon::createFromFormat('Y-m-d', $request['dat'])->format('d');
        $res->m = Carbon::createFromFormat('Y-m-d', $request['dat'])->format('m');
        $res->y = Carbon::createFromFormat('Y-m-d', $request['dat'])->format('Y');
        $res->timeold = $result;
        $res->timenew = $request['time'];
        $res->other = $request['other'];

        $res->save();

        return response()->json([
            'message' => 'แก้ไขข้อมูลเรียบร้อย'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
