<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductApiController extends Controller
{
    /**
     *  @OA\Get(
     *      path="/api/product",
     *      operationId="all-product",
     *      summary="Get all product",
     *      description="get all product",
     *      tags={"Product"},
     *      security={
     *          {"api_key": {}},
     *      },
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\MediaType(
     *              mediaType="application/json"
     *          ),
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Anauthorized",
     *      ),
     *  )
     */
    public function index()
    {
        $products = Product::all();

        return response()->json([
            'success' => true,
            'message' => 'Get data success',
            'data' => ProductResource::collection($products),
        ]);
    }

    /**
     *  @OA\Get(
     *      path="/api/product/{id}",
     *      operationId="show-product",
     *      summary="Detail product",
     *      description="get detail product",
     *      tags={"Product"},
     *      security={
     *          {"api_key": {}},
     *      },
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\MediaType(
     *              mediaType="application/json"
     *          ),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not found",
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Anauthorized",
     *      ),
     *  )
     */
    public function show($id)
    {
        $product = Product::find($id);

        if (empty($product)) {
            return response()->json([
                'message' => 'Not found',
                'data' => null,
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Get data success',
            'data' => new ProductResource($product),
        ]);
    }

    /**
     *  @OA\Post(
     *      path="/api/product",
     *      operationId="create-product",
     *      summary="Create product",
     *      description="create product",
     *      tags={"Product"},
     *      security={
     *          {"api_key": {}},
     *      },
     *      @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="category_id",
     *                      description="Category id",
     *                      type="integer",
     *                  ),
     *                  @OA\Property(
     *                      property="name",
     *                      description="Name",
     *                      type="string",
     *                  ),
     *                  @OA\Property(
     *                      property="price",
     *                      description="Price",
     *                      type="integer",
     *                  ),
     *                  @OA\Property(
     *                      property="sku",
     *                      description="SKU",
     *                      type="string",
     *                  ),
     *                  @OA\Property(
     *                      property="status",
     *                      description="Status",
     *                      type="string",
     *                      enum={"active", "inactive"},
     *                  ),
     *                  @OA\Property(
     *                      property="image",
     *                      description="Image",
     *                      type="file",
     *                  ),
     *                  @OA\Property(
     *                      property="description",
     *                      description="Description",
     *                      type="string",
     *                  ),
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\MediaType(
     *              mediaType="application/json"
     *          ),
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable entity",
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Anauthorized",
     *      ),
     *  )
     */
    public function store(Request $request)
    {
        $inputs = $request->all();

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required',
            'price' => 'required|numeric',
            'sku' => 'required',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image|max:1024',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            if ($image->isValid()) {
                $imageName = time(). '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/product', $imageName);
                $inputs['image'] = $imageName;
            } else {
                unset($inputs['image']);
            }
        } else {
            unset($inputs['image']);
        }

        $result = Product::create($inputs);

        if ($result) {
            return response()->json([
                'success' => true,
                'message' => 'Add data success',
                'data' => new ProductResource($result),
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
     *  @OA\Post(
     *      path="/api/product/{id}/update",
     *      operationId="update-product",
     *      summary="Update product",
     *      description="update product",
     *      tags={"Product"},
     *      security={
     *          {"api_key": {}},
     *      },
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *      ),
     *      @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="category_id",
     *                      description="Category id",
     *                      type="integer",
     *                  ),
     *                  @OA\Property(
     *                      property="name",
     *                      description="Name",
     *                      type="string",
     *                  ),
     *                  @OA\Property(
     *                      property="price",
     *                      description="Price",
     *                      type="integer",
     *                  ),
     *                  @OA\Property(
     *                      property="sku",
     *                      description="SKU",
     *                      type="string",
     *                  ),
     *                  @OA\Property(
     *                      property="status",
     *                      description="Status",
     *                      type="string",
     *                      enum={"active", "inactive"},
     *                  ),
     *                  @OA\Property(
     *                      property="image",
     *                      description="Image",
     *                      type="file",
     *                  ),
     *                  @OA\Property(
     *                      property="description",
     *                      description="Description",
     *                      type="string",
     *                  ),
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\MediaType(
     *              mediaType="application/json"
     *          ),
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable entity",
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Anauthorized",
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not found",
     *      ),
     *  )
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        if (empty($product)) {
            return response()->json([
                'message' => 'Not found',
                'data' => null,
            ], 404);
        }

        $inputs = $request->all();

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required',
            'price' => 'required|numeric',
            'sku' => 'required',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image|max:1024',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            if ($image->isValid()) {

                // Hapus image
                if (!empty($product->image) && Storage::exists('public/product/' . $product->image)) {
                    Storage::delete('public/product/' . $product->image);
                }

                $imageName = time(). '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/product', $imageName);
                $inputs['image'] = $imageName;
            } else {
                unset($inputs['image']);
            }
        } else {
            unset($inputs['image']);
        }

        $result = $product->update($inputs);

        if ($result) {
            return response()->json([
                'success' => true,
                'message' => 'Update data success',
                'data' => new ProductResource($product),
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
     *  @OA\Delete(
     *      path="/api/product/{id}",
     *      operationId="delete-product",
     *      summary="Delete product",
     *      description="Delete product",
     *      tags={"Product"},
     *      security={
     *          {"api_key": {}},
     *      },
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\MediaType(
     *              mediaType="application/json"
     *          ),
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable entity",
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Anauthorized",
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not found",
     *      ),
     *  )
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        
        if (empty($product)) {
            return response()->json([
                'message' => 'Not found',
                'data' => null,
            ], 404);
        }

        // Hapus image
        if (!empty($product->image) && Storage::exists('public/product/' . $product->image)) {
            Storage::delete('public/product/' . $product->image);
        }

        $result = $product->delete();
        if ($result) {
            return response()->json([
                'success' => true,
                'message' => 'Delete data success',
                'data' => null,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Delete data failed',
                'data' => $product,
            ]);
        }
    }
}
