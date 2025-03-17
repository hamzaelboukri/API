<?php

namespace App\Http\Controllers;

use App\Models\JobOffer;
use App\Models\Category;
use App\Models\job_offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class JobOfferController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['index', 'show', 'getByCategory']);
    }

    public function index()
    {
        $jobOffers = job_offer::with(['user:id,name,email', 'category:id,name'])->get();
        return response()->json([
            'success' => true,
            'data' => $jobOffers
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'company' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'salary' => 'nullable|numeric',
            'is_active' => 'boolean',
            'expires_at' => 'nullable|date',
            'requirements' => 'nullable|string',
            'contact_email' => 'required|email',
            'category_id' => 'required|exists:categories,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $category = Category::find($request->category_id);
        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Category not found'
            ], 404);
        }

        $jobOffer = new job_offer($validator->validated());
        $jobOffer->user_id = Auth::id();
        $jobOffer->save();

        return response()->json([
            'success' => true,
            'message' => 'Job offer created successfully',
            'data' => $jobOffer->load(['user:id,name,email', 'category:id,name'])
        ], 201);
    }

    public function show($id)
    {
        $jobOffer = job_offer::with(['user:id,name,email', 'category:id,name'])->find($id);
        if (!$jobOffer) {
            return response()->json([
                'success' => false,
                'message' => 'Job offer not found'
            ], 404);
        }
        return response()->json([
            'success' => true,
            'data' => $jobOffer
        ]);
    }

    public function update(Request $request, $id)
    {
        $jobOffer = job_offer::find($id);
        if (!$jobOffer) {
            return response()->json([
                'success' => false,
                'message' => 'Job offer not found'
            ], 404);
        }

        if ($jobOffer->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to update this job offer'
            ], 403);
        }

        Log::info('Request data:', $request->all());

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'company' => 'sometimes|required|string|max:255',
            'location' => 'sometimes|required|string|max:255',
            'salary' => 'nullable|numeric',
            'is_active' => 'boolean',
            'expires_at' => 'nullable|date',
            'requirements' => 'nullable|string',
            'contact_email' => 'sometimes|required|email',
            'category_id' => 'sometimes|required|exists:categories,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        if ($request->has('category_id')) {
            $category = Category::find($request->category_id);
            if (!$category) {
                return response()->json([
                    'success' => false,
                    'message' => 'Category not found'
                ], 404);
            }
        }

        Log::info('Before update:', $jobOffer->toArray());

        $jobOffer->fill($request->all());
        $jobOffer->save();
        $jobOffer->refresh();

        Log::info('After update:', $jobOffer->toArray());

        return response()->json([
            'success' => true,
            'message' => 'Job offer updated successfully',
            'data' => $jobOffer->load(['user:id,name,email', 'category:id,name'])
        ]);
    }

    public function destroy($id)
    {
        $jobOffer = job_offer::find($id);
        if (!$jobOffer) {
            return response()->json([
                'success' => false,
                'message' => 'Job offer not found'
                ], 404);
            }

        if ($jobOffer->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to delete this job offer'
            ], 403);
        }

        $jobOffer->delete();
        return response()->json([
            'success' => true,
            'message' => 'Job offer deleted successfully'
        ]);                   
    }

    public function myJobOffers()
    {
        $jobOffers = job_offer::where('user_id', Auth::id())
            ->with('category:id,name')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $jobOffers
        ]);
    }

    public function getByCategory($categoryId)
    {
        $category = Category::find($categoryId);
        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Category not found'
            ], 404);
        }

        $jobOffers = job_offer::where('category_id', $categoryId)
            ->with(['user:id,name,email', 'category:id,name'])
            ->get();

        return response()->json([
            'success' => true,
            'category' => [
                'id' => $category->id,
                'name' => $category->name,
                'description' => $category->description
            ],
            'data' => $jobOffers
        ]);
    }
}