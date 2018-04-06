<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use App\Role;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $users = User::paginate(15);
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {

        $roles = Role::all();
        return view('users.create', compact("roles"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {

       $this->validate($request, [
            'username' => 'required|string|min:4|max:255|unique:users',
            'alias' => 'required|string|max:6|unique:users',
            'email' => 'required|string|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $role = Role::find($request->input('role'));

        $user = new User();

        $user->username = $request['username'];
        $user->email = $request['email'];
        $user->alias = $request['alias'];
        $user->password = bcrypt($request['password']);
        $user->save();

        $user->attachRole($role);

        return redirect('/users');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {

        $roles = Role::all();
        $user = User::find($id);

        return view('users.edit', compact('user','roles' ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {

        $user = User::find($id);

        $role = Role::find($request->input('role'));

        $this->validate($request, [
            'username' => 'required|string|min:4|max:255|unique:users,username,'.$user->id,
            'alias' => 'required|string|max:6|unique:users,alias,'.$user->id,
            'email' => 'unique:users,email,'.$user->id,
        ]);

        $user->username = $request['username'];
        $user->email = $request['email'];
        $user->alias = $request['alias'];

        if(!empty($request['new_password'])){
            $user->password = bcrypt($request['new_password']);
        }

        $user->save();

        DB::table('role_user')->where('user_id', '=', $user->id)->delete();

        $user->attachRole($role);

        return redirect('/users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
