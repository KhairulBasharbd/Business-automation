<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DataController extends Controller
{
    
    public function getData()
    {
        return response()->json([
            'message' => 'This is protected data!',
            'data' => [
                'id' => 1,
                'name' => 'Sample Data',
                'description' => 'This data is accessible only with a valid JWT token.',
            ],
        ]);
    }



}
