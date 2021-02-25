<?php
require __DIR__ . '/vendor/autoload.php';
const SPREADSHEET_ID = '10n2MH8XvPFjtRjGiytuqwseyGDTtruHSh7ijlkceiFE';
//Reading data from spreadsheet.

$client = new \Google_Client();

$client->setApplicationName('Google Sheets and PHP');

$client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);

$client->setAccessType('offline');

$client->setAuthConfig(__DIR__ . '/credentials.json');

$service = new Google_Service_Sheets($client);

$get_range = 'A1:C1';
$response = $service->spreadsheets_values->get(SPREADSHEET_ID, $get_range);

$values = $response->getValues();

print_r($values);