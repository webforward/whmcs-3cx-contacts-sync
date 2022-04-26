<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Phonebook extends Model
{
    protected $table = 'phonebook';

    protected $primaryKey = 'idphonebook';

    public $timestamps = false;

    protected $attributes = [
        'fkidtenant' => 1
    ];

    protected $fillable = [
        'firstname', // First Name
        'lastname', // Last Name
        'company', // Company
        'phonenumber', // Mobile
        'pv_an0', // Mobile 2
        'pv_an1', // Home
        'pv_an2', // Home 2
        'pv_an3', // Business
        'pv_an4', // Business 2
        'pv_an5', // Email Address
        'pv_an6', // Other
        'pv_an7', // Business Fax
        'pv_an8', // Home Fax
        'pv_an9', // Pager
    ];
}
