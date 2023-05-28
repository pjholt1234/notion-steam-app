<?php

namespace App\Services;

use App\Models\SteamItem;
use App\NotionStatusCallback;
use Error;
use Notion\Databases\Query;
use Notion\Databases\Query\TextFilter;
use Notion\Notion;
use Notion\Pages\Page;
use Notion\Pages\PageParent;
use Notion\Pages\Properties\Number;
use Notion\Pages\Properties\RichTextProperty;
use Notion\Pages\Properties\Title;

class UpdateNotionPageService
{
    private $notion;
    private $parent;

    private $database;

    private SteamItem $steamItem;

    private array $currentTabledItems = [];

    public function __construct()
    {
        $this->fetchTable();
    }

    public function setSteamItem(SteamItem $steamItem): void
    {
        $this->steamItem = $steamItem;
    }

    public function fetchTable(): void
    {
        $parentPage = '0ac24f4d152d431ca3719d8dddc0b6c7';
        $this->notion = Notion::create(config('app.notion_api_key'));

        $this->parent = PageParent::database($parentPage);
        $this->database = $this->notion->databases()->find($parentPage);

        $query = Query::create()
            ->changeFilter(
                TextFilter::property('Market Hash')->doesNotContain('******')
            );

        $result = $this->notion->databases()->query($this->database, $query);
        foreach ($result->pages as $page) {
            $this->currentTabledItems[] = $page->getProperty("Market Hash")->toString();
        }
    }

    public function updateTable(): void
    {
        if(!isset($this->steamItem)){
            throw new Error('Missing steam item');
        }

        if (in_array($this->steamItem->market_hash_name, $this->currentTabledItems)) {
            $this->updateItemInTable($this->steamItem);
            return;
        }

        $this->addItemToTable($this->steamItem);
    }

    public function addItemToTable(SteamItem $steamItem): void
    {
        $title      = Title::fromString($steamItem->name);
        $marketHash = RichTextProperty::fromString($steamItem->market_hash_name);
        $quantity   = Number::create($steamItem->stockItem->quantity ?? 0);
        $netValue   = Number::create($steamItem->stockItem->net_value ?? 0);
        $totalCost  = Number::create($steamItem->stockItem->total_cost ?? 0);

        $page = Page::create($this->parent)
            ->addProperty("Item Name", $title)
            ->addProperty("Market Hash", $marketHash)
            ->addProperty("Quantity", $quantity)
            ->addProperty("Net Value", $netValue)
            ->addProperty("Total Cost", $totalCost);

        $this->notion->pages()->create($page);
    }

    public function updateItemInTable(SteamItem $steamItem): void
    {
        $query = Query::create()
            ->changeFilter(TextFilter::property('Market Hash')->contains($steamItem->market_hash_name));

        $result = $this->notion->databases()->query($this->database, $query);

        if(count($result->pages) == 0){
            return;
        }

        $profit = $steamItem->stockItem->net_value - $steamItem->stockItem->total_cost;

        $title      = Title::fromString($steamItem->name);
        $marketHash = RichTextProperty::fromString($steamItem->market_hash_name);
        $quantity   = Number::create($steamItem->stockItem->quantity ?? 0);
        $netValue   = Number::create($steamItem->stockItem->net_value ?? 0);
        $totalCost  = Number::create($steamItem->stockItem->total_cost ?? 0);
        $profit     = Number::create($profit ?? 0);

        $page = $result->pages[0]
            ->addProperty("Item Name", $title)
            ->addProperty("Market Hash", $marketHash)
            ->addProperty("Quantity", $quantity)
            ->addProperty("Net Value", $netValue)
            ->addProperty("Total Cost", $totalCost)
            ->addProperty("Profit", $profit);

        $this->notion->pages()->update($page);
    }
}
