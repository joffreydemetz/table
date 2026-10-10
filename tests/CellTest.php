<?php

namespace JDZ\Table\Tests;

use JDZ\Table\Cell;
use PHPUnit\Framework\TestCase;

class CellTest extends TestCase
{
    public function testConstructorWithEmptyValue(): void
    {
        $cell = new Cell();
        $this->assertEquals('', $cell->value);
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
}
