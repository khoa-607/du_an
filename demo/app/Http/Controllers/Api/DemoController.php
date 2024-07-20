<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests\api\DemoRequest;
use App\Http\Controllers\Controller;


class DemoController extends Controller
{
    //
    public function demo(DemoRequest $request)
    {
        $validated = $request->validated();

        $email = $validated['email'];
        $password = $validated['password'];

        return response()->json([
            'message' => 'Form data received successfully',
            'data' => $validated,
        ]);
    }
}
