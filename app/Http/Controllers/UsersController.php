<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
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
        //$imagen = str_replace('data:image/png;base64,', '', $data['img']);
        //$imagen = str_replace(' ', '+', $imagen);
        //$imgName = date('YmdHis').'.png';
        //\File::put(public_path('img/'.$imgName), base64_decode($imagen));
        $data = array_merge($data, ['password' => Hash::make($data['pass'])]);
        try{
            $user = User::create($data);

            $ultimoRegistro = Ticket::latest()->first();

            if(isset($ultimoRegistro))
            {
                $shift = ( ($ultimoRegistro->id + 36) * 10) -1;
                $reference = 'dinerus'.str_pad($ultimoRegistro->id + 36, 5, '0', STR_PAD_LEFT);
            }else{
                $shift = 1;
                $reference = 'dinerus00001';
            }
            $user->shift = $shift;
            $user->reference = $reference;
            $user->save();
            $user->tickets()->create([
                'reference' => $reference,
                'shift' => $shift,
                'paid' => 0
            ]);
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

    public function regenerate()
    {
        $ultimoRegistro = Ticket::latest()->first();

        if(isset($ultimoRegistro))
        {
            $shift = ( ($ultimoRegistro->id + 36) * 10) -1;
            $reference = 'dinerus'.str_pad($ultimoRegistro->id + 36, 5, '0', STR_PAD_LEFT);
        }else{
            $shift = 1;
            $reference = 'dinerus00001';
        }

        $user = Auth::user();

        $user->tickets()->create([
            'reference' => $reference,
            'shift' => $shift,
            'paid' => 0
        ]);

        $user->update([
            'reference' => $reference,
            'shift' => $shift,
            'paid' => 0,
            'voucher' => null
        ]);

        return User::find($user->id);

    }
    public function show()
    {
        $users = User::all();
        return view('users', compact('users'));
    }
    public function downloadVoucher(Int $id)
    {
        $user = User::find($id);
        $voucher = public_path('img/comprobante/'.$user->voucher);
        return response()->file($voucher);
    }
    public function markAsPaid($id)
    {
        $user = User::find($id);
        $user->paid = 1;
        $user->save();
        $users = User::all();
        return view('users', compact('users'));
    }

    public function deleteAccountIndex()
    {
        return view('delete-account');
    }

    public function deleteAccountRemove(Request $request)
    {
        $user = User::query()->where('email', $request->email);

        if (!$user) {
            return "Si el email existe la cuenta sera eliminada de nuestra base de datos.";
        }
        $user->delete();
        return "Si el email existe la cuenta sera eliminada de nuestra base de datos.";
    }

    public function terminosCondiciones()
    {
        return view('termino-condiciones');
    }
}
