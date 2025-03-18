<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ErrorLog extends Model
{
    protected $table = 'error_logs';

    protected $fillable = [
        'level', 'message', 'context', 'stack_trace', 'file', 'line'
    ];
}
