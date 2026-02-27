<?php 

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        return view('auth/login');
    }

    public function attemptLogin()
    {
        $session = session();
        $model   = new UserModel();

        $email    = $this->request->getVar('email');
        $password = $this->request->getVar('password');

        $data = $model->where('email', $email)->first();

        if ($data) {

            $verify_pass = password_verify($password, $data['password']);

            if ($verify_pass) {

                $ses_data = [
                    'user_id'  => $data['user_id'], 
                    'name'     => $data['name'],
                    'email'    => $data['email'],
                    'role'     => $data['role'],
                    'logged_in'=> true
                ];

                $session->set($ses_data);

                // Redirect berdasarkan role
                if ($data['role'] == 'admin') {
                    return redirect()->to('/admin/dashboard');
                } else {
                    return redirect()->to('/');
                }

            } else {
                $session->setFlashdata('msg', 'Password salah');
                return redirect()->to('/login');
            }

        } else {
            $session->setFlashdata('msg', 'Email tidak ditemukan');
            return redirect()->to('/login');
        }
    }

    public function register()
    {
        return view('auth/register');
    }

    public function attemptRegister()
    {
        $model = new UserModel();

        $data = [
            'name'     => $this->request->getVar('name'),
            'email'    => $this->request->getVar('email'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
            'role'     => 'customer'
        ];

        $model->save($data);

        return redirect()->to('/login')->with('msg', 'Registrasi berhasil');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}