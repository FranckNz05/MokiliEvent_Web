<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait HasFollowers
{
    /**
     * Les utilisateurs qui suivent ce modèle
     */
    public function followers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'followers', 'following_id', 'follower_id')
                    ->withTimestamps();
    }

    /**
     * Les utilisateurs que ce modèle suit
     */
    public function followings(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'following_id')
                    ->withTimestamps();
    }

    /**
     * Vérifie si l'utilisateur suit un autre utilisateur
     */
    public function isFollowing(User $user): bool
    {
        return $this->followings()->where('following_id', $user->id)->exists();
    }

    /**
     * Suivre un utilisateur
     */
    public function follow(User $user): void
    {
        if (!$this->isFollowing($user)) {
            $this->followings()->attach($user->id);
        }
    }

    /**
     * Ne plus suivre un utilisateur
     */
    public function unfollow(User $user): void
    {
        $this->followings()->detach($user->id);
    }
}
