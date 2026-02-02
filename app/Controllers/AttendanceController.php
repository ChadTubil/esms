<?php

namespace App\Controllers;
use App\Models\EmployeesModel;
use App\Models\AttendancesModel;
use App\Models\SYModel;
use App\Models\UsersModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use CodeIgniter\I18n\Time;
class AttendanceController extends BaseController
{
    public $employeesModel;
    public $attendancesModel;
    public $syModel;
    public $usersModel;
    public $session;
    public function __construct() {
        helper('form');
        $this->employeesModel = new EmployeesModel();
        $this->attendancesModel = new AttendancesModel();
        $this->syModel = new SYModel();
        $this->usersModel = new UsersModel();
        $this->session = session();
    }
    public function index()
    {
        $DATETODAY = date('Y-m-d');
        
        $data['empdata'] = $this->employeesModel->findall();
        $data['attendancedata'] = $this->attendancesModel->where('date', $DATETODAY)->orderBy('attid', 'DESC')->first();
        $LastAttendance = $this->attendancesModel->where('date', $DATETODAY)->orderBy('attid', 'DESC')->first();
        if(empty($LastAttendance)){

        } else {
            $EMPNUM = $LastAttendance['employeeno'];
            $data['employeedata'] = $this->employeesModel->where('empnum', $EMPNUM)->first();
        }
        
        if($this->request->is('post')) {
            $RFID = $this->request->getVar('rfidno');
            $imageData = $this->request->getPost('image');
            $CheckSY = $this->syModel->where('systatus', 0)->first();
            $CHECKRFIDIFEXIST = $this->employeesModel->where('rfidno', $RFID)->findAll();

            if(empty($CHECKRFIDIFEXIST)) {
                session()->setTempdata('message', 'RFID DO NOT EXIST! Please go to TRS Office.', 2);
                return redirect()->to(base_url()."biometrics");
            }else{
                $CHECKEMPISDEL = $this->employeesModel->where('rfidno', $RFID)->where('empisdel', 1)->findAll();
                if(!empty($CHECKEMPISDEL)) {
                    session()->setTempdata('message', 'RFID IS BLOCKED! Please go to HRD Office.', 2);
                    return redirect()->to(base_url()."biometrics");
                }else{
                    $GETEMPDATA = $this->employeesModel->where('rfidno', $RFID)->first();
                    foreach($CHECKRFIDIFEXIST as $CRFE) {
                        $EMPNUM = $CRFE['empnum'];
                        $EMPFULLNAME = $CRFE['empfullname'];
                        $EMPTIMEIN = $CRFE['timein'];
                        $EMPTIMEOUT = $CRFE['timeout'];
                    }
                    if(empty($EMPTIMEIN) || empty($EMPTIMEOUT) || $EMPTIMEIN == '00:00:00' || $EMPTIMEOUT == '00:00:00') {
                        session()->setTempdata('message', 'RFID IS NOT YET SET! Please go to HRD Office.', 2);
                        return redirect()->to(base_url()."biometrics");
                    }else{
                        $CHECKRFIDINATTENDANCE = $this->attendancesModel->where('rfid', $RFID)->where('date', $DATETODAY)->findAll();
                        if(empty($CHECKRFIDINATTENDANCE)){
                            $imageData = preg_replace('#^data:image/\w+;base64,#i', '', $imageData);
                            // Decode base64 into binary
                            $decodedData = base64_decode($imageData);
                            if ($decodedData === false) {
                                return "Failed to decode image data!";
                            }
                            // Generate filename
                            $filename = 'webcam' . time() . '.png';
                            $filePath = FCPATH . 'public/uploads/captured/' . $filename;
                            file_put_contents($filePath, $decodedData);
                            $TIMEIN = date('H:i:s');
                            
                            $LATE_IN_SECONDS = strtotime($TIMEIN) - strtotime($EMPTIMEIN);
                            if ($LATE_IN_SECONDS > 0) {
                                $LATE_IN_HOURS = $LATE_IN_SECONDS / 3600;
                                $LATE_IN_HOURS = round($LATE_IN_HOURS, 2);
                            } else {
                                $LATE_IN_HOURS = 0;
                            }
                            $data = [
                                'employeeno' => $EMPNUM,
                                'rfid' => $RFID,
                                'sy' => $CheckSY['syname'],
                                'date' => date('Y-m-d'),
                                'timein' => date('H:i:s'),
                                'late' => $LATE_IN_HOURS,
                                'image' => $filename,
                            ];
                            $this->attendancesModel->save($data);
                            if ($LATE_IN_HOURS > 0) {
                                session()->set('play_late_sound', true);
                                session()->setTempdata('message', 'Youre late!', 2);
                                return redirect()->to(current_url());   
                            }else{
                                session()->set('play_early_sound', true);
                                session()->setTempdata('message', 'Welcome!', 2);
                                return redirect()->to(current_url());
                            }
                        }else{
                            $GETRFIDINATTENDANCEDATA = $this->attendancesModel->where('rfid', $RFID)->where('date', $DATETODAY)->findAll();
                            foreach($GETRFIDINATTENDANCEDATA as $GRIAD) {
                                $ATTID = $GRIAD['attid'];
                                $TIMEINATT = $GRIAD['timein'];
                                $TIMEOUTATT = $GRIAD['timeout'];
                            }
                            $PLUSONEHOUR = date('H:i:s', strtotime($TIMEINATT . ' +1 hour'));
                            if(date('H:i:s') <= $PLUSONEHOUR) {
                                session()->setTempdata('message', 'You are already tapped in. Please wait for one hour before tapping out again!', 2);
                                return redirect()->to(current_url());
                            } else {
                                if(empty($TIMEOUTATT) || $TIMEOUTATT == '00:00:00') {
                                    $TIMEOUT = date('H:i:s');
                                    $UNDERTIME_IN_SECONDS = strtotime($EMPTIMEOUT) - strtotime($TIMEOUT);
                                    if ($UNDERTIME_IN_SECONDS > 0) {
                                        $UNDERTIME_HOURS = $UNDERTIME_IN_SECONDS / 3600;
                                        $UNDERTIME_HOURS = round($UNDERTIME_HOURS, 2);
                                    } else {
                                        $UNDERTIME_HOURS = 0;
                                    }
                                    // Calculate rendered hours (time worked)
                                    $RENDERED_IN_SECONDS = strtotime($TIMEOUT) - strtotime($TIMEINATT);
                                    $RENDERED_HOURS = $RENDERED_IN_SECONDS / 3600;
                                    $RENDERED_HOURS = round($RENDERED_HOURS, 2);
                                    
                                    // Optional: Calculate overtime if applicable
                                    $OVERTIME_HOURS = 0;
                                    if (strtotime($TIMEOUT) > strtotime($EMPTIMEOUT)) {
                                        $OVERTIME_IN_SECONDS = strtotime($TIMEOUT) - strtotime($EMPTIMEOUT);
                                        $OVERTIME_HOURS = $OVERTIME_IN_SECONDS / 3600;
                                        $OVERTIME_HOURS = round($OVERTIME_HOURS, 2);
                                    }
                                    $data = [
                                        'timeout' => date('H:i:s'),
                                        'undertime' => $UNDERTIME_HOURS,
                                        'renderhour' => $RENDERED_HOURS,
                                        'overtime' => $OVERTIME_HOURS
                                    ];
                                    $this->attendancesModel->where('attid', $ATTID)->update($ATTID, $data);
                                    if ($UNDERTIME_HOURS > 0) {
                                        session()->set('play_undertime_sound', true);
                                        session()->setTempdata('message', 'Youre early!', 2);
                                        return redirect()->to(base_url()."biometrics-out/".$ATTID);
                                    } else {
                                        return redirect()->to(base_url()."biometrics-out/".$ATTID);
                                    }
                                    
                                } else {
                                    session()->setTempdata('message', 'Already tapped out.', 2);
                                    return redirect()->to(current_url());
                                }
                            }
                        }
                    }
                }
            }
        }
        return view('biometricsview', $data);
    }
    
