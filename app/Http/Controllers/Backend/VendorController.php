<?php

namespace App\Http\Controllers\Backend;

use Exception;
use App\Models\Vendor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class VendorController extends Controller
{
    public function index()
    {
        $vendors = Vendor::orderBy('id', 'desc')->get();
        return view('backend.pages.vendor.index', compact('vendors'));
    }

    public function create()
    {
        return view('backend.pages.vendor.create');
    }

    public function store(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:50',
                'phone' => 'required|numeric|unique:vendors',
                'content_details' => 'string|max:255',

            ]);


            if ($validator->fails()) {
                throw new Exception('Validation failed');
            }
            //dd($request->all());

            Vendor::create([
                'name' => $request->input('name'),
                'phone' => $request->input('phone'),
                'address' => $request->input('content_details'),
            ]);
            return redirect()->route('vendor.index')->with('success', 'Vendor created successfully.');

        } catch (Exception $e) {
            return redirect()
            ->route('vendor.create')
            ->withErrors($validator)
            ->withInput()
            ->with('error', 'vendor creation failed. ' . $e->getMessage());

        }
    }

    public function edit($id)
    {
        $vendor = Vendor::findOrFail($id);
        return view('backend.pages.vendor.edit', compact('vendor'));
    }

    public function update(Request $request, $id)
    {
        try {


            $vendor = Vendor::findOrFail($id);
            //dd($request->all());

            if ($vendor->phone == $request->input('phone')) {
                $validator = Validator::make($request->all(), [
                    'name' => 'required|string|max:50',
                    'phone' => 'required|numeric',
                    'content_details' => 'string|max:255',

                ]);
            } else {
                $validator = Validator::make($request->all(), [
                    'name' => 'required|string|max:50',
                    'phone' => 'required|numeric|unique:vendors',
                    'content_details' => 'string|max:255',

                ]);
            }

            if ($validator->fails()) {
                throw new Exception('Validation failed');
            }

            $vendor->update([
                'name' => $request->input('name'),
                'phone' => $request->input('phone'),
                'address' => $request->input('content_details'),
            ]);
            return redirect()->route('vendor.index')->with('success', 'vendor updated successfully.');

        } catch (Exception $e) {

            return redirect()
            ->route('vendor.edit', $id)
            ->withErrors($validator)
            ->withInput()
            ->with('error', 'vendor updated failed. ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $vendor = Vendor::findOrFail($id);
            $vendor->delete();
            return redirect()->route('vendor.index')->with('success', 'vendor deleted successfully.');

        } catch (Exception $e) {
            return redirect()->route('vendor.index')->with('error', 'vendor deleted failed.');
        }
    }
}
