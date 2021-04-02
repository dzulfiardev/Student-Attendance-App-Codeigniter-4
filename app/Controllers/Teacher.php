<?php

namespace App\Controllers;

use monken\TablesIgniter;
use App\Models\TeacherModel;
use App\Models\GradeModel;

class Teacher extends BaseController
{
    protected $model, $db, $builder, $validation;

    public function __construct()
    {
        $this->model = new TeacherModel();
        $this->gradeModel = new GradeModel();
        $this->db = \Config\Database::connect();
        $this->builder = $this->db->table('tbl_teacher');
        $this->builderGrade = $this->db->table('tbl_grade');
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        $this->builderGrade->orderBy('grade_name', 'ASC');
        $query = $this->builderGrade->get();

        $data = [
            'title' => 'Teacher',
            'session' => session(),
            'grade' => $query->getResult()
        ];
        return view('teacher/index', $data);
    }

    public function fetch_all()
    {
        $table = new TablesIgniter();
        $table->setTable($this->model->noticeTable())
            ->setDefaultOrder('teacher_id', 'DESC')
            ->setSearch(['teacher_name', 'grade_name'])
            ->setOrder(["teacher_name"])
            ->setOutput([$this->model->teacher_image(), $this->model->teacher_name(), 'teacher_emailid', 'grade_name', $this->model->view_button(), $this->model->edit_button(), $this->model->delete_button()]);
        return $table->getDatatable();
    }

