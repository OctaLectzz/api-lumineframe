<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();

        return UserResource::collection($users);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'avatar' => 'nullable',
            'first_name' => 'required|string|max:100',
            'last_name' => 'nullable|string|max:100',
            'email' => 'required|string|email|unique:users,email|max:100',
            'password' => 'required|string|min:8',
            'passwordConfirmation' => 'required|same:password',
            'birthday' => 'nullable|date',
            'gender' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:15',
            'url' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'status' => 'required'
        ]);

        // Avatar
        if ($request->hasFile('avatar')) {
            $avatarName = time() . '-' . auth()->id() . '_' . $request->avatar->getClientOriginalExtension();
            $request->avatar->move(public_path('avatars'), $avatarName);
            $data['avatar'] = $avatarName;
        }

        // Status
        $status = ($request->status === true) ? 1 : 0;
        $data['status'] = $status;

        $user = User::create($data);

        return response()->json([
            'status' => 'Success',
            'message' => 'User Created Successfully',
            'data' => new UserResource($user)
        ]);
    }

    public function show(User $user)
    {
        return response()->json([
            'data' => new UserResource($user)
        ]);
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'avatar' => 'nullable',
            'first_name' => 'required|string|max:100',
            'last_name' => 'nullable|string|max:100',
            'email' => 'required|string|email|max:100',
            'password' => 'required|string|min:8',
            'passwordConfirmation' => 'required|same:password',
            'birthday' => 'nullable|date',
            'gender' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:15',
            'url' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'status' => 'required'
        ]);

        // Avatar
        if ($request->hasFile('avatar')) {
            if ($user->avatar && file_exists(public_path('avatars/' . $user->avatar))) {
                unlink(public_path('avatars/' . $user->avatar));
            }

            $avatarName = time() . '-' . auth()->id() . '_' . $request->avatar->getClientOriginalExtension();
            $request->avatar->move(public_path('avatars'), $avatarName);
            $data['avatar'] = $avatarName;
        }

        // Status
        $status = ($request->status === true) ? 1 : 0;
        $data['status'] = $status;

        $user->update($data);

        return response()->json([
            'status' => 'Success',
            'message' => 'User Edited Successfully',
            'data' => new UserResource($user)
        ]);
    }

    public function destroy(User $user)
    {
        if ($user->avatar && File::exists(public_path('avatars/' . $user->avatar))) {
            File::delete(public_path('avatars/' . $user->avatar));
        }

        $user->delete();

        return response()->json([
            'status' => 'Success',
            'message' => 'User Deleted Successfully'
        ]);
    }
}
