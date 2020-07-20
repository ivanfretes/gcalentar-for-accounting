<?php
require __DIR__ . '/vendor/autoload.php';


define('ENTRY_CALENDAR_NAME', 'INGRESOS');
define('EXIT_CALENDAR_NAME', 'EGRESOS');

// Listado de calendarios configurados
$_calendars = [];
$_events = [];


// Retorna cliente autorizado
$client = \App\Auth::get_authorized_client();

// Get the API client and construct the service object.
$service = new Google_Service_Calendar($client);

$optParams = array(
  'maxResults' => 3,
  'orderBy' => 'startTime',
  'singleEvents' => true,
  'showDeleted' => false,
  'timeMin' => date('c'),
);


// Listado de calendarios
$calendarList = $service->calendarList->listCalendarList();

foreach ($calendarList->getItems() as $calendarListEntry) {

    if ($calendarListEntry->getSummary() == ENTRY_CALENDAR_NAME || 
        $calendarListEntry->getSummary() == EXIT_CALENDAR_NAME){
        
            array_push($_calendars, (object) [
                'id' => $calendarListEntry->getId(),
                'name' => $calendarListEntry->getSummary(),
                'events' => []
            ]);
    }
}


// Se agrega el monto
foreach ($_calendars as $_calendar) {

    $events = $service->events->listEvents($_calendar->id);

    if (empty($events)) {
        print "No upcoming events found.\n";
    } else {
        foreach ($events as $event) {
            $start = $event->start->dateTime;
            if (empty($start)) {
                $start = $event->start->date;
            }

            $monto = extract_amount($event->getSummary()); 
            if ($monto != NULL){
                $_event = (object) [
                    'id' => $event->id,
                    'created_at' => $event->created,
                    'updated_at' => $event->updated,
                    'description' => $event->description,
                    'date' => $event->date,
                    'dateTime' => $event->dateTime,
                    'timezone' => $event->dateTime,
                ];
            }
        }
    }

}


/**
 * Retorna una cantidad numerica si existe en la oracion
 */
function extract_amount($string){
    $words = preg_replace("/\./", '', $string);
    $words = explode(" ", $words);

    foreach ($words as $index => $word) {
        if (is_numeric($word)){
            return $word;
        }
    }

    return NULL;
}