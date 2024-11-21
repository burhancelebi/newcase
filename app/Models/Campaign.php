<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    protected $fillable = ['key', 'make_discount_sql', 'check_campaign_sql'];
}
