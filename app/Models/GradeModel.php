<?php

namespace App\Models;

use CodeIgniter\Model;

class GradeModel extends Model
{
    protected $table = ['tbl_grade'];
    protected $primaryKey = ['grade_id'];
    protected $allowedFields = ['grade_id', 'grade_name'];

    public function noticeTable()
    {
        $builder = $this->db->table("tbl_grade");
        return $builder;
    }

    public function getGradeAll()
    {
        return $this->findAll();
    }

    public function getGrade($id = 0)
    {
        return $this->where(['grade_id' => $id])->first();
    }

    public function edit_button()
    {
        $edit = function ($row) {
            return '<button type="button" name="edit_grade" class="btn btn-primary btn-sm edit_grade" id="' . $row["grade_id"] . '">Edit</button>';
        };
        return $edit;
    }

    public function delete_button()
    {
        $edit = function ($row) {
            return '<button type="button" name="delete_grade" class="btn btn-danger btn-sm delete_grade" id="' . $row["grade_id"] . '">Delete</button>';
        };
        return $edit;
    }
}
