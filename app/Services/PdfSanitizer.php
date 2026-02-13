<?php

namespace App\Services;

class PdfSanitizer
{
    /**
     * Sanitize a Laravel Model or Array into a view-safe object with valid UTF-8.
     *
     * @param mixed $data
     * @return mixed
     */
    public static function sanitize($data)
    {
        if (is_string($data)) {
            // Remove null bytes and invalid UTF-8
            $clean = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u', '', $data);
            return mb_convert_encoding($clean, 'UTF-8', 'UTF-8');
        }

        if (is_array($data)) {
            return array_map([self::class, 'sanitize'], $data);
        }

        if ($data instanceof \Illuminate\Database\Eloquent\Model) {
            // Convert to array to access all attributes and relations that are loaded
            // We use toArray() but we must ensure relations are loaded first.
            $array = $data->toArray();
            $cleanArray = self::sanitize($array);
            // Convert back to object for Blade compatibility ($invoice->field)
            return self::arrayToObject($cleanArray);
        }

        if (is_object($data)) {
            if (method_exists($data, 'toArray')) {
                return self::sanitize($data->toArray());
            }
            $array = (array) $data;
            $cleanArray = self::sanitize($array);
            return self::arrayToObject($cleanArray);
        }

        return $data;
    }

    private static function arrayToObject($array)
    {
        $object = new \stdClass();
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                // Check if this array looks like a collection or just a map
                // If keys are 0, 1, 2... it's a list.
                if (array_is_list($value)) {
                    $object->$key = array_map([self::class, 'arrayToObjectHelper'], $value);
                } else {
                    $object->$key = self::arrayToObject($value);
                }
            } else {
                $object->$key = $value;
            }
        }
        return $object;
    }

    public static function arrayToObjectHelper($value)
    {
        if (is_array($value)) {
            return self::arrayToObject($value);
        }
        return $value;
    }

    // Original helper kept for compatibility if needed
    public static function cleanString(string $string): string
    {
        return self::sanitize($string);
    }
}
