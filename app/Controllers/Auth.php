<?php

namespace App\Controllers;

use App\Models\AdminModel;
use App\Models\TeacherModel;

class Auth extends BaseController
{
    public function admin_login()
    {
        $data = [
            'title' => 'Admin Login'
        ];
        return view('auth/login', $data);
    } // Admin Login

    public function check_admin_login()
    {
        $session = session();
        $model = new AdminModel();
        $username = $this->request->getVar('admin_user_name');
        $password = $this->request->getVar('admin_password');

        $data = $model->where('admin_user_name', $username)->first();
        if ($data) {
            $pass = $data['admin_password'];
            $verify_pass = password_verify($password, $pass);
            if ($verify_pass) {
                $ses_data = [
                    'admin_id'          => $data['admin_id'],
                    'admin_user_name'   => $data['admin_user_name'],
                    'logged_in'         => TRUE
                ];

                $session->set($ses_data);
                return redirect()->to('/admin');
            } else {
                $session->setFlashdata('msg', 'Wrong Password');
                return redirect()->to('/');
            }
        } else {
            $session->setFlashdata('msg', 'Username not Found');
            return redirect()->to('/');
        }
    }

    public function index()
    {
        $data = [
            'title' => 'Teacher Login'
        ];
        return view('auth/teacher_login', $data);
    }

    public function check_teacher_login()
    {
        $session = session();
        $model = new TeacherModel();
        $email = $this->request->getVar('teacher_email');
        $password = $this->request->getVar('teacher_password');
        $data = $model->where('teacher_emailid', $email)->first();
        if ($data) {
            $pass = $data['teacher_password'];
            $verify_pass = password_verify($password, $pass);
            if ($verify_pass) {
                $ses_data = [
                    'teacher_id'            => $data['teacher_id'],
                    'teacher_name'          => $data['teacher_name'],
                    'teacher_emailid'       => $data['teacher_emailid'],
                    'teacher_address'       => $data['teacher_address'],
                    'teacher_qualification' => $data['teacher_qualification'],
                    'teacher_image'         => $data['teacher_image'],
                    'teacher_grade_id'      => $data['teacher_grade_id'],
                    'teacher_doj'           => $data['teacher_doj'],
                    'logged_in_teacher'     => TRUE
                ];

                $session->set($ses_data);
                return redirect()->to('/dashboard');
            } else {
                $session->setFlashdata('msg', 'Wrong Password');
                return redirect()->to('/teacher_login');
            }
        } else {
            $session->setFlashdata('msg', 'Email not Found');
            return redirect()->to('/teacher_login');
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/');
    }
}
