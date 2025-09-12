<?php

use Carbon\Carbon;
if (!function_exists("formatValue")) {

    function formatValue($value) {
        
        if (is_null($value)) {
            return '';
        }
        if ($value && preg_match('/^\d{2}:\d{2}(:\d{2})?$/', $value)) {
            return Carbon::parse($value)->format('h:i A');
        }
        //  if (is_numeric($value) && preg_match('/^\d+(\.\d{2})$/', $value)) {
        //     return '$' . number_format($value, 2, '.', '');
        // }
        if ((is_string($value) && preg_match('/^-?\d+(?:\.\d{2})$/', $value)) || (is_numeric($value) && floor($value) != $value)) {
            $num = (float) $value;
            $sign = $num < 0 ? '-' : '';
            $num = abs($num);
            return $sign.'$'.number_format($num, 2, '.', ',');
        }
        return $value;
    }
}
    