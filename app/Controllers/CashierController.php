<?php

namespace App\Controllers;
use App\Models\UsersModel;
use App\Models\StudentsModel;
use App\Models\SYModel;
use App\Models\SemesterModel;
use App\Models\LevelsModel;
use App\Models\CoursesModel;
use App\Models\SchoolRecordModel;
use App\Models\AssessmentModel;
use App\Models\PermanentRecordModel;
use App\Models\EnrollmentTempDataModel;
use App\Models\FamilyBackgroundModel;
use App\Models\CurriculumsModel;
use App\Models\CurriculumDataModel;
use App\Models\StudentCurriculumModel;
use App\Models\CollegeGradesModel;
use App\Models\SectionsModel;
use App\Models\SubjectsModel;
use App\Models\SchedulesModel;
use App\Models\RatesModel;
use App\Models\RateOtherFeesModel;
use App\Models\RateDuesModel;
use App\Models\RoomsModel;
use TCPDF;
class CashierController extends BaseController
{ 
    public $usersModel;
    public $studentsModel;
    public $syModel;
    public $semModel;
    public $levelsModel;
    public $coursesModel;
    public $srModel;
    public $assModel;
    public $prModel;
    public $etdModel;
    public $fbModel;
    public $curriModel;
    public $currdataModel;
    public $studcurriModel;
    public $colgradesModel;
    public $sectionsModel;
    public $subjectsModel;
    public $schedulesModel;
    public $rofModel;
    public $ratesModel;
    public $rateDuesModel;
    public $roomsModel;
    public $session;
    public function __construct() {
        helper('form');
        $this->usersModel = new UsersModel();
        $this->studentsModel = new StudentsModel();
        $this->syModel = new SYModel();
        $this->semModel = new SemesterModel();
        $this->levelsModel = new LevelsModel();
        $this->coursesModel = new CoursesModel();
        $this->srModel = new SchoolRecordModel();
        $this->assModel = new AssessmentModel();
        $this->prModel = new PermanentRecordModel();
        $this->etdModel = new EnrollmentTempDataModel();
        $this->fbModel = new FamilyBackgroundModel();
        $this->curriModel = new CurriculumsModel();
        $this->currdataModel = new CurriculumDataModel();
        $this->studcurriModel = new StudentCurriculumModel();
        $this->colgradesModel = new CollegeGradesModel();
        $this->sectionsModel = new SectionsModel();
        $this->subjectsModel = new SubjectsModel();
        $this->schedulesModel = new SchedulesModel();
        $this->ratesModel = new RatesModel();
        $this->rofModel = new RateOtherFeesModel();
        $this->rateDuesModel = new RateDuesModel();
        $this->roomsModel = new RoomsModel();
        $this->session = session();
    }
    public function index()
    {
        $data = [
            'page_title' => 'Holy Cross College | Cashier Transaction',
            'page_heading' => 'CASHIER TRANSACTION! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user'))
        {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();

        if($this->request->is('post')) {
            $searchStudent = $this->request->getVar('searchstud');

            if($searchStudent == ''){
                $StudentsCondition = array('studisdel' => 0);
                $data['resultStudent'] = $this->studentsModel->where($StudentsCondition)->findAll();
                return view('cashierviewresult', $data);
            }
            else{
                $StudentsCondition = array('studisdel' => 0);
                $data['resultStudent'] = $this->studentsModel->where($StudentsCondition)
                ->like('studentno', $searchStudent)
                ->orLike('studln', $searchStudent)
                ->orLike('studfn', $searchStudent)
                ->orLike('studfullname', $searchStudent)
                ->findAll();
                return view('cashierviewresult', $data);
            }
        }

        return view('cashierview', $data);
    }
    public function transactionView($id=null)
    {
        $data = [
            'page_title' => 'Holy Cross College | Cashier Transaction View',
            'page_heading' => 'CASHIER TRANSACTION! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user'))
        {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();

        $data['assessmentData'] = $this->assModel->where('studentno', $id)->findAll();

        return view('cashiertransactionview', $data);
    }
    public function transactionViewOpen($id=null)
    {
        $data = [
            'page_title' => 'Holy Cross College | Cashier Transaction View Open',
            'page_heading' => 'CASHIER TRANSACTION! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user'))
        {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();

        $assessmentInfo = $this->assModel->where('assid', $id)->findAll();
        foreach($assessmentInfo as $assinfo){
            $studentNo = $assinfo['studentno'];
        }

        $data['assessmentData'] = $this->assModel->where('studentno', $studentNo)->findAll();
        $data['studentInfo'] = $this->studentsModel->where('studid', $studentNo)->findAll();
        $data['courseInfo'] = $this->coursesModel->findAll();

        $data['assessment'] = $this->assModel->where('studentno', $studentNo)
        ->where('status', 'Finalized')->findAll();
        foreach($data['assessment'] as $ass) {
            $ASSID = $ass['assid'];
            $SECTION = $ass['section'];
            $SY = $ass['sy'];
            $SEM = $ass['sem'];
            $LEVEL = $ass['level'];
            $COURSE = $ass['course'];
        }
        $data['students'] = $this->studentsModel->where('studid', $studentNo)->findAll();
        $data['colgradesdata'] = $this->colgradesModel->where('assid', $ASSID)->findAll();
        $data['subject'] = $this->subjectsModel->findAll();
        $data['schedule'] = $this->schedulesModel->findAll();
        $COURSEData = $this->coursesModel->where('courid', $COURSE)->findAll();
        foreach($COURSEData as $courd) {    
            $COURCODE = $courd['courcode'];
        }
        $data['ratesData'] = $this->ratesModel
        ->where('sy', $SY)
        ->where('sem', $SEM)
        ->where('year', $LEVEL)
        ->where('course', $COURCODE)->findAll();
        foreach($data['ratesData'] as $ratesD) {
            $RATESID = $ratesD['rateid'];
        }
        $data['rofdata'] = $this->rofModel->where('rateid', $RATESID)->findAll();
        $data['duedata'] = $this->rateDuesModel->where('rateid', $RATESID)->findAll();

        $data['totalmajorunits'] = $this->colgradesModel->select('
            SUM(subjects.units) as totalmajorunits, SUM(subjects.hours) as totalmajorhours
            ')->join('subjects', 'subjects.subid = collegegrades.subid')
            ->where('collegegrades.assid', $ASSID)
            ->where('subjects.major', 1)
            ->where('subjects.subcode !=', "NSTP01")
            ->where('subjects.subcode !=', "NSTP02")
            ->findAll();

        $data['totalminorunits'] = $this->colgradesModel->select('
            SUM(subjects.units) as totalminorunits, SUM(subjects.hours) as totalminorhours
            ')->join('subjects', 'subjects.subid = collegegrades.subid')
            ->where('collegegrades.assid', $ASSID)
            ->where('subjects.major', 0)
            ->where('subjects.subcode !=', "NSTP01")
            ->where('subjects.subcode !=', "NSTP02")
            ->findAll();

        return view('cashiertransactionviewopen', $data);
    }
}
