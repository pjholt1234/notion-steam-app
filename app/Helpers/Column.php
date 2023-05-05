<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;

class Column
{
    public $value;
    private bool $hasFormatter = false;
    private $formatter;
    private bool $isHtml = false;
    public bool $isSortable = false;

    public function __construct(public string $heading, public $column)
    {
    }

    public static function create(string $heading, $column): Column
    {
        return new self($heading, $column);
    }

    public function format(callable $callable): self
    {
        $this->hasFormatter = true;
        $this->formatter = $callable;

        return $this;
    }

    public function html(): self
    {
        $this->isHtml = true;
        return $this;
    }

    public function sortable(): self
    {
        $this->isSortable = true;
        return $this;
    }

    public function getContents(Model $row)
    {
        $this->value = $row->{$this->column};

        if ($this->hasFormatter) {
            $output = call_user_func($this->formatter, $this->value, $row, $this->column);

            if ($this->isHtml) {
                return new HtmlString($output);
            }

            return $output;
        }

        return $this->value;
    }
}
