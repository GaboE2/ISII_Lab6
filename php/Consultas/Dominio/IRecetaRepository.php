<?php
declare(strict_types=1);

require_once __DIR__ . '/Receta.php';

interface IRecetaRepository
{
    public function guardar(Receta $receta): bool;

    /**
     * Lista las recetas de un paciente con datos de medicamento y doctor.
     */
    public function buscarPorPaciente(int $idPaciente): array;
}
