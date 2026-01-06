<?php

namespace JDZ\Table\Tests;

use JDZ\Table\Cell;
use PHPUnit\Framework\TestCase;

class CellTest extends TestCase
{
    public function testConstructorSetsValue(): void
    {
        $cell = new Cell('test value');
        $this->assertEquals('test value', $cell->value);
    }

    public function testConstructorWithEmptyValue(): void
    {
        $cell = new Cell();
        $this->assertEquals('', $cell->value);
    }

    public function testSetValue(): void
    {
        $cell = new Cell();
        $cell->setValue('new value');
        $this->assertEquals('new value', $cell->value);
    }

    public function testSetValueReturnsInstance(): void
    {
        $cell = new Cell();
        $result = $cell->setValue('test');
        $this->assertSame($cell, $result);
    }

    public function testSetAttribute(): void
    {
        $cell = new Cell();
        $cell->setAttribute('class', 'my-class');
        $this->assertEquals(['class' => 'my-class'], $cell->attributes);
    }

    public function testSetAttributeReturnsInstance(): void
    {
        $cell = new Cell();
        $result = $cell->setAttribute('id', 'test-id');
        $this->assertSame($cell, $result);
    }

    public function testSetMultipleAttributes(): void
    {
        $cell = new Cell();
        $cell->setAttribute('class', 'my-class')
            ->setAttribute('id', 'my-id')
            ->setAttribute('data-value', '123');

        $this->assertEquals([
            'class' => 'my-class',
            'id' => 'my-id',
            'data-value' => '123'
        ], $cell->attributes);
    }

    public function testSetStyle(): void
    {
        $cell = new Cell();
        $cell->setStyle('color', 'red');
        $this->assertEquals(['color' => 'red'], $cell->styles);
    }

    public function testSetStyleReturnsInstance(): void
    {
        $cell = new Cell();
        $result = $cell->setStyle('width', '100px');
        $this->assertSame($cell, $result);
    }

    public function testSetMultipleStyles(): void
    {
        $cell = new Cell();
        $cell->setStyle('color', 'red')
            ->setStyle('width', '100px')
            ->setStyle('font-size', '14px');

        $this->assertEquals([
            'color' => 'red',
            'width' => '100px',
            'font-size' => '14px'
        ], $cell->styles);
    }

    public function testRenderWithoutAttributesOrStyles(): void
    {
        $cell = new Cell('content');
        $cell->tag = 'td';

        $this->assertEquals('<td>content</td>', $cell->render());
    }

    public function testRenderWithAttributes(): void
    {
        $cell = new Cell('content');
        $cell->tag = 'td';
        $cell->setAttribute('class', 'my-class');

        $this->assertEquals('<td class="my-class">content</td>', $cell->render());
    }

    public function testRenderWithMultipleAttributes(): void
    {
        $cell = new Cell('content');
        $cell->tag = 'td';
        $cell->setAttribute('class', 'my-class')
            ->setAttribute('id', 'my-id');

        $html = $cell->render();
        $this->assertStringContainsString('class="my-class"', $html);
        $this->assertStringContainsString('id="my-id"', $html);
        $this->assertStringStartsWith('<td ', $html);
        $this->assertStringEndsWith('>content</td>', $html);
    }

    public function testRenderWithStyles(): void
    {
        $cell = new Cell('content');
        $cell->tag = 'td';
        $cell->setStyle('color', 'red');

        $this->assertEquals('<td style="color:red">content</td>', $cell->render());
    }

    public function testRenderWithMultipleStyles(): void
    {
        $cell = new Cell('content');
        $cell->tag = 'td';
        $cell->setStyle('color', 'red')
            ->setStyle('width', '100px');

        $html = $cell->render();
        $this->assertStringContainsString('style="color:red;width:100px"', $html);
    }

    public function testRenderWithAttributesAndStyles(): void
    {
        $cell = new Cell('content');
        $cell->tag = 'td';
        $cell->setAttribute('class', 'my-class')
            ->setStyle('color', 'red');

        $html = $cell->render();
        $this->assertStringContainsString('class="my-class"', $html);
        $this->assertStringContainsString('style="color:red"', $html);
        $this->assertEquals('<td class="my-class" style="color:red">content</td>', $html);
    }

    public function testToString(): void
    {
        $cell = new Cell('test');
        $cell->tag = 'td';

        $this->assertEquals('<td>test</td>', (string)$cell);
    }

    public function testToStringCallsRender(): void
    {
        $cell = new Cell('test');
        $cell->tag = 'td';
        $cell->setAttribute('class', 'test-class');

        $this->assertEquals($cell->render(), (string)$cell);
    }
}