    public function biometricsoout($id=null) {
        $DATETODAY = date('Y-m-d');
        $data['attdata'] = $this->attendancesModel->where('date', $DATETODAY)->orderBy('attid', 'DESC')->limit(5)->findall();
        $data['empdata'] = $this->employeesModel->findall();
        
        
        $data['attendancedata'] = $this->attendancesModel->where('date', $DATETODAY)->where('attid', $id)->first();
        $LastAttendance = $this->attendancesModel->where('date', $DATETODAY)->where('attid', $id)->first();
        if(empty($LastAttendance)){

        } else {
            $EMPNUM = $LastAttendance['employeeno'];
            $data['employeedata'] = $this->employeesModel->where('empnum', $EMPNUM)->first();
        }
        return view('biometricsoutview', $data);
    }
    public function biometricsblank() {
        $DATETODAY = date('Y-m-d');
        $data['attdata'] = $this->attendancesModel->where('date', $DATETODAY)->orderBy('attid', 'DESC')->limit(5)->findall();
        $data['empdata'] = $this->employeesModel->findall();
        $data['attendancedata'] = $this->attendancesModel->where('date', $DATETODAY)->orderBy('attid', 'DESC')->first();
        $LastAttendance = $this->attendancesModel->where('date', $DATETODAY)->orderBy('attid', 'DESC')->first();
        if(empty($LastAttendance)){

        } else {
            $EMPNUM = $LastAttendance['employeeno'];
            $data['employeedata'] = $this->employeesModel->where('empnum', $EMPNUM)->first();
        }

        return view('biometricsblankview', $data);
    }
    public function attendanceview() {
        $data = [
            'page_title' => 'Holy Cross College | Attendance',
            'page_heading' => 'ATTENDANCE! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();

        if($this->request->is('post')) {
            $rules = [
                'startdate' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Starting date is required.',
                    ],
                ],
                'enddate' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Ending date is required.',
                    ],
                ],
            ];
            if($this->validate($rules)) {
                $STARTINGDATE = $this->request->getVar('startdate');
                $ENDINGDATE = $this->request->getVar('enddate');
                $this->session->set('selected_startingdate', $STARTINGDATE);
                $this->session->set('selected_endingdate', $ENDINGDATE);
                return redirect()->to(base_url().'hrd-attendance-generate');
            } else {
                $data['validation'] = $this->validator;
            }
        }

        return view('attendanceview', $data);
    }
    public function attendancegenerate() {
        $data = [
            'page_title' => 'Holy Cross College | Attendance',
            'page_heading' => 'ATTENDANCE! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $data['empdata'] = $this->employeesModel->findall();
        $STARTDATE = session()->get('selected_startingdate');
        $ENDDATE = session()->get('selected_endingdate');
        $data['DATESTART'] = $STARTDATE;
        $data['DATEEND'] = $ENDDATE;
        $data['attendancedata'] = $this->attendancesModel
                ->where('date >=', $STARTDATE)
                ->where('date <=', $ENDDATE)->findAll();

        return view('attendancegenerateview', $data);
    }
    public function downloadExcel($start=null, $end=null) {
        $EMPDATA = $this->employeesModel->findall();
        $STARTDATE = $start;
        $ENDDATE = $end;
        $ATTDATA = $this->attendancesModel
                ->where('date >=', $STARTDATE)
                ->where('date <=', $ENDDATE)->findAll();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $spreadsheet->getProperties()->setCreator('MIS Department')
            ->setTitle('Exported Attendance Data');

        // Add data to sheet
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Name');
        $sheet->setCellValue('C1', 'Date');
        $sheet->setCellValue('D1', 'Time In');
        $sheet->setCellValue('E1', 'Time Out');
        $sheet->setCellValue('F1', 'Rendered Hours');

        $row = 2;

        foreach ($ATTDATA as $ATTD) {
            $formattedDate = date('F j, Y', strtotime($ATTD['date']));
            $formattedTimeIn = date('h:i A', strtotime($ATTD['timein']));
            if(empty($ATTD['timeout']) || $ATTD['timeout'] == '00:00:00') {
                $formattedTimeOut = "--:-- --";
            } else {
                $formattedTimeOut = date('h:i A', strtotime($ATTD['timeout']));
            }

            $start = Time::parse($ATTD['timein']);
            $end   = Time::parse($ATTD['timeout']);
            if(empty($ATTD['timeout']) || $ATTD['timeout'] == '00:00:00')  {
                $formattedDiffHours = '0';
            } else {
                $diffHours = ($end->getTimestamp() - $start->getTimestamp()) / 3600;
                $formattedDiffHours = number_format($diffHours, 3);
            }
            

            
            foreach ($EMPDATA as $EMPD) {
                if($ATTD['employeeno'] == $EMPD['empnum']){
                    $sheet->setCellValue('A' . $row, $ATTD['employeeno']);
                    $sheet->setCellValue('B' . $row, $EMPD['empfullname']);
                    $sheet->setCellValue('C' . $row, $formattedDate);
                    $sheet->setCellValue('D' . $row, $formattedTimeIn);
                    $sheet->setCellValue('E' . $row, $formattedTimeOut);
                    $sheet->setCellValue('F' . $row, $formattedDiffHours);
                    $row++;
                }
            }



        }
        $writer = new Xlsx($spreadsheet);
        $filename = 'attendance_export.xlsx';
        return $this->response
            ->setHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
            ->setHeader('Content-Disposition', "attachment; filename=\"$filename\"")
            ->setHeader('Cache-Control', 'max-age=0')
            ->setBody($this->generateOutput($writer));
    }
    private function generateOutput($writer)
    {
        ob_start();
        $writer->save('php://output');
        $excelOutput = ob_get_contents();
        ob_end_clean();

        return $excelOutput;
    }
    
    public function scheduleview() {
        $data = [
            'page_title' => 'Holy Cross College | Employees Schedule',
            'page_heading' => 'EMPLOYEES SCHEDULE! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();

        $data['employeesdata'] = $this->employeesModel->where('empisdel', 0)->findAll();

        return view('hrdscheduleview', $data);
    }
    public function schedulesave() {
        if($this->request->is('post')) {
            $employeesSched = new EmployeesModel();
            $ids = $this->request->getPost('id');
            $timeins = $this->request->getPost('timein');
            $timeouts = $this->request->getPost('timeout');
            
            $db = \Config\Database::connect();
            $db->transStart();

            try {
                foreach ($ids as $index => $id) {
                    $data = [
                        'timein' => $timeins[$index],
                        'timeout' => $timeouts[$index],
                    ];
                

                    $employeesSched->update($id, $data);
                }
                $db->transComplete();
                if ($db->transStatus() === FALSE) {
                    session()->setTempdata('error', 'Schedule update failed!', 2);
                } else {
                    session()->setTempdata('updatesuccess', 'Schedule update is Successful!', 2);
                }
            } catch (\Exception $e) {
                $db->transRollback();
                session()->setTempdata('error', 'Update failed: ' . $e->getMessage(), 2);
            }
            return redirect()->to(base_url()."hrd-schedule");
        }
    }
}