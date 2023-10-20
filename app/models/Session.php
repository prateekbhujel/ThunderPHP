<?php

namespace Core;

defined('ROOT') or die('Direct script access denied');
 
/**
 * Session Class
 *
 * This class manages sessions and provides functions for setting, getting, authenticating, and checking the user's login status.
 */
class Session
{
    private $varKey     = 'APP';
    private $userKey    = 'USER';

    private function startSession(): int
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();

        return 1;
    }

    /**
     * Set session data.
     *
     * @param string|array $keyOrArray The session key or an array of key-value pairs.
     * @param mixed $value             The value for the session key (if $keyOrArray is a string).
     *
     * @return bool True if the session data was set successfully, false otherwise.
     */
    public function set(string|array $keyOrArray, mixed $value = null): bool
    {
        $this->startSession();

        if (is_array($keyOrArray)) {
            foreach ($keyOrArray as $key => $value) {
                $_SESSION[$this->varKey][$key] = $value;
            }

            return true;
        } else {
            $_SESSION[$this->varKey][$keyOrArray] = $value;

            return true;
        }

        return false;
    }

    /**
     * Get session data by key.
     *
     * @param string $key The session key.
     *
     * @return mixed
     *   --The session data associated with the given key or false if not found.
     */
    public function get(string $key): mixed
    {
        $this->startSession();

        if (!empty($_SESSION[$this->varKey][$key]))
            return $_SESSION[$this->varKey][$key];

        return false;
    }


    /**
     * Pop a value associated with the specified key from the session.
     *
     * This method retrieves a value from the session associated with the given key,
     * and then removes it from the session data.
     *
     * @param string $key The key for which to retrieve and remove the value from the session.
     *
     * @return mixed|false The value associated with the specified key, or false if not found.
     */
    public function pop(string $key): mixed
    {
        $this->startSession();
        if(!empty($_SESSION[$this->varKey][$key]))
        {   
            $var = $_SESSION[$this->varKey][$key];
            unset($_SESSION[$this->varKey][$key]);
            return $var;
        }

        return false;
    }


    /**
     * Authenticate the user.
     *
     * @param object|array $row The user data to be stored in the session.
     *
     * @return bool True if the user is authenticated and data is stored, false otherwise.
     */
    public function auth(object|array $row): bool
    {
        $this->startSession();

        $_SESSION[$this->userKey] = $row;

        return true;
    }

    /**
     * Check if the user is logged in.
     *
     * @return bool True if the user is logged in, false otherwise.
     */
    public function is_logged_in(): bool
    {
        $this->startSession();

        if (empty($_SESSION[$this->userKey]))
            return false;

        if (is_object($_SESSION[$this->userKey]) || is_array($_SESSION[$this->userKey]))
            return true;

        return false;
    }

    /**
     * Reset the session.
     *
     * @return bool True if the session is reset successfully, false otherwise.
     */
    public function reset(): bool
    {
        session_destroy();
        session_regenerate_id();

        return true;
    }

    /**
     * Log the user out.
     *
     * @return bool True if the user is logged out successfully, false otherwise.
     */
    public function logout(): bool
    {
        $this->startSession();

        if (!empty($_SESSION[$this->userKey]))
            unset($_SESSION[$this->userKey]);

        return true;
    }

    /**
     * Get a value from the user's session data.
     *
     * @param string $key The key to retrieve from the user's session data.
     *
     * @return mixed The value associated with the given key or false if not found.
     */
    public function user(string $key = ''): mixed
    {
        $this->startSession();

        if (!empty($_SESSION[$this->userKey])) 
        {
        	if(empty($key))
        		$_SESSION[$this->userKey];

            if(is_object($_SESSION[$this->userKey]))
            {
            	if(!empty($_SESSION[$this->userKey]->$key))
            		return $_SESSION[$this->userKey]->$key;
            }else
            if(is_array($_SESSION[$this->userKey]))
            {
            	if(!empty($_SESSION[$this->userKey][$key]))
            		return $_SESSION[$this->userKey][$key];
            }
        }

        return null;
    }


    /**
     * Get all information stored in the session's "var" section.
     *
     * This function returns all data stored in the session's "var" section, excluding user-specific data.
     *
     * @return mixed An array of data from the "var" section or null if the section is empty.
     */
    public function all(): mixed
    {
        $this->startSession();

        if (!empty($_SESSION[$this->varKey])) {
            return $_SESSION[$this->varKey];
        }

        return null;
    }

}
