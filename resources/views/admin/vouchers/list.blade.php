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
                    <th>discount_type</th>
                    <th>discount_value</th>
                    <th>discount_max</th>
                    <th>quantity</th>
                    <th>user_count</th>
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
                            </td><td class="manager-price">
                                <span>{{ $vch->quantity }}</span>
                            </td><td class="manager-price">
                                <span>{{ $vch->user_count }}</span>
                            </td>
                            <td class="manager-updateDay">
                                <span>{{ $vch->day_start }}</span>
                            </td>
                            <td class="manager-updateDay">
                                <span>{{ $vch->day_end }}</span>
                            </td>
                            <td class="manager-action">
                                <a href="{{ route('admin.voucher.destroy', $vch) }}" class="bill_delete">
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
            <hr>
        </div>
    </div>


</x-layouts.layout-admin>
