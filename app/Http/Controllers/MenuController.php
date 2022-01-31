<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Menu;
use App\Models\Image;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use App\Http\Resources\MenuResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class MenuController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (auth()->user()->role === 'clt') {
            try {
                $restaurant = Restaurant::find($request->id);
                $success['nom'] = $restaurant->nom;
                $success['menus'] = MenuResource::collection($restaurant->menus()->get());
                return $this->sendResponse($success, 'Menus found successfully.');
            } catch (Exception $e) {
                return $this->sendError('server Error', $e->getMessage());
            }
        } else {
            try {
                $restaurant = Restaurant::find(auth()->user()->restaurant->id);
                $success['nom'] = $restaurant->nom;
                $success['menus'] = MenuResource::collection($restaurant->menus()->get());
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

        $validator = Validator::make($request->all(), [
            'nom' => 'required|string',
            'description' => 'string',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Error validation', $validator->errors());
        }

        $menu = new Menu();
        $menu->title = $request->nom;
        $menu->description = $request->description;
        $menu->restaurant_id = auth()->user()->restaurant->id;
        $menu->save();

        if ($request->file('file')) {
            try {

                $image = $request->file('file');
                $path = $image->store('uploads/menus/' . $menu->id);
            } catch (Exception $e) {
                Menu::destroy($menu->id);
                Storage::delete($path);
                return $this->sendError('server Error', $e->getMessage());
            }

            try {
                if (isset($path)) {
                    $menu->images()->save(
                        new Image([
                            'uri' => $path
                        ])
                    );
                };
            } catch (Exception $e) {

                Storage::delete($path);
                foreach ($menu->images()->get() as $i) {
                    Image::destroy($i->id);
                }
                Menu::destroy($menu->id);

                return $this->sendError('server Error', $e->getMessage());
            }
        }

        $success['menu'] = $menu;

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
        try {
            $restaurant = Restaurant::find($id);
            $success['nom'] = $restaurant->nom;
            $success['menus'] = MenuResource::collection($restaurant->menu()->get());
            return $this->sendResponse($success, 'Menus found successfully.');
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
