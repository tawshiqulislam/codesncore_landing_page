<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User\BasicSetting;
use App\Models\User\Language;
use App\Models\User\UserProductsQuote;
use App\Models\ProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Purifier;
use Validator;

class QuoteProductController extends Controller
{
    public function index(Request $request)
    {
        $data = null;
        if ($request->has('language')) {
            $lang = Language::where([
                ['code', $request->language],
                ['user_id', Auth::id()]
            ])->first();
            Session::put('currentLangCode', $request->language);
        } else {
            $lang = Language::where([
                ['is_default', 1],
                ['user_id', Auth::id()]
            ])
                ->first();
            Session::put('currentLangCode', $lang->code);
        }
        $data['products'] = UserProductsQuote::where([
            ['lang_id', '=', $lang->id],
            ['user_id', '=', Auth::id()],
        ])
            ->orderBy('id', 'DESC')
            ->get();
        $data['orders'] = ProductRequest::paginate(12);
        return view('user.quote_product.index', $data);
    }

    public function approve(Request $request)
    {
        // dd($request->all());
        $product = ProductRequest::findOrFail($request->id);
        $product->update(['approved' => $request->approved]);
        return redirect()->back()->with('success', 'Approval status updated successfully!');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $img = $request->file('image');
        $allowedExts = array('jpg', 'png', 'jpeg');
        $messages = [
            'name.required' => 'The title field is required',
            'user_language_id.required' => 'The Language field is required',
            'serial_number.required' => 'The serial number field is required',
            'image.required' => 'The image field is required',
            'detail_page.required' => 'The detail page field is required',
        ];


        $rules = [
            'name' => 'required|max:255',
            'user_language_id' => 'required',
            'detail_page' => 'required',
            'serial_number' => 'required|integer',
            'image' => [
                'sometimes',
                'required',
                function ($attribute, $value, $fail) use ($img, $allowedExts) {
                    if (!empty($img)) {
                        $ext = $img->getClientOriginalExtension();
                        if (!in_array($ext, $allowedExts)) {
                            return $fail("Only png, jpg, jpeg image is allowed");
                        }
                    }
                },
            ],
        ];

        $userBs = BasicSetting::where('user_id', Auth::guard('web')->id())->select('theme')->first();
        if ($userBs->theme == 'home_seven' || $userBs->theme == 'home_nine') {
            $rules['icon'] = 'required';
        }

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }
        if (!isset($request->featured))
            $request["featured"] = "0";
        $input = $request->all();
        $slug = make_slug($request->name);
        $input['slug'] = $slug;
        $input['user_id'] = Auth::id();
        $input['lang_id'] = $request->user_language_id;
        $input['icon'] = $request->icon;

        if ($request->hasFile('image')) {
            $filename = time() . '.' . $img->getClientOriginalExtension();
            $directory = public_path('assets/front/img/user/products/');
            if (!file_exists($directory))
                mkdir($directory, 0775, true);
            $request->file('image')->move($directory, $filename);
            $input['image'] = $filename;
        }
        $input['content'] = Purifier::clean($request->content);
        $blog = new UserProductsQuote();
        $blog->create($input);

        Session::flash('success', 'Product added successfully!');
        return "success";
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $data['product'] = UserProductsQuote::where('user_id', Auth::user()->id)->where('id', $id)->firstOrFail();
        return view('user.quote_product.edit', $data);
    }

    public function update(Request $request)
    {
        $img = $request->file('image');
        $allowedExts = array('jpg', 'png', 'jpeg');

        $messages = [
            'name.required' => 'The title field is required',
            'serial_number.required' => 'The serial number field is required',
            'image.required' => 'The image field is required',
            'detail_page.required' => 'The detail page field is required',
        ];

        $rules = [
            'name' => 'required|max:255',
            'detail_page' => 'required',
            'serial_number' => 'required|integer',
            'image' => [
                function ($attribute, $value, $fail) use ($img, $allowedExts) {
                    if (!empty($img)) {
                        $ext = $img->getClientOriginalExtension();
                        if (!in_array($ext, $allowedExts)) {
                            return $fail("Only png, jpg, jpeg image is allowed");
                        }
                    }
                },
            ],
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }
        $product = UserProductsQuote::where('user_id', Auth::user()->id)->where('id', $request->id)->firstOrFail();
        $input = $request->all();
        $slug = make_slug($request->name);
        $input['slug'] = $slug;
        $input['user_id'] = Auth::id();
        $input['icon'] = $request->icon;

        if ($request->hasFile('image')) {
            $filename = time() . '.' . $img->getClientOriginalExtension();
            $request->file('image')->move(public_path('assets/front/img/user/products/'), $filename);
            if (file_exists(public_path('assets/front/img/user/products/' . $product->image))) {
                @unlink(public_path('assets/front/img/user/products/' . $product->image));
            }

            $input['image'] = $filename;
        }
        $input['content'] = Purifier::clean($request->content);
        $product->update($input);
        Session::flash('success', 'Product updated successfully!');
        return "success";
    }

    public function delete(Request $request)
    {
        $product = UserProductsQuote::where('user_id', Auth::user()->id)->where('id', $request->id)->firstOrFail();
        if (file_exists(public_path('assets/front/img/user/products/' . $product->image))) {
            @unlink(public_path('assets/front/img/user/products/' . $product->image));
        }
        $product->delete();
        Session::flash('success', 'Product deleted successfully!');
        return back();
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;
        foreach ($ids as $id) {
            $product = UserProductsQuote::where('user_id', Auth::user()->id)->where('id', $id)->firstOrFail();
            if (file_exists(public_path('assets/front/img/user/products/' . $product->image))) {
                @unlink(public_path('assets/front/img/user/products/' . $product->image));
            }
            $product->delete();
        }
        Session::flash('success', 'Product deleted successfully!');
        return "success";
    }

    public function featured(Request $request): \Illuminate\Http\RedirectResponse
    {
        $member = UserProductsQuote::where('user_id', Auth::user()->id)->where('id', $request->service_id)->firstOrFail();
        $member->featured = $request->featured;
        $member->save();
        if ($request->featured == 1) {
            Session::flash('success', 'Featured successfully!');
        } else {
            Session::flash('success', 'Unfeatured successfully!');
        }
        return back();
    }
}