<?php


if (!function_exists('admin')) {
    function admin(): ?\Illuminate\Contracts\Auth\Authenticatable
    {
        if (auth('admin')->check()) {
            return auth('admin')->user();
        }
        return null;
    }
}

if (!function_exists('settings')) {
    function settings(string $key)
    {
        return config('settings.' . $key);
    }
}

if (!function_exists('getLangs')) {
    function getLangs(bool $all = false): array
    {
        return array_filter(json_decode(config('settings.lang'), true, 512, JSON_THROW_ON_ERROR), function ($lang) use ($all) {
            return $all || $lang['active'] === true;
        });
    }
}

if (!function_exists('params')) {
    function params(string $key)
    {
        return config('params.' . $key);
    }
}

if (!function_exists('getErrorByCode')) {
    /**
     * @throws Exception
     */
    function getErrorByCode(int $key)
    {
        $code = str(str_pad($key, 3, '0', STR_PAD_LEFT))->prepend('E-');
        $result = config('api.errors-code.' . $code);

        if (is_null($result))
        {
            throw new Exception('Invalid API error code');
        }
        return $result;
    }
}

if (! function_exists('money'))
{
    function money(float $amount, string $currency = null): string
    {
        $currency = $currency ?? (string)settings('currency_code');
        return number_format($amount,2,',','') .' '.$currency;
    }
}

