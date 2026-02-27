<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\YandexApi;

class ReviewsController extends Controller
{

    // Этот метод для теста, возвращает 20 фиктивных отзывов
    public function getReviewsTest(Request $request)
    {
        $reviews = [
            ['01.01.2026', 'Анна', 5, 'Отличное место, всё понравилось.'],
            ['03.01.2026', 'Игорь', 4, 'Хороший сервис, вернусь снова.'],
            ['05.01.2026', 'Мария', 5, 'Очень уютная атмосфера.'],
            ['07.01.2026', 'Дмитрий', 3, 'Неплохо, но есть куда расти.'],
            ['09.01.2026', 'Елена', 5, 'Персонал вежливый и внимательный.'],
            ['11.01.2026', 'Алексей', 4, 'Всё быстро и качественно.'],
            ['13.01.2026', 'Ольга', 5, 'Лучшее место в городе!'],
            ['15.01.2026', 'Сергей', 4, 'Приятный интерьер.'],
            ['17.01.2026', 'Наталья', 5, 'Очень довольна посещением.'],
            ['19.01.2026', 'Виктор', 4, 'Хорошее соотношение цены и качества.'],
            ['21.01.2026', 'Татьяна', 5, 'Замечательное обслуживание.'],
            ['23.01.2026', 'Артем', 3, 'Средне, ожидал большего.'],
            ['25.01.2026', 'Ирина', 5, 'Рекомендую друзьям.'],
            ['27.01.2026', 'Максим', 4, 'Всё на уровне.'],
            ['29.01.2026', 'Юлия', 5, 'Очень приятные впечатления.'],
            ['30.01.2026', 'Роман', 4, 'Хорошее качество услуг.'],
            ['31.01.2026', 'Ксения', 5, 'Прекрасное место для отдыха.'],
            ['01.02.2026', 'Павел', 4, 'Обязательно приду снова.'],
            ['02.02.2026', 'Светлана', 5, 'Всё было идеально.'],
            ['02.02.2026', 'Михаил', 4, 'Понравилось, спасибо!'],
        ];

        $formatted = [];
        $sum = 0;

        foreach ($reviews as $r) {
            $sum += $r[2];

            $formatted[] = [
                'date'   => $r[0],
                'author' => $r[1],
                'rating' => $r[2],
                'text'   => $r[3],
            ];
        }

        $average = round($sum / count($formatted), 1);

        return response()->json([
            'reviews' => $formatted,
            'rating'  => $average
        ]);
    }

    // Этот метод для реального получения отзывов с Яндекса (пока не используется, так как может быть блокировка при частых запросах)
    public function getReviews(Request $request)
    {
        $user = $request->user();

        $yandex = YandexApi::where('user_id', $user->id)->first();

        if (!$yandex || !$yandex->yandex_url) {
            return response()->json([
                'reviews' => [],
                'score' => null,
                'count' => 0
            ]);
        }

        // Достаём org_id из ссылки
        if (!preg_match('#/(\d+)/reviews#', $yandex->yandex_url, $matches)) {
            return response()->json(['message' => 'Invalid Yandex URL'], 400);
        }

        // Можно попробовать потом напрямую ту ссылку что дает пользователь, но сейчас так
        $orgId = $matches[1];
        $url = "https://yandex.ru/maps/org/{$orgId}/reviews/";

        // Получаем HTML страницы
        $response = Http::withHeaders([
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)'
        ])->get($url);

        if (!$response->ok()) {
            return response()->json(['message' => 'Failed to fetch page'], 500);
        }

        $html = $response->body();

        // Обрезаем только блок с отзывами
        $start = strpos($html, 'reviews-view__reviews');
        if ($start === false) {
            return response()->json(['reviews' => []]);
        }

        $htmlPart = substr($html, $start, 200000); // ограничим размер

        // Парсим HTML
        libxml_use_internal_errors(true);

        $dom = new \DOMDocument();
        $dom->loadHTML('<?xml encoding="UTF-8">' . $htmlPart);

        $xpath = new \DOMXPath($dom);

        $reviews = [];

        $reviewNodes = $xpath->query("//*[contains(@class, 'business-review-view')]");

        foreach ($reviewNodes as $node) {

            $review = [];

            // Автор
            $authorNode = $xpath->query(".//*[contains(@class,'business-review-view__author')]//span", $node);
            if ($authorNode->length > 0) {
                $review['author'] = trim($authorNode->item(0)->nodeValue);
            }

            // Дата
            $dateNode = $xpath->query(".//*[contains(@class,'business-review-view__date')]//meta", $node);
            if ($dateNode->length > 0) {
                $review['date'] = $dateNode->item(0)->nodeValue;
            }

            // Текст
            $textNode = $xpath->query(".//*[contains(@class,'business-review-view__body-text')]", $node);
            if ($textNode->length > 0) {
                $review['text'] = trim($textNode->item(0)->nodeValue);
            }

            if (!empty($review)) {
                $reviews[] = $review;
            }
        }

        return response()->json([
            'reviews' => $reviews,
            'rating' => count($reviews)
        ]);
    }
}