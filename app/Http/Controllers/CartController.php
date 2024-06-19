<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Basket;
use App\Models\Product;
use App\Models\Receipt;

class CartController extends Controller
{
    public function add(Request $request, Product $product)
    {
        $basket = Basket::where('user_id', $request->user()->id)
                        ->where('product_id', $product->id)
                        ->first();
        if ($basket) {
            $basket->amount += 1;
            $basket->save();
        } else {
            Basket::create([
                'user_id' => $request->user()->id,
                'product_id' => $product->id,
                'amount' => 1,
            ]);
        }
        return redirect()->back()->with('success', 'Товар добавлен в корзину');
    }

    public function decrease(Request $request, Product $product)
    {
        $basket = Basket::where('user_id', $request->user()->id)
                        ->where('product_id', $product->id)
                        ->first();
        if ($basket) {
            if ($basket->amount > 1) {
                $basket->amount -= 1;
                $basket->save();
            } else {
                $basket->delete();
            }
        }
        return redirect()->back();
    }

    public function increase(Request $request, Product $product)
    {
        $basket = Basket::where('user_id', $request->user()->id)
                        ->where('product_id', $product->id)
                        ->first();

        if ($basket) {
            $basket->amount += 1;
            $basket->save();
        }

        return redirect()->back();
    }

    public function checkout(Request $request)
    {
        $basket = Basket::where('user_id', $request->user()->id)->get();
        if ($basket->isEmpty()) {
            return redirect()->back()->with('error', 'Ваша корзина пуста');
        }
        $receipt = new Receipt;
        $receipt->user_id = $request->user()->id;
        $receipt->address = $request->address;
        $receipt->save();
        $user = $request->user();
        $user->address = $request->address;
        $user->save();
        foreach ($basket as $item) {
            $receipt->products()->attach($item->product_id, ['amount' => $item->amount]);
            $item->delete();
        }
        return redirect()->route('index')->with('success', 'Заказ оформлен');
    }
}
