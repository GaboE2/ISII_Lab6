<?php
declare(strict_types=1);

/**
 * Interfaz del repositorio de Usuario.
 * Permite mockear el acceso a datos en los tests del Application Service,
 * independientemente de la implementación concreta (UsuarioRepository con PDO).
 */
interface IUsuarioRepository
{
    /** Persiste un Usuario nuevo. Retorna true si tuvo éxito. */
    public function guardar(Usuario $usuario): bool;

    /** Busca un usuario por número de documento. Retorna array de datos o null si no existe. */
    public function buscarPorDocumento(string $numeroDocumento): ?array;
}
