<?php

namespace Graywings\Etter\Tests\Units;

use Graywings\Etter\Etter;
use Graywings\Etter\Get;
use Graywings\Etter\Set;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use ReflectionException;

#[CoversClass(Etter::class)]
class EtterTest extends TestCase
{
    public function testGetter(): void
    {
        $sample = new Sample(1, 1, 1);
        $this->assertSame(1, $sample->value1);
    }

    public function testGetterDoesntHaveAttribute(): void
    {
        $this->expectException(ReflectionException::class);
        $this->expectExceptionMessage('Property value2 is not attributed by Get class.');
        $sample = new Sample(1, 1, 1);
        $sample->value2;
    }

    public function testGetterDoesntExist(): void
    {
        $this->expectException(ReflectionException::class);
        $this->expectExceptionMessage('Property Graywings\Etter\Tests\Units\Sample::$value3 does not exist');
        $sample = new Sample(1, 1, 1);
        $sample->value3;
    }

    public function testGetterStatic(): void
    {
        $this->expectException(ReflectionException::class);
        $this->expectExceptionMessage('Property staticValue1 is static. Not supported.');
        $sample = new Sample(1, 1, 1);
        $sample->staticValue1;
    }

    public function testSetter(): void
    {
        $sample = new Sample(1, 1, 1);
        $sample->value4 = 2;
        $this->assertSame(2, $sample->value4);
    }

    public function testSetterDoesntHaveAttribute(): void
    {
        $this->expectException(ReflectionException::class);
        $this->expectExceptionMessage('Property value1 is not attributed by Set class.');
        $sample = new Sample(1, 1, 1);
        $sample->value1 = 2;
    }

    public function testSetterDoesntExists(): void
    {
        $this->expectException(ReflectionException::class);
        $this->expectExceptionMessage('Property Graywings\Etter\Tests\Units\Sample::$value3 does not exist');
        $sample = new Sample(1, 1, 1);
        $sample->value3 = 2;
    }

    public function testSetterStatic(): void
    {
        $this->expectException(ReflectionException::class);
        $this->expectExceptionMessage('Property staticValue2 is static. Not supported.');
        $sample = new Sample(1, 1, 1);
        $sample->staticValue2 = 2;
    }
}

class Sample
{
    use Etter;

    #[Get]
    private static $staticValue1;

    #[Get] #[Set]
    private static $staticValue2;

    public function __construct(
        #[Get]
        private int $value1,
        private int $value2,
        #[Get]
        #[Set]
        private int $value4
    ) {
    }
}
