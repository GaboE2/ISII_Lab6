<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Auth\LoginService;
use PHPUnit\Framework\TestCase;

final class LoginServiceTest extends TestCase
{
    public function test_authenticate_returns_user_data_when_password_matches(): void
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

        $mysqli = new class ($stmt) {
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

        $service = new LoginService($mysqli);
        $userData = $service->authenticate('jose@example.com', 'secret123');

        self::assertSame(
            [
                'nombre' => 'Jose',
                'apellido' => 'Perez',
                'correo' => 'jose@example.com',
                'rol' => 4,
            ],
            $userData
        );
    }

    public function test_authenticate_returns_null_when_password_does_not_match(): void
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

        $mysqli = new class ($stmt) {
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

        $service = new LoginService($mysqli);
        $userData = $service->authenticate('jose@example.com', 'wrong-password');

        self::assertNull($userData);
    }
}
