<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Appointment extends Model
{
    // public function scopeForPeriod($query, $startDateTime, $endDateTime){
    // 	return $query->where('start','>=',$startDateTime)
    // 		->where('end','<=',$endDateTime)
    // 		->orderBy('start');
    // }
    public function scopeForPeriod($query, $startDateTime, $endDateTime){
    	return  $query->where(DB::raw('"'.$startDateTime.'"'), '<', DB::raw('end'))
    		->where(DB::raw('"'.$endDateTime.'"'), '>', DB::raw('start'))
    		->orderBy('start');
    }

}
