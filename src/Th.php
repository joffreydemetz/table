<?php

namespace JDZ\Table;

use JDZ\Table\Cell;

class Th extends Cell
{
  public string $tag = 'td';

  public function setValue(string $value)
  {
    if ($value) {
      $value = '<strong>' . $value . '</strong>';
    }

    return parent::setValue($value);
  }

  public function setWidth(int $width)
  {
    $this->setStyle('width', $width . '%');
    return $this;
  }
}
