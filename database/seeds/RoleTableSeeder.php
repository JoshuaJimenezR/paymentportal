<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        $admin = new Role();
        $admin->name         = 'admin';
        $admin->display_name = 'Project Admin'; // optional
        $admin->description  = ''; // optional
        $admin->save();

        $user = new Role();
        $user->name         = 'user';
        $user->display_name = 'User'; // optional
        $user->description  = ''; // optional
        $user->save();
    }
}
