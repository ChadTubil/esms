<?php

namespace App\Controllers;
use App\Models\UsersModel;
use App\Models\SYModel;
use App\Models\SemesterModel;
use App\Models\ImportedGradesModel;
use App\Models\FARModel;
use App\Models\EmployeesModel;
class FARController extends BaseController
{
    public $usersModel;
    public $syModel;
    public $semModel;
    public $importedGradeModel;
    public $farModel;
    public $empModel;
    public $session;
    public function __construct() {
        helper('form');
        $this->usersModel = new UsersModel();
        $this->syModel = new SYModel();
        $this->semModel = new SemesterModel();
        $this->importedGradeModel = new ImportedGradesModel();
        $this->farModel = new FARModel();
        $this->empModel = new EmployeesModel();
        $this->session = session();
    }
    public function index()
    {
        $data = [
            'page_title' => 'Holy Cross College | Teacher Evaluation',
            'page_heading' => 'TEACHER EVALUATION! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();

        $data['sydata'] = $this->syModel->where('syisdel', 0)
        ->where('systatus', 0)->findAll(); //SY Active

        $data['semdata'] = $this->semModel->where('semisdel', 0)
        ->where('semstatus', 0)->findAll(); //SEM Active

        $activeSY = $this->syModel->where('syisdel', 0)
        ->where('systatus', 0)->findAll();
        foreach($activeSY as $aSY) {
            $SY = $aSY['syname'];
        }
        $activeSEM = $this->semModel->where('semisdel', 0)
        ->where('semstatus', 0)->findAll();
        foreach($activeSEM as $aSEM) {
            $SEM = $aSEM['semester'];
        }
        $activeStudent = $this->usersModel->where('uid', $uid)->findAll();
        foreach($activeStudent as $aStudent) {
            $STUDENT = $aStudent['uaccountid'];
        }

        $data['studeval'] = $this->importedGradeModel->where('sy', $SY)
        ->where('sem', $SEM)->where('studentno', $STUDENT)->findAll();

        $data['fardata'] = $this->farModel->findAll();

        return view('studentfarview', $data);
    }
    public function farStudent($id=null){
        $data = [
            'page_title' => 'Holy Cross College | Teacher Evaluation',
            'page_heading' => 'TEACHER EVALUATION! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();

        $data['studeval'] = $this->importedGradeModel->where('impgradeid', $id)->findAll();
        
        $IPGM = $this->importedGradeModel->where('impgradeid', $id)->findAll();
        foreach($IPGM as $ipgm) {
            $TXTACCOUNT = $ipgm['studentno'];
            $TXTTEACHER = $ipgm['teachername'];
            $TXTSUBJECT = $ipgm['subjectdescription'];
            $TXTCOURSE = $ipgm['course'];
            $TXTSY = $ipgm['sy'];
            $TXTSEM = $ipgm['sem'];
        }
        $data['far'] = $this->farModel
            ->where('faraccountid', $TXTACCOUNT)
            ->where('farname', $TXTTEACHER)
            ->where('farsubject', $TXTSUBJECT)
            ->where('farcourse', $TXTCOURSE)
            ->where('farsy', $TXTSY)
            ->where('farsem', $TXTSEM)
            ->findAll();

        return view('studentfarevalview', $data);
    }
    public function farStudentfirst(){
        if($this->request->is('post')) {
            $TXTEVALUATOR = $this->request->getVar('txtevaluator');
            $TXTACCOUNT = $this->request->getVar('txtaccount');
            $TXTTEACHER = $this->request->getVar('txtteacher');
            $TXTSUBJECT = $this->request->getVar('txtsubject');
            $TXTDEPARTMENT = $this->request->getVar('txtdepartment');
            $TXTCOURSE = $this->request->getVar('txtcourse');
            $TXTSY = $this->request->getVar('txtsy');
            $TXTSEM = $this->request->getVar('txtsem');
            $data = [
                'farevaluator' => '1',
                'faraccountid' => $TXTACCOUNT,
                'farname' => $TXTTEACHER,
                'farsubject' => $TXTSUBJECT,
                'fardepartment' => $TXTDEPARTMENT,
                'farcourse' => $TXTCOURSE,
                'farsy' => $TXTSY,
                'farsem' => $TXTSEM,
            ];
            $this->farModel->save($data);
            $farstudentdatasearch = $this->farModel
            ->where('farevaluator', '1')
            ->where('faraccountid', $TXTACCOUNT)
            ->where('farname', $TXTTEACHER)
            ->where('farsubject', $TXTSUBJECT)
            ->where('fardepartment', $TXTDEPARTMENT)
            ->where('farcourse', $TXTCOURSE)
            ->where('farsy', $TXTSY)
            ->where('farsem', $TXTSEM)
            ->findAll();

            foreach($farstudentdatasearch as $fsds) {
                $FARID = $fsds['farid'];
            }
            return redirect()->to('studentfar/evaluationsecond/'.$FARID);
        }
    }
    public function farStudentsecond($id=null){
        $data = [
            'page_title' => 'Holy Cross College | Teacher Evaluation',
            'page_heading' => 'TEACHER EVALUATION! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();

        $data['farstudent'] = $this->farModel->where('farid', $id)->findAll();

        return view('studentfarevalviewtwo', $data);
    }
    public function farStudentthird($id=null){
        if($this->request->is('post')) {
            $farq1 = $this->request->getVar('txtfarq1');
            $farq2 = $this->request->getVar('txtfarq2');
            $farq3 = $this->request->getVar('txtfarq3');
            $farq4 = $this->request->getVar('txtfarq4');
            $farq5 = $this->request->getVar('txtfarq5');
            $farq6 = $this->request->getVar('txtfarq6');
            $farq7 = $this->request->getVar('txtfarq7');
            $farq8 = $this->request->getVar('txtfarq8');
            $farq9 = $this->request->getVar('txtfarq9');
            $farq10 = $this->request->getVar('txtfarq10');
            $farq11 = $this->request->getVar('txtfarq11');
            $farq12 = $this->request->getVar('txtfarq12');
            $farq13 = $this->request->getVar('txtfarq13');
            $farq14 = $this->request->getVar('txtfarq14');
            $farq15 = $this->request->getVar('txtfarq15');
            $farq16 = $this->request->getVar('txtfarq16');
            $farq17 = $this->request->getVar('txtfarq17');
            $farq18 = $this->request->getVar('txtfarq18');
            $farq19 = $this->request->getVar('txtfarq19');
            $farq20 = $this->request->getVar('txtfarq20');
            $farqtotal = $farq1 + $farq2 + $farq3 + $farq4 + $farq5 + $farq6 + $farq7 + $farq8 + $farq9
            + $farq10 + $farq11 + $farq12 + $farq13 + $farq14 + $farq15 + $farq16 + $farq17 + $farq18 + $farq19
            + $farq20;
            $data = [
                'farq1' => $this->request->getVar('txtfarq1'),
                'farq2' => $this->request->getVar('txtfarq2'),
                'farq3' => $this->request->getVar('txtfarq3'),
                'farq4' => $this->request->getVar('txtfarq4'),
                'farq5' => $this->request->getVar('txtfarq5'),
                'farq6' => $this->request->getVar('txtfarq6'),
                'farq7' => $this->request->getVar('txtfarq7'),
                'farq8' => $this->request->getVar('txtfarq8'),
                'farq9' => $this->request->getVar('txtfarq9'),
                'farq10' => $this->request->getVar('txtfarq10'),
                'farq11' => $this->request->getVar('txtfarq11'),
                'farq12' => $this->request->getVar('txtfarq12'),
                'farq13' => $this->request->getVar('txtfarq13'),
                'farq14' => $this->request->getVar('txtfarq14'),
                'farq15' => $this->request->getVar('txtfarq15'),
                'farq16' => $this->request->getVar('txtfarq16'),
                'farq17' => $this->request->getVar('txtfarq17'),
                'farq18' => $this->request->getVar('txtfarq18'),
                'farq19' => $this->request->getVar('txtfarq19'),
                'farq20' => $this->request->getVar('txtfarq20'),
                'farqtotal' => $farqtotal,
            ];
            $this->farModel->where('farid', $id)->update($id, $data);
            return redirect()->to(base_url()."studentfar/evaluationfourth/".$id);
        }
    }
    public function farStudentfourth($id=null){
        $data = [
            'page_title' => 'Holy Cross College | Teacher Evaluation',
            'page_heading' => 'TEACHER EVALUATION! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $data['farstudent'] = $this->farModel->where('farid', $id)->findAll();

        return view('studentfarevalviewfourth', $data);
    }
    public function farStudentfifth($id=null){
        if($this->request->is('post')) {
            $farinfo = $this->farModel->where('farid', $id)->findAll();
            foreach($farinfo as $fi) {
                $FARQTOTAL = $fi['farqtotal'];
            }
            $farq21 = $this->request->getVar('txtfarq21');
            $farq22 = $this->request->getVar('txtfarq22');
            $farq23 = $this->request->getVar('txtfarq23');
            $farq24 = $this->request->getVar('txtfarq24');
            $farq25 = $this->request->getVar('txtfarq25');
            $farqtotal = $farq21 + $farq22 + $farq23 + $farq24 + $farq25 + $FARQTOTAL;

            $data = [
                'farq21' => $this->request->getVar('txtfarq21'),
                'farq22' => $this->request->getVar('txtfarq22'),
                'farq23' => $this->request->getVar('txtfarq23'),
                'farq24' => $this->request->getVar('txtfarq24'),
                'farq25' => $this->request->getVar('txtfarq25'),
                'farqtotal' => $farqtotal,
            ];
            $this->farModel->where('farid', $id)->update($id, $data);
            return redirect()->to(base_url()."studentfar/evaluationsixth/".$id);
        }
    }
    public function farStudentsixth($id=null){
        $data = [
            'page_title' => 'Holy Cross College | Teacher Evaluation',
            'page_heading' => 'TEACHER EVALUATION! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $data['farstudent'] = $this->farModel->where('farid', $id)->findAll();

        return view('studentfarevalviewsixth', $data);
    }
    public function farStudentseventh($id=null){
        if($this->request->is('post')) {
            $farinfo = $this->farModel->where('farid', $id)->findAll();
            foreach($farinfo as $fi) {
                $FARQTOTAL = $fi['farqtotal'];
            }
            $farq26 = $this->request->getVar('txtfarq26');
            $farq27 = $this->request->getVar('txtfarq27');
            $farq28 = $this->request->getVar('txtfarq28');
            $farq29 = $this->request->getVar('txtfarq29');
            $farq30 = $this->request->getVar('txtfarq30');
            $farq31 = $this->request->getVar('txtfarq31');
            $farq32 = $this->request->getVar('txtfarq32');
            $farq33 = $this->request->getVar('txtfarq33');
            $farq34 = $this->request->getVar('txtfarq34');
            $farq35 = $this->request->getVar('txtfarq35');
            $farq36 = $this->request->getVar('txtfarq36');
            $farq37 = $this->request->getVar('txtfarq37');
            $farq38 = $this->request->getVar('txtfarq38');
            $farq39 = $this->request->getVar('txtfarq39');
            $farq40 = $this->request->getVar('txtfarq40');
            $farq41 = $this->request->getVar('txtfarq38');
            $farq42 = $this->request->getVar('txtfarq39');
            $farqtotal = + $farq26 + $farq27 + $farq28 + $farq29 + $farq30 + $farq31 + $farq32 + $farq33 + $farq34
            + $farq35 + $farq36 + $farq37 + $farq38 + $farq39 + $farq40 + $farq41 + $farq42 + $FARQTOTAL;
            $data = [
                'farq26' => $this->request->getVar('txtfarq26'),
                'farq27' => $this->request->getVar('txtfarq27'),
                'farq28' => $this->request->getVar('txtfarq28'),
                'farq29' => $this->request->getVar('txtfarq29'),
                'farq30' => $this->request->getVar('txtfarq30'),
                'farq31' => $this->request->getVar('txtfarq31'),
                'farq32' => $this->request->getVar('txtfarq32'),
                'farq33' => $this->request->getVar('txtfarq33'),
                'farq34' => $this->request->getVar('txtfarq34'),
                'farq35' => $this->request->getVar('txtfarq35'),
                'farq36' => $this->request->getVar('txtfarq36'),
                'farq37' => $this->request->getVar('txtfarq37'),
                'farq38' => $this->request->getVar('txtfarq38'),
                'farq39' => $this->request->getVar('txtfarq39'),
                'farq40' => $this->request->getVar('txtfarq40'),
                'farq41' => $this->request->getVar('txtfarq38'),
                'farq42' => $this->request->getVar('txtfarq39'),
                'farqtotal' => $farqtotal,
                'farcomment' => $this->request->getVar('txtfarcomment'),
            ];
            $this->farModel->where('farid', $id)->update($id, $data);
            return redirect()->to(base_url()."studentfar");
        }
    }
}
