<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Auth;

class ProductController extends Controller
{
    public function store(Request $input){
    	$validator = Validator::make($input->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpg,jpeg,png,bmp,gif,svg,webp|max:1800',
            'stock' => 'required',
            'price' => 'required',
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        if($input->file('image')){
            $file = $input->file('image');
            $filename = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('products'), $filename);
        }

        Product::create([
        	'user_id' => Auth::id(),
        	'name' => $input->name,
        	'description' => $input->description,
        	'image' => $filename,
        	'stock' => $input->stock,
            'price' => $input->price,
        ]);

        return redirect()->back()->with('success', 'Congratulations! Your product can now be purchased anytime.');
    }
}
