<?php

namespace App\Policies;

use App\Models\CargoType;
use App\Models\Inquiry;
use Illuminate\Auth\Access\Response;

class Policies
{
    const INQUIRY = Inquiry::TAG;
}
