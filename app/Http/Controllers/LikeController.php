<?php

namespace App\Http\Controllers;

use App\Http\Resources\LikeResource;
use Exception;
use App\Models\Like;
use App\Models\Client;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;

class LikeController extends BaseController
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
                $success['restaurants'] = LikeResource::collection($client->likes()->where('likeable_type', 'App\Models\Restaurant')->get());
                $success['plats'] = LikeResource::collection($client->likes()->where('likeable_type', 'App\Models\Plat')->get());
                return $this->sendResponse($success, 'Likes found successfully.');
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        if ($request->operation === 'verification') {
            if ($request->type === 'restaurant') {
                try {
                    $client = Client::find(auth()->user()->client->id);
                    $result = $client->likes()->where('likeable_id', $id)->where('likeable_type', 'App\Models\Restaurant')->get();
                    if (count($result)) {
                        $success['result'] = true;
                    } else {
                        $success['result'] = false;
                    }
                    return $this->sendResponse($success, 'status found successfully.');
                } catch (Exception $e) {
                    return $this->sendError('server Error', $e->getMessage());
                }
            } else {
                try {
                    $client = Client::find(auth()->user()->client->id);
                    $result = $client->likes()->where('likeable_id', $id)->where('likeable_type', 'App\Models\Plat')->get();
                    if (count($result)) {
                        $success['result'] = true;
                    } else {
                        $success['result'] = false;
                    }
                    return $this->sendResponse($success, 'status found successfully.');
                } catch (Exception $e) {
                    return $this->sendError('server Error', $e->getMessage());
                }
            }
        } else {
            if ($request->action === 'attach') {
                if ($request->type === 'restaurant') {
                    try {
                        $client = Client::find(auth()->user()->client->id)->likes()->save(
                            new Like([
                                'likeable_type' => 'App\Models\Restaurant',
                                'likeable_id' => $id
                            ])
                        );
                        $success['result'] = true;
                        return $this->sendResponse($success, 'status found successfully.');
                    } catch (Exception $e) {
                        return $this->sendError('server Error', $e->getMessage());
                    }
                } else {
                    try {
                        $client = Client::find(auth()->user()->client->id)->likes()->save(
                            new Like([
                                'likeable_type' => 'App\Models\Plat',
                                'likeable_id' => $id
                            ])
                        );
                        $success['result'] = true;
                        return $this->sendResponse($success, 'status found successfully.');
                    } catch (Exception $e) {
                        return $this->sendError('server Error', $e->getMessage());
                    }
                }
            } else {
                if ($request->type === 'restaurant') {
                    try {
                        $likes = $client = Client::find(auth()->user()->client->id)->likes()
                            ->where('likeable_type', 'App\Models\Restaurant')
                            ->where('likeable_id', $id)->get();
                        if (count($likes)) {
                            foreach ($likes as $l) {
                                Like::destroy($l->id);
                            }
                        }
                        $success['result'] = false;
                        return $this->sendResponse($success, 'status found successfully.');
                    } catch (Exception $e) {
                        return $this->sendError('server Error', $e->getMessage());
                    }
                } else {
                    try {
                        $likes = $client = Client::find(auth()->user()->client->id)->likes()
                            ->where('likeable_type', 'App\Models\Plat')
                            ->where('likeable_id', $id)->get();
                        if (count($likes)) {
                            foreach ($likes as $l) {
                                Like::destroy($l->id);
                            }
                        }
                        $success['result'] = false;
                        return $this->sendResponse($success, 'status found successfully.');
                    } catch (Exception $e) {
                        return $this->sendError('server Error', $e->getMessage());
                    }
                }
            }
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
