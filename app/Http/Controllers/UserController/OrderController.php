<?php

namespace App\Http\Controllers\UserController;

use App\Http\Controllers\Controller;
use App\Jobs\SendNewOrderMailJob;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\User;
use App\Models\VouchersUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)->latest()->paginate(4);

        $totalPrice = 0;

        foreach ($orders as $order) {

            $orderDetails = $order->orderDetails;

            foreach ($orderDetails as $orderDetail) {
                $totalPrice += $orderDetail->price * $orderDetail->quantity;
            }

            $order->totalPrice = $totalPrice;
        }

        // dd($orders);

        return view('orders.order', ['orders' => $orders]);
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
        $carts = session()->get('carts');
        $user = Auth::user();

        if(!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Vui lòng đăng nhập để thanh toán']);
        }
        
        $error =  $this->validatedUser($user);

        if($error !== null) return $error;
        
        if (isset($carts)) {
            $totalPriceOrder = 0;
            $totalPriceOrder += 18000; // Phí vận chuyển
            foreach($carts as $cart) {
                $totalPriceOrder += (intval($cart['price']) * intval($cart['quantity']));
            }

            $voucher = $request->voucher;

            if($voucher) {
                $voucherByUser = VouchersUser::where('user_id', $user->id)->where('voucher_id', $voucher['id'])->first();
                if($voucherByUser) {
                    if($voucherByUser->quantity >=1) {

                    }else {
                        return response()->json(['']);
                    }
                }else {
                    if ($voucher['discount_type'] === "amount") {
                        $totalPriceOrder -= intval($voucher['discount_value']);
                    }
                    else if ($voucher['discount_type'] === "percent") {
                        $totalPriceOrder -= ($totalPriceOrder * (intval($voucher['discount_value']) / 100));
                    }
                }
            }

            try {
                if($request->type === "cod") {
                    return $this->cod_payment($totalPriceOrder, $user, $request->type, $carts);
                }else if($request->type === "momo") {
                    return $this->momo_payment($totalPriceOrder, $user, $request->type, $carts);
                }
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => 'Có lỗi xảy ra trong quá trình thanh toán.']);
            }
        }
        return response()->json(['success' => false, 'message' => 'Giỏ hàng của bạn đang trống.']);
    }
  
    private function validatedUser($user) 
    {
        if ($user) {
            if (!$user->phone) {
                return response()->json(['success' => false, 'message' => 'Vui lòng nhập số điện thoại và đầy đủ thông tin']);
            }
            if (!$user->address) {
                return response()->json(['success' => false, 'message' => 'Vui lòng nhập địa chỉ và đầy đủ thông tin']);
            }
            if (!$user->name) {
                return response()->json(['success' => false, 'message' => 'Vui lòng nhập tên và đầy đủ thông tin']);
            }
            if (!$user->email) {
                return response()->json(['success' => false, 'message' => 'Vui lòng nhập email và đầy đủ thông tin']);
            }
            return null;
        }else {
            return response()->json(['success' => false, 'message' => 'Vui lòng đăng nhập để thanh toán']);
        }
    }

    public function cod_payment($totalPriceOrder, $user, $method, $carts)
    {
        $order = Order::create([
            'user_id' => $user->id,
            'name' => $user->name,
            'phone' => $user->phone,
            'address' => $user->address,
            'status' => "Đang xét duyệt",
            'payment_method' => $method,
            'total_price' => $totalPriceOrder,
        ]);

        foreach ($carts as $cart) {
            $orderDetails = OrderDetail::create([
                'order_id' => $order->id,
                'product_id' => $cart['product_id'],
                'quantity' => $cart['quantity'],
                'price' => $cart['price'],
            ]);
        }
        $orderMail = [$user, $order];
        
        if($orderMail) {
            dispatch(new SendNewOrderMailJob($orderMail));
        }

        if ($orderDetails && $order) {
            session()->pull('carts');
            return response()->json(['success' => true, 'messsage', 'Đơn hàng đã đặt thành công, Chờ xét duyệt']);
        }
        return response()->json(['success' => false, 'message' => "Đang có lỗi trong thanh toán, Bạn vui lòng đợi"]);
    }

    public function momo_payment($totalPriceOrder, $user, $method, $carts) 
    {
        $order = Order::create([
            'user_id' => $user->id,
            'name' => $user->name,
            'phone' => $user->phone,
            'address' => $user->address,
            'status' => "Đang xét duyệt",
            'payment_method' => $method,
            'total_price' => $totalPriceOrder,
        ]);

        foreach ($carts as $cart) {
            $orderDetails = OrderDetail::create([
                'order_id' => $order->id,
                'product_id' => $cart['product_id'],
                'quantity' => $cart['quantity'],
                'price' => $cart['price'],
            ]);
        }

        // session()->pull('carts');

        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
        $partnerCode = env('MOMO_PARTNERCODE');
        $accessKey = env('MOMO_ACCESSKEY');
        $secretKey = env('MOMO_SERCETKEY');
        $orderInfo = "Thanh toán qua MoMo";
        $amount = $totalPriceOrder;
        $orderId = time() . "";
        $redirectUrl = route('order.create',['order' => $order->id, 'user' => $user->id]);
        $ipnUrl = route('order.index');
        $extraData = "";

        $requestId = time() . "";
        $requestType = "payWithATM";
        $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
        $signature = hash_hmac("sha256", $rawHash, $secretKey);
        $data = array(
            'partnerCode' => $partnerCode,
            'partnerName' => "Test",
            "storeId" => "MomoTestStore",
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature
        );
        $result = $this->execPostRequest($endpoint, json_encode($data));
        $jsonResult = json_decode($result, true);

        if($jsonResult['resultCode'] !== 0 ) {
            return response()->json(['success' => false, 'message' => $jsonResult['message']]);
        }
        
        return response()->json(['success' => true, 'payUrl' => $jsonResult['payUrl'], 'message' => 'Đơn hàng đã được tạo thành công, chuyển hướng đến MoMo để thanh toán.']);
    }


    public function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data))
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        //execute post
        $result = curl_exec($ch);
        //close connection
        curl_close($ch);
        return $result;
    }

    public function createOrder(Request $request)
    {
        $order = Order::findOrFail($request->order); 
        $order->update(['status' => "Đã thanh toán"]);
        session()->pull('carts');
        $user = User::findOrFail($request->user);

        dispatch(new SendNewOrderMailJob([$user, $order]));

        return redirect()->route('order.index')->with('success', 'Bạn đã thanh toán thành công');
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
        $order = Order::findOrFail($id);
        // dd($order);
        if ($order->status !== "Đang xét duyệt") {
            return redirect()->back()->with('error', 'Hiện tại đơn hàng không thể xóa');
        }

        $order->delete();

        return redirect()->back()->with('success', 'Xóa thành công');
    }

    public function detail(Order $order)
    {
        Gate::authorize('detail', $order);

        $orderDetails = $order->orderDetails()->with('product')->get();

        foreach ($orderDetails as $orderDetail) {
            $orderDetail->product_name = $orderDetail->product->title;
            $orderDetail->product_price = $orderDetail->product->price;
            $orderDetail->product_image = $orderDetail->product->image;
            $orderDetail->totalPrice = $orderDetail->product->price * $orderDetail->quantity;
        }

        return view('orders.order-detail', ['orderDetails' => $orderDetails]);
    }

    public function OrderByUserApi(Order $order)
    {
        return view('admin.orders.printOrder', ['order' => $order]);
    }

}
