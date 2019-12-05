<?php
use Symfony\Component\Dotenv\Dotenv;

/**
 * Composer Autoload
 */
require '../vendor/autoload.php';

/**
 * Load ENV for this example
 */
$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/../.env');

/**
 * Init VMS by setting API KEY
 */
Vms\Vms::setApiKey($_ENV['VMS_API_KEY']);

/**
 * Fetch all valuations
 */
$valuations = Vms\Valuation::all();

/**
 * Iterate trough valuations
 */
foreach($valuations as $valuation) {
    /* @var Vms\Valuation $valuation */
    echo "Valuation ID: "  . $valuation->id . PHP_EOL;
}

echo "Number of valuations: " . $valuations->getTotalCount() . PHP_EOL . PHP_EOL;

/**
 * Fetch a single valuation by it's ID
 */
$valuationId = $valuations->getIterator()->current()->id;
$valuation = Vms\Valuation::fetch($valuationId);

echo "Valuation ID: "  . $valuation->id . PHP_EOL;