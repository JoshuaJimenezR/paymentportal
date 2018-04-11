<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Order extends Model {
    protected $fillable = [
        'card_number',
        'card_holder_name',
        'card_expirity_month',
        'card_expirity_year',
        'amount',
        'card_cvv',
        'country',
        'address',
        'city',
        'state',
        'zipcode',
        'phone_number',
        'email',
        'ip_address'
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }

}
