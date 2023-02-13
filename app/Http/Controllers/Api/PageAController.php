<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AttemptResource;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;

class PageAController extends Controller
{
    public function play(string $hash, UserService $userService): JsonResponse|AttemptResource
    {
        $link = $userService->getUserLink(Auth::id(), $hash);

        if (!$link) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid link.',
            ], 400);
        }

        if (!$attempt = $userService->createAttemptByLink($link->id)) {
            return response()->json([
                'success' => false,
                'message' => 'Error while create attempt. Please thy again.',
            ], 400);
        }

        return new AttemptResource($attempt);
    }

    public function history(string $hash, UserService $userService): JsonResponse|ResourceCollection
    {
        $link = $userService->getUserLink(Auth::id(), $hash);

        if (!$link) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid link',
            ], 400);
        }

        $history = $link->attempts()->latest()->limit(3)->get();
        return AttemptResource::collection($history);
    }
}
