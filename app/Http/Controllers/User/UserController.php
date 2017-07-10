<?php

namespace App\Http\Controllers\User;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class UserController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        return $this->showAll($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @todo:: Refactor!
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'     => 'required',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed'
        ]);

        $data = array_merge($request->all(), [
            'password'           => bcrypt($request->input('password')),
            'verified'           => User::UNVERIFIED_USER,
            'verification_token' => User::generateVerificationCode(),
            'admin'              => User::REGULAR_USER
        ]);

        $user = User::create($data);

        return $this->showOne($user, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function show(User $user)
    {
        return $this->showOne($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @todo:: Refactor!
     * @param  \Illuminate\Http\Request $request
     * @param User $user
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'email'    => 'email|unique:users,email,' . $user->id,
            'password' => 'min:6|confirmed',
            'admin'    => 'in:' . User::ADMIN_USER . ',' . User::REGULAR_USER
        ]);

        if ($request->has('name')) {
            $user->name = $request->input('name');
        }

        if ($request->has('email') && $user->email !== $request->input('email')) {
            $user->verified = User::UNVERIFIED_USER;
            $user->verification_token = User::generateVerificationCode();
            $user->email = $request->input('email');
        }

        if ($request->has('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        if ($request->has('admin')) {
            if (!$user->isVerified()) {
                return $this->errorResponse('Only verified users', 409);
            }

            $user->admin = $request->input('admin');
        }

        if (!$user->isDirty()) {
            return $this->errorResponse('Need specify diff', 422);
        }

        $user->save();

        return $this->showOne($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     * @throws \Exception
     * @internal param int $id
     */
    public function destroy(User $user)
    {
        $user->delete();

        return $this->showOne($user);
    }
}
