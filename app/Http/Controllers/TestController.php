<?php

namespace App\Http\Controllers;

use App\Models\DcbIntegration;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function __invoke()
    {
        $records = DcbIntegration::get(['api_key', 'channel_id']);

        return response()->json([
            'message' => 'Records retrieved successfully!',
            'data' => $records,
        ]);
    }
}
