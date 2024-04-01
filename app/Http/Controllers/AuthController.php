<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserResource;

class AuthController extends Controller
{
    public function profile(User $user)
    {
        $user = auth()->user();

        return response()->json([
            'data' => new UserResource($user)
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'avatar' => 'nullable',
            'first_name' => 'required|string|max:50',
            'last_name' => 'nullable|string|max:50',
            'email' => 'required|string|email|unique:users,email|max:100',
            'password' => 'required|min:8',
            'repassword' => 'required|same:password',
            'birthday' => 'nullable|date',
            'gender' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:15',
            'url' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255'
        ]);
        $input = $request->all();

        // Avatar
        if ($request->hasFile('avatar')) {
            $avatarName = time() . '-' . auth()->id() . '_' . $request->avatar->getClientOriginalExtension();
            $request->avatar->move(public_path('avatars'), $avatarName);
            $input['avatar'] = $avatarName;
        }

        // Password
        $input['password'] = bcrypt($input['password']);

        $user = User::create($input);

        $token =  $user->createToken('luminaframe')->plainTextToken;
        $data = [
            'token' => $token,
            'name' => $user->first_name . $user->last_name,
            'email' => $user->email,
            'role' => $user->role
        ];

        Auth::login($user);

        return response()->json([
            'status' => 'Success',
            'message' => 'Register Successfully',
            'data' => $data
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = User::where('email', $request->email)->first();
            $data['token'] =  $user->createToken('luminaframe')->plainTextToken;
            $data['name'] =  $user->name;
            $data['role'] =  $user->role;

            return response()->json([
                'status' => 'Success',
                'message' => 'Login Successfully',
                'data' => $data
            ]);
        } else {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Email or Password Failed, Please try again later'
            ]);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => 'Success',
            'message' => 'Logout Successfully'
        ]);
    }
}