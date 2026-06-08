<?php

declare(strict_types=1);

namespace Farmacia\Tests\Sistema;

use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;

final class EjemploMockeryTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function test_mockery_puede_simular_un_metodo(): void
    {
        $mock = \Mockery::mock();
        $mock->shouldReceive('getValue')
             ->once()
             ->andReturn('mocked');

        $this->assertSame('mocked', $mock->getValue());
    }
}

