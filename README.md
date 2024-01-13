# PostValidator

maatify.dev post validator handler, known by our team


# Installation

```shell
composer require maatify/post-validator-json-code
```
    
## Important
Don't forget to create Class App\Assist\RegexPatterns

```php
<?php
/**
 * Created by Maatify.dev
 * User: Maatify.dev
 * Date: 2024-05-12
 * Time: 09:33 AM
 * https://www.Maatify.dev
 */

namespace App\Assist;

class RegexPatterns
{
    private static self $instance;

    public static function obj(): self
    {
        if(!isset(self::$instance))
        {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public static function Patterns(string $typeName): string
    {
        return match ($typeName) {
            'name',
            'name_ar' => '/^[\p{Arabic}a-zA-Z_\-\s\d]*$/iu',
            'name_en' => '/^[a-zA-Z_\-\s]*$/i',
            'username' => '/^[a-zA-Z0-9]*$/i',
            'main_hash' => '/^[A-F0-9]{32}$/',
            'phone' => '/^\d*$/i',
            'phone_full' => '/^\+\d*$/i',
            'year' => '/^(19[0-9][0-9]|2[0-1][0-9][0-9])$/',
            'month' => '/^((0[1-9]|1[0-2]))$/',
            'day' => '/^(0[1-9]|[1-2][0-9]|3[0-1])$/',
            'year_month' => '/^(19[0-9][0-9]|2[0-1][0-9][0-9])-(0[1-9]|1[0-2])$/',
            'date' => '/^(19[0-9][0-9]|2[0-1][0-9][0-9])-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/',
            'datetime' => '/^(19[0-9][0-9]|2[0-1][0-9][0-9])-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1]) (0[0-9]|1[0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])$/',
            'password' => '/^(?=.*\d)(?=.*[a-zA-Z])[0-9A-Za-z!@#$%+_\-&]{7,70}$/',
            'account_no' => '/^[0-9]{9}$/',
            'egypt_national_id' => '/^[0-9]{14}$/',
            'pin', 'code' => '/^[0-9]{6}$/',
            'app_type' => '/^[1-3]{1}$/',
            'int' => '/^[0-9]+$/i',
            'float' => '/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/',
            'bool' => '/^[0-1]{1}$/',
            'device_id' => '/^[a-zA-Z_\-\d]*$/i',
            default => '',
        };
    }

}
```

Don't forget to create Class App\Assist\AppFunctions

```php
<?php
/**
 * Created by Maatify.dev
 * User: Maatify.dev
 * Date: 2024-11-02
 * Time: 09:36 AM
 * https://www.Maatify.dev
 */

namespace App\Assist;

use Maatify\Functions\GeneralFunctions;

class AppFunctions
{
    const pagination_limit = 10;

    public static function PortalUrl(): string
    {
        return GeneralFunctions::HostUrl() . 'portal/';
    }

    public static function SiteUrl(): string
    {
        return GeneralFunctions::HostUrl();
    }

    public static function HeaderMeta(string $title, string $description): void
    {
        echo '
        <meta name="description" content="' . $description . '">
        <meta property="og:title" content="' . $title . '" />
        <meta property="og:site_name" content="' . $title . '">
        <meta property="og:type" content="website" />
        <meta property="og:url" content="' . GeneralFunctions::CurrentUrl() . '">
        <meta property="og:image" content="' . GeneralFunctions::HostUrl() . 'images/logo.png" />
        <meta property="og:description" content="' . $description . '">
        <title>' . $title . '</title> 
            ';
    }

    public static function CurrentDateTime(): string
    {
        return date("Y-m-d H:i:s", time());
    }

    public static function CurrentTime(): string
    {
        return date("H:i:s", time());
    }

    public static function CurrentDate(): string
    {
        return date("Y-m-d", time());
    }

    public static function IP(): string
    {
        return GeneralFunctions::UserIp();
    }

    public static function DefaultDateTime(): string
    {
        return '1900-01-01 00:00:00';
    }

}

```

Don't forget to create Class App\Assist\MJCVarCodes

```php
<?php
/**
 * Created by Maatify.dev
 * User: Maatify.dev
 * Date: 2024-01-13
 * Time: 08:40:18
 * https://www.Maatify.dev
 */

namespace App\Assist;

class MJCVarCodes
{
    public static function Codes(string $varName): int
    {
        return match ($varName) {
            'action' => 10,
            'api' => 11,
            'app_type' => 12,
            'main_hash' => 13,
            'hash' => 14,
            'token' => 15,
            'device_id' => 16,
            'device_name' => 17,
            'device_version' => 18,
            'account_no' => 19,
            'phone' => 20,
            'email' => 21,
            'phone_or_email' => 22,
            'username' => 23,
            'code' => 24,
            'password' => 25,
            'old_password' => 26,
            'transaction_pin' => 27,
            'old_transaction_pin' => 28,
            'ip' => 29,
            'language' => 30,
            'national_id' => 31,
            'credentials' => 32,
            'first_name' => 33,
            'last_name' => 34,
            'name' => 35,
            'description' => 36,
            'status' => 37,
            'title' => 38,
            'birthdate' => 39,
            'gender' => 40,
            'country' => 41,
            'governorate' => 42,
            'city' => 43,
            'area' => 44,
            'address' => 45,
            'info' => 46,
            'base64_file' => 47,
            'file' => 48,
            default => 0,
        };
    }
}
```
