<?php

namespace App\Http\Controllers;

use App\Models\Reclamation;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ReclamationController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        try {
            if (auth()->user()->role == 'clt') {
                $authInstance = auth()->user()->client;
            } else {
                $authInstance = auth()->user()->restaurant;
            }

            $success['reclamation'] = $authInstance->reclamations()->get();
            return $this->sendResponse($success, 'Menu created successfully.');
        } catch (Exception $e) {
            return $this->sendError('server Error', $e->getMessage());
        }
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
        //
        $validator = Validator::make($request->all(), [
            'sujet' => 'required|string',
            'description' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Error validation', $validator->errors());
        }

        try {
            if (auth()->user()->role == 'clt') {
                $authInstance = auth()->user()->client;
            } else {
                $authInstance = auth()->user()->restaurant;
            }
            $authInstance->reclamations()->save(
                new Reclamation([
                    'sujet' => $request->sujet,
                    'description' => $request->description
                ])
            );
            $success['reclamation'] = $authInstance->reclamations()->get();
            return $this->sendResponse($success, 'Menu created successfully.');
        } catch (Exception $e) {
            return $this->sendError('server Error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
