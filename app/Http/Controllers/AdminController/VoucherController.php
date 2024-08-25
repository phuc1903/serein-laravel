<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVoucherRequest;
use App\Http\Requests\UpdateVoucherRequest;
use App\Models\Voucher;
use App\Models\VouchersUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class VoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vouchers = Voucher::orderBy('created_at', 'desc')->orderBy('id', 'desc')->paginate(4);
        return view('admin.vouchers.list', ['vouchers' => $vouchers]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.vouchers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVoucherRequest $request)
    {
        $data = $request->validated();
        
        Voucher::create($data);

        return redirect()->back()->with('success', 'Thêm voucher thành công');
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
    public function edit(Voucher $voucher)
    {
        // $statusVouchers = Voucher::getStatusOptions();

        // $statusVouchers = array_diff($statusVouchers, [$voucher->status]);
        return view('admin.vouchers.edit', ['voucher' => $voucher]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVoucherRequest $request, Voucher $voucher)
    {
        $data = $request->validated();

        $voucher->update($data);

        return redirect()->back()->with('success', 'Sửa voucher thành công');
    }

    public function CheckVoucherUser(Request $request)
    {
        $voucherId = $request->input('id');
        $vouchersUser = VouchersUser::where('voucher_id', $voucherId)->get();
        
        if ($vouchersUser->isEmpty()) {
            return response()->json(['exists' => false, 'test' => $voucherId]);
        } else {
            return response()->json(['exists' => true, 'vouchersUser' => $vouchersUser, 'test' => $voucherId]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Voucher $voucher)
    {
        DB::transaction(function() use ($voucher) {
            $vouchersUser = VouchersUser::where('voucher_id', $voucher->id);

            if ($vouchersUser->exists()) {
                $vouchersUser->delete();
            }

            $voucher->delete();
        });

        return response()->json(['message' => 'Xóa voucher thành công']);
    }
}
