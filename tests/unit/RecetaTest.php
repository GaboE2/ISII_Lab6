<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../php/Consultas/Dominio/Receta.php';
require_once __DIR__ . '/../../php/Consultas/Dominio/DatosRegistroReceta.php';

class RecetaTest extends TestCase
{
    public function test_crea_receta_valida_correctamente()
    {
        $receta = new Receta(new DatosRegistroReceta(
            idConsulta: 10,
            idMedicamento: 2,
            dosis: '500mg cada 8 horas',
            instrucciones: 'Tomar con alimentos'
        ));

        $this->assertSame(10, $receta->getIdConsulta());
        $this->assertSame('500mg cada 8 horas', $receta->getDosis());
    }

    public function test_dosis_vacia_lanza_excepcion()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('dosis es obligatoria');

        new Receta(new DatosRegistroReceta(
            idConsulta: 10,
            idMedicamento: 2,
            dosis: '',
            instrucciones: ''
        ));
    }

    public function test_id_medicamento_invalido_lanza_excepcion()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('medicamento es obligatorio');

        new Receta(new DatosRegistroReceta(
            idConsulta: 10,
            idMedicamento: 0,
            dosis: '500mg',
            instrucciones: ''
        ));
    }
}
