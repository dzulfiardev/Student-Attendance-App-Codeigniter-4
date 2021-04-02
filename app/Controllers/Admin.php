<?php

namespace App\Controllers;

use monken\TablesIgniter;
use App\Models\GradeModel;

class Admin extends BaseController
{
    protected $model, $db, $builder, $validation;

    public function __construct()
    {
        $this->model = new GradeModel();
        $this->db = \Config\Database::connect();
        $this->builder = $this->db->table('tbl_grade');
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        $data = [
            'title' => 'Admin Page',
            'session' => session()
        ];
        return view('admin/index', $data);
    }

    public function grade_action()
    {
        $model = new GradeModel();
        $table = new TablesIgniter();
        $table->setTable($model->noticeTable())
            ->setDefaultOrder('grade_name', 'DESC')
            ->setSearch(['grade_name'])
            ->setOrder(['grade_name'])
            ->setOutput(["grade_name", $model->edit_button(), $model->delete_button()]);
        return $table->getDatatable();
    } // Grade Page

    public function add_grade()
    {

        $valid = $this->validate([
            'grade_name' => [
                'rules' => 'required|is_unique[tbl_grade.grade_name]',
                'errors' => [
                    'required' => 'Input is required',
                    'is_unique' => 'Grade name not be same'
                ]
            ]
        ]);

        if (!$valid) {
            $msg = [
                'error' => [
                    'grade_name' => $this->validation->getError('grade_name')
                ]
            ];
        } else {
            $data = ['grade_name' => $this->request->getVar('grade_name')];
            $this->builder->insert($data);
            $msg =  [
                "success" => "New Grade Name Added"
            ];
        }

        echo json_encode($msg);
    }

    public function edit_grade()
    {
        $id = $this->request->getVar('grade_id');

        $this->builder->where('grade_id', $id);
        $query = $this->builder->get();
        $result = $query->getResult();

        foreach ($result as $row) {
            $output['grade_id'] = $row->grade_id;
            $output['grade_name'] = $row->grade_name;
        }

        echo json_encode($output);
    }

    public function update_grade()
    {
        $id = $this->request->getVar('grade_id');
        $gradename = $this->model->getGrade($id);

        if ($gradename['grade_name'] == $this->request->getVar('grade_name')) {
            $grade_rules = 'required';
        } else {
            $grade_rules = 'required|is_unique[tbl_grade.grade_name]';
        }

        $valid = $this->validate([
            'grade_name' => [
                'rules' => $grade_rules,
                'errors' => [
                    'required' => 'Input is required',
                    'is_unique' => 'Grade name cannot be same'
                ]
            ]
        ]);

        if (!$valid) {
            $msg = [
                'error' => [
                    'grade_name' => $this->validation->getError('grade_name')
                ]
            ];
        } else {
            $id = $this->request->getVar('grade_id');
            $data = ['grade_name' => $this->request->getVar('grade_name')];
            $this->builder->update($data, ['grade_id' => $id]);
            $msg =  [
                "success" => "Selected Grade Is Updated"
            ];
        }

        echo json_encode($msg);
    }

    public function delete_grade()
    {
        $grade_id = $this->request->getVar('grade_id');
        $this->model->where('grade_id', $grade_id)->delete();
        $msg = [
            'success' => 'Selected grade is deleted'
        ];

        echo json_encode($msg);
    }
}
