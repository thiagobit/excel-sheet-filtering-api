<?php

namespace Tests\Unit\Traits;

use App\Traits\ConversionTrait;
use PHPUnit\Framework\TestCase;

class ConversionTraitTest extends TestCase
{
    use ConversionTrait;

    /**
     * @test
     */
    public function convertToGB_can_convert_TB()
    {
        $this->assertEquals(2048, $this->convertToGB(1, 2, 'TB'));

        $this->assertEquals(6144, $this->convertToGB(2, 3, 'TB'));
    }

    /**
     * @test
     */
    public function convertToGB_can_convert_MB()
    {
        $this->assertEquals(0.001953125, $this->convertToGB(1, 2, 'MB'));

        $this->assertEquals(0.005859375, $this->convertToGB(2, 3, 'MB'));
    }
}
