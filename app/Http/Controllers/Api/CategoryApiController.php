<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryApiController extends Controller
{
    /**
     * @OA\Get(
     *   path="/api/category",
     *   operationId="get-category",
     *   summary="Get All Category",
     *   tags={"Category"},
     *   security={
     *    {"api_key": {}},
     *   },
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\MediaType(
     *       mediaType="application/json",
     *     ),
     *   ),
     *   @OA\Response(
     *     response=401,
     *     description="Unauthorized",
     *   ),
     * )
     */
    public function index()
    {
        $categories = Category::all();
        return response()->json([
            'success' => true,
            'message' => 'Get data success',
            'data' => $categories,
        ]);
    }

    /**
     * @OA\Get(
     *   path="/api/category/{category}",
     *   operationId="show-category",
     *   summary="Get Detail Category",
     *   tags={"Category"},
     *   security={
     *    {"api_key": {}},
     *   },
     *   @OA\Parameter(
     *     name="category",
     *     in="path",
     *     required=true,
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\MediaType(
     *       mediaType="application/json",
     *     ),
     *   ),
     *   @OA\Response(
     *     response=401,
     *     description="Unauthorized",
     *   ),
     * )
     */
    public function show(Category $category)
    {
        return response()->json([
            'success' => true,
            'message' => 'Get data success',
            'data' => $category,
        ]);
    }

    /**
     * @OA\Post(
     *   path="/api/category",
     *   operationId="add-category",
     *   summary="Add category",
     *   tags={"Category"},
     *   security={
     *     {"api_key": {}},
     *   },
     *   @OA\RequestBody(
     *     @OA\MediaType(
     *       mediaType="application/x-www-form-urlencoded",
     *       @OA\Schema(
     *         @OA\Property(
     *           property="name",
     *           description="Name",
     *           type="string",
     *         ),
     *         @OA\Property(
     *           property="status",
     *           description="Status",
     *           type="string",
     *           enum={"active", "inactive"}
     *         )
     *       )
     *     ),
     *     @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(
     *         @OA\Property(
     *           property="name",
     *           description="Name",
     *           type="string",
     *         ),
     *         @OA\Property(
     *           property="status",
     *           description="Status",
     *           type="string",
     *           enum={"active", "inactive"}
     *         )
     *       )
     *     )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\MediaType(
     *       mediaType="application/json",
     *     ),
     *   ),
     *   @OA\Response(
     *     response=401,
     *     description="Unauthorized",
     *   ),
     *   @OA\Response(
     *     response=422,
     *     description="Unprocessable Entity",
     *   ),
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'status' => 'required|in:active,inactive',
        ]);

        // Mass assigment
        $result = Category::create($request->all());

        if ($result) {
            return response()->json([
                'success' => true,
                'message' => 'Add data success',
                'data' => $result,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Add data failed',
                'data' => null,
            ]);
        }
    }

    /**
     * @OA\Put(
     *   path="/api/category/{category}",
     *   operationId="update-category",
     *   summary="Update category",
     *   tags={"Category"},
     *   security={
     *     {"api_key": {}},
     *   },
     *   @OA\Parameter(
     *     name="category",
     *     in="path",
     *     required=true,
     *   ),
     *   @OA\RequestBody(
     *     @OA\MediaType(
     *       mediaType="application/x-www-form-urlencoded",
     *       @OA\Schema(
     *         @OA\Property(
     *           property="name",
     *           description="Name",
     *           type="string",
     *         ),
     *         @OA\Property(
     *           property="status",
     *           description="Status",
     *           type="string",
     *           enum={"active", "inactive"}
     *         )
     *       )
     *     )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\MediaType(
     *       mediaType="application/json",
     *     ),
     *   ),
     *   @OA\Response(
     *     response=401,
     *     description="Unauthorized",
     *   ),
     *   @OA\Response(
     *     response=422,
     *     description="Unprocessable Entity",
     *   ),
     * )
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required',
            'status' => 'required|in:active,inactive',
        ]);

        $result = $category->update($request->all());

        if ($result) {
            return response()->json([
                'success' => true,
                'message' => 'Update data success',
                'data' => $category,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Update data failed',
                'data' => null,
            ]);
        }
    }

    /**
     * @OA\Delete(
     *   path="/api/category/{category}",
     *   operationId="delete-category",
     *   summary="Delete category",
     *   tags={"Category"},
     *   security={
     *     {"api_key": {}},
     *   },
     *   @OA\Parameter(
     *     name="category",
     *     in="path",
     *     required=true,
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\MediaType(
     *       mediaType="application/json",
     *     ),
     *   ),
     *   @OA\Response(
     *     response=401,
     *     description="Unauthorized",
     *   ),
     *   @OA\Response(
     *     response=404,
     *     description="Not Found",
     *   ),
     * )
     */
    public function destroy($category)
    {
        $category = Category::find($category);

        if (empty($category)) {
            return response()->json([
                'message' => 'Data not found',
                'data' => null,
            ], 404);
        }

        $result = $category->delete();

        if ($result) {
            return response()->json([
                'success' => true,
                'message' => 'Delete data success',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Delete data failed',
            ]);
        }
    }
}
