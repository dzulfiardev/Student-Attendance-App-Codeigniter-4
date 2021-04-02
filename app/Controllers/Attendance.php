<?php

namespace App\Controllers;

use App\Models\AttendanceModel;
use App\Models\GradeModel;
use monken\TablesIgniter;

class Attendance extends BaseController
{
    protected $session, $attendanceModel, $gradeModel, $builderAttendance, $builderGrade, $builderStudent;

    public function __construct()
    {
        $this->session = session();

        $this->db                   = \Config\Database::connect();
        $this->builderAttendance    = $this->db->table('tbl_attendance');
        $this->builderGrade         = $this->db->table('tbl_grade');
        $this->builderStudent       = $this->db->table('tbl_student');

        $this->attendanceModel = new AttendanceModel();
        $this->gradeModel = new GradeModel();
    }

    public function index()
    {
        $this->builderGrade->orderBy('grade_name', 'ASC');
        $query = $this->builderGrade->get();

        $data = [
            'title' => 'Attendance',
            'session' => session(),
            'grade' => $query->getResultArray()
        ];

        return view('admin/attendance', $data);
    }

    public function analytics()
    {

        $data = [
            'title' => 'Attendance',
            'session' => session(),
        ];
        return view('admin/analytics', $data);
    }

    public function fetch_all() // Attendance Page
    {
        $table = new TablesIgniter();
        $table->setTable($this->attendanceModel->noticeTableAdmin())
            ->setDefaultOrder('attendance_id', 'DESC')
            ->setSearch(['student_name', 'student_roll_number', 'grade_name', 'teacher_name', 'attendance_status'])
            ->setOrder(['student_name', 'student_roll_number'])
            ->setOutput(['student_name', 'student_roll_number', 'grade_name', $this->attendanceModel->badge_attendance(), 'attendance_date', 'teacher_name']);
        return $table->getDatatable();
    }

    public function filter_date()
    {
        $minval = $this->request->getVar('first_date');
        $maxval = $this->request->getVar('last_date');

        $this->builderAttendance->select('*');
        $this->builderAttendance->join('tbl_student', 'tbl_student.student_id = tbl_attendance.student_id');
        $this->builderAttendance->join('tbl_grade', 'tbl_grade.grade_id = tbl_student.student_grade_id');
        $this->builderAttendance->join('tbl_teacher', 'tbl_teacher.teacher_id = tbl_attendance.teacher_id');
        $this->builderAttendance->where('attendance_date >=', $minval);
        $this->builderAttendance->where('attendance_date <=', $maxval);
        $this->builderAttendance->orderBy('attendance_date', 'ASC');
        $query = $this->builderAttendance->get();
        $data = [
            'result' => $query->getResult()
        ];
        $msg = [
            'success' => view('admin/ajax_attendance_search', $data)
        ];

        echo json_encode($msg);
    }

    public function fetch_all_analytics() // Analytics Page
    {
        $table = new TablesIgniter();
        $table->setTable($this->attendanceModel->noticeTableAdminAnalytics())
            ->setDefaultOrder('grade_name', 'ASC')
            ->setSearch(['student_name', 'student_roll_number', 'teacher_name', 'grade_name'])
            ->setOrder(['student_name', 'student_roll_number'])
            ->setOutput(['student_name', 'student_roll_number', 'grade_name', 'teacher_name', $this->attendanceModel->percentage(), $this->attendanceModel->button_report_chart()]);
        return $table->getDatatable();
    }

    public function admin_chart_report()
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
            'success' => view('admin/ajax_chart_report', $data)
        ];

        echo json_encode($msg);
    }

    //  Report Method >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

    public function report_grade_date_pdf()
    {
        $grade_id = $this->request->getVar('grade_id');
        $minval = $this->request->getVar('from_date');
        $maxval = $this->request->getVar('to_date');
        $output = '';

        $this->builderAttendance->select('attendance_date');
        $this->builderAttendance->join('tbl_student', 'tbl_student.student_id = tbl_attendance.student_id');
        $this->builderAttendance->where('tbl_student.student_grade_id', $grade_id);
        $this->builderAttendance->where('attendance_date >=', $minval);
        $this->builderAttendance->where('tbl_attendance.attendance_date <=', $maxval);
        $this->builderAttendance->groupBy('tbl_attendance.attendance_date');
        $this->builderAttendance->orderBy('tbl_attendance.attendance_date', "ASC");
        $query = $this->builderAttendance->get();
        $result = $query->getResultArray();

        $output .= '
                <style>
                @page { margin: 20px; }
                
                </style>
                <p>&nbsp;</p>
                <h3 align="center">Attendance Report</h3><br />      
                ';

        foreach ($result as $row) {
            $output .= '
                    <table width="100%" border="0" cellpadding="5" cellspacing="0">
                    <tr>
                    <td><b>Date - ' . $row["attendance_date"] . '</b></td>
                    </tr>
                    <tr>
                    <td>
                    <table width="100%" border="1" cellpadding="5" cellspacing="0">
                    <tr>
                        <td><b>Student Name</b></td>
                        <td><b>Roll Number</b></td>
                        <td><b>Grade</b></td>
                        <td><b>Teacher</b></td>
                        <td><b>Attendance Status</b></td>
                    </tr>
                ';
            $this->builderAttendance->select('*');
            $this->builderAttendance->join('tbl_student', 'tbl_student.student_id = tbl_attendance.student_id');
            $this->builderAttendance->join('tbl_grade', 'tbl_grade.grade_id = tbl_student.student_grade_id');
            $this->builderAttendance->join('tbl_teacher', 'tbl_teacher.teacher_grade_id = tbl_grade.grade_id');
            $this->builderAttendance->where('tbl_student.student_grade_id', $grade_id);
            $this->builderAttendance->where('tbl_attendance.attendance_date', $row['attendance_date']);
            $query = $this->builderAttendance->get();
            $sub_result = $query->getResultArray();

            foreach ($sub_result as $sub_row) {
                $output .= '
                        <tr>
                            <td>' . $sub_row["student_name"] . '</td>
                            <td>' . $sub_row["student_roll_number"] . '</td>
                            <td>' . $sub_row["grade_name"] . '</td>
                            <td>' . $sub_row["teacher_name"] . '</td>
                            <td>' . $sub_row["attendance_status"] . '</td>
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
    }

    public function export_pdf_by_admin()
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
