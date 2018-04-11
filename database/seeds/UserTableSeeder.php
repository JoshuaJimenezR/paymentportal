<?php

use App\Role;
use App\User;
use Illuminate\Database\Seeder;


class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        $user = new User();

        $user->username = "admin";
        $user->email = "admin@panamamedicalsupplies.com";
        $user->alias = "123456";
        $user->password = bcrypt('panama');
        $user->save();

        $role = Role::find(1);

        $user->attachRole($role);
    }
}
