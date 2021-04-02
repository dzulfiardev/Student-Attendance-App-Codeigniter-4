<?php

namespace App\Models;

use CodeIgniter\Model;

class AttendanceModel extends Model
{
    protected $table = 'tbl_attendance';
    protected $primaryKey = 'attendance_id';
    protected $allowedFields = ['attendance_id', 'student_name', 'attendance_status', 'attendance_date', 'teacher_name', 'grade_name'];

    public function noticeTable($id)
    {
        $builder = $this->db->table("tbl_attendance");
        $builder->select('*');
        $query = $builder->join('tbl_student', 'tbl_student.student_id = tbl_attendance.student_id')
            ->join('tbl_grade', 'tbl_grade.grade_id = tbl_student.student_grade_id')
            ->join('tbl_teacher', 'tbl_teacher.teacher_id = tbl_attendance.teacher_id')
            ->where('tbl_teacher.teacher_id', $id);
        return $query;
    }

    public function noticeTableAdmin()
    {
        $builder = $this->db->table('tbl_attendance');
        $builder->select('*');
        $query = $builder->join('tbl_student', 'tbl_student.student_id = tbl_attendance.student_id')
            ->join('tbl_grade', 'tbl_grade.grade_id = tbl_student.student_grade_id')
            ->join('tbl_teacher', 'tbl_teacher.teacher_id = tbl_attendance.teacher_id');
        return $query;
    }

    public function noticeTableAdminAnalytics()
    {
        $builder = $this->db->table("tbl_student");
        $builder->select('*');
        $query = $builder
            ->join('tbl_grade', 'tbl_grade.grade_id = tbl_student.student_grade_id')
            ->join('tbl_teacher', 'tbl_teacher.teacher_grade_id = tbl_grade.grade_id');
        return $query;
    }

    public function noticeTable2($id)
    {
        $builder = $this->db->table("tbl_student");
        $builder->select('*');
        $query = $builder
            ->join('tbl_grade', 'tbl_grade.grade_id = tbl_student.student_grade_id')
            ->join('tbl_teacher', 'tbl_teacher.teacher_grade_id = tbl_grade.grade_id')
            ->where('tbl_teacher.teacher_id', $id);

        return $query;
    }

    public function addTable($id)
    {
        $builder = $this->db->table("tbl_student");
        $query = $builder->where('student_grade_id', $id);
        return $query;
    }

    public function percentage()
    {
        $percentage = function ($row) {

            $this->where('student_id', $row['student_id']);
            $total_count =  $this->countAllResults();

            $this->where('student_id', $row['student_id']);
            $this->where('attendance_status', 'Present');
            $total_present = $this->countAllResults();

            $result_calc = $total_present * 100 / $total_count;

            if ($result_calc > 0) {
                return number_format($result_calc, 2) . ' %';
            } else {
                return 'N/A';
            }
        };
        return $percentage;
    }

    public function button_report()
    {
        $button = function ($row) {
            return '<button type="button" class="btn btn_tomato report_btn btn-sm" id="' . $row['student_id'] . '" alt="Report Pdf"><i class="fas fa-file-pdf"></i> Report</button>';
        };
        return $button;
    }
    public function button_report_chart()
    {
        $button = function ($row) {
            return '<button type="button" class="btn btn-info btn-sm chart_btn" id="' . $row['student_id'] . '" alt="Report Pdf"><i class="fas fa-chart-pie"></i> Chart</button>
            ' . '  
            <button type="button" class="btn btn_tomato report_btn btn-sm" id="' . $row['student_id'] . '" alt="Report Pdf"><i class="fas fa-file-pdf"></i> Report</button>';
        };
        return $button;
    }

    public function badge_attendance()
    {
        $badge = function ($row) {
            if ($row['attendance_status'] == 'Present') {
                return '<span class="badge bg_lightgreen">Present</span>';
            } else {
                return '<span class="badge bg_tomato text-white">Absent</span>';
            }
        };
        return $badge;
    }

    public function student_name() // in add modal
    {
        $name = function ($row) {
            return $row['student_name'] . '<input type="hidden" name="student_id[]" value="' . $row['student_id'] . '" />';
        };
        return $name;
    }

    public function radio_status_present()
    {
        $radio = function ($row) {
            return '<input type="radio" name="attendance_status' . $row['student_id'] . '" value="Present" />';
        };
        return $radio;
    }
    public function radio_status_absent()
    {
        $radio = function ($row) {
            return '<input type="radio" name="attendance_status' . $row['student_id'] . '" checked value="Absent" />';
        };
        return $radio;
    }
}
