<?php

namespace App\Controllers;
use App\Models\UsersModel;
use App\Models\SYModel;
use App\Models\IBEDLevelModel;
use App\Models\IBEDSubjectsModel;
use App\Models\IBEDCurriculumModel;
use App\Models\IBEDCurriculumDataModel;
use App\Models\IBEDSectionsModel;
use App\Models\RegStudentsModel;
use App\Models\PaymentTransactionsModel;
use App\Models\EnrollmentHistoryIBEDModel;
use App\Models\IBEDStudentsModel;
use App\Models\IBEDSchoolRecordModel;
use App\Models\IBEDFamilyBackgroundModel;
use App\Models\AdditionalInfoIBEDModel;
use App\Models\IBEDAssessmentModel;
use App\Models\IBEDRatesModel;
use App\Models\IBEDRateOtherFeesModel;
use App\Models\IBEDRateDuesModel;
use App\Models\StudentAccountsModel;
use TCPDF;
class IBEDDepartmentController extends BaseController
{
    public $usersModel;
    public $syModel;
    public $ibedlevelModel;
    public $ibedSubjectsModel;
    public $ibedcurriculumModel;
    public $ibedCurriculumDataModel;
    public $ibedSectionsModel;
    public $regStudentsModel;
    public $paymentTransactionsModel;
    public $enrollmentHistoryIBEDModel;
    public $ibedStudentsModel;
    public $ibedSchoolRecordModel;
    public $ibedFamilyBackgroundModel;
    public $additionalInfoIBEDModel;
    public $ibedAssessmentModel;
    public $ibedRatesModel;
    public $ibedRateOtherFeesModel;
    public $ibedRateDuesModel;
    public $studentAccountsModel;
    public $session;
    public function __construct() {
        helper('form');
        $this->usersModel = new UsersModel();
        $this->syModel = new SYModel();
        $this->ibedlevelModel = new IBEDLevelModel();
        $this->ibedSubjectsModel = new IBEDSubjectsModel();
        $this->ibedcurriculumModel = new IBEDCurriculumModel();
        $this->ibedCurriculumDataModel = new IBEDCurriculumDataModel();
        $this->ibedSectionsModel = new IBEDSectionsModel();
        $this->regStudentsModel = new RegStudentsModel();
        $this->paymentTransactionsModel = new PaymentTransactionsModel();
        $this->enrollmentHistoryIBEDModel = new EnrollmentHistoryIBEDModel();
        $this->ibedStudentsModel = new IBEDStudentsModel();
        $this->ibedSchoolRecordModel = new IBEDSchoolRecordModel();
        $this->ibedFamilyBackgroundModel = new IBEDFamilyBackgroundModel();
        $this->additionalInfoIBEDModel = new AdditionalInfoIBEDModel();
        $this->ibedAssessmentModel = new IBEDAssessmentModel();
        $this->ibedRatesModel = new IBEDRatesModel();
        $this->ibedRateOtherFeesModel = new IBEDRateOtherFeesModel();
        $this->ibedRateDuesModel = new IBEDRateDuesModel();
        $this->studentAccountsModel = new StudentAccountsModel();
        $this->session = session();
    }
    public function level(){
        $data = [
            'page_title' => 'Holy Cross College | IBED Grade Level Management',
            'page_heading' => 'IBED GRADE LEVEL MANAGEMENT! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $data['levelsdata'] = $this->ibedlevelModel->where('isdel', '0')->findAll();

        if($this->request->is('post')) {
            $rules = [
                'code' => [
                    'rules' => 'required|is_unique[levels_ibed.code]',
                    'errors' => [
                        'required' => 'Code is required.',
                        'is_unique' => 'This code is already exists.'
                    ],
                ],
                'level' => [
                    'rules' => 'required|is_unique[levels_ibed.name]',
                    'errors' => [
                        'required' => 'Level is required.',
                        'is_unique' => 'This level is already exists.'
                    ],
                ],
            ];
            if($this->validate($rules)){
                $leveldata = [
                    'code' => $this->request->getVar('code'),
                    'name' => $this->request->getVar('level'),
                ];
                $this->ibedlevelModel->save($leveldata);
                session()->setTempdata('addsuccess','Level added successfully', 3);
                return redirect()->to(current_url());
            } else {
                $data['validation'] = $this->validator;
            }
        }
        return view('ibed/levelview', $data);
    }
    public function deletelevel($id=null) {
        $leveldata = [
            'isdel' => '1',
        ];

        $this->ibedlevelModel->where('levelid', $id)->update($id, $leveldata);
        session()->setTempdata('success', 'Level is deleted!', 2);
        return redirect()->to(base_url()."ibed-level");
    }
    public function updatelevel($id=null) {
        if($this->request->is('post')) {
            $data = [
                'code' => $this->request->getVar('code'),
                'name' => $this->request->getVar('level'),
            ];

            $this->ibedlevelModel->where('levelid', $id)->update($id, $data);
            session()->setTempdata('success', 'Update Successful!', 2);
            return redirect()->to(base_url()."ibed-level");
        }
    }
    public function subjects(){
        $data = [
            'page_title' => 'Holy Cross College | IBED Subjects Management',
            'page_heading' => 'IBED SUBJECTS MANAGEMENT! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $data['ibedsubdata'] = $this->ibedSubjectsModel->where('isdel', '0')->findAll();

        if($this->request->is('post')) {
            $rules = [
                'subject' => [
                    'rules' => 'required|is_unique[subjects_ibed.subject]',
                    'errors' => [
                        'required' => 'Subject is required.',
                        'is_unique' => 'This subject is already exists.'
                    ],
                ],
            ];
            if($this->validate($rules)){
                $ibedsubjectdata = [
                    'code' => $this->request->getVar('code'),
                    'subject' => $this->request->getVar('subject'),
                ];
                $this->ibedSubjectsModel->save($ibedsubjectdata);
                session()->setTempdata('addsuccess','Subject added successfully', 3);
                return redirect()->to(current_url());
            } else {
                $data['validation'] = $this->validator;
            }
        }
        return view('ibed/subjectsview', $data);
    }
    public function deletesubjects($id=null) {
        $cludata = [
            'isdel' => '1',
        ];

        $this->ibedSubjectsModel->where('subid', $id)->update($id, $cludata);
        session()->setTempdata('deletesuccess', 'Subject is deleted!', 2);
        return redirect()->to(base_url()."ibed-subjects");
    }
    public function updatesubjects($id=null) {
        if($this->request->is('post')) {
            $data = [
                'code' => $this->request->getVar('code'),
                'subject' => $this->request->getVar('subject'),
            ];

            $this->ibedSubjectsModel->where('subid', $id)->update($id, $data);
            session()->setTempdata('updatesuccess', 'Update Successful!', 2);
            return redirect()->to(base_url()."ibed-subjects");
        }
    }
    public function curriculum(){
        $data = [
            'page_title' => 'Holy Cross College | IBED Curriculum Management',
            'page_heading' => 'IBED CURRICULUM MANAGEMENT! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $data['sydata'] = $this->syModel->where('syisdel', 0)->findAll();
        $data['levelsdata'] = $this->ibedlevelModel->where('isdel', '0')->findAll();
        $data['curriculumdata'] = $this->ibedcurriculumModel
        ->select('curriculum_ibed.*, levels_ibed.*')
        ->join('levels_ibed', 'levels_ibed.levelid = curriculum_ibed.level')
        ->where('curriculum_ibed.isdel', '0')->findAll();
        

        if($this->request->is('post')) {
            $rules = [
                'level' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Level is required.',
                    ],
                ],
            ];
            if($this->validate($rules)){
                $curridata = [
                    'level' => $this->request->getVar('level'),
                    'sy' => $this->request->getVar('sy'),
                ];
                $this->ibedcurriculumModel->save($curridata);
                session()->setTempdata('addsuccess','Curriculum added successfully', 3);
                return redirect()->to(current_url());
            } else {
                $data['validation'] = $this->validator;
            }
        }
        return view('ibed/curriculumview', $data);
    }
    public function deletecurriculum($id=null) {
        $cludata = [
            'isdel' => '1',
        ];

        $this->ibedcurriculumModel->where('currid', $id)->update($id, $cludata);
        session()->setTempdata('deletesuccess', 'Curriculum is deleted!', 2);
        return redirect()->to(base_url()."ibed-curriculum");
    }
    public function updatecurriculum($id=null) {
        if($this->request->is('post')) {
            $data = [
                'level' => $this->request->getVar('level'),
                'sy' => $this->request->getVar('sy'),
            ];

            $this->ibedcurriculumModel->where('currid', $id)->update($id, $data);
            session()->setTempdata('updatesuccess', 'Update Successful!', 2);
            return redirect()->to(base_url()."ibed-curriculum");
        }
    }
    public function setupcurriculum($id=null){
        $data = [
            'page_title' => 'Holy Cross College | IBED Curriculum Setup',
            'page_heading' => 'IBED CURRICULUM SETUP! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $data['sydata'] = $this->syModel->where('syisdel', 0)->findAll();
        $data['levelsdata'] = $this->ibedlevelModel->where('isdel', '0')->findAll();
        $data['ibedsubdata'] = $this->ibedSubjectsModel->where('isdel', '0')->findAll();
        $data['ibedcurriculumdata'] = $this->ibedcurriculumModel
        ->select('curriculum_ibed.*, levels_ibed.*')
        ->join('levels_ibed', 'levels_ibed.levelid = curriculum_ibed.level')
        ->where('currid', $id)->findAll();
        $data['cddata'] = $this->ibedCurriculumDataModel->where('curriculumid', $id)->findAll();

        if($this->request->is('post')) {
            $rules = [
                'subject' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Subject is required.',
                    ],
                ],
            ];
            if($this->validate($rules)){
                $subjectid = $this->request->getVar('subject');
                $data = [
                    'curriculumid' => $id,
                    'subid' => $this->request->getVar('subject'),
                    'level' => $this->request->getVar('level'),
                ];
                $this->ibedCurriculumDataModel->save($data);
                session()->setTempdata('addsuccess','Subject added successfully', 3);
                return redirect()->to(current_url());
            } else {
                $data['validation'] = $this->validator;
            }
        }

        return view('ibed/curriculumsetupview', $data);
    }
    public function sections() {
        $data = [
            'page_title' => 'Holy Cross College | IBED Sections Management',
            'page_heading' => 'IBED SECTIONS MANAGEMENT! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $data['sydata'] = $this->syModel->where('syisdel', 0)->findAll();
        $data['levelsdata'] = $this->ibedlevelModel->where('isdel', '0')->findAll();
        $data['sectiondata'] = $this->ibedSectionsModel
        ->select('sections_ibed.*, levels_ibed.*')
        ->join('levels_ibed', 'levels_ibed.levelid = sections_ibed.level')
        ->where('sections_ibed.isdel', '0')->findAll();

        if($this->request->is('post')) {
            $rules = [
                'section' => [
                    'rules' => 'required|is_unique[sections_ibed.section]',
                    'errors' => [
                        'required' => 'Section is required.',
                        'is_unique' => 'This section is already exists.'
                    ],
                ],
                'sy' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'School year is required.',
                    ],
                ],
                'level' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Level is required.',
                    ],
                ],
            ];
            if($this->validate($rules)) {
                $sectiondata = [
                    'section' => $this->request->getVar('section'),
                    'sy' => $this->request->getVar('sy'),
                    'level' => $this->request->getVar('level'),
                ];
                $this->ibedSectionsModel->save($sectiondata);
                session()->setTempdata('success', 'Section is added successfully', 3);
                return redirect()->to(current_url());
            } else {
                $data['validation'] = $this->validator;
            }
        }

        return view('ibed/sectionsview', $data);
    }
    public function deletesections($id=null) {
        $data = [
            'isdel' => '1',
        ];

        $this->ibedSectionsModel->where('secid', $id)->update($id, $data);
        session()->setTempdata('success', 'Section is deleted!', 2);
        return redirect()->to(base_url()."ibed-sections");
    }
    public function updatesections($id=null) {
        if($this->request->is('post')) {
            $sectiondata = [
                'section' => $this->request->getVar('section'),
                'sy' => $this->request->getVar('sy'),
                'level' => $this->request->getVar('level'),
            ];

            $this->ibedSectionsModel->where('secid', $id)->update($id, $sectiondata);
            session()->setTempdata('updatesuccess', 'Update Successful!', 2);
            return redirect()->to(base_url()."ibed-sections");
        }
    }
    public function registrationselect(){
        $data = [
            'page_title' => 'Holy Cross College | IBED Registration',
            'page_heading' => 'IBED REGISTRATION!',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();

        return view('ibed/registrationselectview', $data);
    }
    public function oldstudentselect(){
        $data = [
            'page_title' => 'Holy Cross College | SHS Registration - Old Students',
            'page_heading' => 'SHS REGISTRATION - OLD STUDENTS!',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $shsStudentsInfo = $this->ibedStudentsModel
        ->select('students_ibed.*, enrollmenthistory_ibed.*')
        ->join('enrollmenthistory_ibed', 'enrollmenthistory_ibed.studid = students_ibed.studid')
        ->where('students_ibed.studentno', '')
        ->where('enrollmenthistory_ibed.sy', '')
        ->where('enrollmenthistory_ibed.level', '')
        ->where('enrollmenthistory_ibed.isdel', '')
        ->findAll();
        $registeredstudentsinfo = $this->regStudentsModel
        ->select('regstudents.*')
        ->where('NOT EXISTS (SELECT 1 FROM enrollmenthistory_ibed 
            WHERE enrollmenthistory_ibed.studfullname = regstudents.studfullname 
            AND enrollmenthistory_ibed.isdel = 0)', NULL, FALSE)
        ->where('studstatus', 'GS')
        ->findAll();
        $data['registeredstudents'] = array_merge($shsStudentsInfo, $registeredstudentsinfo);

        return view('ibed/oldselectview', $data);
    }
    public function oldstudentprocess(){
        if($this->request->is('post')) {
            $studfullname = $this->request->getVar('fullname');
            $studno = $this->request->getVar('studnumber');

            $CHECKSTUDSHSTABLE = $this->ibedStudentsModel
            ->where('studfullname', $studfullname)->findAll();

            if(empty($CHECKSTUDSHSTABLE)){
                $CHECKREGTABLE = $this->regStudentsModel->where('studfullname', $studfullname)->findAll();
                foreach($CHECKREGTABLE as $CRT){
                    $STUDLN = $CRT['studln'];
                    $STUDFN = $CRT['studfn'];
                    $STUDMN = $CRT['studmn'];
                    $STUDEXT = $CRT['studextension'];
                    $STUDFULLNAME = $CRT['studfullname'];
                    $STUDBIRTHDAY = $CRT['studbirthday'];
                    $STUDAGE = $CRT['studage'];
                    $STUDGENDER = $CRT['studgender'];
                    $STUDBARANGAY = $CRT['studstbarangay'];
                    $STUDCITY = $CRT['studcity'];
                    $STUDPROVINCE = $CRT['studprovince'];
                    $STUDCONTACT = $CRT['studcontact'];
                    $STUDICITIZENSHIP = $CRT['studcitizenship'];
                    $STUDRELIGION = $CRT['studreligion'];
                    $STUDEMAIL = $CRT['studemail'];
                    $STUDBIRTHPLACE = $CRT['studbirthplace'];
                }
                $ibedstuddata = [
                    'studentno' => $studno,
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
                $this->ibedStudentsModel->save($ibedstuddata);
                $registeredstudentpr = $this->ibedStudentsModel->where('studfullname', $STUDFULLNAME)->findAll();
                foreach($registeredstudentpr as $rsp){
                    $STUDID = $rsp['studid'];
                }
                $ehdata = [
                    'studid' => $STUDID,
                    'studfullname' => $STUDFULLNAME,
                    'date' => date('Y-m-d'),
                    'status' => 'Registered',
                ];
                $this->enrollmentHistoryIBEDModel->save($ehdata);
                return redirect()->to(base_url()."ibed-admission");
            } else {
                $this->ibedStudentsModel->where('studfullname', $studfullname)->set(['studentno' => $studno])->update();
                return redirect()->to(base_url()."ibed-admission");
            }
        }
    }
    public function registeredstudent(){
        $data = [
            'page_title' => 'Holy Cross College | IBED Registered Students',
            'page_heading' => 'IBED REGISTERED STUDENTS!',
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
        ->join('enrollmenthistory_ibed', 'enrollmenthistory_ibed.studfullname = regstudents.studfullname AND enrollmenthistory_ibed.isdel = 0', 'left')
        ->where('enrollmenthistory_ibed.studfullname IS NULL') // Only those NOT in enrollment history
        ->where('regstudents.studstatus', 'GS') // Only SHS students
        ->groupBy('regstudents.studfullname') // Group by student fullname to avoid duplicates
        ->findAll();
        
        $data['paymenttransactionsData'] = $this->paymentTransactionsModel
        ->where('isdel', 0)->findAll();

        return view('ibed/registeredstudentview', $data);
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
        $ibedstuddata = [
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
        $this->ibedStudentsModel->save($ibedstuddata);
        $registeredstudentpr = $this->ibedStudentsModel->where('studfullname', $STUDFULLNAME)->findAll();
        foreach($registeredstudentpr as $rsp){
            $STUDID = $rsp['studid'];
        }
        $ehdata = [
            'studid' => $STUDID,
            'studfullname' => $STUDFULLNAME,
            'date' => date('Y-m-d'),
            'status' => 'Registered',
        ];
        $this->enrollmentHistoryIBEDModel->save($ehdata);
        return redirect()->to(base_url()."ibed-admission");
    }
    public function admission(){
        $data = [
            'page_title' => 'Holy Cross College | IBED Admission',
            'page_heading' => 'IBED ADMISSION!',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $data['enrollmenthistoryibeddata'] = $this->enrollmentHistoryIBEDModel
        ->select('enrollmenthistory_ibed.*, students_ibed.*')
        ->join('students_ibed', 'students_ibed.studid = enrollmenthistory_ibed.studid')
        ->where('enrollmenthistory_ibed.status', 'Registered')->where('enrollmenthistory_ibed.isdel', 0)->findAll();

        return view('ibed/admissionview', $data);
    }
    public function admissionProcess($id=null){
        $data = [
            'page_title' => 'Holy Cross College | IBED Admission Process',
            'page_heading' => 'IBED ADMISSION PROCESS!',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();

        $data['studentsibeddata'] = $this->ibedStudentsModel
        ->where('studid', $id)->findAll();

        $data['schoolyear'] = $this->syModel->where('syisdel', 0)->findAll();
        $data['levelsdata'] = $this->ibedlevelModel->where('isdel', 0)->findAll();

        if($this->request->is('post')){
            // IBED SCHOOL RECORD 
            $gsschoolrecorddata = [
                'studid' => $id,
                'sy' => $this->request->getVar('schoolyear'),
                'level' => $this->request->getVar('level'),
            ];
            $this->ibedSchoolRecordModel->save($gsschoolrecorddata);
            // IBED FAMILY BACKGROUND 
            $gsfbdata = [
                'studid' => $id,
                'nfather' => $this->request->getVar('fname'),
                'fmobile' => $this->request->getVar('fcontact'),
                'fwork' => $this->request->getVar('fwork'),
                'femail' => $this->request->getVar('femail'),
                'foffice' => $this->request->getVar('foffice'),
                'nmother' => $this->request->getVar('mname'),
                'mmobile' => $this->request->getVar('mcontact'),
                'mwork' => $this->request->getVar('mwork'),
                'memail' => $this->request->getVar('memail'),
                'moffice' => $this->request->getVar('moffice'),
            ];
            $this->ibedFamilyBackgroundModel->save($gsfbdata);

            // ADDITIONAL INFO
            $gsaddinfodata = [
                'studid' => $id,
                'fdateofbirth' => $this->request->getVar('fdateofbirth'),
                'fplaceofbirth' => $this->request->getVar('fplaceofbirth'),
                'faddress' => $this->request->getVar('faddress'),
                'feduc' => $this->request->getVar('feduc'),
                'flanguage' => $this->request->getVar('flanguage'),
                'mdateofbirth' => $this->request->getVar('mdateofbirth'),
                'mplaceofbirth' => $this->request->getVar('mplaceofbirth'),
                'maddress' => $this->request->getVar('maddress'),
                'meducation' => $this->request->getVar('meducation'),
                'mlanguage' => $this->request->getVar('mlanguage'),
                'pstatus' => $this->request->getVar('pstatus'),
                'nameg' => $this->request->getVar('nameg'),
                'contactg' => $this->request->getVar('contactg'),
                'gaddress' => $this->request->getVar('gaddress'),
                'contactperson' => $this->request->getVar('contactperson'),
                'personcontactno' => $this->request->getVar('personcontactno'),
                'siblingname' => $this->request->getVar('siblingname'),
                'siblingwork' => $this->request->getVar('siblingwork'),
                'siblingage' => $this->request->getVar('siblingage'),
                'interest' => $this->request->getVar('interest'),
                'talents' => $this->request->getVar('talents'),
                'hobbies' => $this->request->getVar('hobbies'),
                'goals' => $this->request->getVar('goals'),
                'characteristics' => $this->request->getVar('characteristics'),
                'fears' => $this->request->getVar('fears'),
                'disabilities' => $this->request->getVar('disabilities'),
                'chronic_illnesses' => $this->request->getVar('chronic_illnesses'),
                'medicine' => $this->request->getVar('medicine'),
                'vitamins' => $this->request->getVar('vitamins'),
                'recent_accidents' => $this->request->getVar('recent_accidents'),
                'experience_accidents' => $this->request->getVar('experience_accidents'),
                'recent_surgical' => $this->request->getVar('recent_surgical'),
                'experience_surgical' => $this->request->getVar('experience_surgical'),
                'vaccines' => $this->request->getVar('vaccines'),
                'con_psy' => $this->request->getVar('con_psy'),
                'con_psy_date' => $this->request->getVar('con_psy_date'),
                'con_psy_sessions' => $this->request->getVar('con_psy_sessions'),
                'con_psy_diagnosis' => $this->request->getVar('con_psy_diagnosis'),
                'con_regpsy' => $this->request->getVar('con_regpsy'),
                'con_regpsy_date' => $this->request->getVar('con_regpsy_date'),
                'con_regpsy_sessions' => $this->request->getVar('con_regpsy_sessions'),
                'con_regpsy_diagnosis' => $this->request->getVar('con_regpsy_diagnosis'),
                'con_regguid' => $this->request->getVar('con_regguid'),
                'con_regguid_date' => $this->request->getVar('con_regguid_date'),
                'con_regguid_sessions' => $this->request->getVar('con_regguid_sessions'),
                'con_regguid_diagnosis' => $this->request->getVar('con_regguid_diagnosis'),
                'aisdel' => 0,
            ];
            $this->additionalInfoIBEDModel->save($gsaddinfodata);
            // ENROLLMENT TEMP DATA UPDATE
            $EHGSInfo = $this->enrollmentHistoryIBEDModel->where('studid', $id)->findAll();
            foreach($EHGSInfo as $ehshs) {
                $EHGSID = $ehshs['ehid'];
            }
            $ehgsdata = [
                'sy' => $this->request->getVar('schoolyear'),
                'level' => $this->request->getVar('level'),
                'cluster' => $this->request->getVar('cluster'),
                'status' => 'Admitted',
            ];
            $this->enrollmentHistoryIBEDModel->where('ehid', $EHGSID)->update($EHGSID, $ehgsdata);
            session()->setTempdata('success', 'Admission processed successfully!', 2);
            return redirect()->to(base_url()."ibed-admission");
        }

        return view('ibed/admissionviewprocess', $data);
    }
    public function admissionProcessCancel($id=null) {
        $ehdata = [
            'isdel' => '1',
            'status' => 'Cancelled',
        ];
        $gsstuddata = [
            'studisdel' => '1',
        ];

        $this->enrollmentHistoryIBEDModel->where('ehid', $id)->update($id, $ehdata);
        $this->ibedStudentsModel->where('studid', $id)->update($id, $gsstuddata);
        session()->setTempdata('deletesuccess', 'Application is deleted!', 2);
        return redirect()->to(base_url()."ibed-admission");
    }
    public function admissionProcessGenerate($id=null) {
        $year = date('y');
        // print_r($year);
        $laststudentno = $this->ibedStudentsModel
        ->like('studentno', $year . 'IBED', 'after')
        ->orderBy('studentno', 'DESC')
        ->get()
        ->getFirstRow();

        if ($laststudentno) {
            $lastNumber = (int)substr($laststudentno->studentno, 3);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = '1';
        }

        $studentNumber = $year . 'IBED' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
        // print_r($studentNumber);
        $data = [
            'studentno' => $studentNumber,
        ];
        $this->ibedStudentsModel->where('studid', $id)->update($id, $data);
        return redirect()->to(base_url()."ibed-admission/process/".$id);
    }
    public function advising() {
        $data = [
            'page_title' => 'Holy Cross College | IBED Advising',
            'page_heading' => 'IBED ADVISING!',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $data['enrollmenthistoryibeddata'] = $this->enrollmentHistoryIBEDModel
        ->select('enrollmenthistory_ibed.*, students_ibed.*, levels_ibed.*')
        ->join('students_ibed', 'students_ibed.studid = enrollmenthistory_ibed.studid')
        ->join('levels_ibed', 'levels_ibed.levelid = enrollmenthistory_ibed.level')
        ->where('enrollmenthistory_ibed.status', 'Admitted')->where('enrollmenthistory_ibed.isdel', 0)->findAll();

        return view('ibed/advisingview', $data);
    }
    public function advisingProcess($id=null) {
        $data = [
            'page_title' => 'Holy Cross College | IBED Advising',
            'page_heading' => 'IBED ADVISING!',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();

        $data['enrollmenthistoryibeddata'] = $this->enrollmentHistoryIBEDModel
        ->select('enrollmenthistory_ibed.*, students_ibed.*, levels_ibed.*')
        ->join('students_ibed', 'students_ibed.studid = enrollmenthistory_ibed.studid')
        ->join('levels_ibed', 'levels_ibed.levelid = enrollmenthistory_ibed.level')
        ->where('students_ibed.studid', $id)->findAll();
        foreach($data['enrollmenthistoryibeddata'] as $ehs) {
            $LEVEL = $ehs['level'];
            $SY = $ehs['sy'];
            $STUDID = $ehs['studid'];
        }

        $data['ibedcurriculumdata'] = $this->ibedcurriculumModel
        ->select('curriculum_ibed.*, levels_ibed.*')
        ->join('levels_ibed', 'levels_ibed.levelid = curriculum_ibed.level')
        ->where('curriculum_ibed.level', $LEVEL)
        ->where('curriculum_ibed.sy', $SY)
        ->findAll();

        $data['ibedsectiondata'] = $this->ibedSectionsModel
        ->select('sections_ibed.*, levels_ibed.*')
        ->join('levels_ibed', 'levels_ibed.levelid = sections_ibed.level')
        ->where('sections_ibed.level', $LEVEL)
        ->where('sections_ibed.sy', $SY)
        ->findAll();

        if($this->request->is('post')) {
            $SELECTEDCURRICULUM = $this->request->getVar('curriculum');
            $SELECTEDSECTION = $this->request->getVar('section');
            $ADVISINGCHECK = $this->ibedAssessmentModel
            ->where('studid', $STUDID)
            ->where('sy', $SY)
            ->where('level', $LEVEL)
            ->findAll();
            // print_r($ADVISINGCHECK);
            if(!empty($ADVISINGCHECK)) {
                session()->setTempdata('error', 'Student is already assessed!', 2);
                return redirect()->to(current_url());
            }else{
                $ibedassessmentdata = [
                    'studid' => $STUDID,
                    'sy' => $SY,
                    'level' => $LEVEL,
                    'curriculum' => $SELECTEDCURRICULUM,
                    'section' => $SELECTEDSECTION,
                    'date' => date('Y-m-d'),
                ];
                // print_r($shsassessmentdata);
                $this->ibedAssessmentModel->save($ibedassessmentdata);
                session()->setTempdata('success', 'Student is processed successfully!', 2);
                return redirect()->to(current_url());
            }
        }
        $data['ibedassessmentdata'] = $this->ibedAssessmentModel
        ->select('assessment_ibed.*, curriculum_ibed.*, sections_ibed.*, students_ibed.*, levels_ibed.*')
        ->join('curriculum_ibed', 'curriculum_ibed.currid = assessment_ibed.curriculum')
        ->join('sections_ibed', 'sections_ibed.secid = assessment_ibed.section')
        ->join('students_ibed', 'students_ibed.studid = assessment_ibed.studid')
        ->join('levels_ibed', 'levels_ibed.levelid = assessment_ibed.level')
        ->where('assessment_ibed.studid', $STUDID)
        ->where('assessment_ibed.sy', $SY)
        ->where('assessment_ibed.level', $LEVEL)
        ->findAll();

        // SHS ASSESSED CURRICULUM DATA
        $data['firstsemester'] = $this->ibedAssessmentModel
        ->select('assessment_ibed.*, curriculum_ibed.*, currdata_ibed.*, subjects_ibed.*')
        ->join('curriculum_ibed', 'curriculum_ibed.currid = assessment_ibed.curriculum', 'left')
        ->join('currdata_ibed', 'currdata_ibed.curriculumid = curriculum_ibed.currid', 'left')
        ->join('subjects_ibed', 'subjects_ibed.subid = currdata_ibed.subid', 'left')
        ->where('assessment_ibed.studid', $STUDID)
        ->where('assessment_ibed.sy', $SY)
        ->where('assessment_ibed.level', $LEVEL)
        ->findAll();

        // ASSESSED RATE DATA
        $data['ibedratedata'] = $this->ibedRa
        ->where('rates_ibed.level', $LEVEL)
        ->where('rates_ibed.sy', $SY)
        ->findAll();
        foreach($data['ibedratedata'] as $rates){
            $RATEID = $rates['rateid'];
        }

        $data['ibedrofdata'] = $this->ibedRateOtherFeesModel->where('rateid', $RATEID)->findAll();
        $data['ibedrddata'] = $this->ibedRateDuesModel->where('rateid', $RATEID)->findAll();

        return view('ibed/advisingviewprocess', $data);
    }
    public function advisingSubmitAccount($id=null) {
        $ASSESSMENTDATACHECKING = $this->ibedAssessmentModel
        ->select('assessment_ibed.*, students_ibed.*, levels_ibed.*')
        ->join('students_ibed', 'students_ibed.studid = assessment_ibed.studid')
        ->join('levels_ibed', 'levels_ibed.levelid = assessment_ibed.level')
        ->where('assessment_ibed.studid', $id)
        ->findAll();
        foreach($ASSESSMENTDATACHECKING as $adc) {
            $STUDENTNO = $adc['studentno'];
            $ASSESSMENTID = $adc['assid'];
            $SY = $adc['sy'];
            $LEVEL = $adc['level'];
            $LEVELNAME = $adc['name'];
        }

        $studentsaccounts = [
            'studentno' => $STUDENTNO,
            'assessmentid' => $ASSESSMENTID,
            'sy' => $SY,
            'level' => $LEVELNAME,
            'accountstatus' => 'Active',
            'createddate' => date('Y-m-d'),
        ];
        $FINDEHGS = $this->enrollmentHistoryIBEDModel
        ->where('studid', $id)
        ->where('sy', $SY)
        ->where('level', $LEVEL)
        ->findAll();
        foreach($FINDEHGS as $findehgs){
            $STUDENTID = $findehgs['studid'];
        }

        $ehgsdata = [
            'status' => 'Assessed',
        ];
        
        $gsassessment = [
            'status' => 'Finalized',
        ];

        $this->ibedAssessmentModel->where('assid', $ASSESSMENTID)->update($ASSESSMENTID, $gsassessment);
        $this->studentAccountsModel->save($studentsaccounts);
        // $this->enrollmentHistoryIBEDModel->where('studid', $STUDENTID)->update($STUDENTID, $ehgsdata);
        $this->enrollmentHistoryIBEDModel->where('studid', $STUDENTID)->set(['status' => 'Assessed'])->update();
        session()->setTempdata('success', 'Student is assessed successfully!', 2);
        return redirect()->to(base_url()."ibed-advising");
    }
    public function assessment() {
        $data = [
            'page_title' => 'Holy Cross College | IBED Assessment',
            'page_heading' => 'IBED ASSESSMENT!',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $data['enrollmenthistoryibeddata'] = $this->enrollmentHistoryIBEDModel
        ->select('enrollmenthistory_ibed.*, students_ibed.*, levels_ibed.*')
        ->join('students_ibed', 'students_ibed.studid = enrollmenthistory_ibed.studid')
        ->join('levels_ibed', 'levels_ibed.levelid = enrollmenthistory_ibed.level')
        ->where('enrollmenthistory_ibed.status', 'Assessed')->where('enrollmenthistory_ibed.isdel', 0)->findAll();

        return view('ibed/assessmentview', $data);
    }
    public function assessmentView($id=null) {
        $data = [
            'page_title' => 'Holy Cross College | IBED Assessment View',
            'page_heading' => 'IBED ASSESSMENT VIEW!',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $data['enrollmenthistoryibeddata'] = $this->enrollmentHistoryIBEDModel
        ->select('enrollmenthistory_ibed.*, students_ibed.*, levels_ibed.*')
        ->join('students_ibed', 'students_ibed.studid = enrollmenthistory_ibed.studid')
        ->join('levels_ibed', 'levels_ibed.levelid = enrollmenthistory_ibed.level')
        ->where('students_ibed.studid', $id)->findAll();
        foreach($data['enrollmenthistoryibeddata'] as $ehs) {
            $LEVEL = $ehs['level'];
            $SY = $ehs['sy'];
            $STUDID = $ehs['studid'];
        }
        $data['ibedassessmentdata'] = $this->ibedAssessmentModel
        ->select('assessment_ibed.*, curriculum_ibed.*, sections_ibed.*, students_ibed.*, levels_ibed.*')
        ->join('curriculum_ibed', 'curriculum_ibed.currid = assessment_ibed.curriculum')
        ->join('sections_ibed', 'sections_ibed.secid = assessment_ibed.section')
        ->join('students_ibed', 'students_ibed.studid = assessment_ibed.studid')
        ->join('levels_ibed', 'levels_ibed.levelid = assessment_ibed.level')
        ->where('assessment_ibed.studid', $STUDID)
        ->where('assessment_ibed.sy', $SY)
        ->where('assessment_ibed.level', $LEVEL)
        ->findAll();
        // ASSESSED CURRICULUM DATA
        $data['firstsemester'] = $this->ibedAssessmentModel
        ->select('assessment_ibed.*, curriculum_ibed.*, currdata_ibed.*, subjects_ibed.*')
        ->join('curriculum_ibed', 'curriculum_ibed.currid = assessment_ibed.curriculum', 'left')
        ->join('currdata_ibed', 'currdata_ibed.curriculumid = curriculum_ibed.currid', 'left')
        ->join('subjects_ibed', 'subjects_ibed.subid = currdata_ibed.subid', 'left')
        ->where('assessment_ibed.studid', $STUDID)
        ->where('assessment_ibed.sy', $SY)
        ->where('assessment_ibed.level', $LEVEL)
        ->findAll();

        // ASSESSED RATE DATA
        $data['ibedratedata'] = $this->ibedRatesModel
        ->where('rates_ibed.level', $LEVEL)
        ->where('rates_ibed.sy', $SY)
        ->findAll();
        foreach($data['ibedratedata'] as $rates){
            $RATEID = $rates['rateid'];
        }

        $data['ibedrofdata'] = $this->ibedRateOtherFeesModel->where('rateid', $RATEID)->findAll();
        $data['ibedrddata'] = $this->ibedRateDuesModel->where('rateid', $RATEID)->findAll();
        
        return view('ibed/assessmentviewing', $data);
    }
    public function assessmentPrint($id=null) {
        $pageSize = array(216, 330);
        $pdf = new TCPDF('P', 'mm', $pageSize, true, 'UTF-8', false);
        // Load TCPDF library
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $pdf->SetCreator('Holy Cross College');
        $pdf->SetAuthor('TRS Department');
        $pdf->SetTitle('Assessment of Fees');

        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        $pdf->SetMargins(5,40,5,0);
        $pdf->SetHeaderMargin(0);
        

        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
        }
        $pdf->SetFont('dejavusans', '', 10);
        $pdf->AddPage();

        $imagePath = FCPATH .'public/uploads/hccheader3.png';
        $pdf->Image($imagePath, $x = 5, $y = 0, $w = 201, $h = 36); 
        $pdf->Line(5, 37, 206, 37);

        $enrollmenthistoryibeddata = $this->enrollmentHistoryIBEDModel
        ->select('enrollmenthistory_ibed.*, students_ibed.*, levels_ibed.*')
        ->join('students_ibed', 'students_ibed.studid = enrollmenthistory_ibed.studid')
        ->join('levels_ibed', 'levels_ibed.levelid = enrollmenthistory_ibed.level')
        ->where('students_ibed.studid', $id)->findAll();
        foreach($enrollmenthistoryibeddata as $ehs) {
            $LEVEL = $ehs['level'];
            $SY = $ehs['sy'];
            $STUDID = $ehs['studid'];
            $CLUSTER = $ehs['code'];
        }
        $ibedassessmentdata = $this->ibedAssessmentModel
        ->select('assessment_ibed.*, curriculum_ibed.*, sections_ibed.*, students_ibed.*, levels_ibed.*')
        ->join('curriculum_ibed', 'curriculum_ibed.currid = assessment_ibed.curriculum')
        ->join('sections_ibed', 'sections_ibed.secid = assessment_ibed.section')
        ->join('students_ibed', 'students_ibed.studid = assessment_ibed.studid')
        ->join('levels_ibed', 'levels_ibed.levelid = assessment_ibed.level')
        ->where('assessment_ibed.studid', $STUDID)
        ->where('assessment_ibed.sy', $SY)
        ->where('assessment_ibed.level', $LEVEL)
        ->findAll();
        foreach($ibedassessmentdata as $sad) {
            $STUDENTNO = $sad['studentno'];
            $SY = $sad['sy'];
            $STUDFULLNAME = $sad['studfullname'];
            $LEVEL = $sad['level'];
            $LEVELNAME = $sad['name'];
            $BARANGAY = $sad['studstbarangay'];
            $MUNICIPALITY = $sad['studcity'];
            $PROVINCE = $sad['studprovince'];
            $ADDRESS = $BARANGAY .' '. $MUNICIPALITY .', '. $PROVINCE;
            $SECTION = $sad['section'];
        }
        
        // ASSESSED CURRICULUM DATA
        $firstsemester = $this->ibedAssessmentModel
        ->select('assessment_ibed.*, curriculum_ibed.*, currdata_ibed.*, subjects_ibed.*')
        ->join('curriculum_ibed', 'curriculum_ibed.currid = assessment_ibed.curriculum', 'left')
        ->join('currdata_ibed', 'currdata_ibed.curriculumid = curriculum_ibed.currid', 'left')
        ->join('subjects_ibed', 'subjects_ibed.subid = currdata_ibed.subid', 'left')
        ->where('assessment_ibed.studid', $STUDID)
        ->where('assessment_ibed.sy', $SY)
        ->where('assessment_ibed.level', $LEVEL)
        ->findAll();

        // ASSESSED RATE DATA
        $ibedratedata = $this->ibedRatesModel
        ->where('rates_ibed.level', $LEVEL)
        ->where('rates_ibed.sy', $SY)
        ->findAll();
        foreach($ibedratedata as $rates){
            $RATEID = $rates['rateid'];
        }

        $ibedrofdata = $this->ibedRateOtherFeesModel->where('rateid', $RATEID)->findAll();
        $ibedrddata = $this->ibedRateDuesModel->where('rateid', $RATEID)->findAll();

        $html = '
            <style>        
                    .evaluation {
                    border: 1px solid black;
                }
                table td{
                    font-size: 12px;
                    font-family: Verdana, Geneva, Tahoma, sans-serif;
                }
                .misctbl{
                    display: inline-block;
                }
            </style>

            <table>
                <tr>
                    <td style="width: 80%;"></td>
                    <td><h3>IBED DEPARTMENT</h3></td>
                </tr>   
            </table><br><br>

            <table>
                <tr>
                    <td style="background-color: #b5b5b5; font-size: 25px; font-weight: bold; text-align: center;">ASSESSMENT OF FEES</td>
                </tr>
            </table><br><br>

            <table>
                <tr>
                    <td style="width: 65%;">STUDENT No.: <strong>'. $STUDENTNO .' </strong></td>
                    <td>SCHOOL YEAR: <strong>'. $SY .'</strong></td>
                </tr>
                <tr>
                    <td>STUDENT: <strong>'. strtoupper($STUDFULLNAME) .'</strong></td>
                    <td>LEVEL: <strong>'. $LEVELNAME .'</strong></td>
                </tr>
                <tr>
                    <td>ADDRESS: <strong>'. strtoupper($ADDRESS) .'</strong></td>
                    <td>SECTION: <strong>'. $SECTION .'</strong></td>
                </tr>
            </table><br><br>

            <table border="1" style="width: 100%; font-size: 11px;">
                <tr>
                    <td style="text-align: center;"><strong>SUBJECTS</strong></td>
                </tr>
                <thead>
                    <tr>
                        <th style="width: 20%;text-align: center;"><strong>CODE</strong></th>
                        <th style="width: 80%;text-align: center;"><strong>SUBJECT</strong></th>
                    </tr>
                </thead>
                <tbody>
        ';
        foreach($firstsemester as $fs){
            $CODE = $fs['code'];
            $SUBJECT = $fs['subject'];
            $html .= '<tr>
                    <td style="width: 20%; text-align: center; font-size: 11px;">'.$CODE.' </td>
                    <td style="width: 80%; text-align: left; font-size: 11px;">'.$SUBJECT.'</td>
                </tr>';
        }
        $html .='
                </tbody>
            </table>
        ';
        foreach($ibedratedata as $gsrated){
            $TF = $gsrated['tf'];
        }
        $html .='
            <table style="width: 100%;">
                <tbody>
                    <tr>
                        <td style="width: 50%;">
                            <table>
                                <tbody>
                                <br><br>
                                    <tr>
                                        <td style="width: 100%; text-align: left; font-size: 10px;"><strong>FEES:</strong></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 100%; text-align: left; font-size: 10px;">Tuition Fee</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 5%;"></td>
                                        <td style="width: 45%; text-align: left; font-size: 10px;">Tuition</td>
                                        <td style="width: 45%; text-align: right; font-size: 10px;"><strong>'.number_format($TF, 2).'</strong></td>
                                        <td style="width: 5%;"></td>
                                    </tr>
                                </tbody>
                            </table>
                            <table style="width: 100%;">
                                <tbody>
                                    <tr>
                                        <td style="width: 50%; text-align: left; font-size: 10px;">Miscellaneous Fees</td>
                                    </tr>';
                                    foreach($ibedrofdata as $gsrofd){
                                        if($gsrofd['rateid'] == $gsrated['rateid']){
                                            $NAME = $gsrofd['name'];
                                            $AMOUNT = $gsrofd['otherfees'];
                                            $totalotherfees = 0;
                                            foreach($ibedrofdata as $gsrofd) {
                                                if($gsrofd['rateid'] == $gsrated['rateid']) {
                                                    $totalotherfees += $gsrofd['otherfees'];
                                                }
                                            }
                                            $GRANDTOTAL = $TF + $totalotherfees;
                                            $html .= '<tr>
                                                <td style="width: 5%;"></td>
                                                <td style="width: 45%; text-align: left; font-size: 10px;">'.$NAME.'</td>
                                                <td style="width: 45%; text-align: right; font-size: 10px;"><strong>'.number_format($AMOUNT, 2).'</strong></td>
                                                <td style="width: 5%;"></td>
                                            </tr>';
                                        }
                                    }
                            $html .='<tr>
                                        <td style="width: 5%;"></td>
                                        <td style="width: 45%; text-align: right; font-size: 10px;">Sub Total</td>
                                        <td style="width: 15%; text-align: right; font-size: 10px;"></td>
                                        <td style="width: 30%; text-align: right; font-size: 10px; border-top: 1px solid #000; border-bottom: 1px solid #000;"><strong>'.number_format($totalotherfees, 2).'</strong></td>
                                    </tr>
                                    <tr>
                                    <br>
                                        <td style="width: 5%;"></td>
                                        <td style="width: 45%; text-align: right; font-size: 10px;">Grand Total</td>
                                        <td style="width: 15%; text-align: right; font-size: 10px;"></td>
                                        <td style="width: 30%; text-align: right; font-size: 10px; border-top: 1px solid #000; border-bottom: 1px solid #000;"><strong>'.number_format($GRANDTOTAL, 2).'</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                        <td style="width: 50%;">
                            <table>
                                <tbody>
                                <br><br>
                                    <tr>
                                        <td style="width: 100%; text-align: left; font-size: 10px;"><strong>INSTALLMENT SCHEDULE:</strong></td>
                                    </tr>';
                                    foreach($ibedrddata as $gsrdd){
                                        if($gsrdd['rateid'] == $gsrated['rateid']){
                                            $DNAME = $gsrdd['name'];
                                            $DDATE = $gsrdd['due'];

                                            $html .='<tr>
                                                <td style="width: 5%;"></td>
                                                <td style="width: 45%; text-align: left; font-size: 10px;">'.$DNAME.'</td>
                                                <td style="width: 45%; text-align: left; font-size: 10px;"><strong>'.date("F j, Y", strtotime($DDATE)).'</strong></td>
                                                <td style="width: 5%;"></td>
                                            </tr>';
                                        }
                                    }
                            $html .='</tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>';
            $html .= '<table style="width: 100%;">
                <tr>
                    <td style="width: 50%; vertical-align: top;">
                        <table style="width: 100%;">
                            <tbody>
                            <br><br><br>
                                <tr>
                                    <td style="width: 70%; text-align: left; border-bottom: 1px solid black"></td>
                                </tr>
                                <tr>
                                    <td style="width: 70%; text-align: left;"><p style="font-size: 10px;">SIGNATURE OVER STUDENTS PRINTED NAME</p></td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                    <td style="width: 50%; vertical-align: top;">
                        <table  style="width: 100%;">
                            <tbody>
                            <br><br><br>
                                <tr>
                                    <td style="width: 30%; text-align: center;"></td>
                                    <td style="width: 70%; text-align: center; border-bottom: 1px solid black"></td>
                                </tr>
                                <tr>
                                    <td style="width: 30%; text-align: center;"></td>
                                    <td style="width: 70%; text-align: center;"><p style="font-size: 12px;">REGISTRAR</p></td>
                                </tr>
                            </tbody>
                        </table>
                        <table  style="width: 100%;">
                            <tbody>
                            <br><br><br>
                                <tr>
                                    <td style="width: 30%; text-align: center;"></td>
                                    <td style="width: 70%; text-align: center; border-bottom: 1px solid black"></td>
                                </tr>
                                <tr>
                                    <td style="width: 30%; text-align: center;"></td>
                                    <td style="width: 70%; text-align: center;"><p style="font-size: 12px;">CASHIER</p></td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </table>';
        
        $html .='
            <table>
                <tbody>
                    <tr>
                    <br><br>
                        <td style="text-align: center;">
                            <p style="font-size: 9px;">THIS IS NOT OFFICIAL UNLESS SIGNED BY THE REGISTRAR</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        ';


        $pdf->writeHTML($html, true, false, false, false, '');
        $filename = strtoupper($STUDFULLNAME).'.pdf';
        $pdfContent = $pdf->Output($filename, 'S');
        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setHeader('Content-Disposition', 'inline; filename="' . $filename . '"')
            ->setBody($pdfContent);
    }
    public function assessmentApproved($id=null) {
        $ehgsdata = [
            'status' => 'Payment',
        ];
        $this->enrollmentHistoryIBEDModel->where('ehid', $id)->update($id, $ehgsdata);
        session()->setTempdata('success', 'Student is approved!', 2);
        return redirect()->to(base_url()."ibed-assessment");
    }
}