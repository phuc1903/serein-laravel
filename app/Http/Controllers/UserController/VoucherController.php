<?php

namespace App\Http\Controllers\UserController;

use App\Http\Controllers\Controller;
use App\Models\VouchersUser;
use App\Models\Voucher;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        
        $vouchers = VouchersUser::with('voucher') 
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(4);

        // Truyền dữ liệu đến view
        return view('voucher', ['vouchers' => $vouchers]);
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
        $code = $request->codeVoucher;

        if($code == "") {
            return response()->json(['success' => false, 'message' => "Vui lòng nhập mã voucher"]);
        }

        $codeVoucher = $this->searchVoucher($code, 'order');


        if($codeVoucher === false) {
            return response()->json(['success' => false, 'message' => "Voucher không hợp lệ"]);
        }

        if($codeVoucher) {
            $dayNow = $this->GetTimeNow();

            if($dayNow < $codeVoucher->day_start){
                return response()->json(['success' => false, 'message' => "Voucher chưa đến hạn sử dụng"]);
            }
            if  ($dayNow < $codeVoucher->day_start || $codeVoucher->is_active === false) {
                return response()->json(['success' => false, 'message' => "Voucher đã hết hạn sử dụng"]);
            }
            if($codeVoucher->quantity > 0) {
                return response()->json(['success' => true, 'message' => "Voucher đã được áp dụng", 'voucher' => $codeVoucher]);
            }else {
                return response()->json(['success' => false, 'message' => "Số lượng sử dụng voucher đã hết"]);
            }
        }else {
            return response()->json(['success' => false, 'message' => "Voucher không tồn tại"]);
        }
    }

    public function searchVoucher($voucher, $event) 
    {
        $codeVoucher = strtolower($voucher);

        $voucherByCode = Voucher::whereRaw('LOWER(code) LIKE ?', ['%' . $codeVoucher . '%'])
                                ->where('trigger_event', $event)
                                ->first();

        if ($voucherByCode) {
            return $voucherByCode;
        } else {
            return false;
        }
    }

    private function GetTimeNow() {
        $desiredTimeZone = new DateTimeZone('Asia/Ho_Chi_Minh');
        $currentTime = new DateTime('now', new DateTimeZone('UTC'));
        $currentTime->setTimezone($desiredTimeZone);
        $formattedTime = $currentTime->format('Y-m-d H:i:s');
        return $formattedTime;
    }

    /**
     * Display the specified resource.
     */
    public function show(Voucher $voucher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Voucher $voucher)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Voucher $voucher)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $voucherUser = VouchersUser::findOrFail($request->voucherUserId);
        if ($voucherUser) {
            $voucherUser->delete();
            return response()->json(['success' => true, 'message' => 'Voucher của bạn đã xóa thành công']);
        }
        else {
            return response()->json(['success' => false, 'message' => 'Xin lỗi, có vẻ hệ thống đã có lỗi']);
        }
    }
}
