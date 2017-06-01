<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Event extends Model
{
    public function scopeForPeriod($query, $startDateTime, $endDateTime){
    	return  $query->where(DB::raw('"'.$startDateTime.'"'), '<', DB::raw('datetime_end'))
    		->where(DB::raw('"'.$endDateTime.'"'), '>', DB::raw('datetime_start'))
    		->orderBy('datetime_start');
    }
}
