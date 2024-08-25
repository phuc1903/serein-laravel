<?php

namespace App\Http\Controllers\UserController;

use App\Http\Controllers\Controller;
use App\Models\VouchersUser;
use App\Models\Voucher;
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
        //
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
