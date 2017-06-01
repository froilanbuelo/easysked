<?php

namespace App;

use App\Event;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
   public function __construct()
   {
        
   }

    public function user(){
    	return $this->belongsTo('App\User');
    }
    public function getEvents(){
    	// dd($this->user->token);
    	$googl = new Googl;
    	$client = $googl->client();
        $client->setAccessToken($this->user->token);

    	$base_timezone = env('APP_TIMEZONE');

        $calendar = $this;
        $sync_token = $calendar->sync_token;
        $g_calendar_id = $calendar->calendar_id;
        $calendar_id = $calendar->id;

        $g_cal = new \Google_Service_Calendar($client);

        $g_calendar = $g_cal->calendars->get($g_calendar_id);
        $calendar_timezone = $g_calendar->getTimeZone();
        // dd($g_calendar);
        $events = Event::where('calendar_id', '=', $calendar_id)
            // ->select('event_id')
            ->pluck('event_id')
            ->toArray();
        // dd($events);
        $params = [
            'showDeleted' => true,
            'timeMin' => Carbon::now()
                ->setTimezone($calendar_timezone)
                ->toAtomString()
        ];

        if (!empty($sync_token)) {
            $params = [
                'syncToken' => $sync_token
            ];
        }

        $arrayTemp = array();

        $googlecalendar_events = $g_cal->events->listEvents($g_calendar_id, $params);
        // dd($googlecalendar_events->getItems());
        while (true) {
        	foreach ($googlecalendar_events->getItems() as $g_event) {
        		$g_event_id = $g_event->id;
                $g_event_title = $g_event->getSummary();
                $g_status = $g_event->status;
                // $arrayTemp[] = array(
                // 	'event_id'=>$g_event_id,
                // 	'title'=>$g_event_title,
                // 	'calendar_id' => $g_calendar_id,
                // 	// 'status'=>$g_status,
                // 	// 'datetime_start' => $g_datetime_start,
                //  //    'datetime_end' => $g_datetime_end,
                // );   
                if ($g_status != 'cancelled') {
                    $g_datetime_start = Carbon::parse($g_event->getStart()->getDateTime())
                        ->tz($calendar_timezone)
                        ->setTimezone($base_timezone)
                        ->format('Y-m-d H:i:s');
                    $g_datetime_end = Carbon::parse($g_event->getEnd()->getDateTime())
                        ->tz($calendar_timezone)
                        ->setTimezone($base_timezone)
                        ->format('Y-m-d H:i:s');
                    $arrayTemp[] = array(
	                	'event_id'=>$g_event_id,
	                	'title'=>$g_event_title,
	                	'calendar_id' => $g_calendar_id,
	                	'status'=>$g_status,
	                	'datetime_start' => $g_datetime_start,
                        'datetime_end' => $g_datetime_end,
	                );    
                    // dd(in_array($g_event_id, $events));
	                if (in_array($g_event_id, $events)) {
                        //update event
                        $event = Event::where('event_id', '=', $g_event_id)->first();
                        $event->title = $g_event_title;
                        $event->calendar_id = $calendar_id;
                        $event->event_id = $g_event_id;
                        $event->datetime_start = $g_datetime_start;
                        $event->datetime_end = $g_datetime_end;
                        $event->save();
                    } else {
                        //add event
                        $event = new Event;
                        $event->title = $g_event_title;
                        $event->calendar_id = $calendar_id;
                        $event->event_id = $g_event_id;
                        $event->datetime_start = $g_datetime_start;
                        $event->datetime_end = $g_datetime_end;
                        $event->save();
                    }
                }else {
                    //delete event
                    if (in_array($g_event_id, $events)) {
                        Event::where('event_id', '=', $g_event_id)->delete();
                    }
                }//if-else

        	}//foreach
        	$page_token = $googlecalendar_events->getNextPageToken();
            if ($page_token) {
                $params['pageToken'] = $page_token;
                $googlecalendar_events = $g_cal->events->listEvents('primary', $params);
            } else {
                $next_synctoken = str_replace('=ok', '', $googlecalendar_events->getNextSyncToken());

                //update next sync token
                $calendar = Calendar::find($calendar_id);
                $calendar->sync_token = $next_synctoken;
                $calendar->save();

                break;
            }
        }//while
        return ($arrayTemp);
    }
}
