<?php

namespace Model;

defined('ROOT') or die('Direct script access denied');

/**
 * User Class
 *
 * This User class represents the model for the table users.
*/

class User extends Model
{
    
    protected $table                    = 'users';
    protected $primary_key              = 'id';

    protected $allowedColumns           = [
        'email',
        'date_created',
    ];

    protected $allowedUpdateColumns     = [
        'email',
        'date_updated',
        'date_deleted',
        'deleted',
    ];


    public function validate_insert(array $data): bool
    {
        if(empty($data['email']))
        {
            $this->errors['email'] = "Error: Empty email address.";
        }else
        if($this->first(['email' => $data['email']]))
        {
            $this->errors['email'] = "Error: Email address already on use.";
        }else
        if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL))
        {
            $this->errors['email'] = "Error: Invalid email address.";
        }

        return empty($this->errors);
    }


    public function validate_update(array $data): bool
    {
        $email_arr = [
            'email' => $data['email']
        ];
        $email_arr_not = [
            $this->primary_key => $data[$this->primary_key] ?? 0
        ];

        if(empty($data['email']))
        {
            $this->errors['email'] = "Error: Empty email address.";
        }else
        if($this->first($email_arr, $email_arr_not))
        {
            $this->errors['email'] = "Error: Email address already on use.";
        }else
        if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL))
        {
            $this->errors['email'] = "Error: Invalid email address.";
        }

        return empty($this->errors);
    }


    
}
