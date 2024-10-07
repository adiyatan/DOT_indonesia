<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        try {
            $search = $request->input('search');
            $products = Product::with('category')
                ->when($search, function ($query, $search) {
                    return $query->where('name', 'like', '%' . $search . '%');
                })
                ->with('category')
                ->get();

            if (request()->expectsJson()) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Products retrieved successfully.',
                    'data' => $products
                ], 200);
            }

            return view('products.index', compact('products'));
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Failed to retrieve products.',
                'data' => null
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $product = Product::with('category')->findOrFail($id);

            if (request()->expectsJson()) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Product retrieved successfully.',
                    'data' => $product
                ], 200);
            }

            return view('products.show', compact('product'));
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 404,
                'message' => 'Product not found.',
                'data' => null
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Failed to retrieve product.',
                'data' => null
            ], 500);
        }
    }

    public function create()
    {
        try {
            $categories = Category::all();

            if (request()->expectsJson()) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Product creation form retrieved.',
                    'data' => $categories
                ], 200);
            }

            return view('products.create', compact('categories'));
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Failed to retrieve product creation form.',
                'data' => null
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'price' => 'required|numeric',
                'category_id' => 'required|exists:categories,id'
            ]);

            $product = Product::create($request->all());

            if (request()->expectsJson()) {
                return response()->json([
                    'status' => 201,
                    'message' => 'Product created successfully.',
                    'data' => $product
                ], 201);
            }

            return redirect()->route('products.index')->with('success', 'Product created successfully.');
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Failed to create product.',
                'data' => null
            ], 500);
        }
    }

    public function edit(Product $product)
    {
        try {
            $categories = Category::all();

            if (request()->expectsJson()) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Product edit form retrieved.',
                    'data' => ['product' => $product, 'categories' => $categories]
                ], 200);
            }

            return view('products.edit', compact('product', 'categories'));
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 404,
                'message' => 'Product not found.',
                'data' => null
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Failed to retrieve product edit form.',
                'data' => null
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required',
                'price' => 'required|numeric',
                'category_id' => 'required|exists:categories,id'
            ]);

            $product = Product::findOrFail($id);
            $product->update($request->only(['name', 'price', 'category_id']));

            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Product updated successfully.',
                    'data' => $product
                ], 200);
            }

            return redirect()->route('products.index')->with('success', 'Product updated successfully.');
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 404,
                'message' => 'Product not found.',
                'data' => null
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Failed to update product.',
                'data' => null
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->delete();

            if (request()->expectsJson()) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Product deleted successfully.',
                    'data' => null
                ], 200);
            }

            return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 404,
                'message' => 'Product not found.',
                'data' => null
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Failed to delete product.',
                'data' => null
            ], 500);
        }
    }
}
