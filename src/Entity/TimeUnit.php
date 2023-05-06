<?php

namespace NystronSolar\GrowattApi\Entity;

enum TimeUnit: string
{
    case Day = 'day';

    case Month = 'month';

    case Year = 'year';
}
