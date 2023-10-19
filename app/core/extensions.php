<?php

/**
 * Check Required PHP Extensions
 *
 * This function checks for the presence of required PHP extensions.
 * It will display an error message if any of the required extensions is not loaded.
 */
function check_extension()
{
    // List of required PHP extensions
    $extensions = [
        'gd',
        'pdo_mysql',
    ];

    $not_loaded = [];

    foreach ($extensions as $ext) {
        if (!extension_loaded($ext)) {
            $not_loaded[] = $ext;
        }
    }

    if (!empty($not_loaded)) {
        // Display an error message if required extensions are not loaded
        dd("Please load the following extensions in your <b><i style='text-decoration: underline; color:hotpink'>php.ini</i> </b>file : " . implode(", ", $not_loaded));
    }
}

// Call the function to check extensions
check_extension();
