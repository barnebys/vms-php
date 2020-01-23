<?php
declare(strict_types=1);
namespace Vms\Tests;

use Symfony\Component\Dotenv\Dotenv;

class TestCase extends \PHPUnit\Framework\TestCase
{
    protected function setUp(): void
    {
        if (is_file(__DIR__ . '/../.env')) {
            $dotenv = new Dotenv();
            $dotenv->load(__DIR__ . '/../.env');

            putenv('VMS_API_KEY=' . $_ENV['VMS_API_KEY']);
            putenv('VMS_ADMIN_API_KEY=' . $_ENV['VMS_ADMIN_API_KEY']);
        }

        \Vms\Vms::setApiKey(getenv('VMS_API_KEY'));

        if ($_ENV['VMS_ENV'] === 'staging') {
            \Vms\Vms::useStaging();
        }

        //\Vms\Vms::debug();
    }
}
