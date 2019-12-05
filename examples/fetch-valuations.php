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
 * Fetch all valuations by the limit of 5
 */
$valuations = Vms\Valuation::all([
    "query" => [
        "limit" => 5
    ]
]);

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

/**
 * Fetch all by query e.g. to sort, filter and/or paginate
 * See documentation for all options: https://backend-docs.vms.sh/#api-Valuation-GetValuations
 */

$valuations = Vms\Valuation::all([
    "query" => [
        "filter" => [
            "status" => "complete"
        ]
    ]
]);

echo "Number of completed valuations: ". $valuations->getTotalCount() . PHP_EOL;

$valuations = Vms\Valuation::all([
    "query" => [
        "filter" => [
            "status" => "submitted",
            "category" => "AfricanAndTribalArt"
        ]
    ]
]);

echo "Number of submitted valuations in AfricanAndTribalArt: ". $valuations->getTotalCount() . PHP_EOL;
