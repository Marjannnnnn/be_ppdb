<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        // mengambil data user yang sedang login
        $user = $request->user();

        // mengembalikan data user dalam bentuk JSON
        return response()->json([
            'user' => $user
        ]);
    }
}
