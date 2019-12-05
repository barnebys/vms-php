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
 * Fetch available Options to be used
 */
$options = Vms\Options::fetch();

/**
 * Upload an image to be used for the submitted valuation
 * and catch any error if upload failed
 */
$pathToImage = __DIR__ . '/../tests/data/moo.jpg';

try {
    $images = Vms\Images::create([$pathToImage]);
    echo "Images uploaded successfully" . PHP_EOL;
} catch (\Exception $e) {
    echo "Submission failed: " . $e->getMessage() . PHP_EOL;
}


/**
 * Assign the first available category and currency for this example
 */
$category = $options->categories->getIterator()->current();
$currency = $options->currencies->getIterator()->current();

/**
 * Submit the valuation and catch any error of submission failed
 */
try {
    $dimension = new Vms\Dimensions();
    $dimension->width = 100;
    $dimension->height = 200;
    $dimension->length = 90;
    $dimension->depth = 90;
    $dimension->unit = Vms\Valuation::UNIT_CM;

    $valuation = Vms\Valuation::create([
        'title' => "An example using PHP SDK",
        'userDescription' => "An example using PHP SDK",
        'category' => $category,
        'type' => Vms\Valuation::TYPE_EXPRESS,
        'images' => $images,
        'dimensions' => $dimension,
        'currency' => $currency
    ]);

    echo "Submitted with id: " . $valuation->id . PHP_EOL;
} catch (\Exception $e) {
    echo "Submission failed: " . $e->getMessage() . PHP_EOL;
}

/**
 * Using values to submit the valuation
 */
try {
    $valuation = Vms\Valuation::create([
        'title' => "An example using PHP SDK",
        'userDescription' => "An example using PHP SDK",
        'category' => "AfricanAndTribalArt",
        'type' => Vms\Valuation::TYPE_EXPRESS,
        'images' => $images,
        'dimensions' => [
            'width' => 100,
            'height' => 200,
            'length' => 90,
            'depth' => 20,
            'unit' => Vms\Valuation::UNIT_CM
        ],
        'currency' => "EUR"
    ]);

    echo "Submitted with id: " . $valuation->id . PHP_EOL;
} catch (\Exception $e) {
    echo "Submission failed: " . $e->getMessage() . PHP_EOL;
}