<?php

namespace App\Http\Livewire;

use App\Abstracts\FormAbstract;
use App\Models\SteamItem;
use App\Repositories\SteamMarketApiRepository;

class CreateSteamItem extends FormAbstract
{
    public string $view = 'livewire.create-steam-item';

    public array $rules = [
        'fields.market_hash' => 'required|string',
    ];

    public array $fields = [
        'market_hash' => null,
    ];

    public bool $loading = false;
    public array $item = [];
    public function search(){
        $this->validate($this->rules);
        $this->item = [];

        $this->loading = true;

        $marketHash = formatMarketHash($this->fields['market_hash']);
        $steamItem = SteamItem::where('market_hash_name', $marketHash)->first();

        if(isset($steamItem)){

            $this->item = [
                'name' => $steamItem->name,
                'image_url' => $steamItem->getImageUrl(),
                'stored' => true,
            ];

            $this->loading = false;

            $this->dispatchBrowserEvent('alert', [
                'success' => false,
                'message' => 'This item already exists'
            ]);

            return;
        }

        $response = $this->fetchItem($marketHash);
        $this->loading = false;


        if(array_key_exists('status', $response) && $response['status'] == 400){
            $this->dispatchBrowserEvent('alert', [
                'success' => false,
                'message' => 'No match found'
            ]);

            return;
        }

        if(!array_key_exists('market_hash_name', $response)){
            $this->dispatchBrowserEvent('alert', [
                'success' => false,
                'message' => 'Error when fetching item, please try again later.'
            ]);

            return;
        }

        $this->item = [
            'name' => $response['market_name'],
            'market_hash' => formatMarketHash($response['market_hash_name']),
            'url' => $response['url'],
            'image_url' => $response['image'],
            'stored' => false,
        ];
    }

    public function fetchItem(string $marketHash): array
    {
        $marketApiRepository = new SteamMarketApiRepository(processData: false);
        $url = '/market/item/730/'.$marketHash;
        return $marketApiRepository
            ->buildUrl($url)
            ->makeRequest('get');
    }

    public function submit()
    {
        $this->validate([
            'item.name' => 'required|string',
            'item.market_hash' => 'required|string',
            'item.image_url' => 'required|string',
        ]);

        SteamItem::create([
            'name' => $this->item['name'],
            'market_hash_name' => $this->item['market_hash'],
            'image_url' => $this->item['image_url'],
        ]);

        $this->dispatchBrowserEvent('add-item-modal-toggle');

        $this->dispatchBrowserEvent('alert', [
            'success' => true,
            'message' => $this->item['name'].' successfully added'
        ]);
    }
}
