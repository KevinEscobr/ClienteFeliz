<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\StatusHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ApplicationController extends Controller
{
    // GET /api/applications
    public function index()
    {
        return response()->json([
            'status' => 'success',
            'data' => Application::with(['user', 'offer'])->get()
        ], 200);
    }

    // POST /api/applications
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'offer_id' => 'required|exists:offers,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 400);
        }

        DB::beginTransaction();

        try {
            $application = Application::create([
                'user_id' => $request->user_id,
                'offer_id' => $request->offer_id,
                'status' => 'applied'
            ]);

            StatusHistory::create([
                'application_id' => $application->id,
                'status' => 'applied',
                'comment' => 'Initial application',
                'changed_by' => $request->user_id
            ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Application created',
                'data' => $application
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => 'Error creating application'
            ], 500);
        }
    }

    // GET /api/applications/{application}
    public function show(Application $application)
    {
        return response()->json([
            'status' => 'success',
            'data' => $application->load('statusHistories')
        ], 200);
    }

    // PUT /api/applications/{id}/status
    public function changeStatus(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|string',
            'comment' => 'nullable|string',
            'user_id' => 'required|exists:users,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 400);
        }

        $application = Application::find($id);

        if (!$application) {
            return response()->json([
                'status' => 'error',
                'message' => 'Application not found'
            ], 404);
        }

        DB::beginTransaction();

        try {
            $application->update([
                'status' => $request->status
            ]);

            StatusHistory::create([
                'application_id' => $application->id,
                'status' => $request->status,
                'comment' => $request->comment,
                'changed_by' => $request->user_id
            ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Status updated'
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => 'Error updating status'
            ], 500);
        }
    }

    // POST /api/applications/{id}/comment
    public function addComment(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'comment' => 'required|string',
            'user_id' => 'required|exists:users,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 400);
        }

        $application = Application::find($id);

        if (!$application) {
            return response()->json([
                'status' => 'error',
                'message' => 'Application not found'
            ], 404);
        }

        StatusHistory::create([
            'application_id' => $application->id,
            'status' => $application->status,
            'comment' => $request->comment,
            'changed_by' => $request->user_id
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Comment added'
        ], 201);
    }
}