    public function add_teacher()
    {
        $valid = $this->validate([
            'teacher_name' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Input is required',
                ]
            ],
            'teacher_address' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Input is required',
                ]
            ],
            'teacher_emailid' => [
                'rules' => 'required|valid_email|is_unique[tbl_teacher.teacher_emailid]',
                'errors' => [
                    'required' => 'Input is required',
                    'valid_email' => 'Input must email',
                    'is_unique' => 'Email cannot be same'
                ]
            ],
            'teacher_password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Input is required',
                ]
            ],
            'teacher_qualification' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Input is required',
                ]
            ],
            'teacher_grade_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Input is required',
                ]
            ],
            'teacher_doj' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Input is required',
                ]
            ],
            'teacher_image' => [
                'rules' => 'max_size[teacher_image,1024]|is_image[teacher_image]|mime_in[teacher_image,image/jgp,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran gambar terlalu besar',
                    'is_image' => 'Yang anda pilih bukan gambar',
                    'mime_in' => 'Yang anda pilih bukan gambar'
                ]
            ]
        ]);

        if (!$valid) {
            $msg = [
                'error' => [
                    'error_teacher_name' => $this->validation->getError('teacher_name'),
                    'error_teacher_address' => $this->validation->getError('teacher_address'),
                    'error_teacher_emailid' => $this->validation->getError('teacher_emailid'),
                    'error_teacher_password' => $this->validation->getError('teacher_password'),
                    'error_teacher_qualification' => $this->validation->getError('teacher_qualification'),
                    'error_teacher_grade_id' => $this->validation->getError('teacher_grade_id'),
                    'error_teacher_doj' => $this->validation->getError('teacher_doj'),
                    'error_teacher_image' => $this->validation->getError('teacher_image'),
                ]
            ];
        } else {
            $file_photo = $this->request->getFile('teacher_image');

            if ($file_photo->getError() == 4) {
                $photo_name = 'default.jpg';
            } else {
                $photo_name = $file_photo->getRandomName();
                $file_photo->move('img/photo', $photo_name);
            }

            $data = [
                'teacher_name' => $this->request->getVar('teacher_name'),
                'teacher_address' => $this->request->getVar('teacher_address'),
                'teacher_emailid' => $this->request->getVar('teacher_emailid'),
                'teacher_password' => password_hash($this->request->getVar('teacher_password'), PASSWORD_DEFAULT),
                'teacher_qualification' => $this->request->getVar('teacher_qualification'),
                'teacher_grade_id' => $this->request->getVar('teacher_grade_id'),
                'teacher_doj' => $this->request->getVar('teacher_doj'),
                'teacher_image' => $photo_name
            ];
            $this->builder->insert($data);
            $msg =  [
                "success" => "New Teacher Added"
            ];
        }

        echo json_encode($msg);
    }

    public function edit_teacher()
    {
        $id = $this->request->getVar('teacher_id');

        $this->builder->select('*');
        $this->builder->join('tbl_grade', 'tbl_grade.grade_id = tbl_teacher.teacher_grade_id');
        $this->builder->where('teacher_id', $id);
        $query = $this->builder->get();
        $result = $query->getResult();

        foreach ($result as $row) {
            $output['teacher_id'] = $row->teacher_id;
            $output['teacher_name'] = $row->teacher_name;
            $output['teacher_address'] = $row->teacher_address;
            $output['teacher_emailid'] = $row->teacher_emailid;
            $output['grade_id'] = $row->grade_id;
            $output['teacher_qualification'] = $row->teacher_qualification;
            $output['teacher_doj'] = $row->teacher_doj;
            $output['teacher_image'] = $row->teacher_image;
        }

        echo json_encode($output);
    }

    public function update_teacher()
    {
        $id = $this->request->getVar('teacher_id');
        $teacheremail = $this->model->getTeacher($id);

        if ($teacheremail['teacher_emailid'] == $this->request->getVar('teacher_emailid')) {
            $teacher_rules = 'required|valid_email';
        } else {
            $teacher_rules = 'required|valid_email|is_unique[tbl_teacher.teacher_emailid]';
        }

        $valid = $this->validate([
            'teacher_name' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Input is required',
                ]
            ],
            'teacher_address' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Input is required',
                ]
            ],
            'teacher_emailid' => [
                'rules' => $teacher_rules,
                'errors' => [
                    'required' => 'Input is required',
                    'valid_email' => 'Input must email',
                    'is_unique' => 'Email cannot be same'
                ]
            ],
            // 'teacher_password' => [
            //     'rules' => 'required',
            //     'errors' => [
            //         'required' => 'Input is required',
            //     ]
            // ],
            'teacher_qualification' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Input is required',
                ]
            ],
            'teacher_grade_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Input is required',
                ]
            ],
            'teacher_doj' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Input is required',
                ]
            ],
            'teacher_image' => [
                'rules' => 'max_size[teacher_image,1024]|is_image[teacher_image]|mime_in[teacher_image,image/jgp,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran gambar terlalu besar',
                    'is_image' => 'Yang anda pilih bukan gambar',
                    'mime_in' => 'Yang anda pilih bukan gambar'
                ]
            ]
        ]);

        if (!$valid) {
            $msg = [
                'error' => [
                    'error_teacher_name' => $this->validation->getError('teacher_name'),
                    'error_teacher_address' => $this->validation->getError('teacher_address'),
                    'error_teacher_emailid' => $this->validation->getError('teacher_emailid'),
                    // 'error_teacher_password' => $this->validation->getError('teacher_password'),
                    'error_teacher_qualification' => $this->validation->getError('teacher_qualification'),
                    'error_teacher_grade_id' => $this->validation->getError('teacher_grade_id'),
                    'error_teacher_doj' => $this->validation->getError('teacher_doj'),
                    'error_teacher_image' => $this->validation->getError('teacher_image'),
                ]
            ];
        } else {
            $id = $this->request->getVar('teacher_id');
            $file_photo = $this->request->getFile('teacher_image');
            $old_photo = $this->request->getVar('hidden_teacher_image');

            if ($file_photo->getError() == 4) {
                $photo_name = $old_photo;
            } else {
                if ($old_photo == 'default.jpg') {
                    $photo_name = $file_photo->getRandomName();
                    $file_photo->move('img/photo', $photo_name);
                } else {
                    $photo_name = $file_photo->getRandomName();
                    $file_photo->move('img/photo', $photo_name);
                    unlink('img/photo/' . $old_photo);
                }
            }

            $data = [
                'teacher_name' => $this->request->getVar('teacher_name'),
                'teacher_address' => $this->request->getVar('teacher_address'),
                'teacher_emailid' => $this->request->getVar('teacher_emailid'),
                // 'teacher_password' => password_hash($this->request->getVar('teacher_password'), PASSWORD_DEFAULT),
                'teacher_qualification' => $this->request->getVar('teacher_qualification'),
                'teacher_grade_id' => $this->request->getVar('teacher_grade_id'),
                'teacher_doj' => $this->request->getVar('teacher_doj'),
                'teacher_image' => $photo_name
            ];
            $this->builder->update($data, ['teacher_id' => $id]);
            $msg =  [
                "success" => "Selected Teacher was Edited"
            ];
        }

        echo json_encode($msg);
    }

    public function view_teacher()
    {
        $id = $this->request->getVar('teacher_id');

        $this->builder->select('*');
        $this->builder->join('tbl_grade', 'tbl_grade.grade_id = tbl_teacher.teacher_grade_id');
        $this->builder->where('teacher_id', $id);
        $query = $this->builder->get();
        $result = $query->getResult();

        foreach ($result as $row) {
            $output['teacher_name'] = $row->teacher_name;
            $output['teacher_address'] = $row->teacher_address;
            $output['teacher_emailid'] = $row->teacher_emailid;
            $output['teacher_image'] = $row->teacher_image;
            $output['teacher_qualification'] = $row->teacher_qualification;
            $output['teacher_doj'] = $row->teacher_doj;
            $output['grade_name'] = $row->grade_name;
        }

        $output2 =
            '<div class="row">
        <div class="col-md-4">
            <img src="img/photo/' . $row->teacher_image . '" class="img-thumbnail img_thumbnail_profile" />
            </div>
            <div class="col-md-8">
                <table class="table">
                <tr>
                <th>Name</th>
                <td class="text-capitalize">' . $row->teacher_name . '</td>
                </tr>
                <tr>
                <th>Address</th>
                <td>' . $row->teacher_address . '</td>
                </tr>
                <tr>
                <th>Email Address</th>
                <td>' . $row->teacher_emailid . '</td>
                </tr>
                <tr>
                <th>Qualification</th>
                <td>' . $row->teacher_qualification . '</td>
                </tr>
                <tr>
                <th>Date of Joining</th>
                <td>' . $row->teacher_doj . '</td>
                </tr>
                <tr>
                <th>Grade</th>
                <td>' . $row->grade_name . '</td>
                </tr>
                </table>
            </div>
        </div>
    </div>';

        echo json_encode($output2);
    }

    public function delete_teacher()
    {
        $teacher_id = $this->request->getVar('teacher_id');

        $teacher = $this->model->getTeacher($teacher_id);

        if ($teacher['teacher_image'] != 'default.jpg') {

            unlink('img/photo/' . $teacher['teacher_image']);
        }

        $this->model->where('teacher_id', $teacher_id)->delete();
        $msg = [
            'success' => 'Selected grade is deleted'
        ];

        echo json_encode($msg);
    }
}
