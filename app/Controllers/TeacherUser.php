<?php

namespace App\Controllers;

use App\Models\TeacherModel;
use App\Models\AttendanceModel;
use App\Models\GradeModel;
use monken\TablesIgniter;

class TeacherUser extends BaseController
{
    protected $db, $builder, $builderGrade, $builderAttendance, $builderStudent, $validation, $teacherModel, $attendanceModel;

    public function __construct()
    {
        $this->db                   = \Config\Database::connect();
        $this->builder              = $this->db->table('tbl_teacher');
        $this->builderGrade         = $this->db->table('tbl_grade');
        $this->builderAttendance    = $this->db->table('tbl_attendance');
        $this->builderStudent       = $this->db->table('tbl_student');

        $this->teacherModel     = new TeacherModel();
        $this->attendanceModel  = new AttendanceModel();
        $this->gradeModel       = new GradeModel();

        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        $session = session();
        $teacher_id = $session->teacher_id;
        $id = $this->request->getVar($teacher_id);

        $this->builder->where('teacher_id', $id);
        $query = $this->builder->get();
        $result = $query->getResult();

        $data = [
            'title' => 'Teacher',
            'session' => $session,
            'teacher' => $result,
        ];
        // Dashboard page
        return view('dashboard_teacher/index', $data);
    }

    public function profile()
    {
        $this->builderGrade->orderBy('grade_name', 'ASC');
        $query = $this->builderGrade->get();
        $resultGrade = $query->getResult();

        $session = session();
        $id = $session->teacher_id;

        $this->builder->select('*');
        $this->builder->join('tbl_grade', 'tbl_grade.grade_id = tbl_teacher.teacher_grade_id');
        $this->builder->where('teacher_id', $id);
        $query = $this->builder->get();
        $resultTeacher = $query->getRow();

        $data = [
            'title' => 'Profile',
            'session' => session(),
            'grade' => $resultGrade,
            'teacher' => $resultTeacher
        ];
        return view('dashboard_teacher/teacher_profile', $data);
    }

    public function update_profile()
    {
        $id = $this->request->getVar('teacher_id');
        $teacheremail = $this->teacherModel->getTeacher($id);

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
            'teacher_password' => [
                'rules' => 'matches[teacher_password_repeat]',
                'errors' => [
                    'matches' => 'Password Not Match',
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
            // 'teacher_doj' => [
            //     'rules' => 'required',
            //     'errors' => [
            //         'required' => 'Input is required',
            //     ]
            // ],
            'teacher_image' => [
                'rules' => 'max_size[teacher_image,1024]|is_image[teacher_image]|mime_in[teacher_image,image/jgp,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Image size is so big',
                    'is_image' => 'Yang anda pilih bukan gambar',
                    'mime_in' => 'Yang anda pilih bukan gambar'
                ]
            ]
        ]);

