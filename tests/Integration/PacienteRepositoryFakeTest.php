<?php
declare(strict_types=1);
namespace Tests\Integration;

use App\Domain\Entity\Paciente;
use App\Domain\Repository\PacienteRepositoryInterface;
use PHPUnit\Framework\TestCase;

class PacienteRepositoryFake implements PacienteRepositoryInterface {
    private array $pacientes = [];

    public function save(Paciente $paciente): bool {
        $this->pacientes[$paciente->toArray()['dni']] = $paciente;
        return true;
    }

    public function findAll(): array {
        return $this->pacientes;
    }
}

final class PacienteRepositoryFakeTest extends TestCase {
    public function test_guarda_y_recupera_pacientes_en_memoria(): void {
        $repository = new PacienteRepositoryFake();
        $paciente = new Paciente('Ana', 'Lopez', '12345678');
        
        $result = $repository->save($paciente);
        
        self::assertTrue($result);
        self::assertCount(1, $repository->findAll());
        self::assertSame('Ana', $repository->findAll()['12345678']->toArray()['nombre']);
    }
}
