<?php

namespace App;

use App\Event;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Service extends Model
{
	protected $fillable = [
        'name', 'description', 'duration','url', 'user_id',
    ];
    public function owner(){
        return $this->belongsTo('App\User','user_id','id');
    }
    public function schedules(){
        return $this->hasMany('App\Schedule');
    }
    public function appointments(){
        return $this->hasMany('App\Appointment');
    }
    public function isAvailableOnDay($p_day){
    	return strpos($this->days, "$p_day") !== FALSE;
    }
    // public function isAvailableOnDate($p_date){
    // 	$date = Carbon::parse($p_date);
    // 	if ($this->isAvailableOnDay($date->dayOfWeek)){
    // 		if ($this->is_infinite || 
    // 			($this->start_date <= $date->toDateString() && $this->end_date >= $date->toDateString()) ){
    // 			return true;
    // 		}
    // 	}
    // 	return false;
    // }
    public function generateAvailabilities($p_date = null, $p_numberOfDays = 7){
        $arrTemp = array();
        // dd($this->owner);
        foreach($this->owner->calendars as $calendar){
            $arrTemp[] = $calendar->getEvents();
        }
        
        // dd($arrTemp);
        if (is_null($p_date)){
            $date = Carbon::now();
        }else{
            $date = Carbon::parse($p_date);
        }
        $schedulesArray = array();

        for($i = 0; $i < $p_numberOfDays; $i++){
            $k = $date->toDateString();
            $schedules = $this->schedules()->forDate($date->toDateString())->get();
            if (count($schedules) > 0 ){
                foreach($schedules as $schedule){
                    $arrayStartAndEnd = array();

                    $start = Carbon::parse($date->toDateString().' '.$schedule->start_time);
                    $end = Carbon::parse($date->toDateString().' '.$schedule->end_time);
                    // dd($end->toDateTimeString());
                    
                    
                    // DB::connection()->enableQueryLog();
                    $appointments = $this->appointments()->forPeriod($start->toDateTimeString(),$end->toDateTimeString())->get();
                    $events = Event::forPeriod($start->toDateTimeString(),$end->toDateTimeString())->get();
                    // dd($appointments);
                    // $queries = DB::getQueryLog();
                    // $last_query = end($queries);
                    // dd($queries);
                    foreach($appointments as $appointment){
                        $arrayStartAndEnd[] = array('start' => $appointment->start, 'end' => $appointment->end);
                    }
                    foreach($events as $event){
                        $arrayStartAndEnd[] = array('start' => $event->datetime_start, 'end' => $event->datetime_end);
                    }

                    // $arrayStartAndEnd[] = array(
                    //     'start' => Carbon::parse($k.' '.$schedule->start_time)->toDateTimeString(), 
                    //     'end' => Carbon::parse($k.' '.$schedule->start_time)->toDateTimeString()
                    // );
                    // $arrayStartAndEnd[] = array(
                    //     'start' => Carbon::parse($k.' '.$schedule->end_time)->toDateTimeString(), 
                    //     'end' => Carbon::parse($k.' '.$schedule->end_time)->toDateTimeString()
                    // );

                    // dd($arrayStartAndEnd);
                    $startArray = array();
                    foreach ($arrayStartAndEnd as $key => $row){
                        $startArray[$key] = $row['start'];
                    }
                    array_multisort($startArray, SORT_ASC, $arrayStartAndEnd);
                    // dd($arrayStartAndEnd);

                    $startOfTheSchedule = array(
                        'start' => Carbon::parse($k.' '.$schedule->start_time)->toDateTimeString(), 
                        'end' => Carbon::parse($k.' '.$schedule->start_time)->toDateTimeString()
                    );
                    $endOfTheSchedule = array(
                        'start' => Carbon::parse($k.' '.$schedule->end_time)->toDateTimeString(), 
                        'end' => Carbon::parse($k.' '.$schedule->end_time)->toDateTimeString()
                    );
                    array_unshift($arrayStartAndEnd, $startOfTheSchedule);
                    array_push($arrayStartAndEnd, $endOfTheSchedule);
                    // dd($arrayStartAndEnd);
                    
                    $previousStart = null;
                    for ($c = 0; $c < count($arrayStartAndEnd) - 1; $c++){
                        if (is_null($previousStart) || $previousStart < Carbon::parse($arrayStartAndEnd[$c]['end'])){
                            $start = Carbon::parse($arrayStartAndEnd[$c]['end'])->addMinutes($this->buffer_before);
                            $previousStart = $start->copy();
                        }
                        $end = Carbon::parse($arrayStartAndEnd[$c+1]['start']);
                        if ($start->lte($end)){
                            $ctr = $start->copy()->addMinutes($this->duration);
                            while($ctr->lte($end)){
                                $schedulesArray[$k][$start->format('g:i a')] = array($start->copy(),$ctr->copy());
                                $start = $ctr->addMinutes($this->buffer_after)->addMinutes($this->buffer_before);
                                $ctr = $start->copy()->addMinutes($this->duration);
                            } 
                        }
                    }
                    // $ctr = $start->copy()->addMinutes($this->duration);
                    // while($ctr->lte($end)){
                    //     $schedulesArray[$k][$start->format('g:i a')] = array($start,$ctr);
                    //     $start = $ctr;
                    //     $ctr = $start->copy()->addMinutes($this->duration);
                    // } 
                }
            }else{
                $schedulesArray[$k] = array();
            }
            $date->addDays(1);
        }
        // dd($schedulesArray);
        return $schedulesArray;
    }
    // public function generateAvailabilities($p_date = null, $p_numberOfDays = 7){
    // 	if (is_null($p_date)){
    // 		$date = Carbon::now();
    // 	}else{
    // 		$date = Carbon::parse($p_date);
    // 	}
    // 	$schedulesArray = array();

    // 	for($i = 0; $i < $p_numberOfDays; $i++){
    // 		$k = $date->toDateString();
    //         $schedules = $this->schedules()->forDate($date->toDateString())->get()->toArray();
    // 		if ($this->isAvailableOnDate($k)){
    // 			$arrayStartAndEnd = array();

    // 			$start = Carbon::parse($date->toDateString().' '.$this->start_time);
    // 			$end = Carbon::parse($date->toDateString().' '.$this->end_time);

    // 			$arrayStartAndEnd[$this->start_time] = $this->start_time;
    //     		$arrayStartAndEnd[$this->end_time] = $this->end_time;

    //     		$ctr = $start->copy()->addMinutes($this->duration);
    // 			while($ctr->lte($end)){
    // 				$schedulesArray[$k][$start->format('g:i a')] = array($start,$ctr);
    // 				$start = $ctr;
    // 				$ctr = $start->copy()->addMinutes($this->duration);
    // 			} 
    // 		}else{
    // 			$schedulesArray[$k] = array();
    // 		}
    //     	$date->addDays(1);
    //     }
    //     return $schedulesArray;
    // }
}
