<?php

use Illuminate\Support\Number;
use Illuminate\Support\Str;

if (! function_exists('fake_image_url')) {
    function fake_image_url($width = 640, $height = 640, $text = '', $background = '', $color = '')
    {
        blank($text) and $text = "{$width}x{$height}";
        blank($background) and $background = fake('en')->safeColorName();
        blank($color) and $color = fake('en')->safeColorName();
        $text = Str::slug(Str::substr($text, 0, 20));

        return "https://placehold.co/{$width}x{$height}/".$background.'/'.$color."?text={$text}";
    }
}

if (! function_exists('money')) {
    function money($price, $currency = null, $locale = null)
    {
        empty($currency) and $currency = env('CURRENCY', 'usd');
        empty($locale) and $locale = env('CURRENCY_LOCALE', 'us');

        return Number::currency($price, $currency, $locale);
    }
}
