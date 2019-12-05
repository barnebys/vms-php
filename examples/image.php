<?php
use Symfony\Component\Dotenv\Dotenv;
use Vms\Images;

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
 * Fetch Image
 */
$imageId = "1560452267_itxo.png";
$image = Images::fetch($imageId);

/**
 * Output stream with Content-Type
 */
$image->buffer->output();
