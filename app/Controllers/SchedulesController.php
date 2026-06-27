<?php

namespace App\Controllers;
use App\Models\UsersModel;
use App\Models\SchedulesModel;
use App\Models\SubjectsModel;
use App\Models\EmployeesModel;
use App\Models\RoomsModel;
use App\Models\CoursesModel;
use App\Models\SectionsModel;
use App\Models\CurriculumsModel;
use App\Models\CurriculumDataModel;
use App\Models\TeachersModel;
use App\Models\SYModel;
use App\Models\SemesterModel;
use App\Models\LevelsModel;

class SchedulesController extends BaseController
{
    public $usersModel;
    public $schedModel;
    public $subjModel;
    public $empModel;
    public $roomsModel;
    public $coursesModel;
    public $sectionsModel;
    public $curriculumModel;
    public $cdModel;
    public $syModel;
    public $session;
    public $semModel;
    public $levelModel;
    
    public function __construct() {
        helper('form');
        $this->usersModel = new UsersModel();
        $this->schedModel = new SchedulesModel();
        $this->subjModel = new SubjectsModel();
        $this->empModel = new EmployeesModel();
        $this->roomsModel = new RoomsModel();
        $this->coursesModel = new CoursesModel();
        $this->sectionsModel = new SectionsModel();
        $this->curriculumModel = new CurriculumsModel();
        $this->cdModel = new CurriculumDataModel();
        $this->syModel = new SYModel();
        $this->semModel = new SemesterModel();
        $this->levelModel = new LevelsModel();
        $this->sectionsModel = new SectionsModel();
        $this->session = session();
    }
    
    public function fetchsections() {
        $courid = $this->request->getPost('courid');
        $sections = $this->sectionsModel->where('course', $courid)
        ->orderBy('section', 'asc')
        ->findAll();
        echo json_encode($sections);
    }

    public function getSchedulesByCourse($courid) {
        // Fetch all schedules with the same course ID
        $schedules = $this->schedModel
            ->where('schedcourid', $courid)
            ->findAll();
        
        return $this->response->setJSON($schedules);
    }

    public function checkSubjectForSection() {
        if ($this->request->isAJAX()) {
            $subjectId = $this->request->getPost('subject_id');
            $secId = $this->request->getPost('section_id');
            
            // Check if there's already a schedule with this subject for the selected section
            $existingSchedule = $this->schedModel
                ->where('schedsubid', $subjectId)
                ->where('schedsecid', $secId)
                ->where('schedisdel', 0)
                ->first();
            
            if ($existingSchedule) {
                // Get subject details for better error message
                $subject = $this->subjModel->find($subjectId);
                $section = $this->sectionsModel->find($secId);
                
                return $this->response->setJSON([
                    'exists' => true,
                    'message' => "Subject '{$subject['subject']}' is already scheduled for section '{$section['section']}'. Duplicate subjects are only allowed for different sections.",
                    'subject_code' => $subject['subcode'] ?? '',
                    'subject_name' => $subject['subject'] ?? '',
                    'section_name' => $section['section'] ?? ''
                ]);
            }
            
            return $this->response->setJSON(['exists' => false]);
        }
        
        return $this->response->setJSON(['error' => 'Invalid request']);
    }

