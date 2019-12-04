<?php
declare(strict_types=1);

namespace Vms\Tests;

use Symfony\Component\Dotenv\Dotenv;

class TestCase extends \PHPUnit\Framework\TestCase
{
    protected function setUp(): void
    {
        if(is_file(__DIR__ . '/../.env')) {
            $dotenv = new Dotenv();
            $dotenv->load(__DIR__ . '/../.env');
        }

        \Vms\Vms::setApiKey($_ENV['VMS_API_KEY']);
        //\Vms\Vms::debug();
    }
}
