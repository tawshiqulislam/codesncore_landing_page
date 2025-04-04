<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Uploader;
use App\Models\User\Brand;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class BrandSectionController extends Controller
{
    public function brandSection(Request $request)
    {

        // also, get the brand info of that language from db
        $information['brands'] = Brand::where('user_id', Auth::guard('web')->user()->id)
            ->where('distributor', 0)
            ->orderBy('id', 'desc')
            ->get();
        $information['distributor'] = Brand::where('user_id', Auth::guard('web')->user()->id)
            ->where('distributor', 1)
            ->orderBy('id', 'desc')
            ->get();

        return view('user.home.brand_section.index', $information);
    }

    public function storeBrand(Request $request)
    {
        $request->validate(
            [
                'brand_img' => 'required|mimes:jpeg,jpg,png|max:1000',
                'brand_url' => 'required',
                'serial_number' => 'required|numeric',
                'distributor' => 'required|in:yes,no'
            ],
            [
                'brand_img.required' => 'The brand image field is required.',
                'brand_url.required' => 'The brand url field is required.',
                'serial_number.required' => 'The serial number field is required.',
                'distributor.required' => 'The distributor field is required.'
            ]
        );

        // Convert distributor before creating
        $distributorValue = $request->distributor === 'yes' ? 1 : 0;

        if ($request->hasFile('brand_img')) {
            $imageName = Uploader::upload_picture('assets/front/img/user/brands', $request->file('brand_img'));
        }

        // Create with explicit values
        $brand = Brand::create([
            'user_id' => Auth::guard('web')->user()->id,
            'brand_img' => $imageName,
            'brand_url' => $request->brand_url,
            'serial_number' => $request->serial_number,
            'distributor' => $distributorValue
        ]);

        $request->session()->flash('success', 'New brand added successfully!');
        return 'success';
    }

    public function updateBrand(Request $request)
    {
        $brand = Brand::where('user_id', Auth::guard('web')->user()->id)
                    ->where('id', $request->brand_id)
                    ->firstOrFail();

        $rules = [
            'brand_url' => 'required',
            'serial_number' => 'required|numeric',
            'distributor' => 'required|in:yes,no'
        ];
        
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        // Convert distributor before updating
        $distributorValue = $request->distributor === 'yes' ? 1 : 0;

        $updateData = [
            'brand_url' => $request->brand_url,
            'serial_number' => $request->serial_number,
            'distributor' => $distributorValue
        ];

        if ($request->hasFile('brand_img')) {
            $updateData['brand_img'] = Uploader::update_picture(
                'assets/front/img/user/brands', 
                $request->file('brand_img'), 
                $brand->brand_img
            );
        }

        $brand->update($updateData);

        $request->session()->flash('success', 'Brand info updated successfully!');
        return 'success';
    }

    public function deleteBrand(Request $request)
    {
        $brand = Brand::where('user_id', Auth::guard('web')->user()->id)->where('id', $request->brand_id)->firstOrFail();
        @unlink(public_path('assets/img/brands/' . $brand->brand_img));
        $brand->delete();
        $request->session()->flash('success', 'Brand deleted successfully!');
        return redirect()->back();
    }
}
