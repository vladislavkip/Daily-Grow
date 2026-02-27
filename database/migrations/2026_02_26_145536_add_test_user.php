<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

// Создаём тестового пользователя
// В down() удаляем пользователя и его сессии
return new class extends Migration
{
    public function up(): void
    {
       User::updateOrCreate(
            ['email' => 'test@test.com'],
            [
                'name' => 'Test account',
                'password' => Hash::make('test'),
            ]
        );
    }

    public function down(): void
    {
        $user = User::where('email', 'test@test.com')->first();

        if ($user) {
            DB::table('sessions')->where('user_id', $user->id)->delete();
            $user->delete();
        }
    }
};
