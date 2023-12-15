<?php

namespace App\Http\Controllers;

use App\Models\AbVariant;
use App\Models\Session;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class EventController extends Controller
{
    public function trackMouse(Request $request): JsonResponse {
        if ($request->isMethod('post') && $request->ajax()) {

            // Get data from the request
            $session_id = $request->session()->get('db_session_id');
            $action = $request->input('action');
            $variant_name = $request->input('variant_name');
            $test_name = $request->input('test_name');

            // Save the mouse event to the events table
            $sessionModel = Session::find($session_id);
            $sessionModel->events()->create([
                    'category' => $test_name,
                    'action' => $action,
                    'label' => $variant_name,
                    'url' => url($request->path()),
                ]);

            // Respond with a message
            return response()->json([
                'message' => "Click event on <strong>" . $variant_name . " - " . $test_name . "</strong> recorded successfully"]);
        }

        // Handle invalid requests
        return response()->json(['error' => 'Invalid request'], 400);
    }
}
