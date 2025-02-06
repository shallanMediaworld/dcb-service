<?php

namespace App\Traits\Source;

use Illuminate\Support\Facades\Log;
use App\Traits\Source\MintrouteTrait;
use App\Traits\Source\OneCardTrait;
use App\Traits\Source\EazypinTrait;
use App\Models\Source;
use App\Models\Item;
use App\Models\Local_source_voucher;

trait StockSourceTrait {

 use MintrouteTrait , OneCardTrait , EazypinTrait;


    private static function  mr($item_data){
        if ($item_data->type == "toupUp") 
            return $stockfound = true;

        $stock = self::mintRoute($item_data->sku);
        $att = json_decode($stock, true);
        $stockfound =   $att['status'] ??  false;
            return $stockfound;
    }

    private static function oc($item_data){
        $stock = self::onecard($item_data->sku);
        $stockfound = $stock['product']['available'] ?? false;
            return $stockfound;
    }

    private static function  ez($item_data){

        $json = json_decode($item_data->extras, true);
        $ez_min_price = $json['min_price'] ?? '';
        $stock = self::ezpin($item_data->sku, $ez_min_price);
        $stockfound = ((isset($stock) && $stock == true)) ?: true;
            return $stockfound;
    }

    private static function default($item_data) {

        if($item_data->source_id == env('MW_WALLET_SOURCE')){
            $stockfound = true;
            return $stockfound;
        }


        $stockfound = Local_source_voucher::where([ "source_id" => $item_data->source_id, "item_id" => $item_data->id ])->exists();
            return $stockfound;
    }

    public static function stockfound($item_data){
        $source = Source::find($item_data->source_id);
        if($source->enables ==  false)
            return  false;
        
        $sourceNameArray = [ 'ez' , 'oc' , 'mr' ];
        $sourceName =  (in_array($source->name , $sourceNameArray) ) ? $source->name : 'default';
        $enables = ($source->enables) ? true:false;

        return self::$sourceName($item_data) && $source->enables;
    }

}