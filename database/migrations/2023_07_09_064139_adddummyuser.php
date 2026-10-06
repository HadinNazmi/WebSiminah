<?php

use App\Models\Adminkelurahan;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $user= new User();
        $user->name = 'adminkelurahan';
        $user->username = 'adminkelurahan';
        $user->email = 'adminkelurahan@gmail.com';
        $user->role = 'admin_kelurahan';
        $user->password = bcrypt('adminkelurahan');
        $user->save();

        $user1= new User();
        $user1->name = 'adminkelurahan2';
        $user1->username = 'adminkelurahan2';
        $user1->email = 'adminkelurahan2@gmail.com';
        $user1->role = 'admin_kelurahan';
        $user1->password = bcrypt('adminkelurahan');
        $user1->save();

        $user2= new User();
        $user2->name = 'admincsr';
        $user2->username = 'admincsr';
        $user2->email = 'admincsr@gmail.com';
        $user2->role = 'admin_csr';
        $user2->password = bcrypt('admincsr');
        $user2->save();

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
