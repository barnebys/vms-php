<?php
declare(strict_types=1);
namespace Vms;

/**
 * Class PDf.
 *
 * @property Buffer $buffer
 */
class Pdf extends ApiResource
{
    const OBJECT_NAME = 'pdf';

    use ApiOperations\Fetch;
}
