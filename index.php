<?php
require __DIR__ . '/vendor/autoload.php';


define('ENTRY_CALENDAR_NAME', 'COBRADO');
define('EXIT_CALENDAR_NAME', 'PAGADO');

// Listado de calendarios configurados
$_calendars = [];


// Retorna cliente autorizado
$client = \App\Auth::get_authorized_client();

// Get the API client and construct the service object.
$service = new Google_Service_Calendar($client);

$optParams = array(
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
                'events' => [],
                'total_amounts' => 0
            ]);
    }
}

// Se agrega el monto
foreach ($_calendars as $_calendar) {

    $events = $service->events->listEvents($_calendar->id);
    $total_amounts = 0;

    if (empty($events)) {
        print "No upcoming events found.\n";
    } else {
        foreach ($events as $event) {

            $amount = extract_amount($event->getSummary()); 
            if ($amount != NULL){
                $_event = (object) [
                    'id' => $event->id,
                    'created_at' => $event->created,
                    'updated_at' => $event->updated,
                    'description' => $event->description,
                    'date' => $event->start->date,
                    'dateTime' => $event->start->dateTime,
                    'timeZone' => $event->timeZone,
                    'status' => $event->status,
                    'calendar_id' => $_calendar->id,
                    'amount' => $amount
                ];

                $total_amounts += $amount;
                $_calendar->total_amounts = $total_amounts;

                array_push(
                    $_calendar->events, 
                    $_event
                );
            }
        }
    }
}


$total_exits = 0;
$total_entries = 0;

foreach ($_calendars as $_calendar) {
    if ($_calendar->name == ENTRY_CALENDAR_NAME)
        $total_entries = $_calendar->total_amounts;
    else 
        $total_exits = $_calendar->total_amounts;
}

$balance = $total_entries - $total_exits;

printf("Total Entries: %s \nTotal exits: %s\n-----------\nBalance:%s\n\n", 
    $total_entries, 
    $total_exits, 
    $balance );



/**
 * Retorna una cantidad numerica si existe en la oracion, y la moneda
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


