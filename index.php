<?php

declare(strict_types=1);

require_once 'vendor/autoload.php'; // Make sure to install Faker library using Composer

// Check if the number of contacts argument is provided
if ($argc !== 2 || !is_numeric($argv[1])) {
    echo "Usage: php index.php <number_of_contacts>\n";
    exit(1);
}

$numContacts = (int)$argv[1];

// Initialize the Faker library
$faker = Faker\Factory::create();

// Create the CSV file name with the prefix
$csvFilename = $numContacts.'_contacts.csv';

// Create and open the CSV file for writing
$csvFile = fopen($csvFilename, 'wb');

// Add a header row to the CSV file
fputcsv($csvFile, ['firstname', 'lastname', 'email', 'phone', 'address1', 'address2', 'address3', 'sentence']);

$start = microtime(true);

// Generate random records based on the specified number
for ($i = 0; $i < $numContacts; $i++) {
    $firstname = $faker->firstName;
    $lastname  = $faker->lastName;
    $email     = strtolower($firstname.'.'.$lastname.'@mailtest.mautic.com');
    $phone     = $faker->phoneNumber;
    $address1  = $faker->address;
    $address2  = $faker->address;
    $address3  = $faker->address;
    $sentence  = $faker->sentence;
    fputcsv($csvFile, [$firstname, $lastname, $email, $phone, $address1, $address2, $address3, $sentence]);
}

// Close the CSV file
fclose($csvFile);

$end = microtime(true);
$executionTime = number_format($end - $start, 4);

echo "CSV file with $numContacts records has been created: $csvFilename in $executionTime seconds\n";
