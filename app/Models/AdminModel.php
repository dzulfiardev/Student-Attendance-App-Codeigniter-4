<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
    protected $table = 'tbl_admin';
    protected $allowedFields = ['admin_user_name', 'admin_password', 'admin_created_at'];
}
