<?php

namespace App\Models\Concerns;


trait HumanReadable
{
    public function humanReadableSize()
    {
        $units = ['B', 'KB', 'MB'];

        for ($i = 0; $this->size > 1024; $i++) {
            $this->size /= 1024;
        }

        return round($this->size, 2) . ' ' . $units[$i];
    }
}
