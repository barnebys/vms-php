<?php
declare(strict_types=1);

namespace Vms\ApiOperations;

use Vms\VmsObject;

trait Fetch
{
    public static function fetch(string $id, array $opts = []): self
    {
        $instance = new static($id, $opts);
        return $instance->refresh();
    }
}
