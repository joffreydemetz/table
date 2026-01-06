<?php

namespace JDZ\Table\Tests;

use JDZ\Table\Th;
use PHPUnit\Framework\TestCase;

class ThTest extends TestCase
{
    public function testConstructorSetsTagToTd(): void
    {
        $th = new Th();
        $this->assertEquals('td', $th->tag);
    }

    public function testConstructorWithEmptyValue(): void
    {
        $th = new Th();
        $this->assertEquals('', $th->value);
    }

    public function testConstructorWrapsValueInStrong(): void
    {
        $th = new Th('Header');
        $this->assertEquals('<strong>Header</strong>', $th->value);
    }

    public function testSetValueWrapsInStrong(): void
    {
        $th = new Th();
        $th->setValue('Title');
        $this->assertEquals('<strong>Title</strong>', $th->value);
    }

    public function testSetValueWithEmptyString(): void
    {
        $th = new Th('Initial');
        $th->setValue('');
        $this->assertEquals('', $th->value);
    }

    public function testSetValueReturnsInstance(): void
    {
        $th = new Th();
        $result = $th->setValue('test');
        $this->assertSame($th, $result);
    }

    public function testSetWidth(): void
    {
        $th = new Th();
        $th->setWidth(50);
        $this->assertEquals(['width' => '50%'], $th->styles);
    }

    public function testSetWidthReturnsInstance(): void
    {
        $th = new Th();
        $result = $th->setWidth(30);
        $this->assertSame($th, $result);
    }

    public function testSetWidthAddsPercentageSymbol(): void
    {
        $th = new Th();
        $th->setWidth(25);

        $html = $th->render();
        $this->assertStringContainsString('style="width:25%"', $html);
    }

    public function testSetWidthWithOtherStyles(): void
    {
        $th = new Th();
        $th->setStyle('color', 'red')
            ->setWidth(40);

        $this->assertEquals([
            'color' => 'red',
            'width' => '40%'
        ], $th->styles);
    }

    public function testRenderWithoutValue(): void
    {
        $th = new Th();
        $this->assertEquals('<td></td>', $th->render());
    }

    public function testRenderWithValue(): void
    {
        $th = new Th('Header');
        $this->assertEquals('<td><strong>Header</strong></td>', $th->render());
    }

    public function testRenderWithWidth(): void
    {
        $th = new Th('Header');
        $th->setWidth(33);

        $html = $th->render();
        $this->assertStringContainsString('<strong>Header</strong>', $html);
        $this->assertStringContainsString('style="width:33%"', $html);
    }

    public function testRenderWithAttributes(): void
    {
        $th = new Th('Header');
        $th->setAttribute('class', 'header-cell');

        $html = $th->render();
        $this->assertStringContainsString('class="header-cell"', $html);
        $this->assertStringContainsString('<strong>Header</strong>', $html);
    }

    public function testRenderWithAttributesAndWidth(): void
    {
        $th = new Th('Header');
        $th->setAttribute('class', 'header-cell')
            ->setWidth(50);

        $html = $th->render();
        $this->assertStringContainsString('class="header-cell"', $html);
        $this->assertStringContainsString('style="width:50%"', $html);
        $this->assertStringContainsString('<strong>Header</strong>', $html);
    }

    public function testInheritsCellBehavior(): void
    {
        $th = new Th('Header');
        $th->setAttribute('id', 'header-id')
            ->setStyle('color', 'blue');

        $html = $th->render();
        $this->assertStringContainsString('id="header-id"', $html);
        $this->assertStringContainsString('color:blue', $html);
    }

    public function testToString(): void
    {
        $th = new Th('Title');
        $this->assertEquals('<td><strong>Title</strong></td>', (string)$th);
    }

    public function testFluentInterface(): void
    {
        $th = new Th('Initial');
        $result = $th->setValue('Updated')
            ->setWidth(25)
            ->setAttribute('class', 'test')
            ->setStyle('color', 'green');

        $this->assertSame($th, $result);
        $html = $th->render();
        $this->assertStringContainsString('<strong>Updated</strong>', $html);
        $this->assertStringContainsString('width:25%', $html);
        $this->assertStringContainsString('class="test"', $html);
        $this->assertStringContainsString('color:green', $html);
    }

    public function testValueUpdateMaintainsStrongWrapping(): void
    {
        $th = new Th('First');
        $this->assertEquals('<strong>First</strong>', $th->value);

        $th->setValue('Second');
        $this->assertEquals('<strong>Second</strong>', $th->value);
    }
}
