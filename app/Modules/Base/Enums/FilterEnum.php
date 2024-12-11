<?php

namespace App\Modules\Base\Enums;

enum FilterEnum:string
{
    case whereIn = 'whereIn';
    case range = 'range';
    case equal = 'equal';
}
