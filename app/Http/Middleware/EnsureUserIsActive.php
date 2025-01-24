<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;

class EnsureUserIsActive
{
    
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user(); // Obtener el usuario autenticado

        // Verificar si el usuario está activo
        if ($user && !$user->active) {
            Auth::logout(); // Cerrar sesión si está inactivo

            // Mostrar mensaje de advertencia con Filament Notifications
            Notification::make()
                ->title('Cuenta Inactiva')
                ->body('Tu cuenta está inactiva. Contacta al administrador.')
                ->danger() // Tipo de alerta (rojo)
                ->send();

            // Redirigir con un mensaje de error
            return redirect()->route('filament.admin.auth.login');
                
        }
        return $next($request);
    }
}
