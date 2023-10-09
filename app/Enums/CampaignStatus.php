<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class CampaignStatus extends Enum
{
    public const AWAITING_TO_USE = 0;
    public const COMPLETED = 1;
    public const CANCELED = 2;

}
