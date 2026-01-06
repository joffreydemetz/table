<?php

require_once __DIR__ . '/../vendor/autoload.php';

use JDZ\Table\Table;
use JDZ\Table\Th;
use JDZ\Table\Td;

echo "=== Example 1: Basic Table ===\n\n";

// Create a simple table with string headers
$table1 = new Table(['Name', 'Age', 'City']);

// Add rows with string values
$table1->addRow(['John Doe', '30', 'New York'])
    ->addRow(['Jane Smith', '25', 'Los Angeles'])
    ->addRow(['Bob Johnson', '35', 'Chicago']);

echo $table1->render();
echo "\n\n";

// ====================================================================

echo "=== Example 2: Table with Column Widths ===\n\n";

$table2 = new Table(['Product', 'Price', 'Stock']);

// Set column widths (percentages)
$table2->setColumnWidth(0, 50)  // Product: 50%
    ->setColumnWidth(1, 25)  // Price: 25%
    ->setColumnWidth(2, 25); // Stock: 25%

$table2->addRow(['Laptop', '$999', '15'])
    ->addRow(['Mouse', '$29', '150'])
    ->addRow(['Keyboard', '$79', '75']);

echo $table2->render();
echo "\n\n";

// ====================================================================

echo "=== Example 3: Table with Colspan ===\n\n";

$table3 = new Table(['Column 1', 'Column 2', 'Column 3']);

// Regular row
$table3->addRow(['A', 'B', 'C']);

// Row with colspan
$spanningCell = new Td('This spans 2 columns', 2);
$table3->addRow([$spanningCell, 'D']);

// Another regular row
$table3->addRow(['E', 'F', 'G']);

echo $table3->render();
echo "\n\n";

// ====================================================================

echo "=== Example 4: Styled Table ===\n\n";

$table4 = new Table(['Employee', 'Department', 'Salary']);

// Add rows with custom styles
$highlightedCell = new Td('John Doe');
$highlightedCell->setAttribute('class', 'highlight')
    ->setStyle('background-color', '#ffff99');

$salaryCell = new Td('$85,000');
$salaryCell->setStyle('color', 'green')
    ->setStyle('font-weight', 'bold');

$table4->addRow([$highlightedCell, 'Engineering', $salaryCell]);

// Regular row
$table4->addRow(['Jane Smith', 'Marketing', '$72,000']);

// Another styled row
$urgentCell = new Td('Bob Johnson');
$urgentCell->setAttribute('class', 'urgent');

$table4->addRow([$urgentCell, 'Sales', '$95,000']);

echo $table4->render();
echo "\n\n";

// ====================================================================

echo "=== Example 5: Custom Header Styles ===\n\n";

// Create custom headers with styles
$header1 = new Th('First Name');
$header1->setStyle('color', 'blue');

$header2 = new Th('Last Name');
$header2->setStyle('color', 'blue');

$header3 = new Th('Email');
$header3->setStyle('color', 'blue')
    ->setAttribute('class', 'email-header');

$table5 = new Table([$header1, $header2, $header3]);

$table5->addRow(['Alice', 'Anderson', 'alice@example.com'])
    ->addRow(['Charlie', 'Chen', 'charlie@example.com']);

echo $table5->render();
echo "\n\n";

// ====================================================================

echo "=== Example 6: Mixed Usage ===\n\n";

$table6 = new Table(['Status', 'Task', 'Priority']);

$table6->setColumnWidth(0, 15)
    ->setColumnWidth(1, 60)
    ->setColumnWidth(2, 25);

// Row 1: Custom styled cells
$statusDone = new Td('✓ Done');
$statusDone->setStyle('color', 'green');

$table6->addRow([$statusDone, 'Complete project documentation', 'High']);

// Row 2: Mix of custom and regular cells
$statusProgress = new Td('⚠ In Progress');
$statusProgress->setStyle('color', 'orange');

$urgentTask = new Td('High');
$urgentTask->setStyle('color', 'red')
    ->setStyle('font-weight', 'bold');

$table6->addRow([$statusProgress, 'Fix critical bugs', $urgentTask]);

// Row 3: Regular row
$table6->addRow(['○ Pending', 'Update dependencies', 'Low']);

echo $table6->render();
echo "\n\n";

// ====================================================================

echo "=== Example 7: Empty Table ===\n\n";

$table7 = new Table(['Header 1', 'Header 2', 'Header 3']);
// No rows added

echo $table7->render();
echo "\n\n";

// ====================================================================

echo "=== Example 8: Using __toString() Magic Method ===\n\n";

$table8 = new Table(['Name', 'Score']);
$table8->addRow(['Player 1', '100'])
    ->addRow(['Player 2', '85']);

// You can echo the table directly without calling render()
echo $table8;
