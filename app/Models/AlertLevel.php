<?php

namespace App\Models;

use Illuminate\Validation\Rules\Enum;

final class AlertLevel extends Enum
{
    const SUCCESS = 'success';
    const DANGER = 'danger';
    const WARNING = 'warning';
    const INFO = 'info';
}
