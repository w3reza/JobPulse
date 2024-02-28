<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')
            ->orderBy('id', 'desc')
            ->get();
        return view('backend.pages.product.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::orderBy('id', 'desc')->get();
        return view('backend.pages.product.create', compact('categories'));
    }

    public function store(Request $request)
    {
        try {
            // Validation
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:100|unique:products',
                'category_id' => 'required',
                'price' => 'required',
                'discount' => 'required',
                'content_details' => 'string|max:255',
                'photo_path' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            if ($validator->fails()) {
                // Validation failed
                throw new Exception('Validation failed');
            }

            // Image Processing
            if ($request->hasFile('photo_path') && $request->file('photo_path')->isValid()) {
                $img = $request->file('photo_path');
                $t = time();
                $file_name = $img->getClientOriginalName();
                $img_name = "product_{$t}_{$file_name}";
                $img_url = "uploads/product/{$img_name}";

                // Upload File
                $img->move(public_path('uploads/product/'), $img_name);
            } else {
                // No valid file uploaded
                throw new Exception('No valid file uploaded');
            }

            // Create Product
            Product::create([
                'title' => $request->input('title'),
                'category_id' => $request->input('category_id'),
                'price' => $request->input('price'),
                'discount' => $request->input('discount'),
                'description' => $request->input('content_details'),
                'image' => $img_url,
            ]);

            return redirect()
                ->route('product.index')
                ->with('success', 'Product created successfully.');
        } catch (Exception $e) {
            // Handle exceptions
            //dd($e->getMessage());
            return redirect()
                ->route('product.create')
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Product creation failed. ' . $e->getMessage());
        }
    }
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::orderBy('id', 'desc')->get();
        return view('backend.pages.product.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        try {
            $product = Product::findOrFail($id);

            // dd($request->all());
            // Validation
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:100|unique:products',
                'category_id' => 'required',
                'price' => 'required',
                'discount' => 'required',
                'content_details' => 'string|max:255',
                'photo_path' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            if ($product->title == $request->input('title')) {
                $validator = Validator::make($request->all(), [
                    'category_id' => 'required',
                    'price' => 'required',
                    'discount' => 'required',
                    'content_details' => 'string|max:255',
                    'photo_path' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ]);
            } else {
                $validator = Validator::make($request->all(), [
                    'title' => 'required|string|max:100|unique:products',
                    'category_id' => 'required',
                    'price' => 'required',
                    'discount' => 'required',
                    'content_details' => 'string|max:255',
                    'photo_path' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ]);
            }

            if ($validator->fails()) {
                // Validation failed
                //throw new Exception();
                throw new Exception($validator->errors()->first());
            }

            // Image Processing
            if ($request->hasFile('photo_path') && $request->file('photo_path')->isValid()) {
                $img = $request->file('photo_path');
                $t = time();
                $file_name = $img->getClientOriginalName();
                $img_name = "product_{$t}_{$file_name}";
                $img_url = "uploads/product/{$img_name}";

                // Delete Old Image
                if ($product->image) {
                    $imagePath = public_path($product->image);
                    if (file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                }

                // Upload File
                $img->move(public_path('uploads/product/'), $img_name);
                $product->update([
                    'title' => $request->input('title'),
                    'category_id' => $request->input('category_id'),
                    'price' => $request->input('price'),
                    'discount' => $request->input('discount'),
                    'description' => $request->input('content_details'),
                    'image' => $img_url,
                ]);
            } else {
                //dd($request->all());
                $oldImage = $request->input('old_photo_path');
                $product->update([
                    'title' => $request->input('title'),
                    'category_id' => $request->input('category_id'),
                    'price' => $request->input('price'),
                    'discount' => $request->input('discount'),
                    'description' => $request->input('content_details'),
                    'image' => $oldImage,
                ]);
            }

            return redirect()
                ->route('product.index')
                ->with('success', 'Product updated successfully.');
        } catch (Exception $e) {
            return redirect()
                ->route('product.edit', $id)
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Product updated failed.' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->delete();
            return redirect()
                ->route('product.index')
                ->with('success', 'product deleted successfully.');
        } catch (Exception $e) {
            return redirect()
                ->route('product.index')
                ->with('error', 'product deleted failed.');
        }
    }
}
