<?php

namespace App\Http\Controllers\UserController;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // session()->forget('carts');
        $carts = session()->get('carts');
        if(isset($carts)) {
            $products = $carts;
        }
        else {
            $products = null;
        }
        // dd($carts);
        return view('cart', ['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return response()->json($request);
        $product = Product::findOrFail($request->product_id);
        // return response()->json($request);

        if(!$product){
            return response()->json(['error' => 'Sản phẩm không tồn tại'], 404);
        }

        $quantity = $request->quantity > 1 ? $request->quantity : 1;

        $carts = session()->get('carts', []);

        if (isset($carts[$product->id])) {
            $carts[$product->id]['quantity'] += $quantity;
        } else {
            $carts[$product->id] = [
                "product_id" => $product->id,
                "title" => $product->title,
                "quantity" => $quantity,
                "price" => $product->price,
                "image" => $product->image
            ];
        }

        // // Lưu giỏ hàng vào session
        session()->put('carts', $carts);
        $totalQuantity = array_sum(array_column($carts, 'quantity'));
        return response()->json(['success' => 'Sản phẩm đã thêm vào giỏ hàng thành công.', 'totalQuantityCart' => $totalQuantity]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $carts = session()->get('carts');

        if (isset($carts[$id])) {
            session()->forget("carts.$id");
        }

        $newCarts = session()->get('carts');
        $totalQuantity = array_sum(array_column($newCarts, 'quantity'));

        return response()->json(['success' => true, 'message' => "Xóa sản phẩm thành công", "newCarts" => $newCarts, 'totalQuantity' => $totalQuantity]);
    }


    public function updateQuantity(Request $request)
    {
        $productId = $request->product_id;
        $quantity = $request->quantity;

        $carts = session()->get('carts', []);

        if (isset($carts[$productId])) {
            $carts[$productId]['quantity'] = $quantity;
        } else {
            return response()->json(['error' => 'Không tìm thấy sản phẩm trong giỏ hàng'])->with('error', 'Không tìm thấy sản phẩm trong giỏ hàng');
        }

        session()->put('carts', $carts);

        $totalPriceProduct = $carts[$productId]['quantity'] * $carts[$productId]['price'];
        $totalPrice = array_reduce($carts, function ($sum, $item) {
            return $sum + ($item['quantity'] * $item['price']);
        }, 0);

        $totalCartPrice = $totalPrice + 18000;

        $totalQuantityCart = 0;

        foreach($carts as $cart) {
            $totalQuantityCart += $cart['quantity'];
        }

        return response()->json([
            'totalPriceProduct' => number_format($totalPriceProduct, 0, ',', '.'),
            'totalPrice' => number_format($totalPrice, 0, ',', '.'),
            'totalCartPrice' => number_format($totalCartPrice, 0, ',', '.'),
            'totalQuantityCart' => $totalQuantityCart
        ]);
    }
}
