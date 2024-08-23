<?php

namespace App\Http\Controllers\UserController;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index(User $user)
    {
        // dd($user->favorites);
        $favorites = $user->favorites()->with('product')->latest()->paginate(4);
        $totalFavorites = $favorites->total();

        $favorites->map(function($favorite) {
            $product = $favorite->product;
            $favorite->title = $product->title;
            $favorite->image = $product->image;
            $favorite->price = $product->price;
            return $favorite;
        });

        // dd(session()->get('favorites'));

        return view('article.favorite', ['favorites' => $favorites]);
    }

    public function store(Request $request) 
    {
        $product_id = $request->product_id;
        $product = Product::findOrFail($product_id);
        $now = now();
        $totalProductFavorite = 0;
        if($product) {
            if (Auth::check()) {
                $user_id = Auth::user()->id;
                $favorites = Auth::user()->favorites()->get();
    
                foreach ($favorites as $favorite) {
                    if ($favorite->product_id == $product_id) {
                        $totalProductFavorite = count($favorites);
                        session()->put('totalFavorites', $totalProductFavorite);
                        return response()->json(['warning' => "Sản phẩm này đã được thêm vào danh sách yêu thích của bạn", 'totalProductFavorite' => $totalProductFavorite]);
                    }
                }
    
                Favorite::create([
                    'product_id' => $product_id,
                    'user_id' => $user_id,
                    'created_at' => $now
                ]);
    
                $totalProductFavorite = Auth::user()->favorites()->count();
                session()->put('totalFavorites', $totalProductFavorite);

                return response()->json([
                    'success' => "Đã thêm vào danh sách yêu thích của bạn",
                    'totalProductFavorite' => $totalProductFavorite
                ]);
    
            } else {
                $favorites = session()->get('favorites', []);
                if (isset($favorites[$product_id])) {
                    $totalProductFavorite = count($favorites);
                    session()->put('totalFavorites', $totalProductFavorite);
                    return response()->json(['warning' => 'Sản phẩm này đã được thêm vào danh sách yêu thích của bạn', 'totalProductFavorite' => $totalProductFavorite]);
                } else {
                    $favorites[$product_id] = [
                        "product_id" => $product_id,
                        "created_at" => $now
                    ];
                }
    
                session()->put('favorites', $favorites);
    
                $totalProductFavorite = count(session()->get('favorites'));
                session()->put('totalFavorites', $totalProductFavorite);
                
                return response()->json([
                    'success' => 'Sản phẩm đã được thêm vào danh sách yêu thích. Đăng nhập để được lưu trữ',
                    'totalProductFavorite' => $totalProductFavorite
                ]);
            }
        }else {
            return response()->json(['error' => 'Hiện tại sản phẩm không tồn tại']);
        }
    }

    public function destroy(Favorite $favorite)
    {
        $favorite->delete();

        return redirect()->back()->with('success', 'Xóa sản phẩm yêu thích thành công');
    }
}
