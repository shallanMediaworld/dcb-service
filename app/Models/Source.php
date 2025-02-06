<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use  App\Jobs\Source\MrJob;
use App\Jobs\Source\OcJob;
use App\Jobs\Source\EzJob;
use App\Jobs\Source\LocalJob;

use App\Traits\Source\StockTrait;

class Source extends Model
{
    use HasFactory, SoftDeletes, StockTrait;

    protected $table = 'sources';
    protected $fillable = [
        'name'
    ];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    
    // START: Identify sources ids //
    const MR = [1];
    const OC = [2];
    const EZ = [4];
    const LOCAL = [3, 5, 6, 7, 8];
    // END: Identify sources ids //

    // START: Sources stock status //
    const SOURCES = [
        "mr" => [ "id" => [1], "stock_method" => "mintRoute" ],
        "oc" => [ "id" => [2], "stock_method" => "oneCard" ],
    ];
    const MR_STOCK = "https://mconnect2.mintroute.com/voucher/api/stock";
    // END: Sources stock status //

    public function getSourceJobInfo($source_id) : array {
        $mrArr = array_fill_keys(self::MR, [ "connection" => "database_mr_source", "queue" => "mr_source", "class" => MrJob::class ]);
        $ocArr = array_fill_keys(self::OC, [ "connection" => "database_oc_source", "queue" => "oc_source", "class" => OcJob::class ]);
        $ezArr = array_fill_keys(self::EZ, [ "connection" => "database_ez_source", "queue" => "ez_source", "class" => EzJob::class ]);
        $localArr = array_fill_keys(self::LOCAL, [ "connection" => "database_local_source", "queue" => "local_source", "class" => LocalJob::class ]);

        $data = $mrArr + $ocArr + $ezArr + $localArr;
        return $data[$source_id];
    }

    public function stockValidate($source_id, $sku) {
//        $index = null;
//        foreach( self::SOURCES as $key => $value ) {
//            if (is_array($value) && isset($value["id"]) && in_array($source_id, $value["id"])) {
//                $index = $key;
//            }
//        }
//        $method = self::SOURCES[$index]["stock_method"];
//        $test = $this->$method($sku);
//        dd($test);
//
//        $iterator = new \RecursiveIteratorIterator(new \RecursiveArrayIterator(self::SOURCES));
//        $filteredIterator = new \CallbackFilterIterator($iterator, function ($value, $key) use ($source_id) {
//            dd($source_id);
//            return $key === "id" && in_array($source_id, $value);
//        });
//        if ($filteredIterator->valid()) {
//            $index = $filteredIterator->getInnerIterator()->getSubIterator(1)->key();
//        }
    }
}
