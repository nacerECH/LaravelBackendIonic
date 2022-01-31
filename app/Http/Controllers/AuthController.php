<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Client;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ClientResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\RestaurantResource;
use App\Models\Image;

class AuthController extends BaseController
{
    //
    public function signin(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $authUser = Auth::user();
            $success['token'] =  $authUser->createToken('MyAuthApp')->plainTextToken;
            if ($authUser->role === 'clt') {
                $success['client'] = new ClientResource($authUser->client);
            } else {
                $success['restaurant'] = new ClientResource($authUser->restaurant);
            }
            $success['role'] = $authUser->role;

            return $this->sendResponse($success, 'User signed in');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }
    }

    public function signup(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'fName' => 'required|string',
            'lName' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string',
            'confirmPassword' => 'required|same:password',



        ]);

        if ($validator->fails()) {
            return $this->sendError('Error validation', $validator->errors());
        }

        $user = new User;
        $user->first_name = $request->fName;
        $user->last_name = $request->lName;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role = 'clt';
        $user->save();

        $client = new Client();
        $client->user_id = $user->id;
        $client->save();

        // $input = $request->all();
        // $input['password'] = bcrypt($input['password']);
        // $user = User::create($input);
        $success['token'] =  $user->createToken('MyAuthApp')->plainTextToken;
        $success['client'] = new ClientResource($client);
        $success['role'] = $user->role;

        return $this->sendResponse($success, 'User created successfully.');
    }
    public function signupRestaurant(Request $request)
    {



        $validator = Validator::make($request->all(), [
            'nomRestaurant' => 'required|string',
            'nomGerant' => 'required|string',
            'prenomGerant' => 'required|string',
            'description' => 'required|string',
            'adresse' => 'required|string',
            'ville' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string',
            'confirmPassword' => 'required|same:password',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Error validation', $validator->errors());
        }

        $user = new User;
        $user->first_name = $request->prenomGerant;
        $user->last_name = $request->nomGerant;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role = 'rst';
        $user->save();

        $restaurant = new Restaurant();
        $restaurant->user_id = $user->id;
        $restaurant->nom = $request->nomRestaurant;
        $restaurant->NomGerant = $request->nomGerant . " " . $request->prenomGerant;
        $restaurant->description = $request->description;
        $restaurant->adresse = $request->adresse;
        $restaurant->ville = $request->ville;
        $restaurant->latitude = number_format(floatval($request->latitude), 7, '.', '');
        $restaurant->longitude = number_format(floatval($request->longitude), 7, '.', '');



        $restaurant->save();

        if ($request->file('file')) {
            try {
                $images = $request->file('file');

                foreach ($images as $index => $image) {
                    $path[] = $image->store('uploads/restaurants/' . $restaurant->id);
                }
            } catch (Exception $e) {
                Restaurant::destroy($restaurant->id);
                return $this->sendError('server Error', $e->getMessage());
            }

            try {
                if (isset($path)) {
                    foreach ($path as $p) {
                        $restaurant->images()->save(
                            new Image([
                                'uri' => $p
                            ])
                        );
                    }
                };
            } catch (Exception $e) {

                Restaurant::destroy($restaurant->id);
                foreach ($path as $p) {
                    Storage::delete($p);
                }
                return $this->sendError('server Error', $e->getMessage());
            }
        }



        $success['token'] =  $user->createToken('MyAuthApp')->plainTextToken;
        $success['restaurant'] = new RestaurantResource($restaurant);
        $success['role'] = $user->role;

        return $this->sendResponse($success, 'User created successfully.');
    }
    public function logout(Request $request)
    {
        // if (Auth::guard('')->check()) {
        //     return redirect('/api/login');
        // }
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Logged out'
        ];
    }
}
