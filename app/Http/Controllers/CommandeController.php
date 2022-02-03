<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Plat;
use App\Models\Client;
use App\Models\Commande;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use GrahamCampbell\ResultType\Success;
use App\Http\Resources\CommandeResource;
use Illuminate\Support\Facades\Validator;

class CommandeController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->role === 'clt') {
            try {
                $client = Client::find(auth()->user()->client->id);
                $success['orders'] = CommandeResource::collection($client->commandes()->get());
                return $this->sendResponse($success, 'Menus found successfully.');
            } catch (Exception $e) {
                return $this->sendError('server Error', $e->getMessage());
            }
        } else {
            try {
                $restaurant = Restaurant::find(auth()->user()->restaurant->id);
                $success['orders'] = CommandeResource::collection($restaurant->commandes()->get());
                return $this->sendResponse($success, 'Menus found successfully.');
            } catch (Exception $e) {
                return $this->sendError('server Error', $e->getMessage());
            }
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
        // return response()->json([
        //     'success' => true,
        //     'data' => $request->selectedArray,
        // ]);
        $validator = Validator::make($request->all(), [
            'adresse' => 'required|string',
            'phone' => 'required|string',
            'total' => 'required',
            'quantity' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Error validation', $validator->errors());
        }

        $commande = new Commande();
        $commande->adresse = $request->adresse;
        $commande->telephone = $request->phone;
        $commande->total = floatval($request->total);
        $commande->quantity = intval($request->quantity);
        $commande->plat_id = $request->plat_id;
        $commande->client_id = auth()->user()->client->id;
        $commande->restaurant_id = Plat::find($request->plat_id)->menu->restaurant->id;
        $commande->save();

        if (count($request->selectedArray)) {
            foreach ($request->selectedArray as $check) {
                $commande->accompagnements()->attach(intval($check['id']), ['quantity' => intval($check['quantity'])]);
            }
        }




        $success['Commande'] = new CommandeResource($commande);

        return $this->sendResponse($success, 'Commande created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $success['commande'] = new CommandeResource(Commande::find($id));
            return $this->sendResponse($success, 'plat found successfully.');
        } catch (Exception $e) {
            return $this->sendError('server Error', $e->getMessage());
        }
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
