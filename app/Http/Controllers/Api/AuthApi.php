<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthApi extends Controller
{
    public function changePassword(Request $request)
    {
        $user_id = $request->user_id;
        $current_password = $request->password;
        $new_password = $request->newPassword;

        $user = User::where('id', $user_id)->first();

        if (Hash::check($current_password, $user->password)) {
            User::where('id', $user_id)->update([
                "password" => Hash::make($new_password),
            ]);
            return response()->json([
                "message" => true,
                "data" => null,
            ]);
        }

        return response()->json([
            "message" => false,
            "data" => "Wrong password!",
        ]);
    }
}
