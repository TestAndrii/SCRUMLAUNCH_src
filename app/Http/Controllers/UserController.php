<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        return view('users.index');
    }

    public function search(Request $request)
    {
//        $user = User::find($request->input('user_id'));
        try {
            $user = $this->userService->search($request->input('user_id'));
        } catch (ModelNotFoundException $exception){
            return back()->withError($exception->getMessage())->withInput();
        }

        return view('users.search', compact('user'));
    }


}
