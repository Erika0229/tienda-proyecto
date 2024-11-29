<?php
use PHPUnit\Framework\TestCase;

class PruebaTest extends TestCase{
    public function testSumar(): void{
        $num1 = 1;
        $num2 = 2;

        //Comprobación de afirmaciones
        $this->assertSame(3,$num1+$num2);
    }
}

