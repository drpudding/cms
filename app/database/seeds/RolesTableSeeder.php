<?php

class RolesTableSeeder extends Seeder {

    public function run()
    {
        DB::table('roles')->delete();

        $adminRole = new Role;
        $adminRole->name = 'admin';
        $adminRole->save();

        $memberRole = new Role;
        $memberRole->name = 'member';
        $memberRole->save();

        $bannedRole = new Role;
        $bannedRole->name = 'banned';
        $bannedRole->save();

        $user = User::where('username','=','admin')->first();
        $user->attachRole( $adminRole );

        $user = User::where('username','=','member')->first();
        $user->attachRole( $memberRole );

        $user = User::where('username','=','banned')->first();
        $user->attachRole( $bannedRole );
    }

}