    public function generateFromCurriculum($id=null) {
        $data = [
            'page_title' => 'Holy Cross College | Schedules',
            'page_heading' => 'SCHEDULES! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];

        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();

        $usersinfo = $this->usersModel->where('uid', $uid)->findAll();
        
        $data['coursedata'] = $this->coursesModel->where('isdel', 0)->findAll();
        $data['sectiondata'] = $this->sectionsModel->where('isdel', 0)->findAll();
        $data['curriculumdata'] = $this->curriculumModel->where('isdel', 0)->findAll();
        $data['cddata'] = $this->cdModel->where('isdel', 0)->findAll();
        $data['subjectdata'] = $this->subjModel->where('isdel', 0)->findAll();
        $data['roomsdata'] = $this->roomsModel->where('roomisdel', 0)->findAll();
        $data['employeesdata'] = $this->empModel->where('empisdel', 0)->findAll();
        $data['scheduledata'] = $this->schedModel->where('schedisdel', 0)->findAll();
        $data['leveldata'] = $this->levelModel->where('levelisdel', 0)->findAll();
        $data['curriculumdata'] = $this->curriculumModel->where('isdel', 0)->groupBy('sy')->findAll();


        if($this->request->is('post')) {
            $rules = [
                'course' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Course is required.',
                    ],
                ],
                'section' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Section is required.',
                    ],
                ],
            ];
            if($this->validate($rules)) {
                $courseid = $this->request->getVar('course');
                $sectionid = $this->request->getVar('section');
                $curriculum = $this->request->getVar('curriculum');
                
                $this->session->set('selected_course', $courseid);
                $this->session->set('selected_section', $sectionid);
                $this->session->set('selected_curriculum', $curriculum);

                return redirect()->to(base_url().'generate-schedule-view');
            } else {
                $data['validation'] = $this->validator;
            }
        }
        
        return view('generateschedview', $data);

    }
    public function generateFromCurriculumView(){
        $data = [
            'page_title' => 'Holy Cross College | Schedules',
            'page_heading' => 'SCHEDULES! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];

        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $data['coursedata'] = $this->coursesModel->where('isdel', 0)->findAll();
        $data['sectiondata'] = $this->sectionsModel->where('isdel', 0)->findAll();
        $data['curriculumdata'] = $this->curriculumModel->where('isdel', 0)->findAll();
        $data['cddata'] = $this->cdModel->where('isdel', 0)->findAll();
        $data['subjectdata'] = $this->subjModel->where('isdel', 0)->findAll();
        $data['roomsdata'] = $this->roomsModel->where('roomisdel', 0)->findAll();
        $data['employeesdata'] = $this->empModel->where('empisdel', 0)->findAll();
        $data['scheduledata'] = $this->schedModel->where('schedisdel', 0)->findAll();
        $data['subjectsdata'] = $this->subjModel->where('isdel', 0)->findAll();
        $data['leveldata'] = $this->levelModel->where('levelisdel', 0)->findAll();
        $data['curriculumdata'] = $this->curriculumModel->where('isdel', 0)->groupBy('sy')->findAll();


        $courseid = session()->get('selected_course');
        $sectionid= session()->get('selected_section');
        $curriculum = session()->get('selected_curriculum');

        if($this->request->is('post')) {
            $rules = [
                'course' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Course is required.',
                    ],
                ],
                'section' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Section is required.',
                    ],
                ],
            ];
            if($this->validate($rules)) {

                $courseid = $this->request->getVar('course');
                $sectionid = $this->request->getVar('section');
                $curriculum = $this->request->getVar('curriculum');
                
                $this->session->set('selected_course', $courseid);
                $this->session->set('selected_section', $sectionid);
                $this->session->set('selected_curriculum', $curriculum);

                return redirect()->to(base_url().'generate-schedule-view');
            } else {
                $data['validation'] = $this->validator;
            }
        }

        $data['selectedCourse'] = $this->coursesModel->where('courid', $courseid)->findAll();
        $data['selectedSection'] = $this->sectionsModel->where('secid', $sectionid)->findAll();
        $data['selectedCurriculum'] = $this->curriculumModel->where('sy', $curriculum)->findAll();
        $selectedSection = $this->sectionsModel->where('secid', $sectionid)->findAll();

        foreach($selectedSection as $sects){
            $levelid = $sects['level'];
        }

        $data['selectedSubjects'] = $this->cdModel->select('currdata.*,subjects.*,curriculum.*')
        ->join('curriculum', 'currdata.curriculumid = curriculum.currid', 'left')
        ->join('subjects', 'currdata.subid = subjects.subid', 'left')
        // ->join('sections', 'currdata.level = sections.level', 'left')
        ->where('curriculum.course', $courseid)
        ->where('currdata.level', $levelid)
        ->where('curriculum.sy', $curriculum)
        ->where('curriculum.isdel', "0")
        ->where('currdata.sem', "1st Semester")
        ->groupBy('currdata.subid')
        ->findAll();

        // select subjects.subject, curriculum.course, currdata.curriculumid, curriculum.sy from curriculum left join currdata on 
        // currdata.curriculumid = curriculum.currid left join subjects on 
        // subjects.subid = currdata.subid where curriculum.course = "1" and curriculum.isdel ="0" and currdata.level = "1st Year" and curriculum.sy="2026-2027";

        
        return view('generateschedview2', $data);
    }

    public function addSchedule($id=null)
        {
        $data = [
            'page_title' => 'Holy Cross College | Schedules',
            'page_heading' => 'SCHEDULES! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        
        if(!session()->has('logged_user'))
        {
            return redirect()->to(base_url());
        }
        
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        
        $data['scheduledata'] = $this->schedModel->where('schedisdel', 0)->groupBy('schedsecid')->findAll();
        $data['scheduledata2'] = $this->schedModel->where('schedisdel', 0)->findAll();
        $data['subjectsdata'] = $this->subjModel->where('isdel', 0)->findAll();

        $employeeCondition = array('empisdel' => 0,);

        $data['employeesdata'] = $this->empModel->where($employeeCondition)->findAll();
        $data['roomsdata'] = $this->roomsModel->where('roomisdel', 0)->findAll();
        $data['coursedata'] = $this->coursesModel->where('isdel', 0)->findAll();
        $data['sectiondata'] = $this->sectionsModel->where('isdel', 0)->findAll();
        $data['leveldata'] = $this->levelModel->where('levelisdel', 0)->findAll();
        $data['curriculumdata'] = $this->curriculumModel->where('isdel', 0)->groupBy('sy')->findAll();

        if($this->request->is('post')) {
            $rules = [
                'section' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Section is required.',
                    ],
                ],
                'maxstudent' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Max student count is required.',
                    ],
                ],
                'day' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Day is required.',
                    ],
                ],
                'timein' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Time in is required.',
                    ],
                ],
                'timeout' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Time out is required.',
                    ],
                ],
                'room' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Room is required.',
                    ],
                ],
            ];

            if($this->validate($rules)) {
                
                $course = $this->request->getVar('course');
                $section = $this->request->getVar('section');
                $subject = $this->request->getVar('subject');
                $teacher = $this->request->getVar('teacher');
                $room = $this->request->getVar('room');
                $room2 = $this->request->getVar('room2');
                $room3 = $this->request->getVar('room3');
                $day = $this->request->getVar('day');
                $day2 = $this->request->getVar('day2');
                $day3 = $this->request->getVar('day3');
                $timein = $this->request->getVar('timein');
                $timeout = $this->request->getVar('timeout');
                $timein2 = $this->request->getVar('timein2');
                $timeout2 = $this->request->getVar('timeout2');
                $timein3 = $this->request->getVar('timein3');
                $timeout3 = $this->request->getVar('timeout3');

                // NEW FEATURE: Check if subject already exists for this course
                $existingSubjectForSection = $this->schedModel
                    ->where('schedsubid', $subject)
                    ->where('schedsecid', $section)
                    ->where('schedisdel', 0)
                    ->first();
                
                if ($existingSubjectForSection) {
                    $subjectDetails = $this->subjModel->find($subject);
                    $sectionDetails = $this->sectionsModel->find($section);
                    session()->setTempdata('subjectConflict', 
                        "Subject '{$subjectDetails['subject']}' is already scheduled for section '{$sectionDetails['section']}'. Duplicate subjects are only allowed for different sections.", 3);
                    return redirect()->to(current_url());
                }

                // Check for conflicts
                $hasConflict = false;
                
                // Collect all time slots from the current schedule
                $currentTimeSlots = [];
                
                // Slot 1 (required)
                $currentTimeSlots[] = [
                    'day' => $day, 
                    'timein' => $timein, 
                    'timeout' => $timeout, 
                    'room' => $room,
                    'slot_number' => 1
                ];
                
                // Slot 2 (optional)
                if(!empty($day2) && !empty($timein2) && !empty($timeout2)) {
                    $roomForSlot2 = !empty($room2) ? $room2 : $room;
                    $currentTimeSlots[] = [
                        'day' => $day2, 
                        'timein' => $timein2, 
                        'timeout' => $timeout2, 
                        'room' => $roomForSlot2,
                        'slot_number' => 2
                    ];
                }
                
                // Slot 3 (optional)
                if(!empty($day3) && !empty($timein3) && !empty($timeout3)) {
                    $roomForSlot3 = !empty($room3) ? $room3 : $room;
                    $currentTimeSlots[] = [
                        'day' => $day3, 
                        'timein' => $timein3, 
                        'timeout' => $timeout3, 
                        'room' => $roomForSlot3,
                        'slot_number' => 3
                    ];
                }

                // CHECK 1: INTERNAL CONFLICTS (within the new schedule)
                for ($i = 0; $i < count($currentTimeSlots); $i++) {
                    for ($j = $i + 1; $j < count($currentTimeSlots); $j++) {
                        $slot1 = $currentTimeSlots[$i];
                        $slot2 = $currentTimeSlots[$j];
                        
                        if ($slot1['day'] == $slot2['day']) {
                            if ($this->checkTimeConflict(
                                $slot1['day'], $slot1['timein'], $slot1['timeout'],
                                $slot2['day'], $slot2['timein'], $slot2['timeout']
                            )) {
                                $hasConflict = true;
                                session()->setTempdata('internalConflict', 
                                    "Internal conflict: Time Slot {$slot1['slot_number']} and Time Slot {$slot2['slot_number']} overlap on {$slot1['day']}.", 3);
                                break 2;
                            }
                        }
                    }
                }

                // CHECK 2: EXTERNAL CONFLICTS (with existing schedules)
                if (!$hasConflict) {
                    $existingSchedules = $this->schedModel->where('schedisdel', 0)->findAll();

                    foreach ($currentTimeSlots as $currentSlot) {
                        foreach ($existingSchedules as $existing) {
                            $existingSlots = [];
                            
                            if (!empty($existing['schedday'])) {
                                $existingSlots[] = [
                                    'day' => $existing['schedday'],
                                    'timein' => $existing['schedtimeF'],
                                    'timeout' => $existing['schedtimeT'],
                                    'room' => $existing['schedroom']
                                ];
                            }
                            
                            if (!empty($existing['schedday2']) && !empty($existing['schedtimeF2']) && !empty($existing['schedtimeT2'])) {
                                $existingSlots[] = [
                                    'day' => $existing['schedday2'],
                                    'timein' => $existing['schedtimeF2'],
                                    'timeout' => $existing['schedtimeT2'],
                                    'room' => $existing['schedroom2']
                                ];
                            }
                            
                            if (!empty($existing['schedday3']) && !empty($existing['schedtimeF3']) && !empty($existing['schedtimeT3'])) {
                                $existingSlots[] = [
                                    'day' => $existing['schedday3'],
                                    'timein' => $existing['schedtimeF3'],
                                    'timeout' => $existing['schedtimeT3'],
                                    'room' => $existing['schedroom3']
                                ];
                            }
                            
                            foreach ($existingSlots as $existingSlot) {
                                if (!$this->isExemptFromConflicts('room', $currentSlot['room'])) {
                                    if ($currentSlot['room'] == $existingSlot['room']) {
                                        if ($this->checkTimeConflict(
                                            $currentSlot['day'], $currentSlot['timein'], $currentSlot['timeout'],
                                            $existingSlot['day'], $existingSlot['timein'], $existingSlot['timeout']
                                        )) {
                                            $hasConflict = true;
                                            session()->setTempdata('roomConflict', 
                                                "Room conflict: Room {$currentSlot['room']} is already occupied on {$currentSlot['day']} from " . 
                                                date('h:iA', strtotime($currentSlot['timein'])) . " to " . 
                                                date('h:iA', strtotime($currentSlot['timeout'])), 3);
                                            break 3;
                                        }
                                    }
                                }
                                if (!$this->isExemptFromConflicts('teacher', $teacher)) {
                                    if (!empty($teacher) && $teacher == $existing['schedteacher']) {
                                        if ($this->checkTimeConflict(
                                            $currentSlot['day'], $currentSlot['timein'], $currentSlot['timeout'],
                                            $existingSlot['day'], $existingSlot['timein'], $existingSlot['timeout']
                                        )) {
                                            $hasConflict = true;
                                            session()->setTempdata('teacherConflict', 
                                                "Teacher conflict: Teacher {$teacher} already has a class on {$currentSlot['day']} from " . 
                                                date('h:iA', strtotime($currentSlot['timein'])) . " to " . 
                                                date('h:iA', strtotime($currentSlot['timeout'])), 3);
                                            break 3;
                                        }
                                    }
                                }
                                
                                if ($section == $existing['schedsecid']) {
                                    if ($this->checkTimeConflict(
                                        $currentSlot['day'], $currentSlot['timein'], $currentSlot['timeout'],
                                        $existingSlot['day'], $existingSlot['timein'], $existingSlot['timeout']
                                    )) {
                                        $hasConflict = true;
                                        session()->setTempdata('sectionConflict', 
                                            "Section conflict: Section already has a class on {$currentSlot['day']} from " . 
                                            date('h:iA', strtotime($currentSlot['timein'])) . " to " . 
                                            date('h:iA', strtotime($currentSlot['timeout'])), 3);
                                        break 3;
                                    }
                                }
                            }
                        }
                    }
                }

                if (!$hasConflict) {
                    // No conflicts, save the schedule
                    $scheddata = [
                        'schedcourid' => $course,
                        'schedsubid' => $subject,
                        'schedsecid' => $section,
                        'schedday' => $day,
                        'schedday2' => !empty($day2) ? $day2 : null,
                        'schedday3' => !empty($day3) ? $day3 : null,
                        'schedroom' => $room,
                        'schedroom2' => !empty($room2) ? $room2 : null,
                        'schedroom3' => !empty($room3) ? $room3 : null,
                        'schedteacher' => $teacher,
                        'schedtimeF' => $timein,
                        'schedtimeT' => $timeout,
                        'schedtimeF2' => !empty($timein2) ? $timein2 : null,
                        'schedtimeT2' => !empty($timeout2) ? $timeout2 : null,
                        'schedtimeF3' => !empty($timein3) ? $timein3 : null,
                        'schedtimeT3' => !empty($timeout3) ? $timeout3 : null,
                        'schedmaxstudent' => $this->request->getVar('maxstudent'),
                        'schedstatus' => '0',
                        'schedisdel' => '0',
                    ];
                    
                    $this->schedModel->save($scheddata);
                    session()->setTempdata('addsuccess', 'Schedule is added successfully', 3);
                }
                return redirect()->to(current_url());
            } else {
                $data['validation'] = $this->validator;
            }
        }

        return view('schedulesview', $data);
    }
    
    public function index($id=null)
        {
        $data = [
            'page_title' => 'Holy Cross College | Schedules',
            'page_heading' => 'SCHEDULES! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        
        if(!session()->has('logged_user'))
        {
            return redirect()->to(base_url());
        }
        
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        
        $data['scheduledata'] = $this->schedModel->where('schedisdel', 0)->groupBy('schedsecid')->findAll();
        $data['scheduledata2'] = $this->schedModel->where('schedisdel', 0)->findAll();
        $data['subjectsdata'] = $this->subjModel->where('isdel', 0)->findAll();

        $employeeCondition = array('empisdel' => 0,);

        $data['employeesdata'] = $this->empModel->where($employeeCondition)->findAll();
        $data['roomsdata'] = $this->roomsModel->where('roomisdel', 0)->findAll();
        $data['coursedata'] = $this->coursesModel->where('isdel', 0)->findAll();
        $data['sectiondata'] = $this->sectionsModel->where('isdel', 0)->findAll();
        $data['leveldata'] = $this->levelModel->where('levelisdel', 0)->findAll();
        $data['curriculumdata'] = $this->curriculumModel->where('isdel', 0)->groupBy('sy')->findAll();

        if($this->request->is('post')) {
            $rules = [
                'section' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Section is required.',
                    ],
                ],
                'maxstudent' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Max student count is required.',
                    ],
                ],
                'day' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Day is required.',
                    ],
                ],
                'timein' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Time in is required.',
                    ],
                ],
                'timeout' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Time out is required.',
                    ],
                ],
                'room' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Room is required.',
                    ],
                ],
            ];

            if($this->validate($rules)) {
                
                $course = $this->request->getVar('course');
                $section = $this->request->getVar('section');
                $subject = $this->request->getVar('subject');
                $teacher = $this->request->getVar('teacher');
                $room = $this->request->getVar('room');
                $room2 = $this->request->getVar('room2');
                $room3 = $this->request->getVar('room3');
                $day = $this->request->getVar('day');
                $day2 = $this->request->getVar('day2');
                $day3 = $this->request->getVar('day3');
                $timein = $this->request->getVar('timein');
                $timeout = $this->request->getVar('timeout');
                $timein2 = $this->request->getVar('timein2');
                $timeout2 = $this->request->getVar('timeout2');
                $timein3 = $this->request->getVar('timein3');
                $timeout3 = $this->request->getVar('timeout3');

                // NEW FEATURE: Check if subject already exists for this course
                $existingSubjectForSection = $this->schedModel
                    ->where('schedsubid', $subject)
                    ->where('schedsecid', $section)
                    ->where('schedisdel', 0)
                    ->first();
                
                if ($existingSubjectForSection) {
                    $subjectDetails = $this->subjModel->find($subject);
                    $sectionDetails = $this->sectionsModel->find($section);
                    session()->setTempdata('subjectConflict', 
                        "Subject '{$subjectDetails['subject']}' is already scheduled for section '{$sectionDetails['section']}'. Duplicate subjects are only allowed for different sections.", 3);
                    return redirect()->to(current_url());
                }

                // Check for conflicts
                $hasConflict = false;
                
                // Collect all time slots from the current schedule
                $currentTimeSlots = [];
                
                // Slot 1 (required)
                $currentTimeSlots[] = [
                    'day' => $day, 
                    'timein' => $timein, 
                    'timeout' => $timeout, 
                    'room' => $room,
                    'slot_number' => 1
                ];
                
                // Slot 2 (optional)
                if(!empty($day2) && !empty($timein2) && !empty($timeout2)) {
                    $roomForSlot2 = !empty($room2) ? $room2 : $room;
                    $currentTimeSlots[] = [
                        'day' => $day2, 
                        'timein' => $timein2, 
                        'timeout' => $timeout2, 
                        'room' => $roomForSlot2,
                        'slot_number' => 2
                    ];
                }
                
                // Slot 3 (optional)
                if(!empty($day3) && !empty($timein3) && !empty($timeout3)) {
                    $roomForSlot3 = !empty($room3) ? $room3 : $room;
                    $currentTimeSlots[] = [
                        'day' => $day3, 
                        'timein' => $timein3, 
                        'timeout' => $timeout3, 
                        'room' => $roomForSlot3,
                        'slot_number' => 3
                    ];
                }

                // CHECK 1: INTERNAL CONFLICTS (within the new schedule)
                for ($i = 0; $i < count($currentTimeSlots); $i++) {
                    for ($j = $i + 1; $j < count($currentTimeSlots); $j++) {
                        $slot1 = $currentTimeSlots[$i];
                        $slot2 = $currentTimeSlots[$j];
                        
                        if ($slot1['day'] == $slot2['day']) {
                            if ($this->checkTimeConflict(
                                $slot1['day'], $slot1['timein'], $slot1['timeout'],
                                $slot2['day'], $slot2['timein'], $slot2['timeout']
                            )) {
                                $hasConflict = true;
                                session()->setTempdata('internalConflict', 
                                    "Internal conflict: Time Slot {$slot1['slot_number']} and Time Slot {$slot2['slot_number']} overlap on {$slot1['day']}.", 3);
                                break 2;
                            }
                        }
                    }
                }

                // CHECK 2: EXTERNAL CONFLICTS (with existing schedules)
                if (!$hasConflict) {
                    $existingSchedules = $this->schedModel->where('schedisdel', 0)->findAll();

                    foreach ($currentTimeSlots as $currentSlot) {
                        foreach ($existingSchedules as $existing) {
                            $existingSlots = [];
                            
                            if (!empty($existing['schedday'])) {
                                $existingSlots[] = [
                                    'day' => $existing['schedday'],
                                    'timein' => $existing['schedtimeF'],
                                    'timeout' => $existing['schedtimeT'],
                                    'room' => $existing['schedroom']
                                ];
                            }
                            
                            if (!empty($existing['schedday2']) && !empty($existing['schedtimeF2']) && !empty($existing['schedtimeT2'])) {
                                $existingSlots[] = [
                                    'day' => $existing['schedday2'],
                                    'timein' => $existing['schedtimeF2'],
                                    'timeout' => $existing['schedtimeT2'],
                                    'room' => $existing['schedroom2']
                                ];
                            }
                            
                            if (!empty($existing['schedday3']) && !empty($existing['schedtimeF3']) && !empty($existing['schedtimeT3'])) {
                                $existingSlots[] = [
                                    'day' => $existing['schedday3'],
                                    'timein' => $existing['schedtimeF3'],
                                    'timeout' => $existing['schedtimeT3'],
                                    'room' => $existing['schedroom3']
                                ];
                            }
                            
                            foreach ($existingSlots as $existingSlot) {
                                if (!$this->isExemptFromConflicts('room', $currentSlot['room'])) {
                                    if ($currentSlot['room'] == $existingSlot['room']) {
                                        if ($this->checkTimeConflict(
                                            $currentSlot['day'], $currentSlot['timein'], $currentSlot['timeout'],
                                            $existingSlot['day'], $existingSlot['timein'], $existingSlot['timeout']
                                        )) {
                                            $hasConflict = true;
                                            session()->setTempdata('roomConflict', 
                                                "Room conflict: Room {$currentSlot['room']} is already occupied on {$currentSlot['day']} from " . 
                                                date('h:iA', strtotime($currentSlot['timein'])) . " to " . 
                                                date('h:iA', strtotime($currentSlot['timeout'])), 3);
                                            break 3;
                                        }
                                    }
                                }
                                if (!$this->isExemptFromConflicts('teacher', $teacher)) {
                                    if (!empty($teacher) && $teacher == $existing['schedteacher']) {
                                        if ($this->checkTimeConflict(
                                            $currentSlot['day'], $currentSlot['timein'], $currentSlot['timeout'],
                                            $existingSlot['day'], $existingSlot['timein'], $existingSlot['timeout']
                                        )) {
                                            $hasConflict = true;
                                            session()->setTempdata('teacherConflict', 
                                                "Teacher conflict: Teacher {$teacher} already has a class on {$currentSlot['day']} from " . 
                                                date('h:iA', strtotime($currentSlot['timein'])) . " to " . 
                                                date('h:iA', strtotime($currentSlot['timeout'])), 3);
                                            break 3;
                                        }
                                    }
                                }
                                
                                if ($section == $existing['schedsecid']) {
                                    if ($this->checkTimeConflict(
                                        $currentSlot['day'], $currentSlot['timein'], $currentSlot['timeout'],
                                        $existingSlot['day'], $existingSlot['timein'], $existingSlot['timeout']
                                    )) {
                                        $hasConflict = true;
                                        session()->setTempdata('sectionConflict', 
                                            "Section conflict: Section already has a class on {$currentSlot['day']} from " . 
                                            date('h:iA', strtotime($currentSlot['timein'])) . " to " . 
                                            date('h:iA', strtotime($currentSlot['timeout'])), 3);
                                        break 3;
                                    }
                                }
                            }
                        }
                    }
                }

                if (!$hasConflict) {
                    // No conflicts, save the schedule
                    $scheddata = [
                        'schedcourid' => $course,
                        'schedsubid' => $subject,
                        'schedsecid' => $section,
                        'schedday' => $day,
                        'schedday2' => !empty($day2) ? $day2 : null,
                        'schedday3' => !empty($day3) ? $day3 : null,
                        'schedroom' => $room,
                        'schedroom2' => !empty($room2) ? $room2 : null,
                        'schedroom3' => !empty($room3) ? $room3 : null,
                        'schedteacher' => $teacher,
                        'schedtimeF' => $timein,
                        'schedtimeT' => $timeout,
                        'schedtimeF2' => !empty($timein2) ? $timein2 : null,
                        'schedtimeT2' => !empty($timeout2) ? $timeout2 : null,
                        'schedtimeF3' => !empty($timein3) ? $timein3 : null,
                        'schedtimeT3' => !empty($timeout3) ? $timeout3 : null,
                        'schedmaxstudent' => $this->request->getVar('maxstudent'),
                        'schedstatus' => '0',
                        'schedisdel' => '0',
                    ];
                    
                    $this->schedModel->save($scheddata);
                    session()->setTempdata('addsuccess', 'Schedule is added successfully', 3);
                }
                return redirect()->to(current_url());
            } else {
                $data['validation'] = $this->validator;
            }
        }

        return view('schedulesview', $data);
    }

    private function isExemptFromConflicts($type, $value) {
        // Define exempt values for different types
        $exemptValues = [
            'room' => ['UNDETERMINED'],
            'teacher' => ['TBA'],
        ];
        
        return in_array($value, $exemptValues[$type]);
    }

    private function checkTimeConflict($day1, $timeStart1, $timeEnd1, $day2, $timeStart2, $timeEnd2) 
        {
        // First check if days are the same
        if ($day1 != $day2) {
            return false;
        }

        // Convert times to minutes for comparison
        $start1 = $this->timeToMinutes($timeStart1);
        $end1 = $this->timeToMinutes($timeEnd1);
        $start2 = $this->timeToMinutes($timeStart2);
        $end2 = $this->timeToMinutes($timeEnd2);


        // Check for overlap
        return ($start1 < $end2 && $end1 > $start2);
    }

    // Helper function to convert time string to minutes
    private function timeToMinutes($time)
        {
        if (empty($time)) return 0;
        
        $time = trim($time);
        $parts = explode(':', $time);
        
        if (count($parts) >= 2) {
            $hours = (int)$parts[0];
            $minutes = (int)$parts[1];
            
            // Handle AM/PM if present
            if (strpos($time, 'PM') !== false && $hours < 12) {
                $hours += 12;
            } elseif (strpos($time, 'AM') !== false && $hours == 12) {
                $hours = 0;
            }
            
            return ($hours * 60) + $minutes;
        }
        
        return 0;
    }

    public function deleteSchedule($id=null){
        $data = [
            'schedisdel' => '1',
        ];

        $this->schedModel->where('schedid', $id)->update($id, $data);
        session()->setTempdata('deletesuccess', 'Schedule is deleted!', 2);
        return redirect()->to(base_url()."schedules");
    }

    public function updateSched($id=null) 
        {
        $data = [
            'page_title' => 'Holy Cross College | Schedules',
            'page_heading' => 'SCHEDULES! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        
        if(!session()->has('logged_user'))
        {
            return redirect()->to(base_url());
        }
        
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $data['scheduledata'] = $this->schedModel->where('schedisdel', 0)->findAll();
        $data['subjectsdata'] = $this->subjModel->where('isdel', 0)->findAll();

        $employeeCondition = array('empisdel' => 0,);

        $data['employeesdata'] = $this->empModel->where($employeeCondition)->findAll();
        $data['roomsdata'] = $this->roomsModel->where('roomisdel', 0)->findAll();
        $data['coursedata'] = $this->coursesModel->where('isdel', 0)->findAll();
        $data['sectiondata'] = $this->sectionsModel->where('isdel', 0)->findAll();
        $data['leveldata'] = $this->levelModel->where('levelisdel', 0)->findAll();
        
        if($this->request->is('post')) {

            $rules = [
                'section' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Section is required.',
                    ],
                ],
                'maxstudent' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Max student count is required.',
                    ],
                ],
                'day' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Day is required.',
                    ],
                ],
                'timein' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Time in is required.',
                    ],
                ],
                'timeout' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Time out is required.',
                    ],
                ],
                'room' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Room is required.',
                    ],
                ],
            ];

            if($this->validate($rules)) {
                
                $course = $this->request->getVar('course');
                $section = $this->request->getVar('section');
                $subject = $this->request->getVar('subject');
                $teacher = $this->request->getVar('teacher');
                $room = $this->request->getVar('room');
                $room2 = $this->request->getVar('room2');
                $room3 = $this->request->getVar('room3');
                $day = $this->request->getVar('day');
                $day2 = $this->request->getVar('day2');
                $day3 = $this->request->getVar('day3');
                $timein = $this->request->getVar('timein');
                $timeout = $this->request->getVar('timeout');
                $timein2 = $this->request->getVar('timein2');
                $timeout2 = $this->request->getVar('timeout2');
                $timein3 = $this->request->getVar('timein3');
                $timeout3 = $this->request->getVar('timeout3');

                // NEW FEATURE: Check if subject already exists for this course (excluding current schedule)
                $existingSubjectForSection = $this->schedModel
                    ->where('schedsubid', $subject)
                    ->where('schedsecid', $section)
                    ->where('schedisdel', 0)
                    ->where('schedid !=', $id)
                    ->first();
                
                if ($existingSubjectForSection) {
                    $subjectDetails = $this->subjModel->find($subject);
                    $sectionDetails = $this->sectionsModel->find($section);
                    session()->setTempdata('subjectConflict', 
                        "Subject '{$subjectDetails['subject']}' is already scheduled for section '{$sectionDetails['section']}'. Duplicate subjects are only allowed for different sections.", 3);
                    return redirect()->to(base_url('schedules'));
                }

                // Check for conflicts
                $hasConflict = false;
                
                // Collect all time slots from the current schedule being updated
                $currentTimeSlots = [];
                
                // Slot 1 (required)
                $currentTimeSlots[] = [
                    'day' => $day, 
                    'timein' => $timein, 
                    'timeout' => $timeout, 
                    'room' => $room,
                    'slot_number' => 1
                ];
                
                // Slot 2 (optional)
                if(!empty($day2) && !empty($timein2) && !empty($timeout2)) {
                    $roomForSlot2 = !empty($room2) ? $room2 : $room;
                    $currentTimeSlots[] = [
                        'day' => $day2, 
                        'timein' => $timein2, 
                        'timeout' => $timeout2, 
                        'room' => $roomForSlot2,
                        'slot_number' => 2
                    ];
                }
                
                // Slot 3 (optional)
                if(!empty($day3) && !empty($timein3) && !empty($timeout3)) {
                    $roomForSlot3 = !empty($room3) ? $room3 : $room;
                    $currentTimeSlots[] = [
                        'day' => $day3, 
                        'timein' => $timein3, 
                        'timeout' => $timeout3, 
                        'room' => $roomForSlot3,
                        'slot_number' => 3
                    ];
                }

                // CHECK 1: INTERNAL CONFLICTS (within the current schedule)
                // Check if any time slots within the same schedule conflict with each other
                for ($i = 0; $i < count($currentTimeSlots); $i++) {
                    for ($j = $i + 1; $j < count($currentTimeSlots); $j++) {
                        $slot1 = $currentTimeSlots[$i];
                        $slot2 = $currentTimeSlots[$j];
                        
                        // Check if the days are the same and times overlap
                        if ($slot1['day'] == $slot2['day']) {
                            if ($this->checkTimeConflict(
                                $slot1['day'], $slot1['timein'], $slot1['timeout'],
                                $slot2['day'], $slot2['timein'], $slot2['timeout']
                            )) {
                                $hasConflict = true;
                                session()->setTempdata('internalConflict', 
                                    "Internal conflict: Time Slot {$slot1['slot_number']} and Time Slot {$slot2['slot_number']} overlap on {$slot1['day']}.", 3);
                                break 2;
                            }
                        }
                    }
                }

                // CHECK 2: EXTERNAL CONFLICTS (with other schedules)
                // Only proceed with external checks if no internal conflicts
                if (!$hasConflict) {
                    // Get all other schedules (excluding current one)
                    $otherSchedules = $this->schedModel
                        ->where('schedisdel', 0)
                        ->where('schedid !=', $id)
                        ->findAll();

                    // Check each time slot against other schedules
                    foreach ($currentTimeSlots as $currentSlot) {
                        
                        // Check room conflicts with other schedules
                        foreach ($otherSchedules as $existing) {
                            // Check existing schedule's time slots
                            $existingSlots = [];
                            
                            // Existing slot 1
                            if (!empty($existing['schedday'])) {
                                $existingSlots[] = [
                                    'day' => $existing['schedday'],
                                    'timein' => $existing['schedtimeF'],
                                    'timeout' => $existing['schedtimeT'],
                                    'room' => $existing['schedroom']
                                ];
                            }
                            
                            // Existing slot 2
                            if (!empty($existing['schedday2']) && !empty($existing['schedtimeF2']) && !empty($existing['schedtimeT2'])) {
                                $existingSlots[] = [
                                    'day' => $existing['schedday2'],
                                    'timein' => $existing['schedtimeF2'],
                                    'timeout' => $existing['schedtimeT2'],
                                    'room' => $existing['schedroom2']
                                ];
                            }
                            
                            // Existing slot 3
                            if (!empty($existing['schedday3']) && !empty($existing['schedtimeF3']) && !empty($existing['schedtimeT3'])) {
                                $existingSlots[] = [
                                    'day' => $existing['schedday3'],
                                    'timein' => $existing['schedtimeF3'],
                                    'timeout' => $existing['schedtimeT3'],
                                    'room' => $existing['schedroom3']
                                ];
                            }
                            
                            // Check conflicts for each existing slot
                            foreach ($existingSlots as $existingSlot) {
                                // Check room conflict
                                if ($currentSlot['room'] == $existingSlot['room']) {
                                    if ($this->checkTimeConflict(
                                        $currentSlot['day'], $currentSlot['timein'], $currentSlot['timeout'],
                                        $existingSlot['day'], $existingSlot['timein'], $existingSlot['timeout']
                                    )) {
                                        $hasConflict = true;
                                        session()->setTempdata('roomConflict', 
                                            "Room conflict: Room {$currentSlot['room']} is already occupied on {$currentSlot['day']} from " . 
                                            date('h:iA', strtotime($currentSlot['timein'])) . " to " . 
                                            date('h:iA', strtotime($currentSlot['timeout'])) . " in schedule ID: {$existing['schedid']}", 3);
                                        break 3;
                                    }
                                }
                                
                                // Check teacher conflict
                                if (!empty($teacher) && $teacher == $existing['schedteacher']) {
                                    if ($this->checkTimeConflict(
                                        $currentSlot['day'], $currentSlot['timein'], $currentSlot['timeout'],
                                        $existingSlot['day'], $existingSlot['timein'], $existingSlot['timeout']
                                    )) {
                                        $hasConflict = true;
                                        session()->setTempdata('teacherConflict', 
                                            "Teacher conflict: Teacher {$teacher} already has a class on {$currentSlot['day']} from " . 
                                            date('h:iA', strtotime($currentSlot['timein'])) . " to " . 
                                            date('h:iA', strtotime($currentSlot['timeout'])) . " in schedule ID: {$existing['schedid']}", 3);
                                        break 3;
                                    }
                                }
                                
                                // Check section conflict
                                if ($section == $existing['schedsecid']) {
                                    if ($this->checkTimeConflict(
                                        $currentSlot['day'], $currentSlot['timein'], $currentSlot['timeout'],
                                        $existingSlot['day'], $existingSlot['timein'], $existingSlot['timeout']
                                    )) {
                                        $hasConflict = true;
                                        session()->setTempdata('sectionConflict', 
                                            "Section conflict: Section already has a class on {$currentSlot['day']} from " . 
                                            date('h:iA', strtotime($currentSlot['timein'])) . " to " . 
                                            date('h:iA', strtotime($currentSlot['timeout'])) . " in schedule ID: {$existing['schedid']}", 3);
                                        break 3;
                                    }
                                }
                            }
                        }
                    }
                }
            
                if (!$hasConflict) {
                    // No conflicts, update the schedule
                    $scheddata = [
                        'schedcourid' => $course,
                        'schedsubid' => $subject,
                        'schedsecid' => $section,
                        'schedday' => $day,
                        'schedday2' => !empty($day2) ? $day2 : null,
                        'schedday3' => !empty($day3) ? $day3 : null,
                        'schedroom' => $room,
                        'schedroom2' => !empty($room2) ? $room2 : null,
                        'schedroom3' => !empty($room3) ? $room3 : null,
                        'schedteacher' => $teacher,
                        'schedtimeF' => $timein,
                        'schedtimeT' => $timeout,
                        'schedtimeF2' => !empty($timein2) ? $timein2 : null,
                        'schedtimeT2' => !empty($timeout2) ? $timeout2 : null,
                        'schedtimeF3' => !empty($timein3) ? $timein3 : null,
                        'schedtimeT3' => !empty($timeout3) ? $timeout3 : null,
                        'schedmaxstudent' => $this->request->getVar('maxstudent'),
                        'schedstatus' => '0',
                    ];

                    // Update the schedule
                    if ($this->schedModel->update($id, $scheddata)) {
                        session()->setTempdata('updatesuccess', 'Schedule updated successfully!', 2);
                    } else {
                        session()->setTempdata('updateerror', 'Failed to update schedule!', 2);
                    }
                    return redirect()->to(base_url('schedules'));
                } else {
                    // If there are conflicts, redirect back with error messages
                    return redirect()->to(base_url('schedules'));
                }
            } else {
                // Validation failed
                $data['validation'] = $this->validator;
                return view('schedulesview', $data);
            }
        }
        
        return view('schedulesview', $data);
    }
    public function downloadExcel($secid = null) {
        // Check if user is logged in
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        
        // Get schedule data for the selected section
        $schedules = $this->schedModel
            ->where('schedisdel', 0)
            ->where('schedsecid', $secid)
            ->findAll();
        
        if (empty($schedules)) {
            session()->setTempdata('error', 'No schedule data found for export.', 3);
            return redirect()->to(base_url('schedules'));
        }
        
        // Get section and course details
        $section = $this->sectionsModel->where('secid', $secid)->first();
        $course = $this->coursesModel->where('courid', $section['course'])->first();
        
        // Prepare data for Excel
        $excelData = [];
        
        // Add header row
        $excelData[] = [
            'SUBJECT CODE',
            'SUBJECT',
            'UNITS',
            'HOURS',
            'COURSE',
            'SECTION',
            'ROOM',
            'TEACHER',
            'DAY & TIME (SLOT 1)',
            'DAY & TIME (SLOT 2)',
            'DAY & TIME (SLOT 3)',
            'MAX STUDENTS'
        ];
        
        // Add data rows
        foreach ($schedules as $schedule) {
            // Get subject details
            $subject = $this->subjModel->where('subid', $schedule['schedsubid'])->first();
            
            // Format time slots
            $slot1 = '';
            if (!empty($schedule['schedday']) && !empty($schedule['schedtimeF'])) {
                $slot1 = $schedule['schedday'] . ' | ' . 
                        date('h:i A', strtotime($schedule['schedtimeF'])) . ' - ' . 
                        date('h:i A', strtotime($schedule['schedtimeT']));
            }
            
            $slot2 = '';
            if (!empty($schedule['schedday2']) && !empty($schedule['schedtimeF2']) && $schedule['schedtimeF2'] != '00:00:00') {
                $slot2 = $schedule['schedday2'] . ' | ' . 
                        date('h:i A', strtotime($schedule['schedtimeF2'])) . ' - ' . 
                        date('h:i A', strtotime($schedule['schedtimeT2']));
            }
            
            $slot3 = '';
            if (!empty($schedule['schedday3']) && !empty($schedule['schedtimeF3']) && $schedule['schedtimeF3'] != '00:00:00') {
                $slot3 = $schedule['schedday3'] . ' | ' . 
                        date('h:i A', strtotime($schedule['schedtimeF3'])) . ' - ' . 
                        date('h:i A', strtotime($schedule['schedtimeT3']));
            }
            
            // Format room display
            $roomDisplay = $schedule['schedroom'];
            if (!empty($schedule['schedroom2'])) {
                $roomDisplay .= ', ' . $schedule['schedroom2'];
            }
            if (!empty($schedule['schedroom3'])) {
                $roomDisplay .= ', ' . $schedule['schedroom3'];
            }
            
            $excelData[] = [
                $subject ? $subject['subcode'] : 'N/A',
                $subject ? $subject['subject'] : 'N/A',
                $subject ? $subject['units'] : 'N/A',
                $subject ? $subject['hours'] : 'N/A',
                $course ? $course['code'] : 'N/A',
                $section ? $section['section'] : 'N/A',
                $roomDisplay,
                $schedule['schedteacher'], 
                $slot1 ? : 'N/A',
                $slot2 ? : 'N/A',
                $slot3 ? : 'N/A',
                $schedule['schedmaxstudent']
            ];
        }
        
        // Load PhpSpreadsheet
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Add data to sheet using setCellValue (correct method)
        $row = 1;
        foreach ($excelData as $dataRow) {
            $col = 0; // Start from column index 0
            foreach ($dataRow as $value) {
                // Convert column index to letter (A, B, C, etc.)
                $columnLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col + 1);
                $sheet->setCellValue($columnLetter . $row, $value);
                $col++;
            }
            $row++;
        }
        
        // Set header style
        $headerStyle = [
            'font' => [
                'bold' => true,
                'size' => 12,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4F81BD'],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ];
        
        // Apply header style
        $lastColumn = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(count($excelData[0]));
        $sheet->getStyle('A1:' . $lastColumn . '1')->applyFromArray($headerStyle);
        
        // Auto-size columns
        foreach (range('A', $lastColumn) as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }
        
        // Set border for all cells
        $borderStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ];
        
        $lastRow = count($excelData);
        $sheet->getStyle('A1:' . $lastColumn . $lastRow)->applyFromArray($borderStyle);
        
        // Create filename with section name
        $filename = 'Schedule_' . ($section ? $section['section'] : 'Section_' . $secid) . '_' . date('Y-m-d') . '.xlsx';
        
        // Set headers for download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');
        
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();

        }
        public function exportAllSchedules($secid = null)
        {
            // Check if user is logged in
            if(!session()->has('logged_user')) {
                return redirect()->to(base_url());
            }
            
            // Get all schedules (or filtered by section if provided)
            if ($secid) {
                $schedules = $this->schedModel
                    ->where('schedisdel', 0)
                    ->where('schedsecid', $secid)
                    ->findAll();
                $section = $this->sectionsModel->where('secid', $secid)->first();
            } else {
                $schedules = $this->schedModel
                    ->where('schedisdel', 0)
                    ->findAll();
                $section = null;
            }
            
            if (empty($schedules)) {
                session()->setTempdata('error', 'No schedule data found for export.', 3);
                return redirect()->to(base_url('schedules'));
            }
            
            // Prepare data for Excel
            $excelData = [];
            
            // Add header row with more detailed columns
            $excelData[] = [
                'SUBJECT CODE',
                'SUBJECT',
                'UNITS',
                'HOURS',
                'COURSE',
                'SECTION',
                'ROOM',
                'TEACHER',
                'DAY & TIME (SLOT 1)',
                'DAY & TIME (SLOT 2)',
                'DAY & TIME (SLOT 3)',
                'MAX STUDENTS'
            ];
            
            // Add data rows
            foreach ($schedules as $schedule) {
                // Get subject details
                $subject = $this->subjModel->where('subid', $schedule['schedsubid'])->first();

                // Format room display
                $roomDisplay = $schedule['schedroom'];
                if (!empty($schedule['schedroom2'])) {
                    $roomDisplay .= ', ' . $schedule['schedroom2'];
                }
                if (!empty($schedule['schedroom3'])) {
                    $roomDisplay .= ', ' . $schedule['schedroom3'];
                }

                // Format time slots
                $slot1 = '';
                if (!empty($schedule['schedday']) && !empty($schedule['schedtimeF'])) {
                    $slot1 = $schedule['schedday'] . ' | ' . 
                            date('h:i A', strtotime($schedule['schedtimeF'])) . ' - ' . 
                            date('h:i A', strtotime($schedule['schedtimeT']));
                }
                
                $slot2 = '';
                if (!empty($schedule['schedday2']) && !empty($schedule['schedtimeF2']) && $schedule['schedtimeF2'] != '00:00:00') {
                    $slot2 = $schedule['schedday2'] . ' | ' . 
                            date('h:i A', strtotime($schedule['schedtimeF2'])) . ' - ' . 
                            date('h:i A', strtotime($schedule['schedtimeT2']));
                }
                
                $slot3 = '';
                if (!empty($schedule['schedday3']) && !empty($schedule['schedtimeF3']) && $schedule['schedtimeF3'] != '00:00:00') {
                    $slot3 = $schedule['schedday3'] . ' | ' . 
                            date('h:i A', strtotime($schedule['schedtimeF3'])) . ' - ' . 
                            date('h:i A', strtotime($schedule['schedtimeT3']));
                }
                
                // Get course details
                $course = $this->coursesModel->where('courid', $schedule['schedcourid'])->first();
                
                // Get section details
                $section = $this->sectionsModel->where('secid', $schedule['schedsecid'])->first();
                
                // Get level details if available
                $level = null;
                if ($section && isset($section['seclevelid'])) {
                    $level = $this->levelModel->where('levelid', $section['seclevelid'])->first();
                }
                
                $excelData[] = [
                    $subject ? $subject['subcode'] : 'N/A',
                    $subject ? $subject['subject'] : 'N/A',
                    $subject ? $subject['units'] : 'N/A',
                    $subject ? $subject['hours'] : 'N/A',
                    $course ? $course['code'] : 'N/A',
                    $section ? $section['section'] : 'N/A',
                    $roomDisplay,
                    $schedule['schedteacher'], 
                    $slot1 ? : 'N/A',
                    $slot2 ? : 'N/A',
                    $slot3 ? : 'N/A',
                    $schedule['schedmaxstudent']
                ];
            }
            
            // Create spreadsheet
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            
            // Set sheet title
            $sheetTitle = $section ? 'Schedule_' . $section['section'] : 'All_Schedules';
            $sheet->setTitle(substr($sheetTitle, 0, 31)); // Excel sheet name max 31 chars
            
            // Add data to sheet
            $row = 1;
            foreach ($excelData as $dataRow) {
                $col = 0;
                foreach ($dataRow as $value) {
                    $columnLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col + 1);
                    $sheet->setCellValue($columnLetter . $row, $value);
                    $col++;
                }
                $row++;
            }
            
            // Style the header row
            $headerStyle = [
                'font' => [
                    'bold' => true,
                    'size' => 11,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '2E75B6'],
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['rgb' => 'FFFFFF'],
                    ],
                ],
            ];
            
            $lastColumn = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(count($excelData[0]));
            $sheet->getStyle('A1:' . $lastColumn . '1')->applyFromArray($headerStyle);
            
            // Auto-size all columns
            foreach (range('A', $lastColumn) as $columnID) {
                $sheet->getColumnDimension($columnID)->setAutoSize(true);
            }
            
            // Add borders to all data cells
            $borderStyle = [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['rgb' => 'CCCCCC'],
                    ],
                ],
            ];
            
            $lastRow = count($excelData);
            $sheet->getStyle('A2:' . $lastColumn . $lastRow)->applyFromArray($borderStyle);
            
            // Freeze the header row
            $sheet->freezePane('A2');
            
            // Create filename
            $filename = $section ? 
                'Created_Schedules_' . date('Y-m-d') . '.xlsx' : 
                'All_Schedules_' . date('Y-m-d') . '.xlsx';
            
            // Set headers for download
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');
            header('Cache-Control: max-age=1');
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
            header('Cache-Control: cache, must-revalidate');
            header('Pragma: public');
            
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            $writer->save('php://output');
            exit();
        }
}