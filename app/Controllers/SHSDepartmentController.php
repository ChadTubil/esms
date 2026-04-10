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
use App\Models\SHSSchoolRecordModel;
use App\Models\SHSFamilyBackgroundModel;
use App\Models\SHSSectionsModel;
use App\Models\SHSAssessmentModel;
use App\Models\SHSRatesModel;
use App\Models\SHSRateOtherFeesModel;
use App\Models\SHSRateDuesModel;
use App\Models\StudentAccountsModel;
use App\Models\AdditionalInfoSHSModel;
use TCPDF;
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
    public $shsSchoolRecordModel;
    public $shsFamilyBackgroundModel;
    public $shsSectionsModel;
    public $shsAssessmentModel;
    public $shsRatesModel;
    public $shsRateOtherFeesModel;
    public $shsRateDuesModel;
    public $studentAccountsModel;
    public $additionalInfoSHSModel;
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
        $this->shsSchoolRecordModel = new SHSSchoolRecordModel();
        $this->shsFamilyBackgroundModel = new SHSFamilyBackgroundModel();
        $this->shsSectionsModel = new SHSSectionsModel();
        $this->shsAssessmentModel = new SHSAssessmentModel();
        $this->shsRatesModel = new SHSRatesModel();
        $this->shsRateOtherFeesModel = new SHSRateOtherFeesModel();
        $this->shsRateDuesModel = new SHSRateDuesModel();
        $this->studentAccountsModel = new StudentAccountsModel();
        $this->additionalInfoSHSModel = new AdditionalInfoSHSModel();
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
                    'name' => $this->request->getVar('cluster'),
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
                'name' => $this->request->getVar('cluster'),
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
        $data['shscurriculumdata'] = $this->shsCurriculumModel
        ->select('curriculum_shs.*, clusters.*')
        ->join('clusters', 'clusters.cluid = curriculum_shs.cluster')
        ->where('curriculum_shs.isdel', '0')->findAll();
        

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
        $data['shscurriculumdata'] = $this->shsCurriculumModel
        ->select('curriculum_shs.*, clusters.*')
        ->join('clusters', 'clusters.cluid = curriculum_shs.cluster')
        ->where('currid', $id)->findAll();
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
    public function sections() {
        $data = [
            'page_title' => 'Holy Cross College | SHS Sections Setup',
            'page_heading' => 'SHS SECTIONS SETUP! ',
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
        $data['sectiondata'] = $this->shsSectionsModel
        ->select('sections_shs.*, clusters.*')
        ->join('clusters', 'clusters.cluid = sections_shs.cluster')
        ->where('sections_shs.isdel', '0')->findAll();

        if($this->request->is('post')) {
            $rules = [
                'section' => [
                    'rules' => 'required|is_unique[sections_shs.section]',
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
                'cluster' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Cluster is required.',
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
                    'cluster' => $this->request->getVar('cluster'),
                ];
                $this->shsSectionsModel->save($sectiondata);
                session()->setTempdata('success', 'Section is added successfully', 3);
                return redirect()->to(current_url());
            } else {
                $data['validation'] = $this->validator;
            }
        }

        return view('shs/sectionsview', $data);
    }
    public function deletesections($id=null) {
        $data = [
            'isdel' => '1',
        ];

        $this->shsSectionsModel->where('secid', $id)->update($id, $data);
        session()->setTempdata('success', 'Section is deleted!', 2);
        return redirect()->to(base_url()."shs-sections");
    }
    public function updatesections($id=null) {
        if($this->request->is('post')) {
            $sectiondata = [
                'section' => $this->request->getVar('section'),
                'sy' => $this->request->getVar('sy'),
                'level' => $this->request->getVar('level'),
                'cluster' => $this->request->getVar('cluster'),
            ];

            $this->shsSectionsModel->where('secid', $id)->update($id, $sectiondata);
            session()->setTempdata('updatesuccess', 'Update Successful!', 2);
            return redirect()->to(base_url()."shs-sections");
        }
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
    public function oldstudent(){
        
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
        ->join('enrollmenthistory_shs', 'enrollmenthistory_shs.studfullname = regstudents.studfullname AND enrollmenthistory_shs.isdel = 0', 'left')
        ->where('enrollmenthistory_shs.studfullname IS NULL') // Only those NOT in enrollment history
        ->groupBy('regstudents.studfullname') // Group by student fullname to avoid duplicates
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
        $this->shsPermanentRecordModel->where('studfullname', $STUDFULLNAME)->set(['studid' => $STUDID])->update();
        $ehdata = [
            'studid' => $STUDID,
            'studfullname' => $STUDFULLNAME,
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
        $data['enrollmenthistoryshsdata'] = $this->enrollmentHistorySHSModel
        ->select('enrollmenthistory_shs.*, students_shs.*')
        ->join('students_shs', 'students_shs.studid = enrollmenthistory_shs.studid')
        ->where('enrollmenthistory_shs.status', 'Registered')->where('enrollmenthistory_shs.isdel', 0)->findAll();

        return view('shs/admissionview', $data);
    }
    public function admissionProcess($id=null){
        $data = [
            'page_title' => 'Holy Cross College | SHS Admission Process',
            'page_heading' => 'SHS ADMISSION PROCESS!',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();

        $data['studentsshsdata'] = $this->shsStudentsModel
        ->select('students_shs.*, permanentrecord_shs.*')
        ->join('permanentrecord_shs', 'permanentrecord_shs.studid = students_shs.studid', 'left')
        ->where('students_shs.studid', $id)->findAll();

        $data['schoolyear'] = $this->syModel->where('syisdel', 0)->findAll();
        $data['clusterdata'] = $this->clustersModel->where('isdel', 0)->findAll();

        if($this->request->is('post')){
            // SHS SCHOOL RECORD 
            $shsschoolrecorddata = [
                'studid' => $id,
                'sy' => $this->request->getVar('schoolyear'),
                'level' => $this->request->getVar('level'),
                'cluster' => $this->request->getVar('cluster'),
            ];
            $this->shsSchoolRecordModel->save($shsschoolrecorddata);
            // SHS FAMILY BACKGROUND 
            $shsfbdata = [
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
            $this->shsFamilyBackgroundModel->save($shsfbdata);

            // ADDITIONAL INFO
            $shsaddinfodata = [
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
            $this->additionalInfoSHSModel->save($shsaddinfodata);

            // PERMANENT RECORD 
            $PRSHSInfo = $this->shsPermanentRecordModel->where('studid', $id)->findAll();
            foreach($PRSHSInfo as $prshs) {
                $PRSHSID = $prshs['prid'];
            }
            $shsprdata = [
                'eschool' => $this->request->getVar('eschool'),
                'eyeargraduate' => $this->request->getVar('eyeargraduate'),
                'jhschool' => $this->request->getVar('jhschool'),
                'jhyeargraduate' => $this->request->getVar('jhyeargraduate'),
            ];
            $this->shsPermanentRecordModel->where('prid', $PRSHSID)->update($PRSHSID, $shsprdata);
            // ENROLLMENT TEMP DATA UPDATE
            $EHSHSInfo = $this->enrollmentHistorySHSModel->where('studid', $id)->findAll();
            foreach($EHSHSInfo as $ehshs) {
                $EHSHSID = $ehshs['ehid'];
            }
            $ehshsdata = [
                'sy' => $this->request->getVar('schoolyear'),
                'level' => $this->request->getVar('level'),
                'cluster' => $this->request->getVar('cluster'),
                'status' => 'Admitted',
            ];
            $this->enrollmentHistorySHSModel->where('ehid', $EHSHSID)->update($EHSHSID, $ehshsdata);
            session()->setTempdata('success', 'Admission processed successfully!', 2);
            return redirect()->to(base_url()."shs-admission");
        }

        return view('shs/admissionviewprocess', $data);
    }
    public function admissionProcessCancel($id=null) {
        $ehdata = [
            'isdel' => '1',
            'status' => 'Cancelled',
        ];
        $shsstuddata = [
            'studisdel' => '1',
        ];

        $this->enrollmentHistorySHSModel->where('ehid', $id)->update($id, $ehdata);
        $this->shsStudentsModel->where('studid', $id)->update($id, $shsstuddata);
        session()->setTempdata('deletesuccess', 'Application is deleted!', 2);
        return redirect()->to(base_url()."shs-admission");
    }
    public function admissionProcessGenerate($id=null) {
        $year = date('y');
        // print_r($year);
        $laststudentno = $this->shsStudentsModel
        ->like('studentno', $year . 'S', 'after')
        ->orderBy('studentno', 'DESC')
        ->get()
        ->getFirstRow();

        if ($laststudentno) {
            $lastNumber = (int)substr($laststudentno->studentno, 3);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = '1';
        }

        $studentNumber = $year . 'S' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
        // print_r($studentNumber);
        $data = [
            'studentno' => $studentNumber,
        ];
        $this->shsStudentsModel->where('studid', $id)->update($id, $data);
        return redirect()->to(base_url()."shs-admission/process/".$id);
    }
    public function advising() {
        $data = [
            'page_title' => 'Holy Cross College | SHS Advising',
            'page_heading' => 'SHS ADVISING!',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $data['enrollmenthistoryshsdata'] = $this->enrollmentHistorySHSModel
        ->select('enrollmenthistory_shs.*, students_shs.*, clusters.*')
        ->join('students_shs', 'students_shs.studid = enrollmenthistory_shs.studid')
        ->join('clusters', 'clusters.cluid = enrollmenthistory_shs.cluster')
        ->where('enrollmenthistory_shs.status', 'Admitted')->where('enrollmenthistory_shs.isdel', 0)->findAll();

        return view('shs/advisingview', $data);
    }
    public function advisingProcess($id=null) {
        $data = [
            'page_title' => 'Holy Cross College | SHS Advising',
            'page_heading' => 'SHS ADVISING!',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $data['enrollmenthistoryshsdata'] = $this->enrollmentHistorySHSModel
        ->select('enrollmenthistory_shs.*, students_shs.*, clusters.*')
        ->join('students_shs', 'students_shs.studid = enrollmenthistory_shs.studid')
        ->join('clusters', 'clusters.cluid = enrollmenthistory_shs.cluster')
        ->where('students_shs.studid', $id)->findAll();
        foreach($data['enrollmenthistoryshsdata'] as $ehs) {
            $CLUSTERID = $ehs['cluid'];
            $LEVEL = $ehs['level'];
            $SY = $ehs['sy'];
            $STUDID = $ehs['studid'];
        }

        $data['shscurriculumdata'] = $this->shsCurriculumModel
        ->select('curriculum_shs.*, clusters.*')
        ->join('clusters', 'clusters.cluid = curriculum_shs.cluster')
        ->where('curriculum_shs.cluster', $CLUSTERID)
        ->where('curriculum_shs.level', $LEVEL)
        ->where('curriculum_shs.sy', $SY)
        ->findAll();

        $data['shssectiondata'] = $this->shsSectionsModel
        ->select('sections_shs.*, clusters.*')
        ->join('clusters', 'clusters.cluid = sections_shs.cluster')
        ->where('sections_shs.cluster', $CLUSTERID)
        ->where('sections_shs.level', $LEVEL)
        ->where('sections_shs.sy', $SY)
        ->findAll();

        if($this->request->is('post')) {
            $SELECTEDCURRICULUM = $this->request->getVar('curriculum');
            $SELECTEDSECTION = $this->request->getVar('section');
            $ADVISINGCHECK = $this->shsAssessmentModel
            ->where('studid', $STUDID)
            ->where('sy', $SY)
            ->where('level', $LEVEL)
            ->findAll();
            // print_r($ADVISINGCHECK);
            if(!empty($ADVISINGCHECK)) {
                session()->setTempdata('error', 'Student is already assessed!', 2);
                return redirect()->to(current_url());
            }else{
                $shsassessmentdata = [
                    'studid' => $STUDID,
                    'sy' => $SY,
                    'level' => $LEVEL,
                    'cluster' => $CLUSTERID,
                    'curriculum' => $SELECTEDCURRICULUM,
                    'section' => $SELECTEDSECTION,
                    'date' => date('Y-m-d'),
                ];
                // print_r($shsassessmentdata);
                $this->shsAssessmentModel->save($shsassessmentdata);
                session()->setTempdata('success', 'Student is processed successfully!', 2);
                return redirect()->to(current_url());
            }
        }
        $data['shsassessmentdata'] = $this->shsAssessmentModel
        ->select('assessment_shs.*, curriculum_shs.*, sections_shs.*, students_shs.*')
        ->join('curriculum_shs', 'curriculum_shs.currid = assessment_shs.curriculum')
        ->join('sections_shs', 'sections_shs.secid = assessment_shs.section')
        ->join('students_shs', 'students_shs.studid = assessment_shs.studid')
        ->where('assessment_shs.studid', $STUDID)
        ->where('assessment_shs.sy', $SY)
        ->where('assessment_shs.level', $LEVEL)
        ->findAll();

        // SHS ASSESSED CURRICULUM DATA
        $data['firstsemester'] = $this->shsAssessmentModel
        ->select('assessment_shs.*, curriculum_shs.*, currdata_shs.*, subjects_shs.*')
        ->join('curriculum_shs', 'curriculum_shs.currid = assessment_shs.curriculum', 'left')
        ->join('currdata_shs', 'currdata_shs.curriculumid = curriculum_shs.currid', 'left')
        ->join('subjects_shs', 'subjects_shs.subid = currdata_shs.subid', 'left')
        ->where('assessment_shs.studid', $STUDID)
        ->where('assessment_shs.sy', $SY)
        ->where('assessment_shs.level', $LEVEL)
        ->where('currdata_shs.sem', '1st Semester')
        ->findAll();
        $data['secondsemester'] = $this->shsAssessmentModel
        ->select('assessment_shs.*, curriculum_shs.*, currdata_shs.*, subjects_shs.*')
        ->join('curriculum_shs', 'curriculum_shs.currid = assessment_shs.curriculum', 'left')
        ->join('currdata_shs', 'currdata_shs.curriculumid = curriculum_shs.currid', 'left')
        ->join('subjects_shs', 'subjects_shs.subid = currdata_shs.subid', 'left')
        ->where('assessment_shs.studid', $STUDID)
        ->where('assessment_shs.sy', $SY)
        ->where('assessment_shs.level', $LEVEL)
        ->where('currdata_shs.sem', '2nd Semester')
        ->findAll();

        //SHS ASSESSED RATE DATA
        $data['shsratedata'] = $this->shsRatesModel
        ->where('rates_shs.cluster', $CLUSTERID)
        ->findAll();
        foreach($data['shsratedata'] as $rates){
            $RATEID = $rates['rateid'];
        }

        $data['shsrofdata'] = $this->shsRateOtherFeesModel->where('rateid', $RATEID)->findAll();
        $data['shsrddata'] = $this->shsRateDuesModel->where('rateid', $RATEID)->findAll();

        return view('shs/advisingviewprocess', $data);
    }
    public function advisingSubmitAccount($id=null) {
        $ASSESSMENTDATACHECKING = $this->shsAssessmentModel
        ->select('assessment_shs.*, students_shs.*, clusters.*')
        ->join('students_shs', 'students_shs.studid = assessment_shs.studid')
        ->join('clusters', 'clusters.cluid = assessment_shs.cluster')
        ->where('assessment_shs.studid', $id)
        ->findAll();
        foreach($ASSESSMENTDATACHECKING as $adc) {
            $STUDENTNO = $adc['studentno'];
            $ASSESSMENTID = $adc['assid'];
            $SY = $adc['sy'];
            $CLUSTERID = $adc['code'];
            $LEVEL = $adc['level'];
        }

        $studentsaccounts = [
            'studentno' => $STUDENTNO,
            'assessmentid' => $ASSESSMENTID,
            'sy' => $SY,
            'cluster' => $CLUSTERID,
            'level' => $LEVEL,
            'accountstatus' => 'Active',
            'createddate' => date('Y-m-d'),
        ];
        $FINDEHSHS = $this->enrollmentHistorySHSModel
        ->where('studid', $id)
        ->where('sy', $SY)
        ->where('level', $LEVEL)
        ->findAll();
        foreach($FINDEHSHS as $findehshs){
            $STUDENTID = $findehshs['studid'];
        }

        $ehshsdata = [
            'status' => 'Assessed',
        ];
        
        $shsassessment = [
            'status' => 'Finalized',
        ];

        $this->shsAssessmentModel->where('assid', $ASSESSMENTID)->update($ASSESSMENTID, $shsassessment);
        $this->studentAccountsModel->save($studentsaccounts);
        $this->enrollmentHistorySHSModel->where('studid', $STUDENTID)->update($STUDENTID, $ehshsdata);
        session()->setTempdata('success', 'Student is assessed successfully!', 2);
        return redirect()->to(base_url()."shs-advising");
    }
    public function assessment() {
        $data = [
            'page_title' => 'Holy Cross College | SHS Assessment',
            'page_heading' => 'SHS ASSESSMENT!',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $data['enrollmenthistoryshsdata'] = $this->enrollmentHistorySHSModel
        ->select('enrollmenthistory_shs.*, students_shs.*, clusters.*')
        ->join('students_shs', 'students_shs.studid = enrollmenthistory_shs.studid')
        ->join('clusters', 'clusters.cluid = enrollmenthistory_shs.cluster')
        ->where('enrollmenthistory_shs.status', 'Assessed')->where('enrollmenthistory_shs.isdel', 0)->findAll();

        return view('shs/assessmentview', $data);
    }
    public function assessmentView($id=null) {
        $data = [
            'page_title' => 'Holy Cross College | SHS Assessment View',
            'page_heading' => 'SHS ASSESSMENT VIEW!',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $data['enrollmenthistoryshsdata'] = $this->enrollmentHistorySHSModel
        ->select('enrollmenthistory_shs.*, students_shs.*, clusters.*')
        ->join('students_shs', 'students_shs.studid = enrollmenthistory_shs.studid')
        ->join('clusters', 'clusters.cluid = enrollmenthistory_shs.cluster')
        ->where('students_shs.studid', $id)->findAll();
        foreach($data['enrollmenthistoryshsdata'] as $ehs) {
            $CLUSTERID = $ehs['cluid'];
            $LEVEL = $ehs['level'];
            $SY = $ehs['sy'];
            $STUDID = $ehs['studid'];
        }
        $data['shsassessmentdata'] = $this->shsAssessmentModel
        ->select('assessment_shs.*, curriculum_shs.*, sections_shs.*, students_shs.*')
        ->join('curriculum_shs', 'curriculum_shs.currid = assessment_shs.curriculum')
        ->join('sections_shs', 'sections_shs.secid = assessment_shs.section')
        ->join('students_shs', 'students_shs.studid = assessment_shs.studid')
        ->where('assessment_shs.studid', $STUDID)
        ->where('assessment_shs.sy', $SY)
        ->where('assessment_shs.level', $LEVEL)
        ->findAll();
        // SHS ASSESSED CURRICULUM DATA
        $data['firstsemester'] = $this->shsAssessmentModel
        ->select('assessment_shs.*, curriculum_shs.*, currdata_shs.*, subjects_shs.*')
        ->join('curriculum_shs', 'curriculum_shs.currid = assessment_shs.curriculum', 'left')
        ->join('currdata_shs', 'currdata_shs.curriculumid = curriculum_shs.currid', 'left')
        ->join('subjects_shs', 'subjects_shs.subid = currdata_shs.subid', 'left')
        ->where('assessment_shs.studid', $STUDID)
        ->where('assessment_shs.sy', $SY)
        ->where('assessment_shs.level', $LEVEL)
        ->where('currdata_shs.sem', '1st Semester')
        ->findAll();
        $data['secondsemester'] = $this->shsAssessmentModel
        ->select('assessment_shs.*, curriculum_shs.*, currdata_shs.*, subjects_shs.*')
        ->join('curriculum_shs', 'curriculum_shs.currid = assessment_shs.curriculum', 'left')
        ->join('currdata_shs', 'currdata_shs.curriculumid = curriculum_shs.currid', 'left')
        ->join('subjects_shs', 'subjects_shs.subid = currdata_shs.subid', 'left')
        ->where('assessment_shs.studid', $STUDID)
        ->where('assessment_shs.sy', $SY)
        ->where('assessment_shs.level', $LEVEL)
        ->where('currdata_shs.sem', '2nd Semester')
        ->findAll();

        //SHS ASSESSED RATE DATA
        $data['shsratedata'] = $this->shsRatesModel
        ->where('rates_shs.cluster', $CLUSTERID)
        ->findAll();
        $data['shsrofdata'] = $this->shsRateOtherFeesModel->findAll();
        $data['shsrddata'] = $this->shsRateDuesModel->findAll();
        
        return view('shs/assessmentviewing', $data);
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

        $enrollmenthistoryshsdata = $this->enrollmentHistorySHSModel
        ->select('enrollmenthistory_shs.*, students_shs.*, clusters.*')
        ->join('students_shs', 'students_shs.studid = enrollmenthistory_shs.studid')
        ->join('clusters', 'clusters.cluid = enrollmenthistory_shs.cluster')
        ->where('students_shs.studid', $id)->findAll();
        foreach($enrollmenthistoryshsdata as $ehs) {
            $CLUSTERID = $ehs['cluid'];
            $LEVEL = $ehs['level'];
            $SY = $ehs['sy'];
            $STUDID = $ehs['studid'];
            $CLUSTER = $ehs['code'];
        }
        $shsassessmentdata = $this->shsAssessmentModel
        ->select('assessment_shs.*, curriculum_shs.*, sections_shs.*, students_shs.*')
        ->join('curriculum_shs', 'curriculum_shs.currid = assessment_shs.curriculum')
        ->join('sections_shs', 'sections_shs.secid = assessment_shs.section')
        ->join('students_shs', 'students_shs.studid = assessment_shs.studid')
        ->where('assessment_shs.studid', $STUDID)
        ->where('assessment_shs.sy', $SY)
        ->where('assessment_shs.level', $LEVEL)
        ->findAll();
        foreach($shsassessmentdata as $sad) {
            $STUDENTNO = $sad['studentno'];
            $SY = $sad['sy'];
            $STUDFULLNAME = $sad['studfullname'];
            $LEVEL = $sad['level'];
            $BARANGAY = $sad['studstbarangay'];
            $MUNICIPALITY = $sad['studcity'];
            $PROVINCE = $sad['studprovince'];
            $ADDRESS = $BARANGAY .' '. $MUNICIPALITY .', '. $PROVINCE;
            $SECTION = $sad['section'];
        }
        
        // SHS ASSESSED CURRICULUM DATA
        $firstsemester = $this->shsAssessmentModel
        ->select('assessment_shs.*, curriculum_shs.*, currdata_shs.*, subjects_shs.*')
        ->join('curriculum_shs', 'curriculum_shs.currid = assessment_shs.curriculum', 'left')
        ->join('currdata_shs', 'currdata_shs.curriculumid = curriculum_shs.currid', 'left')
        ->join('subjects_shs', 'subjects_shs.subid = currdata_shs.subid', 'left')
        ->where('assessment_shs.studid', $STUDID)
        ->where('assessment_shs.sy', $SY)
        ->where('assessment_shs.level', $LEVEL)
        ->where('currdata_shs.sem', '1st Semester')
        ->findAll();
        $secondsemester = $this->shsAssessmentModel
        ->select('assessment_shs.*, curriculum_shs.*, currdata_shs.*, subjects_shs.*')
        ->join('curriculum_shs', 'curriculum_shs.currid = assessment_shs.curriculum', 'left')
        ->join('currdata_shs', 'currdata_shs.curriculumid = curriculum_shs.currid', 'left')
        ->join('subjects_shs', 'subjects_shs.subid = currdata_shs.subid', 'left')
        ->where('assessment_shs.studid', $STUDID)
        ->where('assessment_shs.sy', $SY)
        ->where('assessment_shs.level', $LEVEL)
        ->where('currdata_shs.sem', '2nd Semester')
        ->findAll();

        //SHS ASSESSED RATE DATA
        $shsratedata = $this->shsRatesModel
        ->where('rates_shs.cluster', $CLUSTERID)
        ->findAll();
        
        $shsrofdata = $this->shsRateOtherFeesModel->findAll();
        $shsrddata = $this->shsRateDuesModel->findAll();

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
                    <td style="width: 60%;"></td>
                    <td><h3>SENIOR HIGH SCHOOL DEPARTMENT</h3></td>
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
                    <td>LEVEL: <strong>'. $LEVEL .'</strong></td>
                </tr>
                <tr>
                    <td>CLUSTER: <strong>'. strtoupper($CLUSTER) .'</strong></td>
                    <td>SECTION: <strong>'. $SECTION .'</strong></td>
                </tr>
                <tr>
                    <td>ADDRESS: <strong>'. strtoupper($ADDRESS) .'</strong></td>
                    
                </tr>
            </table><br><br>

            <table border="1" style="width: 100%; font-size: 10px;">
                <tr>
                    <td style="text-align: center;"><strong>FIRST SEMESTER</strong></td>
                </tr>
                <thead>
                    <tr>
                        <th style="width: 20%;text-align: center;"><strong>GROUPING</strong></th>
                        <th style="width: 30%;text-align: center;"><strong>CODE</strong></th>
                        <th style="width: 50%;text-align: center;"><strong>SUBJECT</strong></th>
                    </tr>
                </thead>
                <tbody>
        ';
        foreach($firstsemester as $fs){
            $TYPE = $fs['type'];
            $CODE = $fs['code'];
            $SUBJECT = $fs['subject'];
            $html .= '<tr>
                    <td style="width: 20%; text-align: left; font-size: 10px;">'.$TYPE.'</td>
                    <td style="width: 30%; text-align: center; font-size: 10px;">'.$CODE.' </td>
                    <td style="width: 50%; text-align: left; font-size: 10px;">'.$SUBJECT.'</td>
                </tr>';
        }
        $html .='
                </tbody>
            </table><br><br>
            <table border="1" style="width: 100%; font-size: 10px;">
                <tr>
                    <td style="text-align: center;"><strong>SECOND SEMESTER</strong></td>
                </tr>
                <thead>
                    <tr>
                        <th style="width: 20%;text-align: center;"><strong>GROUPING</strong></th>
                        <th style="width: 30%;text-align: center;"><strong>CODE</strong></th>
                        <th style="width: 50%;text-align: center;"><strong>SUBJECT</strong></th>
                    </tr>
                </thead>
                <tbody>
        ';
        foreach($secondsemester as $ss){
            $STYPE = $ss['type'];
            $SCODE = $ss['code'];
            $SSUBJECT = $ss['subject'];
            $html .= '<tr>
                    <td style="width: 20%; text-align: left; font-size: 10px;">'.$STYPE.'</td>
                    <td style="width: 30%; text-align: center; font-size: 10px;">'.$SCODE.' </td>
                    <td style="width: 50%; text-align: left; font-size: 10px;">'.$SSUBJECT.'</td>
                </tr>';
        }
        foreach($shsratedata as $shsrated){
            $TF = $shsrated['tf'];
        }
        $html .='
                </tbody>
            </table><br><br>
            <table>
                <tbody>
                    <tr>
                        <td style="width: 50%;">
                            <table>
                                <tbody>
                                    <tr>
                                        <td style="width: 50%; text-align: left; font-size: 10px;"><strong>FEES:</strong></td>
                                    </tr><br>
                                    <tr>
                                        <td style="width: 50%; text-align: left; font-size: 10px;">Tuition Fee</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 5%;"></td>
                                        <td style="width: 45%; text-align: left; font-size: 10px;">Tuition</td>
                                        <td style="width: 45%; text-align: right; font-size: 10px;"><strong>'.number_format($TF, 2).'</strong></td>
                                        <td style="width: 5%;"></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 5%;"></td>
                                        <td style="width: 45%; text-align: left; font-size: 10px;">QVR (Public)</td>
                                        <td style="width: 45%; text-align: right; font-size: 10px;"><strong>-'.number_format($TF, 2).'</strong></td>
                                        <td style="width: 5%;"></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 5%;"></td>
                                        <td style="width: 45%; text-align: right; font-size: 10px;">Sub Total</td>
                                        <td style="width: 15%; text-align: right; font-size: 10px;"></td>
                                        <td style="width: 30%; text-align: right; font-size: 10px; border-top: 1px solid #000; border-bottom: 1px solid #000;"><strong>0.00</strong></td>
                                    </tr>
                                </tbody>
                            </table><br><br>
                            <table>
                                <tbody>
                                    <tr>
                                        <td style="width: 50%; text-align: left; font-size: 10px;">Miscellaneous Fees</td>
                                    </tr>';
                                    foreach($shsrofdata as $shsrofd){
                                        if($shsrofd['rateid'] == $shsrated['rateid']){
                                            $NAME = $shsrofd['name'];
                                            $AMOUNT = $shsrofd['otherfees'];
                                            $totalotherfees = 0;
                                            foreach($shsrofdata as $shsrofd) {
                                                if($shsrofd['rateid'] == $shsrated['rateid']) {
                                                    $totalotherfees += $shsrofd['otherfees'];
                                                }
                                            }

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
                                </tbody>
                            </table>
                        </td>
                        <td style="width: 50%;">
                            <table>
                                <tbody>
                                    <tr>
                                        <td style="width: 50%; text-align: left; font-size: 10px;"><strong>INSTALLMENT SCHEDULE:</strong></td>
                                    </tr><br>';
                                    foreach($shsrddata as $shsrdd){
                                        if($shsrdd['rateid'] == $shsrated['rateid']){
                                            $DNAME = $shsrdd['name'];
                                            $DDATE = $shsrdd['due'];

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
            </table>
            <br>
            <br>
            <br>
            <br>';
            $html .= '<table style="width: 100%;">
            <br>
            
                <tr>
                    <td style="width: 50%; vertical-align: top;">
                        <table style="width: 100%;">
                            <tbody>
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
                        <br>
                        <br>
                        <br>
                        <table  style="width: 100%;">
                            <tbody>
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
            </table>
            <br>';
        
        $html .='
            <table>
                <tbody>
                    <tr>
                        <td style="text-align: center;">
                            <p style="font-size: 6px;">THIS IS NOT OFFICIAL UNLESS SIGNED BY THE REGISTRAR</p>
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
        $ehshsdata = [
            'status' => 'Payment',
        ];
        $this->enrollmentHistorySHSModel->where('ehid', $id)->update($id, $ehshsdata);
        session()->setTempdata('success', 'Student is approved!', 2);
        return redirect()->to(base_url()."shs-assessment");
    }
}