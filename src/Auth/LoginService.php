<?php

declare(strict_types=1);

namespace App\Auth;

final class LoginService
{
    private object $connection;
    private string $table;

    public function __construct(object $connection, string $table = 'usuario')
    {
        $this->connection = $connection;
        $this->table = $table;
    }

    public function authenticate(string $userOrEmail, string $password): ?array
    {
        $sql = "SELECT Nombre_usuario, Apellido_usuario, Correo_usuario, Contraseña_usuario, ID_Rol FROM {$this->table} WHERE Correo_usuario = ? OR Nombre_usuario = ? LIMIT 1";
        $stmt = $this->connection->prepare($sql);

        if ($stmt === false) {
            return null;
        }

        $stmt->bind_param('ss', $userOrEmail, $userOrEmail);
        $stmt->execute();

        $result = $stmt->get_result();
        if ($result === false) {
            return null;
        }

        $row = $result->fetch_assoc();
        if ($row === null || !isset($row['Contraseña_usuario'])) {
            return null;
        }

        if (!password_verify($password, $row['Contraseña_usuario'])) {
            return null;
        }

        return [
            'nombre' => $row['Nombre_usuario'] ?? '',
            'apellido' => $row['Apellido_usuario'] ?? '',
            'correo' => $row['Correo_usuario'] ?? '',
            'rol' => isset($row['ID_Rol']) ? (int) $row['ID_Rol'] : 0,
        ];
    }
}
