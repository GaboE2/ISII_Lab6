<?php

declare(strict_types=1);

namespace App\Auth;

final class LoginController
{
    private LoginService $loginService;

    public function __construct(LoginService $loginService)
    {
        $this->loginService = $loginService;
    }

    public function handle(array $post, array $server, array &$session): array
    {
        if (($server['REQUEST_METHOD'] ?? '') !== 'POST') {
            return ['redirect' => '../diseño/login.html'];
        }

        $user = trim((string) ($post['usuario'] ?? ''));
        $password = (string) ($post['contraseña'] ?? '');

        if ($user === '' || $password === '') {
            return ['redirect' => '../diseño/login.html?error=Campos+requeridos'];
        }

        $userData = $this->loginService->authenticate($user, $password);
        if ($userData === null) {
            return ['redirect' => '../diseño/login.html?error=Usuario+o+contraseña+inválidos'];
        }

        $session['user'] = $userData;
        return ['redirect' => '../diseño/farmacia.html'];
    }
}
