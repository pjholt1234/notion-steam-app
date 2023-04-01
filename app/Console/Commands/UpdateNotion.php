<?php

namespace App\Console\Commands;

use App\Models\SteamItem;
use Illuminate\Console\Command;
use Notion\Databases\Database;
use Notion\Databases\DatabaseParent;
use Notion\Databases\Query;
use Notion\Databases\Query\CompoundFilter;
use Notion\Databases\Query\TextFilter;
use Notion\Notion;
use Notion\Pages\Page;
use Notion\Pages\PageParent;
use Notion\Pages\Properties\Formula;
use Notion\Pages\Properties\FormulaType;
use Notion\Pages\Properties\Number;
use Notion\Pages\Properties\RichTextProperty;
use Notion\Pages\Properties\Title;

class UpdateNotion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notion:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $parentPage = '0ac24f4d152d431ca3719d8dddc0b6c7'; //TODO this needs to be configured somehow
        $this->notion = Notion::create(config('app.notion_api_key'));

        $this->parent = PageParent::database($parentPage);
        $this->database = $this->notion->databases()->find($parentPage);

        $query = Query::create()
            ->changeFilter(
                TextFilter::property('Market Hash')->doesNotContain('******')
            );

        $result = $this->notion->databases()->query($this->database, $query);
        $currentTabledItems = [];

        foreach($result->pages as $page){
            $currentTabledItems[] = $page->getProperty("Market Hash")->toString();
        }

        $steamItems = SteamItem::all();

        foreach($steamItems as $steamItem){

            if(in_array($steamItem->market_hash_name, $currentTabledItems)){
                $this->updateItemInTable($steamItem);
                continue;
            }

            $this->addItemToTable($steamItem);

            //TODO Fix delete issue
        }
    }

    public function addItemToTable(SteamItem $steamItem)
    {
        $title      = Title::fromString($steamItem->name);
        $marketHash = RichTextProperty::fromString($steamItem->market_hash_name);
        $quantity   = Number::create($steamItem->stockItem->quantity);
        $netValue   = Number::create($steamItem->stockItem->net_value);
        $totalCost  = Number::create($steamItem->stockItem->total_cost);

        $page = Page::create($this->parent)
            ->addProperty("Item Name", $title)
            ->addProperty("Market Hash", $marketHash)
            ->addProperty("Quantity", $quantity)
            ->addProperty("Net Value", $netValue)
            ->addProperty("Total Cost", $totalCost);

        $this->notion->pages()->create($page);
    }

    public function updateItemInTable(SteamItem $steamItem)
    {
        $query = Query::create()
            ->changeFilter(TextFilter::property('Market Hash')->contains($steamItem->market_hash_name));

        $result = $this->notion->databases()->query($this->database, $query);

        if(count($result->pages) == 0){
            return;
        }

        $title      = Title::fromString($steamItem->name);
        $marketHash = RichTextProperty::fromString($steamItem->market_hash_name);
        $quantity   = Number::create($steamItem->stockItem->quantity);
        $netValue   = Number::create($steamItem->stockItem->net_value);
        $totalCost  = Number::create($steamItem->stockItem->total_cost);
        $profit     = Number::create($steamItem->stockItem->total_cost); //I'm not sure how this works

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
