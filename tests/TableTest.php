<?php

namespace JDZ\Table\Tests;

use JDZ\Table\Table;
use JDZ\Table\Th;
use JDZ\Table\Td;
use PHPUnit\Framework\TestCase;

class TableTest extends TestCase
{
    public function testConstructorWithStringHeaders(): void
    {
        $table = new Table(['Name', 'Age', 'City']);

        $this->assertCount(3, $table->headers);
        $this->assertInstanceOf(Th::class, $table->headers[0]);
        $this->assertInstanceOf(Th::class, $table->headers[1]);
        $this->assertInstanceOf(Th::class, $table->headers[2]);
    }

    public function testConstructorWithThObjects(): void
    {
        $th1 = new Th('Name');
        $th2 = new Th('Age');

        $table = new Table([$th1, $th2]);

        $this->assertCount(2, $table->headers);
        $this->assertSame($th1, $table->headers[0]);
        $this->assertSame($th2, $table->headers[1]);
    }

    public function testConstructorWithMixedHeaders(): void
    {
        $th = new Th('Name');
        $table = new Table([$th, 'Age', 'City']);

        $this->assertCount(3, $table->headers);
        $this->assertSame($th, $table->headers[0]);
        $this->assertInstanceOf(Th::class, $table->headers[1]);
        $this->assertInstanceOf(Th::class, $table->headers[2]);
    }

    public function testConstructorInitializesEmptyRows(): void
    {
        $table = new Table(['Header']);
        $this->assertIsArray($table->rows);
        $this->assertEmpty($table->rows);
    }

    public function testAddRowWithStrings(): void
    {
        $table = new Table(['Name', 'Age']);
        $table->addRow(['John', '30']);

        $this->assertCount(1, $table->rows);
        $this->assertCount(2, $table->rows[0]);
        $this->assertInstanceOf(Td::class, $table->rows[0][0]);
        $this->assertInstanceOf(Td::class, $table->rows[0][1]);
    }

    public function testAddRowWithTdObjects(): void
    {
        $table = new Table(['Name', 'Age']);
        $td1 = new Td('John');
        $td2 = new Td('30');

        $table->addRow([$td1, $td2]);

        $this->assertCount(1, $table->rows);
        $this->assertSame($td1, $table->rows[0][0]);
        $this->assertSame($td2, $table->rows[0][1]);
    }

    public function testAddRowWithMixedValues(): void
    {
        $table = new Table(['Name', 'Age']);
        $td = new Td('John');

        $table->addRow([$td, '30']);

        $this->assertCount(1, $table->rows);
        $this->assertSame($td, $table->rows[0][0]);
        $this->assertInstanceOf(Td::class, $table->rows[0][1]);
    }

    public function testAddRowReturnsInstance(): void
    {
        $table = new Table(['Header']);
        $result = $table->addRow(['value']);

        $this->assertSame($table, $result);
    }

    public function testAddMultipleRows(): void
    {
        $table = new Table(['Name', 'Age']);
        $table->addRow(['John', '30'])
            ->addRow(['Jane', '25'])
            ->addRow(['Bob', '35']);

        $this->assertCount(3, $table->rows);
    }

    public function testSetColumnWidth(): void
    {
        $table = new Table(['Name', 'Age', 'City']);
        $table->setColumnWidth(0, 50);

        // The width should be set on the first header
        $this->assertEquals(['width' => '50%'], $table->headers[0]->styles);
    }

    public function testSetColumnWidthReturnsInstance(): void
    {
        $table = new Table(['Name', 'Age']);
        $result = $table->setColumnWidth(0, 30);

        $this->assertSame($table, $result);
    }

    public function testSetMultipleColumnWidths(): void
    {
        $table = new Table(['Name', 'Age', 'City']);
        $table->setColumnWidth(0, 40)
            ->setColumnWidth(1, 30)
            ->setColumnWidth(2, 30);

        $this->assertEquals(['width' => '40%'], $table->headers[0]->styles);
        $this->assertEquals(['width' => '30%'], $table->headers[1]->styles);
        $this->assertEquals(['width' => '30%'], $table->headers[2]->styles);
    }

    public function testRenderEmptyTable(): void
    {
        $table = new Table(['Name', 'Age']);
        $html = $table->render();

        $this->assertStringContainsString('<table>', $html);
        $this->assertStringContainsString('</table>', $html);
        $this->assertStringContainsString('<thead>', $html);
        $this->assertStringContainsString('</thead>', $html);
        $this->assertStringContainsString('<tbody>', $html);
        $this->assertStringContainsString('</tbody>', $html);
        $this->assertStringContainsString('<strong>Name</strong>', $html);
        $this->assertStringContainsString('<strong>Age</strong>', $html);
    }

