<?php

namespace App;

/**
 * 
 */
class Event
{
	protected $id;
	protected $name;
	protected $created_at;
	protected $update_at;
	protected $description;
	protected $date; // Is a day
	protected $hour; // Is a day hours
	protected $dateTime; // Is a datetime of the day
	protected $calendar_id;
	protected $currency = NULL;
	protected $timeZone;
	protected $status;

	
	function __construct()
	{
		# code...
	}


	public function get_event(){

	}

	public static function get_events_by_calendar(){
		
	}

}



?>