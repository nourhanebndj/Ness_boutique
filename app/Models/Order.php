<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
    'reference',
    'montant',
    'pseudo',
    'email',
    'prenom',
    'nom',
    'adresse',
    'ville',
    'code_postal',
    'pays',
    'telephone',
    'shipping_method',
    'shipping_cost',
    'payment_method',
    'ip_address',
    'total',
];


}