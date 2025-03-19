<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class JwtAuthentication
{
    /**
     * Middleware pour vérifier l'authentification JWT.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $roles
     * @return mixed
     */
    public function handle($request, Closure $next, $roles = null)
    {
        try {
            // Vérifier si le token est présent et valide
            $user = JWTAuth::parseToken()->authenticate();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Utilisateur non trouvé'
                ], 404);
            }
            
            // Vérifier les rôles si spécifiés
            if ($roles !== null) {
                $rolesArray = explode('|', $roles);
                
                if (!in_array($user->role, $rolesArray)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Accès non autorisé'
                    ], 403);
                }
            }
            
        } catch (TokenExpiredException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Token expiré',
                'error' => 'token_expired'
            ], 401);
        } catch (TokenInvalidException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Token invalide',
                'error' => 'token_invalid'
            ], 401);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Token non trouvé',
                'error' => 'token_absent'
            ], 401);
        }
        
        return $next($request);
    }
}