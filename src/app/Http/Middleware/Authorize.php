<?php

namespace App\Http\Middleware;

use App\Services\Permission\PermissionServiceInterface;
use Closure;

class Authorize
{
    private PermissionServiceInterface $permissionService;

    public function __construct(PermissionServiceInterface $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, string $permissionSlug)
    {
        if ($this->permissionService->can(auth()->user()->role_id, $permissionSlug)) {
            return $next($request);
        }
        
        return response()->json(['message' => 'Unauthorized'], 401);
    }
}
