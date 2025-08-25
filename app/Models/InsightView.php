<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InsightView extends Model
{
    use HasFactory;

    protected $fillable = ['insight_id', 'ip_address', 'user_agent', 'user_id'];

    public function insight()
    {
        return $this->belongsTo(Insight::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}