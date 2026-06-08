<?php

declare(strict_types=1);

namespace Tests\Functional;

use App\Auth\LoginController;
use App\Auth\LoginService;
use PHPUnit\Framework\TestCase;

final class LoginFlowTest extends TestCase
{
    public function test_valid_credentials_redirect_to_farmacia_and_set_session(): void
    {
        $result = new class {
            public function fetch_assoc(): ?array
            {
                return [
                    'Nombre_usuario' => 'Jose',
                    'Apellido_usuario' => 'Perez',
                    'Correo_usuario' => 'jose@example.com',
                    'Contraseña_usuario' => password_hash('secret123', PASSWORD_DEFAULT),
                    'ID_Rol' => '4',
                ];
            }
        };

        $stmt = new class ($result) {
            private object $result;

            public function __construct(object $result)
            {
                $this->result = $result;
            }

            public function bind_param(string $types, string $user, string $email): bool
            {
                return true;
            }

            public function execute(): bool
            {
                return true;
            }

            public function get_result(): object
            {
                return $this->result;
            }
        };

        $connection = new class ($stmt) {
            private object $stmt;

            public function __construct(object $stmt)
            {
                $this->stmt = $stmt;
            }

            public function prepare(string $sql): object
            {
                return $this->stmt;
            }
        };

        $controller = new LoginController(new LoginService($connection));
        $session = [];
        $response = $controller->handle(
            ['usuario' => 'jose@example.com', 'contraseña' => 'secret123'],
            ['REQUEST_METHOD' => 'POST'],
            $session
        );

        self::assertSame('../diseño/farmacia.html', $response['redirect']);
        self::assertArrayHasKey('user', $session);
        self::assertSame('Jose', $session['user']['nombre']);
    }

    public function test_invalid_credentials_redirect_back_to_login(): void
    {
        $result = new class {
            public function fetch_assoc(): ?array
            {
                return [
                    'Nombre_usuario' => 'Jose',
                    'Apellido_usuario' => 'Perez',
                    'Correo_usuario' => 'jose@example.com',
                    'Contraseña_usuario' => password_hash('secret123', PASSWORD_DEFAULT),
                    'ID_Rol' => '4',
                ];
            }
        };

        $stmt = new class ($result) {
            private object $result;

            public function __construct(object $result)
            {
                $this->result = $result;
            }

            public function bind_param(string $types, string $user, string $email): bool
            {
                return true;
            }

            public function execute(): bool
            {
                return true;
            }

            public function get_result(): object
            {
                return $this->result;
            }
        };

        $connection = new class ($stmt) {
            private object $stmt;

            public function __construct(object $stmt)
            {
                $this->stmt = $stmt;
            }

            public function prepare(string $sql): object
            {
                return $this->stmt;
            }
        };

        $controller = new LoginController(new LoginService($connection));
        $session = [];
        $response = $controller->handle(
            ['usuario' => 'jose@example.com', 'contraseña' => 'wrong-password'],
            ['REQUEST_METHOD' => 'POST'],
            $session
        );

        self::assertSame('../diseño/login.html?error=Usuario+o+contraseña+inválidos', $response['redirect']);
        self::assertArrayNotHasKey('user', $session);
    }
}
