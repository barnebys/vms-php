<?php
use Symfony\Component\Dotenv\Dotenv;
use Vms\Pdf;

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
 * Fetch PDF
 */
$valuationId = "5d0519851490bb63ec62ae3f";
$pdf = Pdf::fetch($valuationId);

/**
 * Output stream with Content-Type
 */
$pdf->buffer->output();


/**
 * Save to file
 */
$pdf->buffer->saveTo('/tmp/example.pdf');