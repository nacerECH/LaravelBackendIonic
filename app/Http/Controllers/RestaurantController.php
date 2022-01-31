<?php

namespace App\Http\Controllers;

use App\Http\Resources\RestaurantResource;
use App\Models\Restaurant;
use Exception;
use Illuminate\Http\Request;

class RestaurantController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $GLOBALS['raduis'] = $this->calcCoordinates($request->longitude, $request->latitude, 1000);
        $restaurants =  Restaurant::where('latitude', '>=', $GLOBALS['raduis']['min']['lat'])
            ->where('longitude', '>=',  $GLOBALS['raduis']['min']['lng'])
            ->where('latitude', '<=', $GLOBALS['raduis']['max']['lat'])
            ->where('longitude', '<=', $GLOBALS['raduis']['max']['lng'])
            ->get();


        $success['restaurants'] = RestaurantResource::collection($restaurants);
        return $this->sendResponse($success, 'Commande created successfully.');
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
        try {
            $success['restaurant'] = new RestaurantResource(Restaurant::find($id));
            return $this->sendResponse($success, 'Restaurant found successfully.');
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
    public  function calcCoordinates($longitude, $latitude, $radius = 20)
    {
        $lng_min = $longitude - $radius / abs(cos(deg2rad($latitude)) * 69);
        $lng_max = $longitude + $radius / abs(cos(deg2rad($latitude)) * 69);
        $lat_min = $latitude - ($radius / 69);
        $lat_max = $latitude + ($radius / 69);

        return [
            'min' => [
                'lat' => $lat_min,
                'lng' => $lng_min,
            ],
            'max' => [
                'lat' => $lat_max,
                'lng' => $lng_max,
            ],
        ];
    }
}
