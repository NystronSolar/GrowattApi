<?php

namespace NystronSolar\GrowattApi\Entity;

enum TimeUnit: string
{
    case Day = 'day';
    
    case Week = 'week';

    case Month = 'month';

    case Year = 'year';
}
