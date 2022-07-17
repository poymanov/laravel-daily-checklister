<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\User\Contracts\UserServiceContract;
use Illuminate\Support\Facades\Log;
use Throwable;

class UserController extends Controller
{
    public function __construct(private UserServiceContract $userService)
    {
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        try {
            $users = $this->userService->findAllNotAdminLatest();

            return view('admin.user.index', compact('users'));
        } catch (Throwable $e) {
            Log::error($e);

            return redirect()->route('page.welcome')->with('alert.error', 'Something went wrong');
        }
    }
}
