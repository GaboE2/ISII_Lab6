<?php

declare(strict_types=1);

namespace Farmacia\Tests;

use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;

final class ExampleTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * MockeryPHPUnitIntegration ejecuta TearDown para cerrar expectativas (equivalente xUnit).
     */

    public function test_framework_is_loaded(): void
    {
        $this->assertTrue(true);
    }

    public function test_mockery_double(): void
    {
        $dep = Mockery::mock();
        $dep->shouldReceive('valor')->once()->andReturn(7);

        $this->assertSame(7, $dep->valor());
    }
}
