<?php

namespace App\Services;

use App\Models\Attempt;
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

    public function createAttemptByLink($linkId): ?Attempt
    {
        try {

            $value = random_int(1, 1000);
            $result = $value % 2 === 0 ? Attempt::RESULT_WIN : Attempt::RESULT_LOSE;

            return Attempt::create([
                'link_id' => $linkId,
                'value' => $value,
                'result' => $result,
                'prize' => $result === Attempt::RESULT_LOSE ? 0 : $this->_calculatePrize($value),
            ]);
        } catch (\Throwable $exception) {
            return null;
        }
    }

    /**
     * @param $value
     *
     * If value attribute > 900, prize = 70% of value.
     * If value attribute > 600, prize = 50% of value.
     * If value attribute > 300, prize = 30% of value.
     * If value attribute <= 300, prize = 10% of value.
     *
     * @return float
     */
    private function _calculatePrize($value): float
    {
        if ($value > 900) {
            $prize = $value * 0.7;
        } elseif ($value > 600) {
            $prize = $value * 0.5;
        } elseif ($value > 300) {
            $prize = $value * 0.3;
        } else {
            $prize = $value * 0.1;
        }
        return round($prize, 2);
    }
}
