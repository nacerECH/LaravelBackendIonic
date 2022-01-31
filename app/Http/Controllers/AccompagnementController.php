<?php

namespace App\Http\Controllers;

use App\Http\Resources\AccompagnementResource;
use Exception;
use Illuminate\Http\Request;


use App\Models\Accompagnement;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Validator;

class AccompagnementController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        try {
            $restaurant = Restaurant::find(auth()->user()->restaurant->id);
            $success['accompagnements'] = AccompagnementResource::collection($restaurant->accompagnements()->get());
            return $this->sendResponse($success, 'accompagnements found successfully.');
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

        $validator = Validator::make($request->all(), [
            'nom' => 'required|string',
            'prix' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Error validation', $validator->errors());
        }

        try {
            $accompagnement = new Accompagnement();
            $accompagnement->title = $request->nom;
            $accompagnement->prix = floatval($request->prix);
            $accompagnement->restaurant_id = auth()->user()->restaurant->id;
            $accompagnement->save();

            $success['accompagnement'] = $accompagnement;
            return $this->sendResponse($success, 'Accompagnement created successfully.');
        } catch (Exception $e) {
            return $this->sendError('server Error', $e->getMessage());
        }


        $success['menu'] = $accompagnement;

        return $this->sendResponse($success, 'Menu created successfully.');
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
