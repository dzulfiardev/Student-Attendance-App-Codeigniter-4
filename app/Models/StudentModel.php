<?php

namespace App\Models;

use CodeIgniter\Model;

class StudentModel extends Model
{
    protected $table = 'tbl_student';
    protected $primaryKey = 'student_id';
    protected $allowedFields = ['student_id', 'student_name', 'student_roll_number', 'student_dob', 'student_grade_id', 'grade_name'];

    public function noticeTable()
    {
        $builder = $this->db->table('tbl_student');
        $builder->select('*');
        $query = $builder->join('tbl_grade', 'tbl_grade.grade_id = tbl_student.student_grade_id');
        return $query;
    }

    public function getStudentAll()
    {
        return $this->findAll();
    }

    public function getStudentGrade($grade_id)
    {
        return $this->where(['student_grade_id' => $grade_id])->first();
    }

    public function getStudent($id)
    {
        return $this->where(['student_id' => $id])->first();
    }

    public function btn_edit()
    {
        $edit = function ($row) {
            return '<button type="button" name="edit_student" class="btn btn-primary btn-sm edit_student" id="' . $row["student_id"] . '">Edit</button>';
        };
        return $edit;
    }

    public function btn_delete()
    {
        $edit = function ($row) {
            return '<button type="button" name="delete_student" class="btn btn-danger btn-sm delete_student" id="' . $row["student_id"] . '">Delete</button>';
        };
        return $edit;
    }
}
