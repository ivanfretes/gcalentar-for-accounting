<?php

namespace App;

use Event;

/**
 */
class Calendar
{
	protected $id;
	protected $name;
	protected $total_amount;
	protected $type_calendar = [
		'ENTRY', 'EXIT'
	];

	/**
	 * @var 
	 * List of events of a calendario
	 */ 
	protected $events = [];

	
	public function __construct(){

	}


	public static function add_calendar(){
		
	}


	/**
	 * Retorna los eventos de un calendario
	 */
	public function get_all_events(){

	}

	public function get_sum_of_all_events(){

	}


}