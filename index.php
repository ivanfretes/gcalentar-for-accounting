<?php
require __DIR__ . '/vendor/autoload.php';



//$client = new Google_Client()
$client = \App\Auth::get_authorized_client();

// Get the API client and construct the service object.
$service = new Google_Service_Calendar($client);

// Print the next 10 events on the user's calendar.
$calendarId = 'primary';
$optParams = array(
  'maxResults' => 3,
  'orderBy' => 'startTime',
  'singleEvents' => true,
  'timeMin' => date('c'),
);


$results = $service->events->listEvents($calendarId, $optParams);
$events = $results->getItems();

if (empty($events)) {
    print "No upcoming events found.\n";
} else {
    print "Upcoming events:\n";
    foreach ($events as $event) {
        $start = $event->start->dateTime;
        if (empty($start)) {
            $start = $event->start->date;
        }

        echo "\n\n\n------------------------------------------------------\n";
        echo json_encode($event);
        //var_dump($event);

        printf("%s (%s)\n", $event->getSummary(), $start);
    }
}