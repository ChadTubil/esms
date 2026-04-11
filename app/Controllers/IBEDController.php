<?php

namespace App\Controllers;
use App\Models\UsersModel;
use App\Models\SYModel;
use App\Models\IBEDLevelModel;
use App\Models\IBEDCurriculumModel;

use TCPDF;
class IBEDController extends BaseController
{
    public $usersModel;
    public $syModel;
    public $ibedlvlModel;
    public $ibedcurriculumModel;
    
    public $session;
    public function __construct() {
        helper('form');
        $this->usersModel = new UsersModel();
        $this->syModel = new SYModel();
        $this->ibedlvlModel = new IBEDLevelModel();
        $this->ibedcurriculumModel = new IBEDCurriculumModel();

        
        $this->session = session();
    }
    public function level(){
        $data = [
            'page_title' => 'Holy Cross College | IBED Level',
            'page_heading' => 'IBED LEVEL MANAGEMENT! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $data['leveldata'] = $this->ibedlvlModel->where('isdel', '0')->findAll();

        if($this->request->is('post')) {
            $rules = [
                'code' => [
                    'rules' => 'required|is_unique[ibedlevel.code]',
                    'errors' => [
                        'required' => 'Code is required.',
                        'is_unique' => 'This code is already exists.'
                    ],
                ],
                'level' => [
                    'rules' => 'required|is_unique[ibedlevel.name]',
                    'errors' => [
                        'required' => 'Level is required.',
                        'is_unique' => 'This level is already exists.'
                    ],
                ],
            ];
            if($this->validate($rules)){
                $lvldata = [
                    'code' => $this->request->getVar('code'),
                    'name' => $this->request->getVar('level'),
                ];
                $this->ibedlvlModel->save($lvldata);
                session()->setTempdata('addsuccess','Level added successfully', 3);
                return redirect()->to(current_url());
            } else {
                $data['validation'] = $this->validator;
            }
        }
        return view('ibed/levelview', $data);
    }
    public function deletelevel($id=null) {
        $lvldata = [
            'isdel' => '1',
        ];

        $this->ibedlvlModel->where('ibedlvlid', $id)->update($id, $lvldata);
        session()->setTempdata('deletesuccess', 'Level is deleted!', 2);
        return redirect()->to(base_url()."ibed-level");
    }
    public function updatelevel($id=null) {
        if($this->request->is('post')) {
            $data = [
                'code' => $this->request->getVar('code'),
                'name' => $this->request->getVar('level'),
            ];

            $this->ibedlvlModel->where('ibedlvlid', $id)->update($id, $data);
            session()->setTempdata('updatesuccess', 'Update Successful!', 2);
            return redirect()->to(base_url()."ibed-level");
        }
    }
    public function subjects(){
        $data = [
            'page_title' => 'Holy Cross College | IBED Subjects',
            'page_heading' => 'IBED SUBJECTS! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $data['gssubjectsdata'] = $this->gsSubjectsModel->where('isdel', '0')->findAll();

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
                $gssubjectdata = [
                    'code' => $this->request->getVar('code'),
                    'subject' => $this->request->getVar('subject'),
                    'type' => $this->request->getVar('type'),
                    'hours' => $this->request->getVar('hours'),
                    'prerequisite' => $this->request->getVar('prerequisite'),
                ];
                $this->gsSubjectsModel->save($gssubjectdata);
                session()->setTempdata('addsuccess','Subject added successfully', 3);
                return redirect()->to(current_url());
            } else {
                $data['validation'] = $this->validator;
            }
        }
        return view('gs/subjectsview', $data);
    }
    public function deletesubjects($id=null) {
        $cludata = [
            'isdel' => '1',
        ];

        $this->gsSubjectsModel->where('subid', $id)->update($id, $cludata);
        session()->setTempdata('deletesuccess', 'Subject is deleted!', 2);
        return redirect()->to(base_url()."gs-subjects");
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

            $this->gsSubjectsModel->where('subid', $id)->update($id, $data);
            session()->setTempdata('updatesuccess', 'Update Successful!', 2);
            return redirect()->to(base_url()."gs-subjects");
        }
    }
    public function curriculum(){
        $data = [
            'page_title' => 'Holy Cross College | IBED Curriculum',
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
        $data['leveldata'] = $this->ibedlvlModel->where('isdel', '0')->findAll();
        $data['curriculumdata'] = $this->ibedcurriculumModel
        ->select('curriculum_ibed.*, ibedlevel.*')
        ->join('ibedlevel', 'ibedlevel.ibedlvlid = curriculum_ibed.level')
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
        $data['clusterdata'] = $this->clustersModel->where('isdel', '0')->findAll();
        $data['gssubjectsdata'] = $this->gsSubjectsModel->where('isdel', '0')->findAll();
        $data['gscurriculumdata'] = $this->gsCurriculumModel
        ->select('curriculum_gs.*, clusters.*')
        ->join('clusters', 'clusters.cluid = curriculum_gs.cluster')
        ->where('currid', $id)->findAll();
        $data['cddata'] = $this->gsCurriculumDataModel->where('curriculumid', $id)->findAll();

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
                $FINDSUBJECT = $this->gsSubjectsModel->where('subid', $subjectid)->findAll();
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
                $this->gsCurriculumDataModel->save($data);
                session()->setTempdata('addsuccess','Subject added successfully', 3);
                return redirect()->to(current_url());
            } else {
                $data['validation'] = $this->validator;
            }
        }

        return view('gs/curriculumsetupview', $data);
    }
    public function sections() {
        $data = [
            'page_title' => 'Holy Cross College | IBED Sections Setup',
            'page_heading' => 'IBED SECTIONS SETUP! ',
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
        $data['sectiondata'] = $this->gsSectionsModel
        ->select('sections_gs.*, clusters.*')
        ->join('clusters', 'clusters.cluid = sections_gs.cluster')
        ->where('sections_gs.isdel', '0')->findAll();

        if($this->request->is('post')) {
            $rules = [
                'section' => [
                    'rules' => 'required|is_unique[sections_gs.section]',
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
                $this->gsSectionsModel->save($sectiondata);
                session()->setTempdata('success', 'Section is added successfully', 3);
                return redirect()->to(current_url());
            } else {
                $data['validation'] = $this->validator;
            }
        }

        return view('gs/sectionsview', $data);
    }
    public function deletesections($id=null) {
        $data = [
            'isdel' => '1',
        ];

        $this->gsSectionsModel->where('secid', $id)->update($id, $data);
        session()->setTempdata('success', 'Section is deleted!', 2);
        return redirect()->to(base_url()."gs-sections");
    }
    public function updatesections($id=null) {
        if($this->request->is('post')) {
            $sectiondata = [
                'section' => $this->request->getVar('section'),
                'sy' => $this->request->getVar('sy'),
                'level' => $this->request->getVar('level'),
                'cluster' => $this->request->getVar('cluster'),
            ];

            $this->gsSectionsModel->where('secid', $id)->update($id, $sectiondata);
            session()->setTempdata('updatesuccess', 'Update Successful!', 2);
            return redirect()->to(base_url()."shs-sections");
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

        return view('gs/registrationselectview', $data);
    }
    public function oldstudent(){

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

        $data['registeredstudents'] = $this->gsStudentsModel
        ->select('students_gs.*')
        ->join('paymenttransactions', 'paymenttransactions.studfullname = students_gs.studfullname')
        ->join('enrollmenthistory_gs', 'enrollmenthistory_gs.studfullname = students_gs.studfullname AND enrollmenthistory_gs.isdel = 0', 'left')
        ->where('enrollmenthistory_gs.studfullname IS NULL') // Only those NOT in enrollment history
        ->groupBy('students_gs.studfullname') // Group by student fullname to avoid duplicates
        ->findAll();


        return view('gs/registeredstudentview', $data);
    }
    public function registeredstudentProcess($id=null){
        $registeredstudent = $this->gsStudentsModel->where('studid', $id)->findAll();
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
        $gsstuddata = [
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
        $this->gsStudentsModel->save($gsstuddata);
        $registeredstudentpr = $this->gsStudentsModel->where('studfullname', $STUDFULLNAME)->findAll();
        foreach($registeredstudentpr as $rsp){
            $STUDID = $rsp['studid'];
        }
        $this->gsPermanentRecordModel->where('studfullname', $STUDFULLNAME)->set(['studid' => $STUDID])->update();
        $ehdata = [
            'studid' => $STUDID,
            'studfullname' => $STUDFULLNAME,
            'date' => date('Y-m-d'),
            'status' => 'Registered',
        ];
        $this->enrollmentHistoryGSModel->save($ehdata);
        return redirect()->to(base_url()."gs-admission");
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
        $data['enrollmenthistorygsdata'] = $this->enrollmentHistoryGSModel
        ->select('enrollmenthistory_gs.*, students_gs.*')
        ->join('students_gs', 'students_gs.studid = enrollmenthistory_gs.studid')
        ->where('enrollmenthistory_gs.status', 'Registered')->where('enrollmenthistory_gs.isdel', 0)->findAll();

        return view('gs/admissionview', $data);
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

        $data['studentsgssdata'] = $this->gsStudentsModel
        ->select('students_gs.*, permanentrecord_gs.*')
        ->join('permanentrecord_gs', 'permanentrecord_gs.studid = students_gs.studid', 'left')
        ->where('students_gs.studid', $id)->findAll();

        $data['schoolyear'] = $this->syModel->where('syisdel', 0)->findAll();
        $data['clusterdata'] = $this->clustersModel->where('isdel', 0)->findAll();

        if($this->request->is('post')){
            // IBED SCHOOL RECORD 
            $gsschoolrecorddata = [
                'studid' => $id,
                'sy' => $this->request->getVar('schoolyear'),
                'level' => $this->request->getVar('level'),
                'cluster' => $this->request->getVar('cluster'),
            ];
            $this->gsSchoolRecordModel->save($gsschoolrecorddata);
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
            $this->gsFamilyBackgroundModel->save($gsfbdata);

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
            $this->additionalInfoGSModel->save($gsaddinfodata);
            // ENROLLMENT TEMP DATA UPDATE
            $EHGSInfo = $this->enrollmentHistoryGSModel->where('studid', $id)->findAll();
            foreach($EHGSInfo as $ehshs) {
                $EHGSID = $ehshs['ehid'];
            }
            $ehgsdata = [
                'sy' => $this->request->getVar('schoolyear'),
                'level' => $this->request->getVar('level'),
                'cluster' => $this->request->getVar('cluster'),
                'status' => 'Admitted',
            ];
            $this->enrollmentHistoryGSModel->where('ehid', $EHGSID)->update($EHGSID, $ehgsdata);
            session()->setTempdata('success', 'Admission processed successfully!', 2);
            return redirect()->to(base_url()."gs-admission");
        }

        return view('gs/admissionviewprocess', $data);
    }
    public function admissionProcessCancel($id=null) {
        $ehdata = [
            'isdel' => '1',
            'status' => 'Cancelled',
        ];
        $gsstuddata = [
            'studisdel' => '1',
        ];

        $this->enrollmentHistoryGSModel->where('ehid', $id)->update($id, $ehdata);
        $this->gsStudentsModel->where('studid', $id)->update($id, $gsstuddata);
        session()->setTempdata('deletesuccess', 'Application is deleted!', 2);
        return redirect()->to(base_url()."gs-admission");
    }
    public function admissionProcessGenerate($id=null) {
        $year = date('y');
        // print_r($year);
        $laststudentno = $this->gsStudentsModel
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
        $this->gsStudentsModel->where('studid', $id)->update($id, $data);
        return redirect()->to(base_url()."gs-admission/process/".$id);
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
        $data['enrollmenthistorygsdata'] = $this->enrollmentHistoryGSModel
        ->select('enrollmenthistory_gs.*, students_gs.*, clusters.*')
        ->join('students_gs', 'students_gs.studid = enrollmenthistory_gs.studid')
        ->join('clusters', 'clusters.cluid = enrollmenthistory_gs.cluster')
        ->where('enrollmenthistory_gs.status', 'Admitted')->where('enrollmenthistory_gs.isdel', 0)->findAll();

        return view('gs/advisingview', $data);
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
        $data['enrollmenthistorygsdata'] = $this->enrollmentHistoryGSModel
        ->select('enrollmenthistory_gs.*, students_gs.*, clusters.*')
        ->join('students_gs', 'students_gs.studid = enrollmenthistory_gs.studid')
        ->join('clusters', 'clusters.cluid = enrollmenthistory_gs.cluster')
        ->where('students_gs.studid', $id)->findAll();
        foreach($data['enrollmenthistorygsdata'] as $ehs) {
            $CLUSTERID = $ehs['cluid'];
            $LEVEL = $ehs['level'];
            $SY = $ehs['sy'];
            $STUDID = $ehs['studid'];
        }

        $data['gscurriculumdata'] = $this->gsCurriculumModel
        ->select('curriculum_gs.*, clusters.*')
        ->join('clusters', 'clusters.cluid = curriculum_gs.cluster')
        ->where('curriculum_gs.cluster', $CLUSTERID)
        ->where('curriculum_gs.level', $LEVEL)
        ->where('curriculum_gs.sy', $SY)
        ->findAll();

        $data['gssectiondata'] = $this->gsSectionsModel
        ->select('sections_gs.*, clusters.*')
        ->join('clusters', 'clusters.cluid = sections_gs.cluster')
        ->where('sections_gs.cluster', $CLUSTERID)
        ->where('sections_gs.level', $LEVEL)
        ->where('sections_gs.sy', $SY)
        ->findAll();

        if($this->request->is('post')) {
            $SELECTEDCURRICULUM = $this->request->getVar('curriculum');
            $SELECTEDSECTION = $this->request->getVar('section');
            $ADVISINGCHECK = $this->gsAssessmentModel
            ->where('studid', $STUDID)
            ->where('sy', $SY)
            ->where('level', $LEVEL)
            ->findAll();
            // print_r($ADVISINGCHECK);
            if(!empty($ADVISINGCHECK)) {
                session()->setTempdata('error', 'Student is already assessed!', 2);
                return redirect()->to(current_url());
            }else{
                $gsassessmentdata = [
                    'studid' => $STUDID,
                    'sy' => $SY,
                    'level' => $LEVEL,
                    'cluster' => $CLUSTERID,
                    'curriculum' => $SELECTEDCURRICULUM,
                    'section' => $SELECTEDSECTION,
                    'date' => date('Y-m-d'),
                ];
                // print_r($shsassessmentdata);
                $this->gsAssessmentModel->save($gsassessmentdata);
                session()->setTempdata('success', 'Student is processed successfully!', 2);
                return redirect()->to(current_url());
            }
        }
        $data['gsassessmentdata'] = $this->gsAssessmentModel
        ->select('assessment_gs.*, curriculum_gs.*, sections_gs.*, students_gs.*')
        ->join('curriculum_gs', 'curriculum_gs.currid = assessment_gs.curriculum')
        ->join('sections_gs', 'sections_gs.secid = assessment_gs.section')
        ->join('students_gs', 'students_gs.studid = assessment_gs.studid')
        ->where('assessment_gs.studid', $STUDID)
        ->where('assessment_gs.sy', $SY)
        ->where('assessment_gs.level', $LEVEL)
        ->findAll();

        // SHS ASSESSED CURRICULUM DATA
        $data['firstsemester'] = $this->gsAssessmentModel
        ->select('assessment_gs.*, curriculum_gs.*, currdata_gs.*, subjects_gs.*')
        ->join('curriculum_gs', 'curriculum_gs.currid = assessment_gs.curriculum', 'left')
        ->join('currdata_gs', 'currdata_gs.curriculumid = curriculum_gs.currid', 'left')
        ->join('subjects_gs', 'subjects_gs.subid = currdata_gs.subid', 'left')
        ->where('assessment_gs.studid', $STUDID)
        ->where('assessment_gs.sy', $SY)
        ->where('assessment_gs.level', $LEVEL)
        ->where('currdata_gs.sem', '1st Semester')
        ->findAll();
        $data['secondsemester'] = $this->gsAssessmentModel
        ->select('assessment_gs.*, curriculum_gs.*, currdata_gs.*, subjects_gs.*')
        ->join('curriculum_gs', 'curriculum_gs.currid = assessment_gs.curriculum', 'left')
        ->join('currdata_gs', 'currdata_gs.curriculumid = curriculum_gs.currid', 'left')
        ->join('subjects_gs', 'subjects_gs.subid = currdata_gs.subid', 'left')
        ->where('assessment_gs.studid', $STUDID)
        ->where('assessment_gs.sy', $SY)
        ->where('assessment_gs.level', $LEVEL)
        ->where('currdata_gs.sem', '2nd Semester')
        ->findAll();

        //SHS ASSESSED RATE DATA
        $data['gsratedata'] = $this->gsRatesModel
        ->where('rates_gs.cluster', $CLUSTERID)
        ->findAll();
        foreach($data['gsratedata'] as $rates){
            $RATEID = $rates['rateid'];
        }

        $data['gsrofdata'] = $this->gsRateOtherFeesModel->where('rateid', $RATEID)->findAll();
        $data['gsrddata'] = $this->gsRateDuesModel->where('rateid', $RATEID)->findAll();

        return view('gs/advisingviewprocess', $data);
    }
    public function advisingSubmitAccount($id=null) {
        $ASSESSMENTDATACHECKING = $this->gsAssessmentModel
        ->select('assessment_gs.*, students_gs.*, clusters.*')
        ->join('students_gs', 'students_gs.studid = assessment_gs.studid')
        ->join('clusters', 'clusters.cluid = assessment_gs.cluster')
        ->where('assessment_gs.studid', $id)
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
        $FINDEHGS = $this->enrollmentHistoryGSModel
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

        $this->gsAssessmentModel->where('assid', $ASSESSMENTID)->update($ASSESSMENTID, $gsassessment);
        $this->studentAccountsModel->save($studentsaccounts);
        $this->enrollmentHistoryGSModel->where('studid', $STUDENTID)->update($STUDENTID, $ehgsdata);
        session()->setTempdata('success', 'Student is assessed successfully!', 2);
        return redirect()->to(base_url()."gs-advising");
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
        $data['enrollmenthistorygsdata'] = $this->enrollmentHistoryGSModel
        ->select('enrollmenthistory_gs.*, students_gs.*, clusters.*')
        ->join('students_gs', 'students_gs.studid = enrollmenthistory_gs.studid')
        ->join('clusters', 'clusters.cluid = enrollmenthistory_gs.cluster')
        ->where('enrollmenthistory_gs.status', 'Assessed')->where('enrollmenthistory_gs.isdel', 0)->findAll();

        return view('gs/assessmentview', $data);
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
        $data['enrollmenthistorygsdata'] = $this->enrollmentHistoryGSModel
        ->select('enrollmenthistory_gs.*, students_gs.*, clusters.*')
        ->join('students_gs', 'students_gs.studid = enrollmenthistory_gs.studid')
        ->join('clusters', 'clusters.cluid = enrollmenthistory_gs.cluster')
        ->where('students_gs.studid', $id)->findAll();
        foreach($data['enrollmenthistorygsdata'] as $ehs) {
            $CLUSTERID = $ehs['cluid'];
            $LEVEL = $ehs['level'];
            $SY = $ehs['sy'];
            $STUDID = $ehs['studid'];
        }
        $data['gsassessmentdata'] = $this->gsAssessmentModel
        ->select('assessment_gs.*, curriculum_gs.*, sections_gs.*, students_gs.*')
        ->join('curriculum_gs', 'curriculum_gs.currid = assessment_gs.curriculum')
        ->join('sections_gs', 'sections_gs.secid = assessment_gs.section')
        ->join('students_gs', 'students_gs.studid = assessment_gs.studid')
        ->where('assessment_gs.studid', $STUDID)
        ->where('assessment_gs.sy', $SY)
        ->where('assessment_gs.level', $LEVEL)
        ->findAll();
        // SHS ASSESSED CURRICULUM DATA
        $data['firstsemester'] = $this->gsAssessmentModel
        ->select('assessment_gs.*, curriculum_gs.*, currdata_gs.*, subjects_gs.*')
        ->join('curriculum_gs', 'curriculum_gs.currid = assessment_gs.curriculum', 'left')
        ->join('currdata_gs', 'currdata_gs.curriculumid = curriculum_gs.currid', 'left')
        ->join('subjects_gs', 'subjects_gs.subid = currdata_gs.subid', 'left')
        ->where('assessment_gs.studid', $STUDID)
        ->where('assessment_gs.sy', $SY)
        ->where('assessment_gs.level', $LEVEL)
        ->where('currdata_gs.sem', '1st Semester')
        ->findAll();
        $data['secondsemester'] = $this->gsAssessmentModel
        ->select('assessment_gs.*, curriculum_gs.*, currdata_gs.*, subjects_gs.*')
        ->join('curriculum_gs', 'curriculum_gs.currid = assessment_gs.curriculum', 'left')
        ->join('currdata_gs', 'currdata_gs.curriculumid = curriculum_gs.currid', 'left')
        ->join('subjects_gs', 'subjects_gs.subid = currdata_gs.subid', 'left')
        ->where('assessment_gs.studid', $STUDID)
        ->where('assessment_gs.sy', $SY)
        ->where('assessment_gs.level', $LEVEL)
        ->where('currdata_gs.sem', '2nd Semester')
        ->findAll();

        //SHS ASSESSED RATE DATA
        $data['gsratedata'] = $this->gsRatesModel
        ->where('rates_gs.cluster', $CLUSTERID)
        ->findAll();
        $data['gsrofdata'] = $this->gsRateOtherFeesModel->findAll();
        $data['gsrddata'] = $this->gsRateDuesModel->findAll();
        
        return view('gs/assessmentviewing', $data);
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

        $enrollmenthistorygsdata = $this->enrollmentHistoryGSModel
        ->select('enrollmenthistory_gs.*, students_gs.*, clusters.*')
        ->join('students_gs', 'students_gs.studid = enrollmenthistory_gs.studid')
        ->join('clusters', 'clusters.cluid = enrollmenthistory_gs.cluster')
        ->where('students_gs.studid', $id)->findAll();
        foreach($enrollmenthistorygsdata as $ehs) {
            $CLUSTERID = $ehs['cluid'];
            $LEVEL = $ehs['level'];
            $SY = $ehs['sy'];
            $STUDID = $ehs['studid'];
            $CLUSTER = $ehs['code'];
        }
        $gsassessmentdata = $this->gsAssessmentModel
        ->select('assessment_gs.*, curriculum_gs.*, sections_gs.*, students_gs.*')
        ->join('curriculum_gs', 'curriculum_gs.currid = assessment_gs.curriculum')
        ->join('sections_gs', 'sections_gs.secid = assessment_gs.section')
        ->join('students_gs', 'students_gs.studid = assessment_gs.studid')
        ->where('assessment_gs.studid', $STUDID)
        ->where('assessment_gs.sy', $SY)
        ->where('assessment_gs.level', $LEVEL)
        ->findAll();
        foreach($gsassessmentdata as $sad) {
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
        $firstsemester = $this->gsAssessmentModel
        ->select('assessment_gs.*, curriculum_gs.*, currdata_gs.*, subjects_gs.*')
        ->join('curriculum_gs', 'curriculum_gs.currid = assessment_gs.curriculum', 'left')
        ->join('currdata_gs', 'currdata_gs.curriculumid = curriculum_gs.currid', 'left')
        ->join('subjects_gs', 'subjects_gs.subid = currdata_gs.subid', 'left')
        ->where('assessment_gs.studid', $STUDID)
        ->where('assessment_gs.sy', $SY)
        ->where('assessment_gs.level', $LEVEL)
        ->where('currdata_gs.sem', '1st Semester')
        ->findAll();
        $secondsemester = $this->gsAssessmentModel
        ->select('assessment_gs.*, curriculum_gs.*, currdata_gs.*, subjects_gs.*')
        ->join('curriculum_gs', 'curriculum_gs.currid = assessment_gs.curriculum', 'left')
        ->join('currdata_gs', 'currdata_gs.curriculumid = curriculum_gs.currid', 'left')
        ->join('subjects_gs', 'subjects_gs.subid = currdata_gs.subid', 'left')
        ->where('assessment_gs.studid', $STUDID)
        ->where('assessment_gs.sy', $SY)
        ->where('assessment_gs.level', $LEVEL)
        ->where('currdata_gs.sem', '2nd Semester')
        ->findAll();

        //SHS ASSESSED RATE DATA
        $gsratedata = $this->gsRatesModel
        ->where('rates_gs.cluster', $CLUSTERID)
        ->findAll();
        
        $gsrofdata = $this->gsRateOtherFeesModel->findAll();
        $gsrddata = $this->gsRateDuesModel->findAll();

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
        foreach($gsratedata as $gsrated){
            $TF = $gsrated['tf'];
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
                                    foreach($gsrofdata as $gsrofd){
                                        if($gsrofd['rateid'] == $gsrated['rateid']){
                                            $NAME = $gsrofd['name'];
                                            $AMOUNT = $gsrofd['otherfees'];
                                            $totalotherfees = 0;
                                            foreach($gsrofdata as $gsrofd) {
                                                if($gsrofd['rateid'] == $gsrated['rateid']) {
                                                    $totalotherfees += $gsrofd['otherfees'];
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
                                    foreach($gsrddata as $gsrdd){
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
        $ehgsdata = [
            'status' => 'Payment',
        ];
        $this->enrollmentHistoryGSModel->where('ehid', $id)->update($id, $ehgsdata);
        session()->setTempdata('success', 'Student is approved!', 2);
        return redirect()->to(base_url()."gs-assessment");
    }
}