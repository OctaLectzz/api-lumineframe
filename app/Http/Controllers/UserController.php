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
            'username' => 'required|string|max:15|unique:users,username',
            'first_name' => 'required|string|max:15',
            'last_name' => 'nullable|string|max:15',
            'email' => 'required|string|email|unique:users,email|max:100',
            'password' => 'required|string|min:8',
            'passwordConfirmation' => 'required|same:password',
            'phone' => 'nullable|string|max:15',
            'role' => 'nullable|string',
            'pronouns' => 'nullable|string|max:20',
            'url' => 'nullable|string|max:255',
            'birthday' => 'nullable|date',
            'gender' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'about' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:255'
        ]);

        // Avatar
        if ($request->hasFile('avatar')) {
            $avatarName = time() . '-' . auth()->user()->username . '_' . $request->avatar->getClientOriginalExtension();
            $request->avatar->move(public_path('avatars'), $avatarName);
            $data['avatar'] = $avatarName;
        }

        $user = User::create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'User Created Successfully',
            'data' => new UserResource($user)
        ]);
    }

    public function show($username)
    {
        $user = User::where('username', $username)->firstOrFail();

        return response()->json([
            'data' => new UserResource($user)
        ]);
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'username' => 'required|string|max:15',
            'first_name' => 'required|string|max:15',
            'last_name' => 'nullable|string|max:15',
            'email' => 'required|string|email|max:100',
            'phone' => 'nullable|string|max:15',
            'role' => 'nullable|string',
            'pronouns' => 'nullable|string|max:20',
            'url' => 'nullable|string|max:255',
            'birthday' => 'nullable|date',
            'gender' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'about' => 'nullable|string|max:100',
            'status' => 'required'
        ]);

        // Status
        $status = ($request->status === true) ? 1 : 0;
        $data['status'] = $status;

        $user->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'User Edited Successfully',
            'data' => new UserResource($user)
        ]);
    }

    public function updateavatar(Request $request, User $user)
    {
        $data = $request->validate([
            'avatar' => 'required|image'
        ]);

        if ($request->hasFile('avatar')) {
            if ($user->avatar && file_exists(public_path('avatars/' . $user->avatar))) {
                unlink(public_path('avatars/' . $user->avatar));
            }

            $avatarName = time() . '-' . auth()->user()->username . '_' . $request->avatar->getClientOriginalExtension();
            $request->avatar->move(public_path('avatars'), $avatarName);
            $data['avatar'] = $avatarName;
        }

        $user->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'User Avatar Edited Successfully',
            'data' => new UserResource($user)
        ]);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'User Deleted Successfully'
        ]);
    }
}
