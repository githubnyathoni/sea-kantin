<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Wallet;
use App\Models\Order;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $products = Product::where('stock', '>', 0)->where('user_id', Auth::id())->paginate(15);
        $idProducts = Product::where('user_id', Auth::id())->pluck('id');
        $balance = Wallet::value('balance');
        $history = Order::whereIn('product_id', $idProducts)->get()->sortByDesc('created_at')->take(3);
        return view('dashboard', compact('products', 'balance', 'history'));
    }

    public function withdraw(Request $request)
    {
        $wallet = Wallet::first();
        $wallet->balance -= $request->amount;
        $wallet->save();

        return redirect()->back()->with('success', 'Successfully made a withdrawal of Rp'. number_format($request->amount,0,',','.'));  
    }
}
