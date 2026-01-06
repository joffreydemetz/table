# JDZ Table

A simple PHP library for generating HTML tables with ease.

## Features

- 🎯 Simple and intuitive API
- 🎨 Support for custom styles and attributes
- 📊 Column width management
- 🔗 Colspan support
- 🔄 Fluent interface for method chaining

## Requirements

- PHP 8.2 or higher

## Installation

Install via Composer:

```bash
composer require jdz/table
```

## Quick Start

```php
use JDZ\Table\Table;

// Create a table with headers
$table = new Table(['Name', 'Age', 'City']);

// Add rows
$table->addRow(['John Doe', '30', 'New York'])
      ->addRow(['Jane Smith', '25', 'Los Angeles']);

// Render the table
echo $table->render();
```

Output:
```html
<table>
 <thead>
  <tr>
   <td><strong>Name</strong></td>
   <td><strong>Age</strong></td>
   <td><strong>City</strong></td>
  </tr>
 </thead>
 <tbody>
  <tr>
   <td>John Doe</td>
   <td>30</td>
   <td>New York</td>
  </tr>
  <tr>
   <td>Jane Smith</td>
   <td>25</td>
   <td>Los Angeles</td>
  </tr>
 </tbody>
</table>
```

## Usage

### Creating a Table

#### With String Headers

```php
$table = new Table(['Column 1', 'Column 2', 'Column 3']);
```

#### With Custom Header Objects

```php
use JDZ\Table\Th;

$header1 = new Th('Name');
$header1->setStyle('color', 'blue');

$table = new Table([$header1, 'Age', 'Email']);
```

### Adding Rows

#### Simple String Values

```php
$table->addRow(['Alice', '28', 'alice@example.com']);
```

#### With Custom Cell Objects

```php
use JDZ\Table\Td;

$cell = new Td('Important');
$cell->setStyle('color', 'red')
     ->setAttribute('class', 'highlight');

$table->addRow([$cell, 'Data', 'More data']);
```

### Setting Column Widths

```php
$table->setColumnWidth(0, 50)  // First column: 50%
      ->setColumnWidth(1, 25)  // Second column: 25%
      ->setColumnWidth(2, 25); // Third column: 25%
```

### Using Colspan

```php
use JDZ\Table\Td;

$spanningCell = new Td('This spans 2 columns', 2);
$table->addRow([$spanningCell, 'Normal cell']);
```

### Styling Cells

#### Adding CSS Classes

```php
$cell = new Td('Content');
$cell->setAttribute('class', 'my-class');
```

#### Adding Inline Styles

```php
$cell = new Td('Content');
$cell->setStyle('color', 'red')
     ->setStyle('font-weight', 'bold')
     ->setStyle('background-color', '#ffff99');
```

#### Adding Multiple Attributes

```php
$cell = new Td('Content');
$cell->setAttribute('class', 'highlight')
     ->setAttribute('id', 'cell-1')
     ->setAttribute('data-value', '123');
```

### Custom Headers

```php
use JDZ\Table\Th;

$header = new Th('Status');
$header->setWidth(20)  // 20% width
       ->setStyle('color', 'blue')
       ->setAttribute('class', 'header-cell');
```

## Complete Example

```php
use JDZ\Table\Table;
use JDZ\Table\Td;

// Create table with headers
$table = new Table(['Product', 'Price', 'Stock']);

// Set column widths
$table->setColumnWidth(0, 50)
      ->setColumnWidth(1, 25)
      ->setColumnWidth(2, 25);

// Add rows with styled cells
$priceCell = new Td('$999');
$priceCell->setStyle('color', 'green')
          ->setStyle('font-weight', 'bold');

$stockCell = new Td('Low');
$stockCell->setStyle('color', 'red');

$table->addRow(['Laptop', $priceCell, $stockCell]);
$table->addRow(['Mouse', '$29', '150']);

// Render
echo $table;  // Uses __toString() magic method
```

## Testing

Run the test suite:

```bash
composer test
```

Run tests with detailed output:

```bash
vendor/bin/phpunit --testdox
```

Run tests with code coverage:

```bash
vendor/bin/phpunit --coverage-text
```

## Examples

See the [examples](examples/) directory for more usage examples:

## License

This library is licensed under the MIT License. See [LICENSE](LICENSE) file for details.
