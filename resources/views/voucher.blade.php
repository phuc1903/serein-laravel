<x-layouts.layout-admin title="Danh sách vouchers">

    <div class="col l-9 main__admin">
        <h1>Quản lý Voucher</h1>
        <a href="{{ route('info') }}">
            <button class="addProduct" name="addProduct">Trở về hồ sơ</button>
        </a>
        <div class="manager-main">
            <table class="manager-table" style="width: 100%;">
                <tr class="manager-header"style="width: 100%;">
                    <th>code</th>
                    <th>Kiểu giảm giá</th>
                    <th>Giá trị giảm giá</th>
                    <th>Giảm giá cao nhất</th>
                    <th>Số lượng voucher</th>
                    <th>Số lượng mỗi tài khoản</th>
                    <th>Sử dụng</th>
                    <th>Loại voucher</th>
                    <th>Mô tả</th>
                    <th>Ngày bắt đầu</th>
                    <th>Ngày kết thúc</th>
                    <th>Hành động</th>
                    {{-- {{ dd($vouchers)}} --}}
                </tr>
                <tbody class="manager-body" style="width: 100%;">
                    @foreach ($vouchers as $voucherUser)
                        <tr class="manager-list" style="width: 100%;">
                            <td class="manager-name">
                                <span>{{ $voucherUser->voucher->code }}</span>
                            </td>
                            <td class="manager-price">
                                <span>{{ $voucherUser->voucher->discount_type }}</span>
                            </td>
                            <td class="manager-price">
                                <span>{{ $voucherUser->voucher->discount_value }}</span>
                            </td>
                            <td class="manager-price">
                                <span>{{ $voucherUser->voucher->discount_max }}</span>
                            </td>
                            <td class="manager-price">
                                <span>{{ $voucherUser->voucher->quantity }}</span>
                            </td>
                            <td class="manager-price">
                                <span>{{ $voucherUser->voucher->user_count }}</span>
                            </td>
                            <td class="manager-price">
                                <span>
                                    <x-buttons.badges
                                        type="{{ $voucherUser->voucher->user_count ? 'success' : 'error' }}"
                                        title="{{ $voucherUser->voucher->user_count ? 'Còn sử dụng' : 'Hết sử dụng' }}" />
                                </span>
                            </td>
                            <td class="manager-price">
                                <span>{{ $voucherUser->voucher->trigger_event }}</span>
                            </td>
                            <td class="manager-price">
                                <span>{{ $voucherUser->voucher->description }}</span>
                            </td>
                            <td class="manager-updateDay">
                                <span>{{ $voucherUser->voucher->day_start }}</span>
                            </td>
                            <td class="manager-updateDay">
                                <span>{{ $voucherUser->voucher->day_end }}</span>
                            </td>
                            <td class="manager-action">
                                <a data-route="{{ route('voucher.destroy')}}" data-voucher-user="{{ $voucherUser->id }}" class="bill_delete delete-voucher">
                                    <div class="manager-action-item">
                                        <i class="fa-solid fa-trash"></i>
                                    </div>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <x-links.paginate :data="$vouchers" />
        </div>
    </div>


</x-layouts.layout-admin>
