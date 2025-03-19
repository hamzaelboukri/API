<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Vérifie si l'utilisateur authentifié possède l'un des rôles spécifiés.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $roles  Liste des rôles autorisés séparés par des pipes (|)
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $roles = null)
    {
        if (!$roles) {
            return $next($request);
        }

        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Non authentifié',
            ], 401);
        }

        $user = Auth::user();
        $allowedRoles = explode('|', $roles);

        if (!in_array($user->role, $allowedRoles)) {
            return response()->json([
                'success' => false,
                'message' => 'Accès non autorisé. Rôle(s) requis : ' . $roles,
            ], 403);
        }

        return $next($request);
    }
}