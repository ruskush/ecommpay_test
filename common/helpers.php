<?php
/**
 * @param string $key
 * @param mixed $default
 * @return mixed
 */
function env($key, $default = null) {
    // getenv is disabled when using createImmutable with Dotenv class
    if (isset($_ENV[$key])) {
        return $_ENV[$key];
    } elseif (isset($_SERVER[$key])) {
        return $_SERVER[$key];
    }

    return $default;
}
