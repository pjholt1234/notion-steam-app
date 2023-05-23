<?php

namespace App\Console\Commands;

use App\Models\SteamItem;
use App\Services\UpdateNotionPageService;
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
        $UpdateNotionService = app(UpdateNotionPageService::class);

        $steamItems = SteamItem::all();

        foreach($steamItems as $steamItem){
            $UpdateNotionService->setSteamItem($steamItem);
            $UpdateNotionService->updateTable();
        }
    }
}
