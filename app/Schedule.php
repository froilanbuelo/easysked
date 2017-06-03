<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Schedule extends Model
{
    public function scopeForDate($query, $startDate = null) //, $numberOfDays = 7
    {
        if (is_null($startDate)){
    		$start = Carbon::now();
    	}else{
    		$start = Carbon::parse($startDate);
            if ($start->lt(Carbon::now())){
                return $query->where(DB::raw(0));
            }
    	}
    	return $query->where('start_date','<=',$start->toDateString())
    		->where('end_date','>=',$start->toDateString())
    		->where('days','like','%'.$start->dayOfWeek.'%')
    		->orderBy('start_time');
    }
}
