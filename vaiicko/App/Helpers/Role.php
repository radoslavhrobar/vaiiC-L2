<?php

namespace App\Helpers;

enum Role : string
{
    case User = 'Používateľ';
    case Admin = 'Administrátor';
}