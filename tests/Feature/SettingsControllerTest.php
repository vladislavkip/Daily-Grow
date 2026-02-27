<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

class SettingsControllerTest extends TestCase
{

public function test_settings_require_authentication()
    {
        $response = $this->postJson('/settings/yandex', [
            'yandex_url' => 'test'
        ]);

        $response->assertStatus(401);
    }

    //если пользователь не установил yandex_url, то возвращаем пустую строку
   /* public function test_get_yandex_url_returns_empty_string_if_not_set()
    {
        $user = User::find(1); //создаём тестового пользователя в миграции, чтобы не плодить лишних в БД

        $response = $this->actingAs($user)
            ->getJson('/settings/yandex');

        $response->assertStatus(200)
            ->assertJson([
                'yandex_url' => ''
            ]);
    }*/

    // Проверяем, что пользователь может сохранить yandex_url

       /*public function test_user_can_save_yandex_url()
    {
        $user = User::find(1);

        $response = $this->actingAs($user)
            ->postJson('/settings/yandex', [
                'yandex_url' => 'https://yandex.ru/maps/org/test/123/reviews/'
            ]);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Yandex URL saved'
            ]);

        $this->assertDatabaseHas('yandex_apis', [
            'user_id' => $user->id
        ]);
    } */

        public function test_yandex_url_validation_fails_if_empty()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->postJson('/settings/yandex', [
                'yandex_url' => ''
            ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['yandex_url']);
    }

        
}

