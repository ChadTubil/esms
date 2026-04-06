<?php

namespace App\Controllers;
use App\Models\UsersModel;
use App\Models\SYModel;
use App\Models\ClustersModel;
use App\Models\SHSSubjectsModel;
use App\Models\SHSCurriculumModel;
use App\Models\SHSCurriculumDataModel;
use App\Models\RegStudentsModel;
use App\Models\PaymentTransactionsModel;
use App\Models\EnrollmentHistorySHSModel;
use App\Models\SHSStudentsModel;
use App\Models\SHSPermanentRecordModel;
class SHSDepartmentController extends BaseController
{
    public $usersModel;
    public $syModel;
    public $clustersModel;
    public $shsSubjectsModel;
    public $shsCurriculumModel;
    public $shsCurriculumDataModel;
    public $regStudentsModel;
    public $paymentTransactionsModel;
    public $enrollmentHistorySHSModel;
    public $shsStudentsModel;
    public $shsPermanentRecordModel;
    public $session;
    public function __construct() {
        helper('form');
        $this->usersModel = new UsersModel();
        $this->syModel = new SYModel();
        $this->clustersModel = new ClustersModel();
        $this->shsSubjectsModel = new SHSSubjectsModel();
        $this->shsCurriculumModel = new SHSCurriculumModel();
        $this->shsCurriculumDataModel = new SHSCurriculumDataModel();
        $this->regStudentsModel = new RegStudentsModel();
        $this->paymentTransactionsModel = new PaymentTransactionsModel();
        $this->enrollmentHistorySHSModel = new EnrollmentHistorySHSModel();
        $this->shsStudentsModel = new SHSStudentsModel();
        $this->shsPermanentRecordModel = new SHSPermanentRecordModel();
        $this->session = session();
    }
    public function cluster(){
        $data = [
            'page_title' => 'Holy Cross College | SHS Cluster',
            'page_heading' => 'SHS CLUSTER! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $data['clusterdata'] = $this->clustersModel->where('isdel', '0')->findAll();

        if($this->request->is('post')) {
            $rules = [
                'code' => [
                    'rules' => 'required|is_unique[clusters.code]',
                    'errors' => [
                        'required' => 'Code is required.',
                        'is_unique' => 'This code is already exists.'
                    ],
                ],
                'cluster' => [
                    'rules' => 'required|is_unique[clusters.cluster]',
                    'errors' => [
                        'required' => 'Cluster is required.',
                        'is_unique' => 'This cluster is already exists.'
                    ],
                ],
            ];
            if($this->validate($rules)){
                $clusterdata = [
                    'code' => $this->request->getVar('code'),
                    'cluster' => $this->request->getVar('cluster'),
                ];
                $this->clustersModel->save($clusterdata);
                session()->setTempdata('addsuccess','Cluster added successfully', 3);
                return redirect()->to(current_url());
            } else {
                $data['validation'] = $this->validator;
            }
        }
        return view('shs/clusterview', $data);
    }
    public function deletecluster($id=null) {
        $cludata = [
            'isdel' => '1',
        ];

        $this->clustersModel->where('cluid', $id)->update($id, $cludata);
        session()->setTempdata('deletesuccess', 'Cluster is deleted!', 2);
        return redirect()->to(base_url()."shs-cluster");
    }
    public function updatecluster($id=null) {
        if($this->request->is('post')) {
            $data = [
                'code' => $this->request->getVar('code'),
                'cluster' => $this->request->getVar('cluster'),
            ];

            $this->clustersModel->where('cluid', $id)->update($id, $data);
            session()->setTempdata('updatesuccess', 'Update Successful!', 2);
            return redirect()->to(base_url()."shs-cluster");
        }
    }
    public function subjects(){
        $data = [
            'page_title' => 'Holy Cross College | SHS Subjects',
            'page_heading' => 'SHS SUBJECTS! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $data['shssubjectsdata'] = $this->shsSubjectsModel->where('isdel', '0')->findAll();

        if($this->request->is('post')) {
            $rules = [
                'code' => [
                    'rules' => 'required|is_unique[subjects_shs.code]',
                    'errors' => [
                        'required' => 'Code is required.',
                        'is_unique' => 'This code is already exists.'
                    ],
                ],
                'subject' => [
                    'rules' => 'required|is_unique[subjects_shs.subject]',
                    'errors' => [
                        'required' => 'Subject is required.',
                        'is_unique' => 'This subject is already exists.'
                    ],
                ],
                'hours' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Hours is required.',
                    ],
                ],
                'type' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Subject type is required.',
                    ],
                ],
            ];
            if($this->validate($rules)){
                $shssubjectdata = [
                    'code' => $this->request->getVar('code'),
                    'subject' => $this->request->getVar('subject'),
                    'type' => $this->request->getVar('type'),
                    'hours' => $this->request->getVar('hours'),
                    'prerequisite' => $this->request->getVar('prerequisite'),
                ];
                $this->shsSubjectsModel->save($shssubjectdata);
                session()->setTempdata('addsuccess','Subject added successfully', 3);
                return redirect()->to(current_url());
            } else {
                $data['validation'] = $this->validator;
            }
        }
        return view('shs/subjectsview', $data);
    }
    public function deletesubjects($id=null) {
        $cludata = [
            'isdel' => '1',
        ];

        $this->shsSubjectsModel->where('subid', $id)->update($id, $cludata);
        session()->setTempdata('deletesuccess', 'Subject is deleted!', 2);
        return redirect()->to(base_url()."shs-subjects");
    }
    public function updatesubjects($id=null) {
        if($this->request->is('post')) {
            $data = [
                'code' => $this->request->getVar('code'),
                'subject' => $this->request->getVar('subject'),
                'type' => $this->request->getVar('type'),
                'hours' => $this->request->getVar('hours'),
                'prerequisite' => $this->request->getVar('prerequisite'),
            ];

            $this->shsSubjectsModel->where('subid', $id)->update($id, $data);
            session()->setTempdata('updatesuccess', 'Update Successful!', 2);
            return redirect()->to(base_url()."shs-subjects");
        }
    }
    public function curriculum(){
        $data = [
            'page_title' => 'Holy Cross College | SHS Curriculum',
            'page_heading' => 'SHS CURRICULUM! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $data['sydata'] = $this->syModel->where('syisdel', 0)->findAll();
        $data['clusterdata'] = $this->clustersModel->where('isdel', '0')->findAll();
        $data['shscurriculumdata'] = $this->shsCurriculumModel->where('isdel', '0')->findAll();
        

        if($this->request->is('post')) {
            $rules = [
                'cluster' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Cluster is required.',
                    ],
                ],
            ];
            if($this->validate($rules)){
                $curridata = [
                    'cluster' => $this->request->getVar('cluster'),
                    'sy' => $this->request->getVar('sy'),
                    'level' => $this->request->getVar('level'),
                ];
                $this->shsCurriculumModel->save($curridata);
                session()->setTempdata('addsuccess','Curriculum added successfully', 3);
                return redirect()->to(current_url());
            } else {
                $data['validation'] = $this->validator;
            }
        }
        return view('shs/curriculumview', $data);
    }
    public function deletecurriculum($id=null) {
        $cludata = [
            'isdel' => '1',
        ];

        $this->shsCurriculumModel->where('currid', $id)->update($id, $cludata);
        session()->setTempdata('deletesuccess', 'Curriculum is deleted!', 2);
        return redirect()->to(base_url()."shs-curriculum");
    }
    public function updatecurriculum($id=null) {
        if($this->request->is('post')) {
            $data = [
                'cluster' => $this->request->getVar('cluster'),
                'sy' => $this->request->getVar('sy'),
                'level' => $this->request->getVar('level'),
            ];

            $this->shsCurriculumModel->where('currid', $id)->update($id, $data);
            session()->setTempdata('updatesuccess', 'Update Successful!', 2);
            return redirect()->to(base_url()."shs-curriculum");
        }
    }
    public function setupcurriculum($id=null){
        $data = [
            'page_title' => 'Holy Cross College | SHS Curriculum Setup',
            'page_heading' => 'SHS CURRICULUM SETUP! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $data['sydata'] = $this->syModel->where('syisdel', 0)->findAll();
        $data['clusterdata'] = $this->clustersModel->where('isdel', '0')->findAll();
        $data['shssubjectsdata'] = $this->shsSubjectsModel->where('isdel', '0')->findAll();
        $data['shscurriculumdata'] = $this->shsCurriculumModel->where('currid', $id)->findAll();
        $data['cddata'] = $this->shsCurriculumDataModel->where('curriculumid', $id)->findAll();

        if($this->request->is('post')) {
            $rules = [
                'subject' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Subject is required.',
                    ],
                ],
                'sem' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Semester is required.',
                    ],
                ],
            ];
            if($this->validate($rules)){
                $subjectid = $this->request->getVar('subject');
                $FINDSUBJECT = $this->shsSubjectsModel->where('subid', $subjectid)->findAll();
                foreach($FINDSUBJECT as $FINDSUB){
                    $PRERE = $FINDSUB['prerequisite'];
                }
                $data = [
                    'curriculumid' => $id,
                    'subid' => $this->request->getVar('subject'),
                    'level' => $this->request->getVar('level'),
                    'sem' => $this->request->getVar('sem'),
                    'prerequisite' => $PRERE,
                ];
                $this->shsCurriculumDataModel->save($data);
                session()->setTempdata('addsuccess','Subject added successfully', 3);
                return redirect()->to(current_url());
            } else {
                $data['validation'] = $this->validator;
            }
        }

        return view('shs/curriculumsetupview', $data);
    }
    public function registrationselect(){
        $data = [
            'page_title' => 'Holy Cross College | SHS Registration',
            'page_heading' => 'SHS REGISTRATION!',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();

        return view('shs/registrationselectview', $data);
    }
    public function newregistration(){

    }
    public function registeredstudent(){
        $data = [
            'page_title' => 'Holy Cross College | SHS Registered Students',
            'page_heading' => 'SHS REGISTERED STUDENTS!',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();

        $data['registeredstudents'] = $this->regStudentsModel
        ->select('regstudents.*')
        ->join('paymenttransactions', 'paymenttransactions.studfullname = regstudents.studfullname')
        ->join('enrollmenthistory_shs', 'enrollmenthistory_shs.studid = regstudents.studid AND enrollmenthistory_shs.isdel = 0', 'left')
        ->where('enrollmenthistory_shs.studid IS NULL') // Only those NOT in enrollment history
        ->groupBy('regstudents.studid')
        ->findAll();


        return view('shs/registeredstudentview', $data);
    }
    public function registeredstudentProcess($id=null){
        $registeredstudent = $this->regStudentsModel->where('studid', $id)->findAll();
        foreach($registeredstudent as $rs){
            $STUDLN = $rs['studln'];
            $STUDFN = $rs['studfn'];
            $STUDMN = $rs['studmn'];
            $STUDEXT = $rs['studextension'];
            $STUDFULLNAME = $rs['studfullname'];
            $STUDBIRTHDAY = $rs['studbirthday'];
            $STUDAGE = $rs['studage'];
            $STUDGENDER = $rs['studgender'];
            $STUDBARANGAY = $rs['studstbarangay'];
            $STUDCITY = $rs['studcity'];
            $STUDPROVINCE = $rs['studprovince'];
            $STUDCONTACT = $rs['studcontact'];
            $STUDICITIZENSHIP = $rs['studcitizenship'];
            $STUDRELIGION = $rs['studreligion'];
            $STUDEMAIL = $rs['studemail'];
            $STUDBIRTHPLACE = $rs['studbirthplace'];
        }
        $shsstuddata = [
            'studln' => $STUDLN,
            'studfn' => $STUDFN,
            'studmn' => $STUDMN,
            'studextension' => $STUDEXT,
            'studfullname' => $STUDFULLNAME,
            'studbirthday' => $STUDBIRTHDAY,
            'studage' => $STUDAGE,
            'studgender' => $STUDGENDER,
            'studstbarangay' => $STUDBARANGAY,
            'studcity' => $STUDCITY,
            'studprovince' => $STUDPROVINCE,
            'studcontact' => $STUDCONTACT,
            'studcitizenship' => $STUDICITIZENSHIP,
            'studreligion' => $STUDRELIGION,
            'studemail' => $STUDEMAIL,
            'studbirthplace' => $STUDBIRTHPLACE,
        ];
        $this->shsStudentsModel->save($shsstuddata);
        $registeredstudentpr = $this->shsStudentsModel->where('studfullname', $STUDFULLNAME)->findAll();
        foreach($registeredstudentpr as $rsp){
            $STUDID = $rsp['studid'];
        }
        $shsprdata = [
            'studid' => $STUDID,
        ];
        $this->shsPermanentRecordModel->where('studid', $id)->update($id, $shsprdata);
        $ehdata = [
            'studid' => $STUDID,
            'date' => date('Y-m-d'),
            'status' => 'Registered',
        ];
        $this->enrollmentHistorySHSModel->save($ehdata);
        return redirect()->to(base_url()."shs-admission");
    }
    public function admission(){
        $data = [
            'page_title' => 'Holy Cross College | SHS Admission',
            'page_heading' => 'SHS ADMISSION!',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();

        return view('shs/admissionview', $data);
    }
}
