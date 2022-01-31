<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Menu;
use App\Models\Plat;
use App\Models\Image;
use Illuminate\Http\Request;
use App\Models\Accompagnement;
use App\Http\Resources\PlatResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PlatController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        try {
            $menu = Menu::find($request->id);
            $success['nom'] = $menu->title;
            $success['plats'] = PlatResource::collection($menu->plats()->get());
            return $this->sendResponse($success, 'Menus found successfully.');
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

        $checkArray = json_decode($request->checkArray);
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string',
            'description' => 'required|string',
            'price' => 'required',
            'promoPrice' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Error validation', $validator->errors());
        }

        $plat = new Plat();
        $plat->title = $request->nom;
        $plat->description = $request->description;
        $plat->prix = floatval($request->price);
        $plat->prix_promo = floatval($request->promoPrice);
        $plat->restaurant_id = auth()->user()->restaurant->id;
        $plat->menu_id = $request->id;
        $plat->save();

        if (count($checkArray)) {
            foreach ($checkArray as $check) {
                $plat->accompagnements()->attach(intval($check));
            }
        }


        if ($request->file('file')) {
            try {
                $images = $request->file('file');

                foreach ($images as $index => $image) {
                    $path[] = $image->store('uploads/plats/' . $plat->id);
                }
            } catch (Exception $e) {
                Plat::destroy($plat->id);

                if (count($checkArray)) {
                    foreach ($checkArray as $check) {
                        Accompagnement::destroy(intval($check));
                    }
                }
                return $this->sendError('server Error', $e->getMessage());
            }

            try {
                if (isset($path)) {
                    foreach ($path as $p) {
                        $plat->images()->save(
                            new Image([
                                'uri' => $p
                            ])
                        );
                    }
                };
            } catch (Exception $e) {

                Plat::destroy($plat->id);
                foreach ($path as $p) {
                    Storage::delete($p);
                }
                if (count($checkArray)) {

                    foreach ($checkArray as $check) {
                        Accompagnement::destroy(intval($check));
                    }
                }
                return $this->sendError('server Error', $e->getMessage());
            }
        }



        $success['plat'] = new PlatResource($plat);

        return $this->sendResponse($success, 'User created successfully.');
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
            $success['plat'] = new PlatResource(PLat::find($id));
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
