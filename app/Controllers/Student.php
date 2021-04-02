<?php

namespace App\Controllers;

use monken\TablesIgniter;
use App\Models\StudentModel;
use App\Models\GradeModel;

class Student extends BaseController
{
    protected $db, $builder, $builderGrade, $model, $gradeModel, $validate;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->builder = $this->db->table('tbl_student');
        $this->builderGrade = $this->db->table('tbl_grade');
        $this->model = new StudentModel();
        $this->gradeModel = new GradeModel();
        $this->validate = \Config\Services::validation();
    }

    public function index()
    {
        $this->builderGrade->orderBy('grade_name', 'ASC');
        $query = $this->builderGrade->get();
        $data = [
            'title'     => 'Student',
            'session'   => session(),
            'grade'     => $query->getResult()
        ];
        return view('student/index', $data);
    }

    public function fetch_all()
    {
        $table = new TablesIgniter();
        $table->setTable($this->model->noticeTable())
            ->setDefaultOrder('grade_name', 'ASC')
            ->setSearch(['student_name', 'grade_name'])
            ->setOrder(['student_name', 'student_roll_number'])
            ->setOutput(['student_name', 'student_roll_number', 'student_dob', 'grade_name', $this->model->btn_edit(), $this->model->btn_delete()]);
        return $table->getDatatable();
    }

    public function add_student()
    {
        $valid = $this->validate([
            'student_name' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Input is Required'
                ]
            ],
            'student_roll_number' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Input is Required',
                ]
            ],
            'student_dob' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Input is Required'
                ]
            ],
            'student_grade_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Input is Required'
                ]
            ],
        ]);

        if (!$valid) {
            $msg = [
                'error' => [
                    'student_name'          => $this->validate->getError('student_name'),
                    'student_roll_number'   => $this->validate->getError('student_roll_number'),
                    'student_dob'           => $this->validate->getError('student_dob'),
                    'student_grade_id'      => $this->validate->getError('student_grade_id'),
                ]
            ];
        } else {
            $student_name = $this->request->getVar('student_name');
            $data = [
                'student_name'        => $student_name,
                'student_roll_number' => $this->request->getVar('student_roll_number'),
                'student_dob'         => $this->request->getVar('student_dob'),
                'student_grade_id'    => $this->request->getVar('student_grade_id'),
            ];
            $this->builder->insert($data);
            $msg = [
                'success' => 'New Student <strong>' . $student_name . '</strong> Added'
            ];
        }

        echo json_encode($msg);
    }

    public function edit_student()
    {
        $student_id = $this->request->getVar('student_id');

        $this->builder->where('student_id', $student_id);
        $query = $this->builder->get();
        $result = $query->getResult();

        foreach ($result as $row) {
            $output['student_id'] = $row->student_id;
            $output['student_name'] = $row->student_name;
            $output['student_roll_number'] = $row->student_roll_number;
            $output['student_dob'] = $row->student_dob;
            $output['student_grade_id'] = $row->student_grade_id;
        }

        echo json_encode($output);
    }

    public function update_student()
    {
        $student_id = $this->request->getVar('student_id');

        $valid = $this->validate([
            'student_name' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Input is Required'
                ]
            ],
            'student_roll_number' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Input is Required',
                ]
            ],
            'student_dob' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Input is Required'
                ]
            ],
            'student_grade_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Input is Required'
                ]
            ],
        ]);

        if (!$valid) {
            $msg = [
                'error' => [
                    'student_name'          => $this->validate->getError('student_name'),
                    'student_roll_number'   => $this->validate->getError('student_roll_number'),
                    'student_dob'           => $this->validate->getError('student_dob'),
                    'student_grade_id'      => $this->validate->getError('student_grade_id'),
                ]
            ];
        } else {
            $student_name = $this->request->getVar('student_name');
            $data = [
                'student_name'        => $student_name,
                'student_roll_number' => $this->request->getVar('student_roll_number'),
                'student_dob'         => $this->request->getVar('student_dob'),
                'student_grade_id'    => $this->request->getVar('student_grade_id'),
            ];
            $this->builder->update($data, ['student_id' => $student_id]);
            $msg = [
                'success' => 'Student <strong>' . $student_name . '</strong> was updated'
            ];
        }

        echo json_encode($msg);
    }

    public function delete_student()
    {
        $student_id = $this->request->getVar('student_id');
        $this->builder->where('student_id', $student_id)->delete();
        $msg = ['success' => 'Selected data was Delete'];
        echo json_encode($msg);
    }
}
