<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;

class ApiUserController extends Controller
{
    public function register(Request $request)
    {
        $rules = array(
            "name" => "required",
            "email" => "required|unique:users|email",
            "password" => "required|min:6"
        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            // menggunakan format json
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Error Validation',
                    'data' => $validator->errors()
                ],
                500
            );
        } else {
            try {
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);
                // menggunakan format json
                return response()->json(
                    [
                        'success' => true,
                        'message' => 'Register Berhasil',
                        'data' => $user
                    ],
                    200
                );
            } catch (Exception $error) {
                $user = null;
                // menggunakan format json
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Register Gagal'. $error->getMessage(),
                        'data' => $user
                    ],
                    500
                );
            } 
        }
    }

    public function login(Request $request){
        $data = [
            "email" => $request->email,
            "password" => $request->password,
        ];

        Auth::attempt($data);
        if(Auth::check()) {
            $userId = Auth::user()->id;
            $user = User::where('id', $userId )->first();

            // menggunakan format json
            return response()->json(
                [
                    'success' => true,
                    'message' => 'Login Berhasil',
                    'data' => $user
                ],
                200
            );
        } else {
            $user = null;
            // menggunakan format json
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Username / Password Salah',
                    'data' => null
                ],
                500
            );
        }
    }

    public function logout(){
        

        try {
            $logout = Auth::logout();

            // if($logout) {
                // menggunakan format json
                return response()->json(
                    [
                        'success' => true,
                        'message' => 'Logout Berhasil',
                        'data' => null
                    ],
                    200
                );
            // } else {
                // menggunakan format json
            //     return response()->json(
            //         [
            //             'success' => true,
            //             'message' => 'Logout Gagal',
            //             'data' => null
            //         ],
            //         500
            //     );
            // }
        } catch (Exception $error) {
                 return response()->json(
                    [
                        'success' => false,
                        'message' => 'Logout Gagal',
                        'data' => $error->getMessage()
                    ],
                    500
                );
            }
        }

        
    }
