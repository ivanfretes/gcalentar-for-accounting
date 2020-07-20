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
	protected $datetime; // Is a datetime
	protected $calendar_id;
	protected $currency = NULL;
	protected $timezone;

	
	function __construct(argument)
	{
		# code...
	}


	public function get_event(){

	}

	public static function get_events_by_calendar(){
		
	}

}



?>