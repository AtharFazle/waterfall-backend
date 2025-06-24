<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitorLog extends Model
{
    protected $table = 'visitor_logs';

    protected $fillable = [
        'ticket_number',
        'name',
        'amount',
        'check_in_time',
        'check_out_time',
    ];
}
