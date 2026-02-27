<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\YandexApi;

class SettingsController extends Controller
{
    // Получить текущий yandex_url
    public function getYandexUrl()
    {
        $user = Auth::user();

        $record = YandexApi::where('user_id', $user->id)->first();

        return response()->json([
            'yandex_url' => $record->yandex_url ?? ''
        ]);
    }

    // Сохранить или обновить yandex_url
    public function saveYandexUrl(Request $request)
    {
        $request->validate([
            'yandex_url' => 'required|string|max:255',
        ]);

        $user = Auth::user();

        $record = YandexApi::updateOrCreate(
            ['user_id' => $user->id],
            ['yandex_url' => $request->yandex_url]
        );

        return response()->json([
            'message' => 'Yandex URL saved',
            'yandex_url' => $record->yandex_url
        ]);
    }
}