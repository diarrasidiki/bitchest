<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('unserialize', [$this, 'unserialize']),
            new TwigFilter('json_decode', [$this, 'jsonDecode']),
            new TwigFilter('json_encode', [$this, 'jsonEncode']),
            new TwigFilter('printr', [$this, 'printr']),
            new TwigFilter('die', [$this, 'die']),
            new TwigFilter('array_slice', [$this, 'array_slice']),
            new TwigFilter('is_url', [$this, 'is_url']),
        ];
    }
    
    public function unserialize($str)
    {
        return \unserialize($str);
    }

    public function jsonDecode($str)
    {
        return json_decode($str);
    }

    public function jsonEncode($str)
    {
        return json_encode($str, JSON_NUMERIC_CHECK);
    }

    public function printr($arr)
    {
        return print_r($arr);
    }

    public function die($var)
    {
        return dd($var);
    }

    public function array_slice($arr)
    {
        return array_slice($arr, 0, 30);
    }

    public function is_url($str)
    {
        if (filter_var($str, FILTER_VALIDATE_URL) === FALSE) {
            return null;
        }
        else
        {
            return true;
        }
    }
}