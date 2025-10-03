<?php

use Carbon\Carbon;

if (!function_exists("formatValue")) {

    function formatValue($value)
    {

        $estados = [
            'Activo'      => 'bg-green-500 text-white px-2 py-1 rounded',
            'En proceso'  => 'bg-yellow-400 text-black px-2 py-1 rounded',
            'Inactivo'    => 'bg-gray-400 text-white px-2 py-1 rounded',
            'Pendiente'   => 'bg-yellow-200 text-black px-2 py-1 rounded',
            'Cancelado'   => 'bg-red-500 text-white px-2 py-1 rounded',
            'Completado'  => 'bg-blue-500 text-white px-2 py-1 rounded',
        ];
        if (is_null($value)) {
            return '';
        }
        if (is_string($value) && array_key_exists($value, $estados)) {
            return '<span class="' . $estados[$value] . '">' . $value . '</span>';
        }
        if (is_string($value) && $value && preg_match('/^\d{2}:\d{2}(:\d{2})?$/', $value)) {
            return Carbon::parse($value)->format('h:i A');
        }
        //  if (is_numeric($value) && preg_match('/^\d+(\.\d{2})$/', $value)) {
        //     return '$' . number_format($value, 2, '.', '');
        // }
        if ((is_string($value) && preg_match('/^-?\d+(?:\.\d{2})$/', $value)) || (is_numeric($value) && floor($value) != $value)) {
            $num = (float) $value;
            $sign = $num < 0 ? '-' : '';
            $num = abs($num);
            return $sign . '$' . number_format($num, 2, '.', ',');
        }
        if (filter_var($value, FILTER_VALIDATE_URL) && preg_match('#/storage/#', $value)) {
                $label = basename(parse_url($value, PHP_URL_PATH)) ?: 'Ver documento';
                return '<a href="' . $value . '" target="_blank" rel="noopener noreferrer" class="text-blue-600 underline">'
                        . $label . '</a>';
            }
        return $value;
    }
}
