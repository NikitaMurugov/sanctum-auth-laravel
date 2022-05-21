<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $products = Product::all();
        return ProductResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return ProductResource
     */
    public function store(Request $request): ProductResource
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required',
            'price' => 'required',
        ]);
        $product = Product::create($request->all());
        return new ProductResource($product);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return ProductResource | Response
     */
    public function show($id): Response|ProductResource
    {
        try {
            $product = Product::findOrFail($id);
            return new ProductResource($product);
        } catch (\Exception $exception) {
            return response()->json(['message'=>'No have product with id:' . $id, 'code' => Response::HTTP_NOT_FOUND],Response::HTTP_NOT_FOUND);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @param Request $request
     * @return ProductResource | Response
     */
    public function update(Request $request, int $id): Response|ProductResource
    {
        try {
            $product = Product::findOrFail($id);
            $product->update($request->all());
            return new ProductResource($product);
        } catch (\Exception $exception) {
            return response()->json(['message'=>'No have product with id:' . $id, 'code' => Response::HTTP_NOT_FOUND],Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        try {
            $product = Product::findOrFail($id);
            $product->delete();
            return response()->json([
                'message' => 'Success deleted',
                'code' => Response::HTTP_OK,
            ],Response::HTTP_OK);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => 'No have product with id:' . $id,
                'code' => Response::HTTP_NOT_FOUND,
            ],Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Search for a name
     *
     * @param string $name
     * @return AnonymousResourceCollection
     */
    public function search(string $name): AnonymousResourceCollection
    {

        $products = Product::where('name', 'like', '%'.$name.'%')->get();
        return ProductResource::collection($products);

    }
}
