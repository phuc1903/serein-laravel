<?php

namespace App\Http\Controllers\UserController;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactRequest;
use App\Jobs\SendContactMailJob;
use App\Jobs\SendFeedbackFormCustomersMailJob;
use Illuminate\Http\Request;

class ContactController extends Controller
{

    public function index() {

        return view('article.contact');
    }

    public function store(StoreContactRequest $request)
    {
        $request->validated();
        
        dispatch(new SendFeedbackFormCustomersMailJob($request->email, $request->content));

        dispatch(new SendContactMailJob($request->email));

        return redirect()->back()->with('success', 'Phản hồi của bạn đã được gửi đi');
    }
}
