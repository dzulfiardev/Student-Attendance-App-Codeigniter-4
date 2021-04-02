<?php

namespace App\Models;

use CodeIgniter\Model;

class TeacherModel extends Model
{
    protected $table = 'tbl_teacher';
    protected $primaryKey = 'teacher_id';
    protected $allowedFields = ['teacher_id', 'teacher_name', 'teacher_address', 'teacher_emailid', 'teacher_qualification', 'teacher_doj', 'teacher_image', 'teacher_grade_id', 'grade_name'];

    public function noticeTable()
    {
        $builder = $this->db->table("tbl_teacher");
        $builder->select('*');
        $query = $builder->join('tbl_grade', 'tbl_grade.grade_id = tbl_teacher.teacher_grade_id');
        return $query;
    }

    public function tableJoin()
    {
        $this->join('tbl_grade', 'tbl_grade.grade_id = tbl_teacher.teacher_grade_id');
        $result = $this->findAll();
        return $result;
    }

    public function getTeacher($id)
    {
        return $this->where(['teacher_id' => $id])->first();
    }

    public function teacher_name()
    {
        $name = function ($row) {
            return '<span class="text-capitalize">' . $row['teacher_name'] . '</span>';
        };
        return $name;
    }

    public function teacher_image()
    {
        $photo = function ($row) {
            return '<img src="/img/photo/' . $row["teacher_image"] . '" class="img-thumbnail img_thumbnail">';
        };
        return $photo;
    }

    public function view_button()
    {
        $view = function ($row) {
            return '<button type="button" name="view_teacher" class="btn btn-info btn-sm view_teacher" id="' . $row["teacher_id"] . '">View</button>';
        };
        return $view;
    }
    public function edit_button()
    {
        $view = function ($row) {
            return '<button type="button" name="edit_teacher" class="btn btn-primary btn-sm edit_teacher" id="' . $row["teacher_id"] . '">Edit</button>';
        };
        return $view;
    }
    public function delete_button()
    {
        $view = function ($row) {
            return '<button type="button" name="delete_teacher" class="btn btn-danger btn-sm delete_teacher" id="' . $row["teacher_id"] . '">Delete</button>';
        };
        return $view;
    }
}
