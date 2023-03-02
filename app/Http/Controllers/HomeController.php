<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function verifyEmail(Request $request)
    {
        // Find the user by verification token
        $user = User::where('verification_token', $request->input('verification_token'))->firstOrFail();
    
        // Mark the user's email address as verified
        $user->email_verified_at = Carbon::now();
        $user->verification_token = null;
        $user->save();
    
        return '';
    }
}
