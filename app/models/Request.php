<?php

namespace Core;

defined('ROOT') or die("Direct script access denied");

/**
 * Request Class Handles the request.
 */
class Request
{
    // Maximum size for file uploads (in megabytes)
    public $upload_max_size    = 20;

    // Folder where uploads will be stored
    public $upload_folder      = 'uploads';

    // Array to store upload errors
    public $upload_errors      = [];

    // Code to represent the last upload error
    public $upload_error_code  = 0;
    
    /*
    * Lists of Supported file Type Goes here :
    */
    public $upload_file_types  = [
        'image/jpeg',
        'image/png',
        'image/webp',
        'image/gif',
    ];

    /**
     * Returns the request method (GET, POST, etc.)
     */
    public function method(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Checks if the request method is POST
     */
    public function posted(): bool
    {
        return $_SERVER['REQUEST_METHOD'] == 'POST';
    }

    /**
     * Gets POST data. If $key is empty, returns all POST data.
     */
    public function post(string $key = ''): string|array
    {
        if (empty($key))
            return $_POST;

        if (!empty($_POST[$key]))
            return $_POST[$key];

        return '';
    }

    /**
     * Gets input data based on key with a default value if not set.
     */
    public function input(string $key, string $default = ''): string
    {
        if (!empty($_POST[$key]))
            return $_POST[$key];

        return $default;
    }

    /**
     * Gets GET data. If $key is empty, returns all GET data.
     */
    public function get(string $key = ''): string
    {
        if (empty($key))
            return $_GET;

        if (!empty($_GET[$key]))
            return $_GET[$key];

        return '';
    }

    /**
     * Gets FILES data. If $key is empty, returns all FILES data.
     */
    public function files(string $key = ''): string|array
    {
        if (empty($key))
            return $_FILES;

        if (!empty($_FILES[$key]))
            return $_FILES[$key];

        return '';
    }

    /**
     * Gets REQUEST data. If $key is empty, returns all REQUEST data.
     */
    public function all(string $key = ''): string|array
    {
        if (empty($key))
            return $_REQUEST;

        if (!empty($_REQUEST[$key]))
            return $_REQUEST[$key];

        return '';
    }

    /**
     * Handles the upload of files.
     */
    public function upload_files(string $key = ''): string|array
    {
        $this->upload_errors      = [];
        $this->upload_error_code  = 0;

        $uploaded = empty($key) ? [] : '';

        if (!empty($this->files()))
        {
            $get_one = false;
            if (!empty($key))
                $get_one = true;

            if ($get_one && empty($this->files()[$key]))
            {
                $this->upload_errors['name'] = 'File not found';
                return '';
            }

            $uploaded = [];
            foreach ($this->files() as $key => $file_arr)
            {
                if ($file_arr['error'] > 0)
                {
                    $this->upload_error_code = $file_arr['error'];
                    $this->upload_errors[] = "An error occurred with file: ". $file_arr['name'];
                    continue;
                }

                if (!in_array($file_arr['type'], $this->upload_file_types))
                {
                    $this->upload_errors[] = "Invalid file type: ". $file_arr['name'];
                    continue;
                }

                if ($file_arr['size'] > ($this->upload_max_size * 1024 * 1024))
                {
                    $this->upload_errors[] = "File too large: ". $file_arr['name'];
                    continue;
                }
                
                $folder = trim($this->upload_folder,'/') . '/';
                $destination = $folder . $file_arr['name'];

                $num = 0;
                while (file_exists($destination) && $num < 10)
                {
                    $num++;
                    $ext = explode(".", $destination);
                    $ext = end($ext);

                    $destination = preg_replace("/\.$ext$/", "_" . rand(0,99) . ".$ext", $destination);
                }

                if (!is_dir($folder))
                    mkdir($folder,0777,true);

                move_uploaded_file($file_arr['tmp_name'], $destination);
                $uploaded[] = $destination;

                if ($get_one)
                    break;
            }

            if ($get_one)
                return $uploaded[0] ?? '';

            return $uploaded;
            
        }

        return $uploaded;
    }
}