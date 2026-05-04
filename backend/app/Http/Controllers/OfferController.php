<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OfferController extends Controller
{
    // GET /api/offers
    public function index()
    {
        return response()->json([
            'status' => 'success',
            'data' => Offer::all()
        ], 200);
    }

    // POST /api/offers
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255|unique:offers,title',
            'description' => 'required|string',
            'created_by' => 'required|exists:users,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 400);
        }

        $offer = Offer::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => 'active',
            'created_by' => $request->created_by
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Offer created successfully',
            'data' => $offer
        ], 201);
    }

    // GET /api/offers/{offer}
    public function show(Offer $offer)
    {
        return response()->json([
            'status' => 'success',
            'data' => $offer
        ], 200);
    }

    // PUT /api/offers/{offer}
    public function update(Request $request, Offer $offer)
    {
        $offer->update($request->only(['title', 'description', 'status']));

        return response()->json([
            'status' => 'success',
            'message' => 'Offer updated',
            'data' => $offer
        ], 200);
    }

    // DELETE /api/offers/{offer}
    public function destroy(Offer $offer)
    {
        $offer->update(['status' => 'inactive']);
        $offer->delete(); // soft delete

        return response()->json([
            'status' => 'success',
            'message' => 'Offer deactivated'
        ], 200);
    }
}
