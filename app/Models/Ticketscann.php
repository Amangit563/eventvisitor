<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticketscann extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'ticket_id',
        'date',
        'time',
        'device_no',
        'name',
        'phone',
        'email',
        'location',
        'designation',
        'company_name',
        'company_location',
        'event_name',
        'event_location',
        'col1',
        'col2',
        'col3',
    ];

}
