<?php

namespace Core;

defined('ROOT') or die('Direct script access denied');

/**
 * Request Class
 *
 * This class handles incoming requests, including form submissions and URL information.
 * It provides methods to retrieve request method, check for POST requests, and access POST, GET, FILES, or all request data.
 */
class Request
{
    /**
     * Get the request method (e.g., 'GET', 'POST').
     *
     * @return string The request method.
     */
    public function method(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Check if the request method is POST.
     *
     * @return bool True if the request method is POST, false otherwise.
     */
    public function posted(): bool
    {
        return $_SERVER['REQUEST_METHOD'] == 'POST';
    }

    /**
     * Retrieve POST data for a specific key or all POST data.
     *
     * @param string $key The key to retrieve from POST data.
     *
     * @return string|array The POST data for the specified key or all POST data.
     */
    public function post(string $key = ''): string|array
    {
        if (empty($key)) {
            return $_POST;
        }

        if (!empty($_POST[$key])) {
            return $_POST[$key];
        }

        return '';
    }

    /**
     * Retrieve GET data for a specific key or all GET data.
     *
     * @param string $key The key to retrieve from GET data.
     *
     * @return string|array The GET data for the specified key or all GET data.
     */
    public function get(string $key = ''): string|array
    {
        if (empty($key)) {
            return $_GET;
        }

        if (!empty($_GET[$key])) {
            return $_GET[$key];
        }

        return '';
    }

    /**
     * Retrieve FILES data for a specific key or all FILES data.
     *
     * @param string $key The key to retrieve from FILES data.
     *
     * @return string|array The FILES data for the specified key or all FILES data.
     */
    public function files(string $key = ''): string|array
    {
        if (empty($key)) {
            return $_FILES;
        }

        if (!empty($_FILES[$key])) {
            return $_FILES[$key];
        }

        return '';
    }

    /**
     * Retrieve all request data for a specific key or all request data.
     *
     * @param string $key The key to retrieve from all request data.
     *
     * @return string|array The request data for the specified key or all request data.
     */
    public function all(string $key = ''): string|array
    {
        if (empty($key)) {
            return $_REQUEST;
        }

        if (!empty($_REQUEST[$key])) {
            return $_REQUEST[$key];
        }

        return '';
    }

    /**
     * Retrieve input data from POST or provide a default value.
     *
     * @param string $key     The key to retrieve from POST data.
     * @param string $default The default value if the key is not found in POST data.
     *
     * @return string The POST data for the specified key or the default value.
     */
    public function input(string $key = '', string $default = ''): string
    {
        if (!empty($_POST[$key])) {
            return $_POST[$key];
        }

        return $default;
    }
}
