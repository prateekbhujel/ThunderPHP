<?php

$postdata = $req->post();
$csrf = csrf_verify($postdata);
if($csrf)
{
    if(user_can('edit_permissions'))
    {
        $data = [];
        foreach ($postdata as $role_id => $permission)
        {
            if (!strstr($role_id , "checkbox_"))
                continue;
            $role_id = str_replace("checkbox_", "", $role_id);
            $role_id = preg_replace("/_[0-9]+$/", "", $role_id);
            $data[$role_id][] = $permission;
        }
        /** Disable all permissons. **/
        $user_permission->query('update ' . $vars['tables']['permissions_table'] . ' set disabled = 1');

        /** Save to database. **/
        foreach ($data as $id => $permissions)
        {
            foreach ($permissions as $perm) {
                $row = $user_permission->first(['role_id' => $id, 'permission' => $perm]);
                if ($row) {
                    $user_permission->update($row->id, ['disabled' => 0]);
                }else {
                    $user_permission->insert([
                        'role_id'   => $id,
                        'permission' => $perm,
                        'disabled'  => 0
                    ]);
                }
            }
        }
        message_success("Permssion Saved successfully!");
        redirect($admin_route . '/' . $plugin_route);
    }
}

if(!$csrf)
    $user_role->errors['role'] = "Form Expired!";

set_value('errors', $user_role->errors);