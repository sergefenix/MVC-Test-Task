<?php

namespace Tests;

use App\Controllers\MetagramController;
use PHPUnit\Framework\TestCase;

class MetagramControllerTest extends TestCase
{

    private MetagramController $metagram;

    public function testResult(): void
    {
        $this->metagram  = new MetagramController();
        $this->metagram->loadWords('лужа', 'море');
        $result = $this->metagram->result();
        $text = 'лужа->ложа->рожа->роза->поза->пора->гора->горе->море';
        $this->assertSame($text, $result);

        $this->metagram  = new MetagramController();
        $this->metagram->loadWords('конь', 'вонь');
        $result = $this->metagram->result();
        $text = 'конь->вонь';
        $this->assertSame($text, $result);

        $this->metagram  = new MetagramController();
        $this->metagram->loadWords('кора', 'нога');
        $result = $this->metagram->result();
        $text = 'кора->коза->роза->рога->нога';
        $this->assertSame($text, $result);

        $this->metagram  = new MetagramController();
        $this->metagram->loadWords('вуду', 'гуру');
        $result = $this->metagram->result();
        $text = 'Что-то пошло не так.';
        $this->assertSame($text, $result);
    }
}
