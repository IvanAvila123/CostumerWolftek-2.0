<?php

namespace App\Traits;

trait IsSuperAdmin
{
    public function isSuperAdmin()
    {
        return $this->hasRole('super-admin');
    }
}
