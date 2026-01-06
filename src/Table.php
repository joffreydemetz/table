<?php

namespace JDZ\Table;

use JDZ\Table\Th;
use JDZ\Table\Td;

class Table
{
  public array $headers = [];
  public array $rows = [];

  public function __construct(array $headers, array $rows = [])
  {
    foreach ($headers as $header) {
      if ($header instanceof Th) {
        $this->headers[] = $header;
      } else {
        $this->headers[] = new Th($header);
      }
    }

    foreach ($this->rows as $row) {
      $this->addRow($row);
    }
  }

  public function __toString(): string
  {
    return $this->render();
  }

  public function render(): string
  {
    $html = '';
    // return $html;

    $html .= '<table>' . "\n";
    $html .= ' <thead>' . "\n";
    $html .= '  <tr>' . "\n";
    foreach ($this->headers as $th) {
      $html .= '   ' . (string)$th . "\n";
    }
    $html .= '  </tr>' . "\n";
    $html .= ' </thead>' . "\n";
    $html .= ' <tbody>' . "\n";
    foreach ($this->rows as $row) {
      $html .= '  <tr>' . "\n";
      foreach ($row as $td) {
        $html .= '   ' . (string)$td . "\n";
      }
      $html .= '  </tr>' . "\n";
    }
    $html .= ' </tbody>' . "\n";
    $html .= '</table>' . "\n";

    return $html;
  }

  public function addRow(array $row)
  {
    // if ( count($row) <> count($this->headers) ){
    // throw new \Exception('Columns '.count($this->headers).' <> '.count($row));
    // }

    $cols = [];
    foreach ($row as $value) {
      if ($value instanceof Td) {
        $cols[] = $value;
      } else {
        $cols[] = new Td($value);
      }
    }

    $this->rows[] = $cols;
    return $this;
  }

  public function setColumnWidth(int $colNb, int $width)
  {
    $this->headers[$colNb]->setWidth($width);
    return $this;
  }
}
