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

class ValidatorConstantsValidators
{
    private static self $instance;

    public static function obj(): self
    {
        if (empty(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    const Require = 'Require';
    const AcceptEmpty = 'RequireAcceptEmpty';
    const Optional = 'Optional';
}