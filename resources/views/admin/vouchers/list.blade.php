<x-layouts.layout-admin>


    <div class="col l-9 main__admin">
        <h1>Quản lý Voucher</h1>
        <a href="{{ route('admin.voucher.create') }}">
            <button class="addProduct" name="addProduct">Add</button>
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
                    @foreach ($vouchers as $vch)
                        <tr class="manager-list" style="width: 100%;">
                            <td class="manager-name">
                                <span>{{ $vch->code }}</span>
                            </td>
                            <td class="manager-price">
                                <span>{{ $vch->discount_type }}</span>
                            </td>
                            <td class="manager-price">
                                <span>{{ $vch->discount_value }}</span>
                            </td>
                            <td class="manager-price">
                                <span>{{ $vch->discount_max }}</span>
                            </td>
                            <td class="manager-price">
                                <span>{{ $vch->quantity }}</span>
                            </td>
                            <td class="manager-price">
                                <span>{{ $vch->user_count }}</span>
                            </td>
                            <td class="manager-price">
                                <span>
                                    <x-buttons.badges type="{{ $vch->user_count ? 'success' : 'error' }}" title="{{ $vch->user_count ? 'Còn sử dụng' : 'Hết sử dụng' }}"/>
                                </span>
                            </td>
                            <td class="manager-price">
                                <span>{{ $vch->trigger_event }}</span>
                            </td>
                            <td class="manager-price">
                                <span>{{ $vch->description }}</span>
                            </td>
                            <td class="manager-updateDay">
                                <span>{{ $vch->day_start }}</span>
                            </td>
                            <td class="manager-updateDay">
                                <span>{{ $vch->day_end }}</span>
                            </td>
                            <td class="manager-action">
                                <a 
                                    data-id="{{ $vch->id }}" 
                                    data-route-delete="{{ route('admin.voucher.destroy', $vch->id) }}"  
                                    data-route-check="{{ route('admin.voucher.checkVoucherUser') }}"
                                    data-confirm="Voucher này đã có khách hàng sử dụng. Bạn có muốn xóa không ?"
                                    class="bill_delete delete-button">
                                        <meta name="csrf-token" content="{{ csrf_token() }}">
                                        <div class="manager-action-item">
                                            <i class="fa-solid fa-trash"></i>
                                        </div>
                                    </a>
                                <a href="{{ route('admin.voucher.edit', $vch)}}" class="manager-action-item bill_detail">
                                    <div class="manager-action-item">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </div>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <x-links.paginate :data="$vouchers"/>
        </div>
    </div>


</x-layouts.layout-admin>
