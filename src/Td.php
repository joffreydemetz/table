<?php

namespace JDZ\Table;

use JDZ\Table\Cell;

class Td extends Cell
{
  public string $tag = 'td';

  public function __construct(string $value = '', int $colspan = 0)
  {
    parent::__construct($value);

    if ($colspan) {
      $this->setAttribute('colspan', $colspan);
    }
  }

  public function setColspan(int $colspan)
  {
    $this->setAttribute('colspan', $colspan);
    return $this;
  }
}
