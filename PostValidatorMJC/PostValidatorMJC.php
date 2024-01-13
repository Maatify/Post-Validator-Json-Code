<?php
/**
 * @copyright   ©2024 Maatify.dev
 * @Liberary    Post-Validator-Json-Code
 * @Project     Post-Validator-Json-Code
 * @author      Mohamed Abdulalim (megyptm) <mohamed@maatify.dev>
 * @since       2024-01-13 09:27 AM
 * @see         https://www.maatify.dev Maatify.com
 * @link        https://github.com/Maatify/post-validator-json-code view project on GitHub
 * @link        https://github.com/Maatify/Json-Code (maatify/json-code)
 * @link        https://github.com/Maatify/Functions (maatify/functions)
 * @link        https://github.com/Maatify/Logger (maatify/logger)
 * @link        https://github.com/daveearley/Email-Validation-Tool (daveearley/daves-email-validation-tool)
 * @link        https://github.com/giggsey/libphonenumber-for-php (giggsey/libphonenumber-for-php)
 * @copyright   ©2023 Maatify.dev
 * @note        This Project using for MYSQL PDO (PDO_MYSQL).
 * @note        This Project extends other libraries maatify/logger, maatify/json-code, maatify/post-validator.
 *
 * @note        This program is distributed in the hope that it will be useful - WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 * FITNESS FOR A PARTICULAR PURPOSE.
 *
 */

namespace Maatify\PostValidatorMJC;

use \App\Assist\AppFunctions;
use \App\Assist\RegexPatterns;
use Maatify\JsonCode\MJC;

class PostValidatorMJC extends PostValidatorMethods
{
    private static self $instance;
    protected RegexPatterns $regex_patterns;

    public static function obj(): self
    {
        if (! isset(self::$instance)) {
            self::$instance = new self();
        }
        self::$line = debug_backtrace()[0]['line'];

        return self::$instance;
    }

    public function __construct()
    {
        $this->regex_patterns = RegexPatterns::obj();
    }

    public function Require(string $name, string $type = 'string', string $more_info = ''): string
    {
        if (empty($_POST)) {
            MJC::MissingMethod();
        }

        if (empty($_POST[$name])) {
            MJC::Missing($name, $more_info, self::$line);

            return '';
        }

        return $this->HandleRequired($name, $type, $more_info);
    }

    public function RequireAcceptEmpty(string $name, string $type = 'string', string $more_info = ''): string
    {
        if (empty($_POST)) {
            MJC::MissingMethod();
        }

        if (! isset($_POST[$name])) {
            MJC::Missing($name, $more_info, self::$line);

            return '';
        }

        return $this->HandleRequired($name, $type, $more_info);
    }

    private function HandleRequired(string $name, string $type = 'string', string $more_info = ''): string
    {
        if (is_array($_POST[$name])) {
            MJC::Invalid($name, $more_info, self::$line);

            return '';
        }

        return $this->HandlePostType($name, $type, $more_info);
    }

    public function Optional(string $name, string $type = 'string', string $more_info = ''): string
    {
        if (! empty($_POST) && ! empty($_POST[$name]) && ! is_array($_POST[$name])) {
            return $this->HandlePostType($name, $type, $more_info);
        } else {
            if (in_array($type, ['page', 'limit'])) {
                if (empty($_POST[$name]) || ! is_numeric($_POST[$name])) {
                    return match ($type) {
                        'page' => 1,
                        'limit' => AppFunctions::pagination_limit,
                    };
                }
            }
        }

        return '';
    }

    private function HandlePostType(string $name, string $type, string $more_info): string
    {
        $postData = $_POST[$name] ?? '';

        switch ($type) {
            case 'email':
                return $this->validateEmail($postData, $name, $more_info);

            case 'ip':
                return $this->validateIP($postData, $name, $more_info);

            case 'phone':
                return $this->validatePhoneNumber($postData, $name, $more_info);

            case 'mobile_egypt':
                return $this->validateMobileEgyptNumber($postData, $name, $more_info);

            case 'day':
            case 'month':
                return $this->validateDayOrMonth($postData, $type, $name, $more_info);

            case 'float':
            case 'int':
                return $this->validateIntegerFloat($postData, $name, $more_info);

            default:
                $regexPattern = $this->regex_patterns::Patterns($type) ?: $this->Patterns($type);
                if(empty($regexPattern)){
                    return $this->clearInput($postData);
                }else{
                    if (preg_match($regexPattern, $postData)) {
                        return $this->clearInput($postData);
                    } else {
                        MJC::Invalid($name, $more_info, self::$line);
                        return '';
                    }
                }
        }
    }

}