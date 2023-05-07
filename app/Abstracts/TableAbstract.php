<?php

namespace App\Abstracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

abstract class TableAbstract extends Component
{
    use WithPagination;

    public array $allowedItemsPerPage = [5, 10, 15];

    public int $itemsPerPage;

    public ?string $sortDirection = null;

    public ?string $sortColumn = null;

    public array $columns = [];

    public bool $enableSorting = true;

    public function mount()
    {
        $this->itemsPerPage = $this->allowedItemsPerPage[0];
    }

    abstract public function builder(): Builder;

    abstract public function columns(): array;

    public function render(): View
    {
        return view('livewire.table', [
            'items' => $this->query()->paginate($this->itemsPerPage),
        ]);
    }

    public function query(): Builder
    {
        //Add sorting
        if(isset($this->sortColumn) && isset($this->sortDirection) && $this->enableSorting){
            return $this->builder()->orderBy($this->sortColumn, $this->sortDirection);
        }

        return $this->builder();
    }


    public function setPaging(int $itemsPerPage): void
    {
        $this->itemsPerPage = $itemsPerPage;
    }

    public function setSort(string $column): void
    {
        $this->sortDirection = match ($this->sortDirection) {
            'asc' => 'desc',
            'desc' => null,
            default => 'asc',
        };

        if(isset($this->sortDirection)){
            $this->sortColumn = $column;
        } else {
            $this->sortColumn = null;
        }
    }

    public function getSortArrow(): string
    {
        return match ($this->sortDirection) {
            'asc' => '↑',
            'desc' => '↓',
            default => '',
        };
    }
}
