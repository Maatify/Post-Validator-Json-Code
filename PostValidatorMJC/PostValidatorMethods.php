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

use \App\Assist\RegexPatterns;
use libphonenumber\NumberParseException;
use Maatify\JsonCode\MJC;
use Maatify\Logger\Logger;

abstract class PostValidatorMethods extends ValidatorRegexPatterns
{
    protected static int|string $line;
    protected RegexPatterns $regex_patterns;
    protected function validateEmail(string $email, string $name, string $more_info = ''): string
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL) && HostEmailValidation::HostEmailValidation($email)) {
            return $email;
        } else {
            MJC::Invalid($name, $more_info, self::$line);
            return '';
        }
    }

    protected function validateIP(string $ip, string $name, string $more_info = ''): string
    {
        if (filter_var($ip, FILTER_VALIDATE_IP)) {
            return $ip;
        } else {
            MJC::Invalid($name, $more_info, self::$line);
            return '';
        }
    }

    protected function validatePhoneNumber(string $phone, string $name, string $more_info = ''): string
    {
        $regexPattern = $this->regex_patterns::Patterns('phone');
        $regexPatternFull = $this->regex_patterns::Patterns('phone_full');

        if (preg_match($regexPattern, $phone) || preg_match($regexPatternFull, $phone)) {
            $ph = PhoneNumberValidation::getInstance()->SetRegion()->SetNumber($phone);
            if ($ph->NumberIsValid()) {
                try {
                    $formattedPhone = $ph->NumberFormatE164();

                    if (str_contains($formattedPhone, '+20') && !in_array(substr($formattedPhone, 3, 2), [10, 11, 12, 15])) {
                        MJC::Invalid('phone', $more_info, self::$line);
                    }

                    return $formattedPhone;
                } catch (NumberParseException $e) {
                    Logger::RecordLog($e, 'post_validator_phone');
                    MJC::TryAgain();
                }
            }
        }

        MJC::Invalid($name, $more_info, self::$line);
        return '';
    }

    protected function validateMobileEgyptNumber(string $mobile, string $name, string $more_info = ''): string
    {
        $regexPattern = $this->regex_patterns::Patterns('mobile_egypt');

        if (preg_match($regexPattern, $mobile) && in_array(substr($mobile, 1, 2), [10, 11, 12, 15]) && strlen((int)$mobile) != 10) {
            return $mobile;
        } else {
            MJC::Invalid($name, $more_info, self::$line);
            return '';
        }
    }

    protected function validateDayOrMonth(string $value, string $type, string $name, string $more_info = ''): string
    {
        if (is_numeric($value)) {
            $value = (int)$value;

            if ($value > 0) {
                if ($type === 'month' && $value > 12) {
                    MJC::Invalid($name, $more_info, self::$line);
                    return '';
                }else{
                    if ($value < 10) {
                        $value = '0' . $value;
                    }

                    if (! preg_match($this->regex_patterns::Patterns($type), $_POST[$name])) {
                        MJC::Invalid($name, $more_info, self::$line);
                        exit();
                    }
                }

                return $value;
            }
        }

        MJC::Invalid($name, $more_info, self::$line);
        return '';
    }

    protected function validateIntegerFloat(string $value, string $name, string $more_info = ''): string
    {
        if (is_numeric($value)) {
            return (float)$value;
        }

        MJC::Invalid($name, $more_info, self::$line);
        return '';
    }

    protected function clearInput(string $data): string
    {
        $data = trim($data);
        $data = stripslashes($data);
        return htmlspecialchars($data, ENT_QUOTES | ENT_SUBSTITUTE);
    }
}