    public function testRenderTableWithRows(): void
    {
        $table = new Table(['Name', 'Age']);
        $table->addRow(['John', '30'])
            ->addRow(['Jane', '25']);

        $html = $table->render();

        $this->assertStringContainsString('John', $html);
        $this->assertStringContainsString('30', $html);
        $this->assertStringContainsString('Jane', $html);
        $this->assertStringContainsString('25', $html);
    }

    public function testRenderTableStructure(): void
    {
        $table = new Table(['Header']);
        $table->addRow(['Data']);

        $html = $table->render();

        // Check structure order
        $this->assertMatchesRegularExpression('/<table>.*<thead>.*<tbody>.*<\/table>/s', $html);
        $this->assertMatchesRegularExpression('/<thead>.*<tr>.*<\/tr>.*<\/thead>/s', $html);
        $this->assertMatchesRegularExpression('/<tbody>.*<tr>.*<\/tr>.*<\/tbody>/s', $html);
    }

    public function testRenderTableWithMultipleRows(): void
    {
        $table = new Table(['Col1', 'Col2']);
        $table->addRow(['A', 'B'])
            ->addRow(['C', 'D'])
            ->addRow(['E', 'F']);

        $html = $table->render();

        // Count TR elements in tbody (should be 3)
        $tbodySection = preg_match('/<tbody>(.*?)<\/tbody>/s', $html, $matches);
        $this->assertEquals(1, $tbodySection);
        $trCount = substr_count($matches[1], '<tr>');
        $this->assertEquals(3, $trCount);
    }

    public function testRenderTableWithColumnWidths(): void
    {
        $table = new Table(['Name', 'Age']);
        $table->setColumnWidth(0, 70)
            ->setColumnWidth(1, 30);

        $html = $table->render();

        $this->assertStringContainsString('style="width:70%"', $html);
        $this->assertStringContainsString('style="width:30%"', $html);
    }

    public function testRenderTableWithStyledCells(): void
    {
        $table = new Table(['Name']);

        $td = new Td('John');
        $td->setAttribute('class', 'highlight');

        $table->addRow([$td]);

        $html = $table->render();
        $this->assertStringContainsString('class="highlight"', $html);
    }

    public function testToString(): void
    {
        $table = new Table(['Header']);
        $table->addRow(['Data']);

        $this->assertEquals($table->render(), (string)$table);
    }

    public function testToStringCallsRender(): void
    {
        $table = new Table(['Name', 'Age']);
        $table->addRow(['John', '30']);

        $stringOutput = (string)$table;
        $renderOutput = $table->render();

        $this->assertEquals($renderOutput, $stringOutput);
    }

    public function testComplexTableScenario(): void
    {
        $table = new Table(['Name', 'Age', 'City']);
        $table->setColumnWidth(0, 40)
            ->setColumnWidth(1, 20)
            ->setColumnWidth(2, 40);

        $table->addRow(['John Doe', '30', 'New York'])
            ->addRow(['Jane Smith', '25', 'Los Angeles'])
            ->addRow(['Bob Johnson', '35', 'Chicago']);

        $html = $table->render();

        // Verify all headers
        $this->assertStringContainsString('<strong>Name</strong>', $html);
        $this->assertStringContainsString('<strong>Age</strong>', $html);
        $this->assertStringContainsString('<strong>City</strong>', $html);

        // Verify all data
        $this->assertStringContainsString('John Doe', $html);
        $this->assertStringContainsString('30', $html);
        $this->assertStringContainsString('New York', $html);
        $this->assertStringContainsString('Jane Smith', $html);
        $this->assertStringContainsString('25', $html);
        $this->assertStringContainsString('Los Angeles', $html);
        $this->assertStringContainsString('Bob Johnson', $html);
        $this->assertStringContainsString('35', $html);
        $this->assertStringContainsString('Chicago', $html);

        // Verify widths
        $this->assertStringContainsString('width:40%', $html);
        $this->assertStringContainsString('width:20%', $html);
    }

    public function testRenderTableWithColspan(): void
    {
        $table = new Table(['Col1', 'Col2', 'Col3']);

        $td = new Td('Spanning', 2);
        $table->addRow([$td, 'Normal']);

        $html = $table->render();

        $this->assertStringContainsString('colspan="2"', $html);
        $this->assertStringContainsString('Spanning', $html);
    }

    public function testFluentInterface(): void
    {
        $result = (new Table(['Name', 'Age']))
            ->setColumnWidth(0, 70)
            ->setColumnWidth(1, 30)
            ->addRow(['John', '30'])
            ->addRow(['Jane', '25']);

        $this->assertInstanceOf(Table::class, $result);
        $this->assertCount(2, $result->rows);
    }
}
