<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Http\Response;

trait AuthorizesRoles
{
    /**
     * Authorize that the current user has any of the given roles.
     * Accepts a single role string or an array of roles.
     *
     * @param  array|string  $roles
     * @return void
     */
    protected function authorizeRole(array|string $roles): void
    {
        $roles = is_array($roles) ? $roles : [$roles];

        $user = auth()->user();

        if (! $user || ! $user->hasAnyRole($roles)) {
            abort(Response::HTTP_FORBIDDEN, 'Unauthorized');
        }
    }
}
