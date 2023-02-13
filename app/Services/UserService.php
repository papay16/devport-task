<?php

namespace App\Services;

use App\Models\Link;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserService
{
    public function createNewUser(array $userData): User|bool
    {
        try {
            DB::beginTransaction();

            $model = User::firstOrCreate($userData);
            $model->links()->create([
                'hash' => Str::uuid(),
                'expires_at' => now()->addDays(7),
            ]);

            DB::commit();
        } catch (\Throwable $exception) {
            DB::rollBack();
            return false;
        }


        return $model;
    }

    public function createNewLinkForUser($userId): Link
    {
        $user = User::findOrFail($userId);
        /**
         * @var Link $link
         */
        $link = $user->links()->create([
            'hash' => Str::uuid(),
            'expires_at' => now()->addDays(7),
        ]);

        return $link;
    }

    public function getUserLinks(int $userId): Collection
    {
        return Link::whereUserId($userId)
            ->active()
            ->latest()
            ->get();
    }

    public function getUserLink(int $userId, string $linkHash): ?Link
    {
        return Link::whereUserId($userId)
            ->whereHash($linkHash)
            ->active()
            ->first();
    }

    public function userHasLink(int $userId, string $linkHash): bool
    {
        return (bool) $this->getUserLink($userId, $linkHash);
    }

    public function deactivateLink($linkHash): bool
    {
        $link = Link::whereHash($linkHash)->first();

        if (!$link) {
            return false;
        }

        $link->expires_at = now();

        return $link->save();
    }
}
