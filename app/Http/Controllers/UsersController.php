<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->all();
        $imagen = str_replace('data:image/png;base64,', '', $data['img']);
        $imagen = str_replace(' ', '+', $imagen);
        $imgName = date('YmdHis').'.png';
        \File::put(public_path('img/'.$imgName), base64_decode($imagen));
        $data = array_merge($data, ['ine' => $imgName, 'shift' => uniqid(), 'password' => Hash::make($data['pass'])]);
        try{
            User::create($data);
            $session = LoginController::serviceLogin($request);
            return json_encode(['type' => 'success', 'message' => 'Cuenta creada']);
        } catch(\Exception $e){
            return json_encode(['type' => 'error', 'message' => $e]);
        }
    }
    public function paid(Request $request)
    {
        $data = $request->all();
        $imagen = str_replace('data:image/png;base64,', '', $data['img']);
        $imagen = str_replace(' ', '+', $imagen);
        $imgName = date('YmdHis').'.png';
        \File::put(public_path('img/comprobante/'.$imgName), base64_decode($imagen));
        $data = array_merge($data, ['voucher' => $imgName]);
        try{
            $user = User::find(Auth::user()->id);
            $user->voucher = $imgName;
            $user->save();
            return json_encode(['type' => 'success', 'message' => 'Exito']);
        } catch(\Exception $e){
            return json_encode(['type' => 'error', 'message' => $e]);
        }
    }
}
