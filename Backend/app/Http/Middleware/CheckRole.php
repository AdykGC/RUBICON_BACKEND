<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();
        
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Не авторизован'
            ], 401);
        }
        
        // Проверяем через Spatie
        foreach ($roles as $role) {
            if ($user->hasRole($role)) {
                return $next($request);
            }
        }
        
        // Проверяем синонимы ролей
        $roleSynonyms = [
            'Manager' => ['Manager', 'Admin', 'Owner', 'CEO'],
            'Client' => ['Client', 'Client VIP'],
            'Employee' => ['Employee', 'Slave', 'Seller', 'Counter', 'Lawyer', 'HR'],
        ];
        
        foreach ($roleSynonyms as $mainRole => $synonyms) {
            if (in_array($mainRole, $roles)) {
                foreach ($synonyms as $synonym) {
                    if ($user->hasRole($synonym)) {
                        return $next($request);
                    }
                }
            }
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Доступ запрещен. Требуемые роли: ' . implode(', ', $roles)
        ], 403);
    }
}