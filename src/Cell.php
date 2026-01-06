<?php

namespace JDZ\Table;

class Cell
{
  public string $tag = '';
  public string $value;
  public array $attributes = [];
  public array $styles = [];

  public function __construct(string $value = '')
  {
    $this->setValue($value);
  }

  public function __toString(): string
  {
    return $this->render();
  }

  public function render(): string
  {
    $html = '<' . $this->tag;

    if ($this->attributes) {
      $attrs = [];
      foreach ($this->attributes as $key => $value) {
        $attrs[] = $key . '="' . $value . '"';
      }
      $html .= ' ' . implode(' ', $attrs);
    }

    if ($this->styles) {
      $styles = [];
      foreach ($this->styles as $key => $value) {
        $styles[] = $key . ':' . $value;
      }
      $html .= ' style="' . implode(';', $styles) . '"';
    }
    $html .= '>' . $this->value . '</' . $this->tag . '>';

    return $html;
  }

  public function setValue(string $value)
  {
    $this->value = $value;
    return $this;
  }

  public function setAttribute(string $key, mixed $value)
  {
    $this->attributes[$key] = (string)$value;
    return $this;
  }

  public function setStyle(string $key, mixed $value)
  {
    $this->styles[$key] = (string)$value;
    return $this;
  }
}
