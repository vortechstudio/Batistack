<?php

namespace App\Http\Controllers;

use App\Models\Core\BanqueAggregate;
use App\Models\Core\Company;
use App\Services\Bridges\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AggregateController extends Controller
{
    public function __invoke(Request $request)
    {
        $bridge = new Api();

        if(BanqueAggregate::where('item_id', $request->item_id)->exists()){
            BanqueAggregate::where('item_id', $request->item_id)
                ->first()
                ->update(['item_id' => $request->item_id]);
        } else {
            BanqueAggregate::create([
                'item_id' => $request->get('item_id'),
            ]);
        }
        $banque = BanqueAggregate::where('item_id', $request->get('item_id'))->first();


        if(!cache()->has('bridge_access_token')) {
            $authToken = $bridge->post('aggregation/authorization/token', [
                'user_uuid' => Company::first()->info->bridge_client_id,
            ]);
            cache()->put('bridge_access_token', $authToken['access_token']);
        }


        $item = $bridge->get('aggregation/items/'.$request->get('item_id'), null, cache('bridge_access_token'));
        $provider = $bridge->get('providers/'.$item['provider_id']);

        $banque->update([
            'banque_id' => $provider['id'],
            'banque_name' => $provider['name'],
            'banque_logo_url' => $provider['images']['logo'],
            'last_refreshed_at' => Carbon::createFromTimestamp(strtotime($item['last_successful_refresh']))
        ]);

        toastr()->addSuccess('Compte bancaire ajouté avec succès !');
        return redirect()->route('core.settings.banque');

    }
}
