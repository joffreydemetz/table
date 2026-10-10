<?php

namespace JDZ\Table\Tests;

use JDZ\Table\Td;
use PHPUnit\Framework\TestCase;

class TdTest extends TestCase
{
    public function testConstructorWithoutColspan(): void
    {
        $td = new Td('value');
        $this->assertEmpty($td->attributes);
    }

    public function testConstructorWithColspan(): void
    {
        $td = new Td('value', 2);
        $this->assertEquals(['colspan' => '2'], $td->attributes);
    }

    public function testConstructorWithColspanZero(): void
    {
        $td = new Td('value', 0);
        $this->assertEmpty($td->attributes);
    }

    public function testSetColspan(): void
    {
        $td = new Td();
        $td->setColspan(3);
        $this->assertEquals(['colspan' => '3'], $td->attributes);
    }

    public function testSetColspanOverridesConstructorValue(): void
    {
        $td = new Td('value', 2);
        $td->setColspan(5);
        $this->assertEquals(['colspan' => '5'], $td->attributes);
    }

    public function testRenderWithoutColspan(): void
    {
        $td = new Td('content');
        $this->assertEquals('<td>content</td>', $td->render());
    }

    public function testRenderWithColspan(): void
    {
        $td = new Td('content', 3);
        $this->assertEquals('<td colspan="3">content</td>', $td->render());
    }

    public function testRenderWithColspanAndOtherAttributes(): void
    {
        $td = new Td('content', 2);
        $td->setAttribute('class', 'my-class');

        $html = $td->render();
        $this->assertStringContainsString('colspan="2"', $html);
        $this->assertStringContainsString('class="my-class"', $html);
    }

    public function testRenderWithColspanAndStyles(): void
    {
        $td = new Td('content', 2);
        $td->setStyle('color', 'red');

        $html = $td->render();
        $this->assertStringContainsString('colspan="2"', $html);
        $this->assertStringContainsString('style="color:red"', $html);
    }

    public function testToString(): void
    {
        $td = new Td('test', 2);
        $this->assertEquals('<td colspan="2">test</td>', (string)$td);
    }

    public function testFluentInterface(): void
    {
        $td = new Td('value');
        $result = $td->setValue('new value')
            ->setColspan(3)
            ->setAttribute('class', 'test')
            ->setStyle('color', 'blue');

        $this->assertSame($td, $result);
        $html = $td->render();
        $this->assertStringContainsString('colspan="3"', $html);
        $this->assertStringContainsString('class="test"', $html);
        $this->assertStringContainsString('style="color:blue"', $html);
        $this->assertStringContainsString('new value', $html);
    }
}
