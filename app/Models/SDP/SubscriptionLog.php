<?php

namespace App\Models\SDP;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionLog extends Model
{
    use HasFactory;

    protected $table = 'sdp_subscription_logs';
    protected $fillable = [
        'user_id',
        'username',
        'password',
        'msisdn',
        'action_type',
        'service_id',
        'sp_id',
        'date',
        'request_id',
        'sc',
        'description',
        'key',
    ];

    // OPERATOR SUBSCRIPTION value => cent
//    const OPERATOR_SUBSCRIPTION = [
//        2 => [ "name" => "ZAIN", "value" => 1 ],
//        3 => [ "name" => "OODI", "value" => 1 ],
//        4 => [ "name" => "JAWWAL", "value" => 1 ],
//        5 => [ "name" => "BATELCO", "value" => 1 ],
//        8 => [ "name" => "QANAWAT", "value" => 1 ],
//        11 => [ "name" => "VODAFONE", "value" => 1 ]
//    ];

    const TYPES = [
        1 => "New Subscriber",
        2 => "Billed MT Successfully",
        3 => "Failed to charge user",
        0 => "Opt out user"
    ];
    public static function getTableName() {
        return with(new static)->getTable();
    }

//    public function getOperatorName($operator_id) {
//        return self::OPERATOR_SUBSCRIPTION[$operator_id]["name"];
//    }
//
//    public function getOperatorValue($operator_id) {
//        return self::OPERATOR_SUBSCRIPTION[$operator_id]["value"];
//    }

    public function getTypeKeys() {
        return array_keys(self::TYPES);
    }

    public function getDescription($type_id) {
        return self::TYPES[$type_id];
    }
}