        if (!$valid) {
            $msg = [
                'error' => [
                    'teacher_name'          => $this->validation->getError('teacher_name'),
                    'teacher_address'       => $this->validation->getError('teacher_address'),
                    'teacher_emailid'       => $this->validation->getError('teacher_emailid'),
                    'teacher_password'      => $this->validation->getError('teacher_password'),
                    'teacher_qualification' => $this->validation->getError('teacher_qualification'),
                    'teacher_grade_id'      => $this->validation->getError('teacher_grade_id'),
                    // 'teacher_doj' => $this->validation->getError('teacher_doj'),
                    'teacher_image'         => $this->validation->getError('teacher_image'),
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

            $password = $this->request->getVar('teacher_password');

            if ($password != '') {
                $data = [
                    'teacher_name'          => $this->request->getVar('teacher_name'),
                    'teacher_address'       => $this->request->getVar('teacher_address'),
                    'teacher_emailid'       => $this->request->getVar('teacher_emailid'),
                    'teacher_password'      => password_hash($password, PASSWORD_DEFAULT),
                    'teacher_qualification' => $this->request->getVar('teacher_qualification'),
                    'teacher_grade_id'      => $this->request->getVar('teacher_grade_id'),
                    'teacher_doj'           => $this->request->getVar('teacher_doj_hidden'),
                    'teacher_image'         => $photo_name
                ];
                $this->builder->update($data, ['teacher_id' => $id]);
            } else {
                $data = [
                    'teacher_name'          => $this->request->getVar('teacher_name'),
                    'teacher_address'       => $this->request->getVar('teacher_address'),
                    'teacher_emailid'       => $this->request->getVar('teacher_emailid'),
                    'teacher_qualification' => $this->request->getVar('teacher_qualification'),
                    'teacher_grade_id'      => $this->request->getVar('teacher_grade_id'),
                    'teacher_doj'           => $this->request->getVar('teacher_doj_hidden'),
                    'teacher_image'         => $photo_name
                ];
                $this->builder->update($data, ['teacher_id' => $id]);
            }

            $msg =  [
                "success" => "Data anda telah di Update"
            ];
        }

        echo json_encode($msg);
    }

    public function teacher_attendance()
    {
        $session = session();

        $grade = $this->gradeModel->getGrade($session->teacher_grade_id);
        $data = [
            'title' => 'Attendance',
            'session' => session(),
            'grade' => $grade,
        ];
        return view('dashboard_teacher/teacher_attendance', $data);
    }

    public function attendance_dashboard_fetch() // Dashboard Page
    {
        $session = session();
        $table = new TablesIgniter();
        $table->setTable($this->attendanceModel->noticeTable2($session->teacher_id))
            ->setDefaultOrder('student_roll_number', 'ASC')
            ->setSearch(['student_name', 'student_roll_number'])
            ->setOrder(['student_name', 'student_roll_number'])
            ->setOutput(['student_name', 'student_roll_number', 'grade_name', $this->attendanceModel->percentage(), $this->attendanceModel->button_report_chart()]);
        return $table->getDatatable();
    }

    public function attendance_fetch()
    {
        $session = session();
        $table = new TablesIgniter();
        $table->setTable($this->attendanceModel->noticeTable($session->teacher_id))
            ->setDefaultOrder('attendance_id', 'DESC')
            ->setSearch(['student_name', 'attendance_status'])
            ->setOrder(['student_name', 'student_roll_number'])
            ->setOutput(['student_name', 'student_roll_number', 'grade_name', $this->attendanceModel->badge_attendance(), 'attendance_date']);
        return $table->getDatatable();
    }

    public function atteandance_add_fetch()
    {
        $session = session();
        $table = new TablesIgniter();
        $table->setTable($this->attendanceModel->addTable($session->teacher_grade_id))
            ->setDefaultOrder('student_id', 'ASC')
            ->setSearch(['student_name'])
            ->setOrder(['student_name'])
            ->setOutput(['student_roll_number', $this->attendanceModel->student_name(), $this->attendanceModel->radio_status_present(), $this->attendanceModel->radio_status_absent()]);
        return $table->getDatatable();
    }

    public function submit_attendance()
    {
        $session = session();
        $date = $this->request->getVar('attendance_date');

        $this->builderAttendance->select('attendance_date');
        $this->builderAttendance->where('teacher_id', $session->teacher_id);
        $this->builderAttendance->where('attendance_date', $date);
        $query = $this->builderAttendance->get();
        $result = $query->getRow();

        if ($result) {
            $ruleDate = 'required|is_unique[tbl_attendance.attendance_date]';
        } else {
            $ruleDate = 'required';
        }

        $valid = $this->validate([
            'attendance_date' => [
                'rules' => $ruleDate,
                'errors' => [
                    'required' => 'Date is required!',
                    'is_unique' => 'Date not be same!'
                ]
            ]
        ]);

        if (!$valid) {
            $msg = [
                'error' => [
                    'attendance_date' => $this->validation->getError('attendance_date')
                ]
            ];
        } else {
            $student_id = $this->request->getVar('student_id');

            for ($count = 0; $count < count($student_id); $count++) {
                $data = [
                    'student_id' => $student_id[$count],
                    'attendance_status' => $this->request->getVar('attendance_status' . $student_id[$count] . ""),
                    'attendance_date' => $this->request->getVar('attendance_date'),
                    'teacher_id' => $session->teacher_id
                ];
                $this->builderAttendance->insert($data);
            }
            $msg = [
                'success' => '<div class="alert alert-success">New Data Added!</div>'
            ];
        }

        echo json_encode($msg);
    }

    public function search_filter()
    {
        $session = session();
        $minval = $this->request->getVar('first_date');
        $maxval = $this->request->getVar('last_date');

        $this->builderAttendance->select('*');
        $this->builderAttendance->join('tbl_student', 'tbl_student.student_id = tbl_attendance.student_id');
        $this->builderAttendance->join('tbl_grade', 'tbl_grade.grade_id = tbl_student.student_grade_id');
        $this->builderAttendance->where('teacher_id', $session->teacher_id);
        $this->builderAttendance->where('attendance_date >=', $minval);
        $this->builderAttendance->where('attendance_date <=', $maxval);
        $this->builderAttendance->orderBy('attendance_date', 'ASC');
        $query = $this->builderAttendance->get();

        $data = [
            'result' => $query->getResult()
        ];
        $msg = [
            'success' => view('dashboard_teacher/ajax_search_datatable', $data)
        ];

        echo json_encode($msg);
    }

    // Chart report >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
    public function teacher_chart_report()
    {
        $student_id = $this->request->getVar('student_id');
        $minval = $this->request->getVar('from_date');
        $maxval = $this->request->getVar('to_date');

        $this->builderStudent->select('*');
        $this->builderStudent->join('tbl_grade', 'tbl_grade.grade_id = tbl_student.student_grade_id');
        $this->builderStudent->join('tbl_teacher', 'tbl_teacher.teacher_grade_id = tbl_grade.grade_id');
        $this->builderStudent->where('student_id', $student_id);
        $query = $this->builderStudent->get();
        $total_row = $this->builderStudent->countAllResults();
        $result_student_data = $query->getRow();

        $this->builderAttendance->select('*');
        $this->builderAttendance->where('student_id', $student_id);
        $this->builderAttendance->where('attendance_date >=', $minval);
        $this->builderAttendance->where('attendance_date <=', $maxval);
        $query = $this->builderAttendance->get();
        $result_student = $query->getResult();

        $data = [
            'from_date' => $minval,
            'to_date' => $maxval,
            'total_row' => $total_row,
            'result_student' => $result_student,
            'result_student_data' => $result_student_data
        ];

        $msg = [
            'success' => view('dashboard_teacher/ajax_chart_report', $data)
        ];

        echo json_encode($msg);
    }

    // Report Method >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

    // Export Pdf by teacher 
    public function export_pdf()
    {
        $session = session();
        $minval = $this->request->getVar('from_date');
        $maxval = $this->request->getVar('to_date');

        $this->builderAttendance->select('attendance_date');
        $this->builderAttendance->where('teacher_id', $session->teacher_id);
        $this->builderAttendance->where('attendance_date >=', $minval);
        $this->builderAttendance->where('attendance_date <=', $maxval);
        $this->builderAttendance->groupBy('attendance_date');
        $this->builderAttendance->orderBy('attendance_date', 'ASC');
        $queryDate = $this->builderAttendance->get();
        $dateResult = $queryDate->getResult();

        $output = '';

        foreach ($dateResult as $row) {
            $output .= '
                        <table width="100%" border="0" cellpadding="5" cellspacing="0">
                        <tr>
                        <td><b>Date - ' . $row->attendance_date . '</b></td>
                        </tr>
                        <tr>
                        <td>
                        <table width="100%" border="1" cellpadding="5" cellspacing="0">
                        <tr>
                            <td><b>Student Name</b></td>
                            <td><b>Roll Number</b></td>
                            <td><b>Grade</b></td>
                            <td><b>Attendance Status</b></td>
                        </tr>
                    ';
            // Sub Query
            $this->builderAttendance->select('*');
            $this->builderAttendance->join('tbl_student', 'tbl_student.student_id = tbl_attendance.student_id');
            $this->builderAttendance->join('tbl_grade', 'tbl_grade.grade_id = tbl_student.student_grade_id');
            $this->builderAttendance->where('teacher_id', $session->teacher_id);
            $this->builderAttendance->where('attendance_date', $row->attendance_date);
            $queryJoin = $this->builderAttendance->get();
            $dataResult = $queryJoin->getResult();

            foreach ($dataResult as $sub_row) {
                $output .= '
                        <tr>
                        <td>' . $sub_row->student_name . '</td>
                        <td>' . $sub_row->student_roll_number . '</td>
                        <td>' . $sub_row->grade_name . '</td>
                        <td>' . $sub_row->attendance_status . '</td>
                        </tr>
                        ';
            }
            $output .=
                '</table>
                </td>
                </tr>
                </table><br>';
        }

        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML($output);
        $mpdf->Output();
        exit;
    } // Report kehadiran siswa

    public function export_pdf_by_teacher()
    {
        $student_id = $this->request->getVar('student_id');
        $minval = $this->request->getVar('from_date');
        $maxval = $this->request->getVar('to_date');
        $output = '';

        $this->builderStudent->select('*');
        $this->builderStudent->join('tbl_grade', 'tbl_grade.grade_id = tbl_student.student_grade_id');
        $this->builderStudent->where('tbl_student.student_id', $student_id);
        $query = $this->builderStudent->get();
        $result = $query->getResultArray();

        foreach ($result as $row) {
            $output .= '
                    <style>
                    @page { margin: 20px; }
                    
                    </style>
                    <p>&nbsp;</p>
                    <h3 align="center">Attendance Report</h3><br /><br />
                    <table width="100%" border="0" cellpadding="5" cellspacing="0">
                        <tr>
                            <td width="25%"><b>Student Name</b></td>
                            <td width="75%">' . $row["student_name"] . '</td>
                        </tr>
                        <tr>
                            <td width="25%"><b>Roll Number</b></td>
                            <td width="75%">' . $row["student_roll_number"] . '</td>
                        </tr>
                        <tr>
                            <td width="25%"><b>Grade</b></td>
                            <td width="75%">' . $row["grade_name"] . '</td>
                        </tr>
                        <tr>
                            <td colspan="2" height="5">
                            <h3 align="center">Attendance Details</h3>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                            <table width="100%" border="1" cellpadding="5" cellspacing="0">
                            <tr>
                            <td><b>Attendance Date</b></td>
                            <td><b>Attendance Status</b></td>
                            </tr>
            ';

            // Sub query
            $this->builderAttendance->where('student_id', $student_id);
            $this->builderAttendance->where('attendance_date >=', $minval);
            $this->builderAttendance->where('attendance_date <=', $maxval);
            $this->builderAttendance->orderBy('attendance_date', 'ASC');
            $query = $this->builderAttendance->get();
            $sub_result = $query->getResultArray();

            foreach ($sub_result as $sub_row) {
                $output .= '
                            <tr>
                                <td>' . $sub_row["attendance_date"] . '</td>
                                <td>' . $sub_row["attendance_status"] . '</td>
                            </tr>
                        ';
            }
            $output .= '
                             </table>
                        </td>
                        </tr>
                    </table>
                    ';
        }

        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML($output);
        $mpdf->Output();
        exit;
    }
}
