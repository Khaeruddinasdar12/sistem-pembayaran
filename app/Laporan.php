<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    public function getCreatedAtAttribute()
    {
        return \Carbon\Carbon::parse($this->attributes['created_at'])
        // ->diffForHumans();
        ->translatedFormat('d F Y');
    }

    // public function getLunasAtAttribute()
    // {
    //     return \Carbon\Carbon::parse($this->attributes['lunas_at'])
    //     ->diffForHumans();
    //     // ->translatedFormat('d F Y');
    // }
    public function admin()
    {
        return $this->belongsTo('App\Admin', 'updated_by');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
