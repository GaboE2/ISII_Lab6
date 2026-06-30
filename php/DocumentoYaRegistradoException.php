<?php
declare(strict_types=1);

/**
 * Excepción dedicada para cuando se intenta registrar un usuario
 * con un número de documento que ya existe.
 * Refactoring: Replace generic exception with dedicated exception.
 */
final class DocumentoYaRegistradoException extends RuntimeException
{
    public function __construct(string $numeroDocumento)
    {
        parent::__construct("Ya existe un usuario registrado con el documento: {$numeroDocumento}");
    }
}
