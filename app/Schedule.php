<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    public function scopeForDate($query, $startDate = null) //, $numberOfDays = 7
    {
        if (is_null($startDate)){
    		$start = Carbon::now();
    	}else{
    		$start = Carbon::parse($startDate);
    	}
    	return $query->where('start_date','<=',$start->toDateString())
    		->where('end_date','>=',$start->toDateString())
    		->where('days','like','%'.$start->dayOfWeek.'%')
    		->orderBy('start_time');
    		;
    }
}
