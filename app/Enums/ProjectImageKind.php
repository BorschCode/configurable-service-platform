<?php

namespace App\Enums;

enum ProjectImageKind: string
{
    case Before = 'before';
    case After = 'after';
    case Gallery = 'gallery';
}
