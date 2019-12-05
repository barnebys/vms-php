<?php
declare(strict_types=1);
namespace Vms;

/**
 * Class Valuation.
 *
 * @property string $id
 * @property string $title
 * @property string $userDescription
 * @property string $category
 * @property string $type
 * @property Collection $images
 * @property string $currency
 * @property Dimensions dimensions
 * @property string $client
 * @property string $submissionDate
 * @property string $assigningDate
 * @property string $valuingDate
 * @property string $completionDate
 * @property string $assignedExpert
 * @property string $lastSaveDate
 * @property VmsObject $valueRange
 * @property VmsObject $insurance
 * @property string $expertDescription
 * @property string $era
 * @property string $requester
 * @property string $notes
 * @property string $guaranteeLine
 * @property string $_humanReadbleId
 */
class Valuation extends ApiResource
{
    const OBJECT_NAME = 'valuation';

    const TYPE_EXPRESS = 'EXPRESS';
    const TYPE_NORMAL = 'NORMAL';

    const UNIT_CM = 'cm';
    const UNIT_INCH = 'inch';

    use ApiOperations\All;
    use ApiOperations\Fetch;
    use ApiOperations\Create;
}
