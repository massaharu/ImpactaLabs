<?php
////////////////////////////// HEADER ////////////////////////////////////////////////////////////
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 300);
//require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");
require_once '../../src/Google_Client.php';
require_once '../../src/contrib/Google_CalendarService.php';
session_start();

/////////////// FUNCTION //////////////////////////////////////////////////////////////////////////
function fn_getOwnerId($calListItems){
		
	foreach($calListItems['items'] as $calItems){
		if($calItems['accessRole'] == "owner"){
			return $ID = $calItems['id']; 
		}
	}
}

function fn_removeAllEvents($events){
	global $calService;
	
	foreach($events['items'] as $eventsItems){
		//echo "ID: ".$eventsItems["id"]."<br />Nome: ".$eventsItems["summary"]."<br /><br />";
		$calService->events->delete($events["summary"], $eventsItems["id"]);
	}
}

function pre($arr){
	echo "<pre>";
	var_dump($arr);
	echo "</pre><hr />";
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////

$client = new Google_Client();

//$client->setApplicationName("Google Calendar PHP Starter Application");

// Visit https://code.google.com/apis/console?api=calendar to generate your
// client id, client secret, and to register your redirect uri.
$client->setClientId('647646547672-phrl4nktf2q9vusprs6vr7pjn04bviob.apps.googleusercontent.com');
$client->setClientSecret('TT9eVDAfX3Z0bR6PUpdnQxUB');
$client->setRedirectUri('https://simpac.impacta.com.br/simpacweb/labs/Massaharu/labsTests/google-api-php-client/examples/calendar/simple.php');
$client->setDeveloperKey('AIzaSyDyac4e3TBzo_tageYqep3GJooeMkTNoGE');

$calService = new Google_CalendarService($client);

if (isset($_GET['logout'])) {
	echo "<br><br><font size=+2>Logging out</font>";
	unset($_SESSION['token']);
}

if (isset($_GET['logout'])) {
  unset($_SESSION['token']);
}
 
if (isset($_GET['code'])) {
  $client->authenticate($_GET['code']);
  $_SESSION['token'] = $client->getAccessToken();
  echo 'Location: https://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
  header('Location: https://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);
}

if (isset($_SESSION['token'])) {
  $client->setAccessToken($_SESSION['token']);
}

if ($client->getAccessToken()) {
	$calList = $calService->calendarList->listCalendarList();
	
	print "<h1>Calendar List</h1><pre>" . print_r($calList, true) . "</pre>";
	
	echo "<hr />";
	
	$events = $calService->events->listEvents(fn_getOwnerId($calList));
	
	pre($events);
	
	fn_removeAllEvents($events);
	
	
	
    
	/*$event = new Google_Event();
	
	$event->setSummary('Halloween');
	$event->setLocation('The Neighbourhood');
	$start = new Google_EventDateTime();
	$start->setDateTime('2014-01-31T11:00:00.000-05:00');
	$event->setStart($start);
	$end = new Google_EventDateTime();
	$end->setDateTime('2014-01-31T11:25:00.000-05:00');
	$event->setEnd($end);
	$createdEvent = $calService->events->insert('massa.kunikane@gmail.com', $event);
	
	echo pre($createdEvent);*/
  
  



	$_SESSION['token'] = $client->getAccessToken();
} else {
	
  $authUrl = $client->createAuthUrl();
  print "<a class='login' href='$authUrl'>Connect Me!</a>";
}

/*
$calendarListEntry = $calService->calendarList->get('massa.kunikane@gmail.com');

exit(pre($calendarListEntry));
$calendarListEntry->setColorId('2');

$updatedCalendarListEntry = $calService->calendarList->update($calendarListEntry->getId(), $calendarListEntry);

echo $updatedCalendarListEntry->getEtag();*/
?>

<iframe src="https://www.google.com/calendar/embed?src=massa.kunikane%40gmail.com&ctz=America/Sao_Paulo" style="border: 0" width="800" height="600" frameborder="0" scrolling="no"></iframe>