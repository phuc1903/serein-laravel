<x-layouts.layout-admin>

    <div class="col l-9 main__admin">
        <form action="{{ route('admin.voucher.store') }}" method="post" class="col l-9 main__admin"
            enctype="multipart/form-data">
            @csrf
            <h1>Thêm voucher</h1>

            <div class="main__admin-inputs">
                <div class="col l-6 main__admin-input-item">
                    <label for="code">Code voucher</label>
                    <input class="@error('code') error @enderror" type="text" id="code" name="code"
                        placeholder="Nhập code voucher hoặc sẽ tự tạo" value="{{ old('code') }}">
                    <div class="error">
                        @error('code')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>
            <div class="main__admin-inputs">
                <div class="col l-6 main__admin-input-item">
                    <label for="discount_type">Loại giảm giá voucher</label>
                    <select class="@error('discount_type') error @enderror" name="discount_type" id="discount_type"
                        style="padding: 15px; border-radius: 8px;">
                        <option value="percent">Giảm theo %</option>
                        <option value="amount">Giảm theo số tiền</option>
                    </select>
                    <div class="error">
                        @error('discount_type')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>

            <div class="main__admin-inputs">
                <div class="col l-6 main__admin-input-item">
                    <label for="discount_value">Giá trị giảm giá</label>
                    <input class="@error('discount_value') error @enderror" type="number" id="discount_value"
                        name="discount_value" placeholder="Nhập giá trị giảm giá (%/số tiền)" value="{{ old('discount_value') }}">
                    <div class="error">
                        @error('discount_value')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="col l-6 main__admin-input-item">
                    <label for="discount_max">Giảm giá cao nhất</label>
                    <input class="@error('discount_max') error @enderror" type="number" id="discount_max"
                        name="discount_max" placeholder="Nhập giá trị giảm giá cao nhất" value="{{ old('discount_max') }}">
                    <div class="error">
                        @error('discount_max')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>

            <div class="main__admin-inputs">
                <div class="col l-6 main__admin-input-item">
                    <label for="quantity">Số lượng voucher</label>
                    <input class="@error('quantity') error @enderror" type="number" id="quantity" name="quantity"
                        placeholder="Nhập số lượng voucher" value="{{ old('quantity') }}">
                    <div class="error">
                        @error('quantity')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="col l-6 main__admin-input-item">
                    <label for="user_count">Số lượng mỗi tài khoản</label>
                    <input class="@error('user_count') error @enderror" type="number" id="user_count" name="user_count"
                        placeholder="Nhập số lượng mỗi tài khoản" value="{{ old('user_count') }}">
                    <div class="error">
                        @error('user_count')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>

            <div class="main__admin-inputs">
                <div class="col l-6 main__admin-input-item">
                    <label for="is_active">Hoạt động của voucher</label>
                    <select class="@error('is_active') error @enderror" name="is_active" id="is_active"
                        style="padding: 15px; border-radius: 8px;">
                        <option value="1">Còn sử dụng</option>
                        <option value="0">Hết sử dụng</option>
                    </select>
                    <div class="error">
                        @error('is_active')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>
            <div class="main__admin-inputs">
                <div class="col l-6 main__admin-input-item">
                    <label for="trigger_event">Loại voucher</label>
                    <input class="@error('trigger_event') error @enderror" type="text" id="trigger_event" name="trigger_event"
                        placeholder="Loại voucher (Sử dụng khi khách hàng đăng ký tài khoản, Sử dụng khi lần đầu mua hàng ...)" value="{{ old('triggerr_event') }}">
                    <div class="error">
                        @error('trigger_event')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="col l-6 main__admin-input-item">
                    <label for="description">Mô tả</label>
                    <textarea class="@error('description') error @enderror" cols="44" rows="4"  type="text" id="description" name="description" placeholder="Nhập mô tả voucher">{{ old("description") }}</textarea>
                    @error('description')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="main__admin-inputs">
                <div class="col l-6 main__admin-input-item">
                    <label for="day_start">Ngày bắt đầu</label>
                    <input class="@error('day_start') error @enderror" type="date" id="day_start" name="day_start" value="{{ old('day_start') }}">
                    <div class="error">
                        @error('day_start')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="col l-6 main__admin-input-item">
                    <label for="day_end">Ngày kết thúc</label>
                    <input class="@error('day_end') error @enderror" type="date" id="day_end" name="day_end" value="{{ old('day_end') }}">
                    <div class="error">
                        @error('day_end')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>

            <div class="main__admin-btn-action">
                <button type="submit" class="btn-admin">Thêm voucher</button>
            </div>
        </form>
    </div>

</x-layouts.layout-admin>
