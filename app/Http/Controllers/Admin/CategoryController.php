<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        try {
            $search = $request->input('search'); 
            if ($search) {
                $categories = Category::where('name', 'like', '%' . $search . '%')->get();
            } else {
                $categories = Category::all();
            }

            if (request()->expectsJson()) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Categories retrieved successfully.',
                    'data' => $categories
                ], 200);
            }

            return view('categories.index', compact('categories'));
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Failed to retrieve categories.',
                'data' => null
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $category = Category::findOrFail($id);

            if (request()->expectsJson()) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Category retrieved successfully.',
                    'data' => $category
                ], 200);
            }

            return view('categories.show', compact('category'));
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 404,
                'message' => 'Category not found.',
                'data' => null
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Failed to retrieve category.',
                'data' => null
            ], 500);
        }
    }

    public function create()
    {
        try {
            if (request()->expectsJson()) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Category creation form retrieved.',
                    'data' => null
                ], 200);
            }

            return view('categories.create');
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Failed to retrieve category creation form.',
                'data' => null
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate(['name' => 'required']);

            $category = Category::create($request->all());

            if (request()->expectsJson()) {
                return response()->json([
                    'status' => 201,
                    'message' => 'Category created successfully.',
                    'data' => $category
                ], 201);
            }

            return redirect()->route('categories.index')->with('success', 'Category created successfully.');
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Failed to create category.',
                'data' => null
            ], 500);
        }
    }

    public function edit($id)
    {
        try {
            $category = Category::findOrFail($id);

            if (request()->expectsJson()) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Category edit form retrieved.',
                    'data' => $category
                ], 200);
            }

            return view('categories.edit', compact('category'));
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 404,
                'message' => 'Category not found.',
                'data' => null
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Failed to retrieve category edit form.',
                'data' => null
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate(['name' => 'required']);

            $category = Category::findOrFail($id);
            $category->update($request->all());

            if (request()->expectsJson()) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Category updated successfully.',
                    'data' => $category
                ], 200);
            }

            return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 404,
                'message' => 'Category not found.',
                'data' => null
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Failed to update category.',
                'data' => null
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->delete();

            if (request()->expectsJson()) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Category deleted successfully.',
                    'data' => null
                ], 200);
            }

            return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 404,
                'message' => 'Category not found.',
                'data' => null
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Failed to delete category.',
                'data' => null
            ], 500);
        }
    }
}
