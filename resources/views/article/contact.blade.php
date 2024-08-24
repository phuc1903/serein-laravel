<x-layouts.layout>

    <div class="contact container">
        <div class="grid wide">
            <div class="row">
                <div class="col l-6">
                    <div class="about-content">
                        <div class="about-content-top">
                            <div class="about-content-top-icon">#</div>
                            <div class="about-content-top-item">Liên hệ</div>
                        </div>
                        <div class="about-content-title">
                            <h1>
                                Nếu có bất kỳ vấn đề gì thì liên hệ <a href="/">Serein</a> Jewelry
                            </h1>
                        </div>
                        <div class="about-content-list">
                            Nếu bạn muốn gửi một thông điệp trực tiếp cho
                            chúng tôi, bạn có thể sử dụng mẫu liên hệ dưới
                            đây. Hãy điền đầy đủ thông tin cần thiết và chsun
                            tôi sẽ liên hệ lại với bạn càng sớm càng tốt.
                            <a hreft="#">Serein</a>.
                        </div>
                    </div>
                    <form action="{{ route('contact.store') }}" method="post" class="contact-form">
                        @csrf
                        <div class="contact-form-item">
                            <div>
                                <input name="fullname" value="{{ old('fullname')}}" class="contact-form-item-1 @error('fullname') error @enderror" type="text" placeholder="Họ và tên...">
                                @error('fullname')
                                    <div class="error" id="fullname">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <input name="email" value="{{ old('email')}}" class="contact-form-item-2 @error('email') error @enderror" type="email" placeholder="Email...">
                                @error('email')
                                    <div class="error" id="email_err">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="contact-form-item">
                            <div>
                                <input class="@error('phone') error @enderror" name="phone" value="{{ old('phone')}}" type="number" placeholder="Số điện thoại">
                                @error('phone')
                                    <div class="error" id="phone_err">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="contact-form-item">
                            <div>
                                <textarea class="@error('content') error @enderror" name="content" value="{{ old('content')}}" id="" cols="30" rows="10" placeholder="Nội dung"></textarea>
                            </div>
                            @error('content')
                                <div class="error" id="content_err">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit">Gửi</button>
                    </form>
                </div>
                <div class="col l-6">
                    <div class="about-img">
                        <img src="img/post1.png" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('article.evaluate')

</x-layouts.layout>
