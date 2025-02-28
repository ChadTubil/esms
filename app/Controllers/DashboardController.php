<?php

namespace App\Controllers;
use App\Models\UsersModel;
class DashboardController extends BaseController
{
    public $usersModel;
    public $session;
    public function __construct() {
        $this->usersModel = new UsersModel();
        helper('form');
        $this->session = session();
    }
    public function index()
    {
        $data = [
            'page_title' => 'Holy Cross College | Dashboard',
            'page_heading' => 'Hello! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user'))
        {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();

        return view('dashboardview', $data);
    }
    public function logout() 
    {
        session()->remove('logged_user');
        session()->destroy();
        return redirect()->to(base_url());
    }
}
