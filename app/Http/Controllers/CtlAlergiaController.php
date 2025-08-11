<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCtlAlergiaRequest;
use App\Http\Requests\UpdateCtlAlergiaRequest;
use App\Models\CtlAlergia;

class CtlAlergiaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return view('alergia.index', [
            'alergias' => CtlAlergia::where('deleted_at', '=', null)->get(),
        ]);
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
    public function store(StoreCtlAlergiaRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(CtlAlergia $ctl_Alergia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CtlAlergia $ctl_Alergia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCtlAlergiaRequest $request, CtlAlergia $ctl_Alergia)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CtlAlergia $ctl_Alergia)
    {
        //
    }
}
