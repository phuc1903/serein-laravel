<?php

namespace App\Http\Controllers\UserController;

use App\Http\Controllers\Controller;
use App\Jobs\SendCreateAccountMailJob;
use App\Models\Favorite;
use App\Models\User;
use App\Models\Voucher;
use App\Models\VouchersUser;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{

    public function changePassword(User $user) 
    {
        // Gate::authorize('changePassword', $user);

        return view('auth.change-password', ['user' => $user]);
    }

    public function changePasswordStore(Request $request, User $user)
    {
        $request->validate([
            'passwordOld' => 'required|min:3|max:255',
            'password' => 'required|min:3|max:255|confirmed',
        ]);

        if (Hash::check($request->passwordOld, $user->password)) {
            $user->update(['password' => Hash::make($request->password)]);
            return redirect()->route('info')->with('success', 'Thay đổi mật khẩu thành công');
        } else {
            return redirect()->back()->with('error', 'Mật khẩu cũ sai');
        }
    }

    // Page Đăng nhập
    public function login()
    {
        return view('auth.login');
    }
    
    // Handler đăng nhập
    public function loginStore(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8, string']
        ]);

        
        if (Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password])) {
            $this->addFavorite(Auth::user());
            return redirect()->route('home')->with('success', "Đăng nhập thành công");
        } else {
            return back()->withErrors('email', 'email sai')->with('error', "Đăng nhập thất bại");
        }
    }

    // Page đăng ký
    public function register()
    {
        return view('auth.register');
    }

    // Handler đăng ký
    public function registerStore(Request $request)
    {
        $request->validate([
            'name' => ['required', 'min:5', 'max:50'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:8', 'confirmed']
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        if($user) {
            $voucherWhenRegister = Voucher::where('trigger_event', 'register')->first();
            VouchersUser::create([
                'user_id' => $user->id,
                'voucher_id' => $voucherWhenRegister->id
            ]);
        }

        dispatch(new SendCreateAccountMailJob($user));

        Auth::login($user);

        $this->addFavorite(Auth::user());

        event(new Registered($user));

        return redirect()->route('home')->with("success", "Đăng ký thành công và bạn đã được đăng nhập");
    }

    public function addFavorite(User $user)
    {
        $favoritesByUser = $user->favorites;
        $favoritesBySession = session('favorites');

        if ($favoritesBySession) {
            foreach ($favoritesBySession as $favoriteSession) {
                $existsInUserFavorites = $favoritesByUser->contains('product_id', $favoriteSession['product_id']);
                if (!$existsInUserFavorites) {
                    // Nếu sản phẩm từ session không tồn tại trong danh sách của user, thêm nó vào danh sách
                    Favorite::create([
                        'product_id' => $favoriteSession['product_id'],
                        'user_id' => Auth::user()->id,
                        'created_at' => $favoriteSession['created_at'],
                    ]);
                }
            }
        }

        $totalProductFavorite = count($favoritesByUser);
        session()->put('totalFavorites', $totalProductFavorite);

        Auth::user()->load('favorites',);
    }

    // Handler đăng xuất tài khoản
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate(); // Xóa tất cả session
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Bạn đã đăng xuất tài khoản thành công');
    }

    // Page Đổi mật khẩu

    

    // Page thông báo xác nhận email
    public function verifyNotice() 
    {
        return view('auth.verify-email');
    }

    // Handler xử lý xác nhận email
    public function verifyEmail(EmailVerificationRequest $request) {
        $request->fulfill();
     
        return redirect()->route('home')->with('success', 'Xác minh thành công');
    }

    // Handler gửi lại email xác nhận email
    public function verifyHandler(Request $request) {
        $request->user()->sendEmailVerificationNotification();
     
        return back()->with('success', 'Đã gửi liên kết xác minh!');
    }

    // Page gửi email xác nhận đổi mật khẩu
    public function forgotPassword() {
        return view('auth.forgot-password');
    }

    // Sending token resset password
    public function passwordEmail(Request $request) {
        $request->validate(['email' => 'required|email']);
     
        $status = Password::sendResetLink(
            $request->only('email')
        );
     
        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['success' => __($status)])
                    : back()->with(['error' => __($status)]);
    }

    public function passwordReset(string $token) {
        return view('auth.password-new', ['token' => $token]);
    }

    public function passwordUpdate(Request $request) {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);
     
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
     
                $user->save();
     
                event(new PasswordReset($user));
            }
        );
     
        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('success', __($status))
                    : back()->with(['error' => [__($status)]]);
    }
}
