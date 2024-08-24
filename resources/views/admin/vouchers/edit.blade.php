<x-layouts.layout-admin title="Chỉnh sửa {{$voucher->title}}">

    <form action="{{ route('admin.voucher.update', $voucher->id) }}" method="post" class="col l-9 main__admin"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <h1>Sửa voucher</h1>
        <div class="main__admin-inputs">
            <div class="col l-6 main__admin-input-item">
                <label for="code">Code voucher</label>
                <input type="text" id="code" name="code"
                    value="{{ old('code', $voucher->code) }}">
                @error('code')
                    <div class="error" id="email_err">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="main__admin-inputs">
            <div class="col l-6 main__admin-input-item">
                <label for="discount_type">Kiểu giảm giá của Voucher</label>
                <select name="discount_type" id="discount_type" style="margin-bottom: 20px; padding: 15px; border-radius: 8px;">
                    <option value="amount" {{ $voucher->discount_type === "amount" ? 'selected' : '' }}>amount</option>
                    <option value="percent" {{ $voucher->discount_type === "percent" ? 'selected' : '' }}>percent</option>
                </select>
                @error('discount_type')
                    <div class="error" id="email_err">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="main__admin-inputs">
            <div class="col l-6 main__admin-input-item">
                <label for="discount_value">Giá trị của voucher</label>
                <input type="number" id="discount_value" name="discount_value"
                value="{{ old('discount_value', $voucher->discount_value) }}">
                @error('discount_value')
                    <div class="error" id="email_err">{{ $message }}</div>
                @enderror
            </div>
            <div class="col l-6 main__admin-input-item">
                <label for="discount_max">Giá trị giảm nhiều nhất</label>
                <input type="number" id="discount_max" name="discount_max"
                value="{{ old('discount_max', $voucher->discount_max) }}">
                @error('discount_max')
                    <div class="error" id="email_err">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="main__admin-inputs">
            <div class="col l-6 main__admin-input-item">
                <label for="quantity">Số lượng voucher</label>
                <input class="@error('quantity') error @enderror" type="number" id="quantity" name="quantity" placeholder="Nhập số lượng voucher" value="{{ old('quantity', $voucher->quantity) }}">
                <div class="error">
                    @error('quantity')
                    {{ $message }}
                    @enderror
                </div>
            </div>
            <div class="col l-6 main__admin-input-item">
                <label for="user_count">Số lượng mỗi tài khoản</label>
                <input class="@error('user_count') error @enderror" type="number" id="user_count" name="user_count" placeholder="Nhập số lượng mỗi tài khoản" value="{{ old('user_count', $voucher->user_count) }}">
                <div class="error">
                    @error('user_count')
                    {{ $message }}
                    @enderror
                </div>
            </div>
        </div>
        <div class="main__admin-inputs">
            <div class="col l-6 main__admin-input-item">
                <label for="day_start">Ngày bắt đầu</label>
                <input class="@error('day_start') error @enderror" type="datetime-local" id="day_start" name="day_start" value="{{ old('day_start', $voucher->day_start) }}">
                <div class="error">
                    @error('day_start')
                    {{ $message }}
                    @enderror
                </div>
            </div>
            <div class="col l-6 main__admin-input-item">
                <label for="day_end">Ngày kết thúc</label>
                <input class="@error('day_end') error @enderror" type="datetime-local" id="day_end" name="day_end" value="{{ old('day_end', $voucher->day_end) }}">
                <div class="error">
                    @error('day_end')
                    {{ $message }}
                    @enderror
                </div>
            </div>
        </div>
        <div class="main__admin-btn-action">
            <button type="submit" class="btn-admin">Lưu</button>
        </div>
    </form>
</div>


</x-layouts.layout-admin>
