<?php

namespace App\Controllers;
use App\Models\UsersModel;
use App\Models\RoomsModel;
class RoomsController extends BaseController
{
    public $usersModel;
    public $roomsModel;
    public $session;
    public function __construct() {
        helper('form');
        $this->usersModel = new UsersModel();
        $this->roomsModel = new RoomsModel();
        $this->session = session();
    }
    public function index()
    {
        $data = [
            'page_title' => 'Holy Cross College | ROOMS',
            'page_heading' => 'ROOMS! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user'))
        {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $data['roomdata'] = $this->roomsModel->where('roomisdel', 0)->findAll();

        if($this->request->is('post')) {
            $rules = [
                'rcode' => [
                    'rules' => 'required|is_unique[rooms.roomcode]',
                    'errors' => [
                        'required' => 'Room is required.',
                        'is_unique' => 'This room is already exists.'
                    ],
                ],
            ];
            if($this->validate($rules)) {
                $roomdata = [
                    'roomcode' => $this->request->getVar('rcode'),
                    'room' => $this->request->getVar('rdescription'),
                    'roomisdel' => '0',
                ];
                $this->roomsModel->save($roomdata);
                session()->setTempdata('addsuccess', 'Room is added successfully', 3);
                return redirect()->to(current_url());
            } else {
                $data['validation'] = $this->validator;
            }
        }

        return view('roomsview', $data);
    }
    public function deleteRoom($id=null){
        $data = [
            'roomisdel' => '1',
        ];

        $this->roomsModel->where('roomid', $id)->update($id, $data);
        session()->setTempdata('deletesuccess', 'Room is deleted!', 2);
        return redirect()->to(base_url()."rooms");
    }
    public function updateRoom($id=null) {
        if($this->request->is('post')) {
            $data = [
                'roomcode' => $this->request->getVar('rcode'),
                'room' => $this->request->getVar('rdescription'),
            ];

            $this->roomsModel->where('roomid', $id)->update($id, $data);
            session()->setTempdata('updatesuccess', 'Update is Successful!', 2);
            return redirect()->to(base_url()."rooms");
        }
    }
}
