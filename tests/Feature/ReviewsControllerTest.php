<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\YandexApi;
use Illuminate\Support\Facades\Http;

class ReviewsControllerTest extends TestCase
{

    public function test_reviews_require_authentication()
    {
        $response = $this->getJson('/reviews/data');

        $response->assertStatus(401);
    }

    public function test_get_reviews_test_returns_20_reviews_and_correct_average()
    {
        $user = User::find(1);

        $response = $this->actingAs($user)
            ->getJson('/reviews/data');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'reviews' => [
                    '*' => ['date', 'author', 'rating', 'text']
                ],
                'rating'
            ]);

        $data = $response->json();

        $this->assertCount(20, $data['reviews']);

        
        $ratings = array_column($data['reviews'], 'rating');
        $expectedAverage = round(array_sum($ratings) / count($ratings), 1);
        dump($data['rating']);
        dump($expectedAverage);
        $this->assertEquals($expectedAverage, $data['rating']);
    }


    // Поменял метод
    /*public function test_get_reviews_returns_empty_if_no_yandex_url()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->getJson('/reviews/data');

        $response->assertStatus(200)
            ->assertJson([
                'reviews' => [],
                'score' => null,
                'count' => 0
            ]);
    }*/

/*
// Тоже уже не актуально
    public function test_get_reviews_returns_400_for_invalid_url()
    {
        $user = User::factory()->create();

        YandexApi::create([
            'user_id' => $user->id,
            'yandex_url' => 'invalid-url'
        ]);

        $response = $this->actingAs($user)
            ->getJson('/reviews/data');

        $response->assertStatus(400)
            ->assertJson([
                'message' => 'Invalid Yandex URL'
            ]);
    }

*/

}
