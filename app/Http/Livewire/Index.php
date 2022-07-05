<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Order;
use App\Models\Wallet;
use Auth;

class Index extends Component
{
	public $qty, $pay, $product, $query, $sortBy, $type = null;

    public function render()
    {
        // I know it's very complicated, I will do it with better queries next time
        $this->sortBy = $this->type != null ? $this->type : 'Sort By';
        $productData = Product::where('stock', '>', 0)->get();
        $productSearch = Product::where('stock', '>', 0)->where('name','like','%'.$this->query.'%')->get();
        $nameAsc = Product::where('stock', '>', 0)->orderBy('name', 'ASC')->get();
        $nameDesc = Product::where('stock', '>', 0)->orderBy('name', 'DESC')->get();
        $timestampAsc = Product::where('stock', '>', 0)->latest()->get();
        $timestampDesc = Product::where('stock', '>', 0)->oldest()->get();
        $nameSearchAsc = Product::where('stock', '>', 0)->where('name','like','%'.$this->query.'%')->orderBy('name', 'ASC')->get();
        $nameSearchDesc = Product::where('stock', '>', 0)->where('name','like','%'.$this->query.'%')->orderBy('name', 'DESC')->get();
        $timestampSearchAsc = Product::where('stock', '>', 0)->where('name','like','%'.$this->query.'%')->latest()->get();
        $timestampSearchDesc = Product::where('stock', '>', 0)->where('name','like','%'.$this->query.'%')->oldest()->get();
        return view('livewire.index', ['products' =>
            $this->query == null && $this->type == null ? $productData : 
            (($this->query == null && $this->type == 'A-Z') ? $nameAsc : 
            (($this->query == null && $this->type == 'Z-A') ? $nameDesc : 
            (($this->query == null && $this->type == 'Newest') ? $timestampAsc : 
            (($this->query == null && $this->type == 'Oldest') ? $timestampDesc : 
            (($this->query != null && $this->type == 'A-Z')) ? $nameSearchAsc : 
            (($this->query != null && $this->type == 'Z-A') ? $nameSearchDesc : 
            (($this->query != null && $this->type == 'Newest') ? $timestampSearchAsc : 
            (($this->query != null && $this->type == 'Oldest') ? $timestampSearchDesc : $productSearch)))))))
        ]);
    }

    public function buyProduct($id)
    {
    	$this->product = Product::where('id', $id)->first();
    	if($this->pay == null){
    		session()->flash('error', "We caught the thief here! Tapi boong, at least input zero rupiah");
    	}elseif($this->qty == null){
    		session()->flash('error', "Nothing can't be empty!");
    	}elseif($this->qty > $this->product->stock){
    		session()->flash('error', "Someone try to ngeborong! but too much to exceed the available stock.");
    	}else{
    		$this->product->stock -= $this->qty;
    		$this->product->save();

    		Order::create([
    			'product_id' => $id,
    			'buyer_id' => Auth::id(),
    			'qty' => $this->qty,
    			'pay' => $this->pay,
    		]);

    		$wallet = Wallet::first();
    		$wallet->balance += $this->pay;
    		$wallet->save();

    		session()->flash('success', 'Thank you for buying '.$this->qty .' '. $this->product->name);
    	}
    }
}
