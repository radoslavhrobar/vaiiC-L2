<?php

namespace App\Helpers;

enum Types : string
{
    case Movie = 'Film';
    case Series = 'Seriál';
    case Book = 'Kniha';
    case Both = 'Oboje';
}