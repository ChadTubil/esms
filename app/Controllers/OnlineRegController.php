<?php

namespace App\Controllers;
use App\Models\RegStudentsModel;
use App\Models\PaymentTransactionsModel;
use App\Models\PermanentRecordModel;
use App\Models\SHSStudentsModel;
use App\Models\SHSPermanentRecordModel;
use App\Models\EnrollmentHistorySHSModel;
class OnlineRegController extends BaseController
{
    public $session;
    public $regstudModel;
    public $paymentransactionsModel;
    public $permanentrecordModel;
    public $shspermanentrecordModel;
    public $shsStudentsModel;
    public $enrollmentHistorySHSModel;
    public function __construct() {
        helper('form');
        $this->session = session();
        $this->regstudModel = new RegStudentsModel();
        $this->paymentransactionsModel = new PaymentTransactionsModel();
        $this->permanentrecordModel = new PermanentRecordModel();
        $this->shspermanentrecordModel = new SHSPermanentRecordModel();
        $this->shsStudentsModel = new SHSStudentsModel();
        $this->enrollmentHistorySHSModel = new EnrollmentHistorySHSModel();
    }
    public function index()
    {
        return view('onlineregistration/onlineregview');
    }
    public function stage2()
    {
        return view('onlineregistration/onlineregstage2view');
    }
    public function gsregistration()
    {
        $data = [];
        if($this->request->is('post')) {
            $rules = [
                'lastname' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Last name is required.',
                    ],
                ],
                'firstname' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'First name is required.',
                    ],
                ],
                'middlename' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Middle name is required.',
                    ],
                ],
                'birthday' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Birthday is required.',
                    ],
                ],
                'birthplace' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Birth place is required.',
                    ],
                ],
                'gender' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Gender is required.',
                    ],
                ],
                'email' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Email Address is required.',
                    ],
                ],
                'contact' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Contact number is required.',
                    ],
                ],
                'citizenship' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Citizenship is required.',
                    ],
                ],
                'religion' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Religion is required.',
                    ],
                ],
                'barangay' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Barangay is required.',
                    ],
                ],
                'municipality' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Municipality is required.',
                    ],
                ],
                'province' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Province is required.',
                    ],
                ],
            ];
            if($this->validate($rules)){
                // Check if student with same full name already exists
                $lastname = $this->request->getVar('lastname');
                $firstname = $this->request->getVar('firstname');
                $middlename = $this->request->getVar('middlename');

                $existingStudent = $this->regstudModel
                ->where('studln', $lastname)
                ->where('studfn', $firstname)
                ->where('studmn', $middlename)
                ->first();

                // Get birthday and calculate age
                $birthday = $this->request->getVar('birthday');
                $age = $this->calculateAge($birthday);
            
                if($existingStudent) {
                    // Student with same full name exists
                    session()->setTempdata('error', 'A student with the same full name already exists.', 3);
                    return redirect()->to(current_url());
                } else {
                    // Generate unique reference number
                    $referenceNumber = $this->generateReferenceNumber();

                    $data = [
                        'studln' => $this->request->getVar('lastname'),
                        'studfn' => $this->request->getVar('firstname'),
                        'studmn' => $this->request->getVar('middlename'),
                        'studextension' => $this->request->getVar('extension'),
                        'studfullname' => $lastname.', '.$firstname.' '.$middlename,
                        'studbirthday' => $this->request->getVar('birthday'),
                        'studage' => $age,
                        'studgender' => $this->request->getVar('gender'),
                        'studstbarangay' => $this->request->getVar('barangay'),
                        'studcity' => $this->request->getVar('municipality'),
                        'studprovince' => $this->request->getVar('province'),
                        'studcontact' => $this->request->getVar('contact'),
                        'studcitizenship' => $this->request->getVar('citizenship'),
                        'studreligion' => $this->request->getVar('religion'),
                        'studemail' => $this->request->getVar('email'),
                        'studbirthplace' => $this->request->getVar('birthplace'),
                        'studcreatedat' => date('Y-m-d H:i:s'),
                        'studstatus' => "GS",
                    ];
                    $this->regstudModel->save($data);
                    $PTdata = [
                        'paymentreference' => $referenceNumber,
                        'studfullname' => $lastname.', '.$firstname.' '.$middlename,
                        'particulars' => "GS Registration Fee",
                        'paymentstatus' => "Pending",
                        'createddate' => date('Y-m-d H:i:s'),
                    ];
                    $this->paymentransactionsModel->save($PTdata);
                    $this->session->set('referenceno', $referenceNumber);
                    return redirect()->to(base_url()."online-registration-3");
                }
            } else {
                $data['validation'] = $this->validator;
            }
        }
        return view('onlineregistration/gsregview', $data);
    }

    private function saveStudentPhoto($base64Image, $lastname, $firstname)
    {
        // Remove base64 header if present
        if (preg_match('/^data:image\/(\w+);base64,/', $base64Image, $type)) {
            $base64Image = substr($base64Image, strpos($base64Image, ',') + 1);
            $type = strtolower($type[1]); // jpg, png, etc.
            
            // Validate file type
            if (!in_array($type, ['jpg', 'jpeg', 'png'])) {
                $type = 'jpg';
            }
        } else {
            $type = 'jpg';
        }
        
        // Decode base64
        $imageData = base64_decode($base64Image);
        
        // Create unique filename
        $timestamp = date('Ymd_His');
        $randomString = bin2hex(random_bytes(8));
        $filename = strtoupper($lastname . '_' . $firstname . '_' . $timestamp . '_' . $randomString . '.' . $type);
        
        // Define upload directory
        $uploadDir = 'public/uploads/student_photos/';
        
        // Create directory if it doesn't exist
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        // Save file
        $filePath = $uploadDir . $filename;
        file_put_contents($filePath, $imageData);
        
        // Return relative path for database storage
        return 'public/uploads/student_photos/' . $filename;
    }

    public function shsregistration()
    {
        $data = [];
        if($this->request->is('post')) {
            $rules = [
                'lastname' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Last name is required.',
                    ],
                ],
                'firstname' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'First name is required.',
                    ],
                ],
                'middlename' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Middle name is required.',
                    ],
                ],
                'birthday' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Birthday is required.',
                    ],
                ],
                'birthplace' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Birth place is required.',
                    ],
                ],
                'gender' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Gender is required.',
                    ],
                ],
                'email' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Email Address is required.',
                    ],
                ],
                'contact' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Contact number is required.',
                    ],
                ],
                'citizenship' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Citizenship is required.',
                    ],
                ],
                'religion' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Religion is required.',
                    ],
                ],
                'barangay' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Barangay is required.',
                    ],
                ],
                'municipality' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Municipality is required.',
                    ],
                ],
                'province' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Province is required.',
                    ],
                ],
                'elementaryschool' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Name of the elementary school you graduated is required.',
                    ],
                ],
                'elementaryyear' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Year of the elementary school you graduated is required.',
                    ],
                ],
                'jhsschool' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Name of the elementary school you graduated is required.',
                    ],
                ],
                'jhsyear' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Year of the elementary school you graduated is required.',
                    ],
                ],
            ];
            if($this->validate($rules)){
                // Check if student with same full name already exists
                $lastname = $this->request->getVar('lastname');
                $firstname = $this->request->getVar('firstname');
                $middlename = $this->request->getVar('middlename');

                $existingStudent = $this->regstudModel
                ->where('studln', $lastname)
                ->where('studfn', $firstname)
                ->where('studmn', $middlename)
                ->first();

                // Get birthday and calculate age
                $birthday = $this->request->getVar('birthday');
                $age = $this->calculateAge($birthday);
            
                if($existingStudent) {
                    // Student with same full name exists
                    session()->setTempdata('error', 'A student with the same full name already exists.', 3);
                    return redirect()->to(current_url());
                } else {
                    // Generate unique reference number
                    $referenceNumber = $this->generateReferenceNumber();

                    $data = [
                        'studln' => $this->request->getVar('lastname'),
                        'studfn' => $this->request->getVar('firstname'),
                        'studmn' => $this->request->getVar('middlename'),
                        'studextension' => $this->request->getVar('extension'),
                        'studfullname' => $lastname.', '.$firstname.' '.$middlename,
                        'studbirthday' => $this->request->getVar('birthday'),
                        'studage' => $age,
                        'studgender' => $this->request->getVar('gender'),
                        'studstbarangay' => $this->request->getVar('barangay'),
                        'studcity' => $this->request->getVar('municipality'),
                        'studprovince' => $this->request->getVar('province'),
                        'studcontact' => $this->request->getVar('contact'),
                        'studcitizenship' => $this->request->getVar('citizenship'),
                        'studreligion' => $this->request->getVar('religion'),
                        'studemail' => $this->request->getVar('email'),
                        'studbirthplace' => $this->request->getVar('birthplace'),
                        'studcreatedat' => date('Y-m-d H:i:s'),
                        'studstatus' => "SHS",
                    ];
                    $this->regstudModel->save($data);
                    $PRdata = [
                        'studfullname' => $lastname.', '.$firstname.' '.$middlename,
                        'eschool' => $this->request->getVar('elementaryschool'),
                        'eyeargraduate' => $this->request->getVar('elementaryyear'),
                        'jhschool' => $this->request->getVar('jhsschool'),
                        'jhyeargraduate' => $this->request->getVar('jhsyear'),
                    ];
                    $this->shspermanentrecordModel->save($PRdata);
                    $PTdata = [
                        'paymentreference' => $referenceNumber,
                        'studfullname' => $lastname.', '.$firstname.' '.$middlename,
                        'particulars' => "SHS Registration Fee",
                        'paymentstatus' => "Pending",
                        'createddate' => date('Y-m-d H:i:s'),
                    ];
                    $this->paymentransactionsModel->save($PTdata);
                    $this->session->set('referenceno', $referenceNumber);
                    return redirect()->to(base_url()."online-registration-3");
                }
            } else {
                $data['validation'] = $this->validator;
            }
        }
        return view('onlineregistration/shsregview', $data);
    }
    public function collegeregistration()
    {
        $data = [];
        if($this->request->is('post')) {
            $rules = [
                'lastname' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Last name is required.',
                    ],
                ],
                'firstname' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'First name is required.',
                    ],
                ],
                'middlename' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Middle name is required.',
                    ],
                ],
                'birthday' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Birthday is required.',
                    ],
                ],
                'birthplace' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Birth place is required.',
                    ],
                ],
                'gender' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Gender is required.',
                    ],
                ],
                'email' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Email Address is required.',
                    ],
                ],
                'contact' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Contact number is required.',
                    ],
                ],
                'citizenship' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Citizenship is required.',
                    ],
                ],
                'religion' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Religion is required.',
                    ],
                ],
                'barangay' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Barangay is required.',
                    ],
                ],
                'municipality' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Municipality is required.',
                    ],
                ],
                'province' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Province is required.',
                    ],
                ],
                'elementaryschool' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Name of the elementary school you graduated is required.',
                    ],
                ],
                'elementaryyear' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Year of the elementary school you graduated is required.',
                    ],
                ],
                'jhsschool' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Name of the elementary school you graduated is required.',
                    ],
                ],
                'jhsyear' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Year of the elementary school you graduated is required.',
                    ],
                ],
            ];
            if($this->validate($rules)){
                // Check if student with same full name already exists
                $lastname = $this->request->getVar('lastname');
                $firstname = $this->request->getVar('firstname');
                $middlename = $this->request->getVar('middlename');

                $existingStudent = $this->regstudModel
                ->where('studln', $lastname)
                ->where('studfn', $firstname)
                ->where('studmn', $middlename)
                ->first();

                // Get birthday and calculate age
                $birthday = $this->request->getVar('birthday');
                $age = $this->calculateAge($birthday);
            
                if($existingStudent) {
                    // Student with same full name exists
                    session()->setTempdata('error', 'A student with the same full name already exists.', 3);
                    return redirect()->to(current_url());
                } else {
                    // Generate unique reference number
                    $referenceNumber = $this->generateReferenceNumber();

                    $data = [
                        'studln' => $this->request->getVar('lastname'),
                        'studfn' => $this->request->getVar('firstname'),
                        'studmn' => $this->request->getVar('middlename'),
                        'studextension' => $this->request->getVar('extension'),
                        'studfullname' => $lastname.', '.$firstname.' '.$middlename,
                        'studbirthday' => $this->request->getVar('birthday'),
                        'studage' => $age,
                        'studgender' => $this->request->getVar('gender'),
                        'studstbarangay' => $this->request->getVar('barangay'),
                        'studcity' => $this->request->getVar('municipality'),
                        'studprovince' => $this->request->getVar('province'),
                        'studcontact' => $this->request->getVar('contact'),
                        'studcitizenship' => $this->request->getVar('citizenship'),
                        'studreligion' => $this->request->getVar('religion'),
                        'studemail' => $this->request->getVar('email'),
                        'studbirthplace' => $this->request->getVar('birthplace'),
                        'studcreatedat' => date('Y-m-d H:i:s'),
                        'studstatus' => "COL",
                    ];
                    $this->regstudModel->save($data);
                    $regdata = $this->regstudModel->where('studln', $lastname)->where('studfn', $firstname)->where('studmn', $middlename)
                    ->findAll();
                    foreach($regdata as $rdata){
                        $studid = $rdata['studid'];
                    }
                    $PRdata = [
                        'studid' => $studid,
                        'eschool' => $this->request->getVar('elementaryschool'),
                        'eyeargraduate' => $this->request->getVar('elementaryyear'),
                        'jhschool' => $this->request->getVar('jhsschool'),
                        'jhyeargraduate' => $this->request->getVar('jhsyear'),
                        'shschool' => $this->request->getVar('shsschool'),
                        'shyeargraduate' => $this->request->getVar('shsyear'),
                    ];
                    $this->permanentrecordModel->save($PRdata);
                    $PTdata = [
                        'paymentreference' => $referenceNumber,
                        'studfullname' => $lastname.', '.$firstname.' '.$middlename,
                        'particulars' => "COL Registration Fee",
                        'paymentstatus' => "Pending",
                        'createddate' => date('Y-m-d H:i:s'),
                    ];
                    $this->paymentransactionsModel->save($PTdata);
                    $this->session->set('referenceno', $referenceNumber);
                    return redirect()->to(base_url()."online-registration-3");
                }
            } else {
                $data['validation'] = $this->validator;
            }
        }
        return view('onlineregistration/collegeregview', $data);
    }
    
    public function stage3()
    {
        $data = [];
    
        // Check if reference number exists in session
        if(!session()->has('referenceno')) {
            return redirect()->to(base_url()."online-registration");
        }
        $REFERENCENO = session()->get('referenceno');
        return view('onlineregistration/onlineregstage3view', $data);
    }
    public function kiosk1()
    {
        return view('onlineregistration/kioskview');
    }
    public function kiosk2()
    {
        return view('onlineregistration/kiosk2view');
    }
    public function kioskgsregistration()
    {
        $data = [];
        if($this->request->is('post')) {
            $rules = [
                'lastname' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Last name is required.',
                    ],
                ],
                'firstname' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'First name is required.',
                    ],
                ],
                'middlename' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Middle name is required.',
                    ],
                ],
                'birthday' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Birthday is required.',
                    ],
                ],
                'birthplace' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Birth place is required.',
                    ],
                ],
                'gender' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Gender is required.',
                    ],
                ],
                'email' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Email Address is required.',
                    ],
                ],
                'contact' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Contact number is required.',
                    ],
                ],
                'citizenship' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Citizenship is required.',
                    ],
                ],
                'religion' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Religion is required.',
                    ],
                ],
                'barangay' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Barangay is required.',
                    ],
                ],
                'municipality' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Municipality is required.',
                    ],
                ],
                'province' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Province is required.',
                    ],
                ],
            ];
        }
        if($this->validate($rules)){
            // Check if student with same full name already exists
            $lastname = $this->request->getVar('lastname');
            $firstname = $this->request->getVar('firstname');
            $middlename = $this->request->getVar('middlename');

            $existingStudent = $this->regstudModel
            ->where('studln', $lastname)
            ->where('studfn', $firstname)
            ->where('studmn', $middlename)
            ->first();

            if($existingStudent) {
                // Student with same full name exists
                session()->setTempdata('error', 'A student with the same full name already exists.', 3);
                return redirect()->to(current_url());
            } else {
                $FN = $this->request->getVar('lastname');
                $MN = $this->request->getVar('middlename');
                $LN = $this->request->getVar('lastname');
                $FULLNAME = $lastname.', '.$firstname.' '.$middlename;
                $data = [
                    'studln' => $this->request->getVar('lastname'),
                    'studfn' => $this->request->getVar('firstname'),
                    'studmn' => $this->request->getVar('middlename'),
                    'studextension' => $this->request->getVar('extension'),
                    'studfullname' => $lastname.', '.$firstname.' '.$middlename,
                    'studbirthday' => $this->request->getVar('birthday'),
                    'studage' => $age,
                    'studgender' => $this->request->getVar('gender'),
                    'studstbarangay' => $this->request->getVar('barangay'),
                    'studcity' => $this->request->getVar('municipality'),
                    'studprovince' => $this->request->getVar('province'),
                    'studcontact' => $this->request->getVar('contact'),
                    'studcitizenship' => $this->request->getVar('citizenship'),
                    'studreligion' => $this->request->getVar('religion'),
                    'studemail' => $this->request->getVar('email'),
                    'studbirthplace' => $this->request->getVar('birthplace'),
                    'studcreatedat' => date('Y-m-d H:i:s'),
                ];
            }
        }
        return view('onlineregistration/kioskgsregview');
    }
    public function kioskshsregistration()
    {
        $data = [];
        if($this->request->is('post')) {
            $rules = [
                'lastname' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Last name is required.',
                    ],
                ],
                'firstname' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'First name is required.',
                    ],
                ],
                'middlename' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Middle name is required.',
                    ],
                ],
                'birthday' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Birthday is required.',
                    ],
                ],
                'birthplace' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Birth place is required.',
                    ],
                ],
                'gender' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Gender is required.',
                    ],
                ],
                'email' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Email Address is required.',
                    ],
                ],
                'contact' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Contact number is required.',
                    ],
                ],
                'citizenship' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Citizenship is required.',
                    ],
                ],
                'religion' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Religion is required.',
                    ],
                ],
                'barangay' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Barangay is required.',
                    ],
                ],
                'municipality' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Municipality is required.',
                    ],
                ],
                'province' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Province is required.',
                    ],
                ],
                'elementaryschool' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Name of the elementary school you graduated is required.',
                    ],
                ],
                'elementaryyear' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Year of the elementary school you graduated is required.',
                    ],
                ],
                'jhsschool' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Name of the elementary school you graduated is required.',
                    ],
                ],
                'jhsyear' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Year of the elementary school you graduated is required.',
                    ],
                ],
                'student_photo' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Student photo is required. Please capture a photo.',
                    ],
                ],
            ];
            if($this->validate($rules)){
                // Check if student with same full name already exists
                $lastname = $this->request->getVar('lastname');
                $firstname = $this->request->getVar('firstname');
                $middlename = $this->request->getVar('middlename');

                $existingStudent = $this->shsStudentsModel
                ->where('studln', $lastname)
                ->where('studfn', $firstname)
                ->where('studmn', $middlename)
                ->first();

                // Handle image upload
                $studentPhoto = $this->request->getVar('student_photo');
                $photoPath = $this->saveStudentPhoto($studentPhoto, $lastname, $firstname);

                // Get birthday and calculate age
                $birthday = $this->request->getVar('birthday');
                $age = $this->calculateAge($birthday);

                if($existingStudent) {
                    // Student with same full name exists
                    session()->setTempdata('error', 'A student with the same full name already exists.', 3);
                    return redirect()->to(current_url());
                } else {
                    $FN = $this->request->getVar('lastname');
                    $MN = $this->request->getVar('middlename');
                    $LN = $this->request->getVar('lastname');
                    $FULLNAME = $lastname.', '.$firstname.' '.$middlename;
                    $data = [
                        'studln' => $this->request->getVar('lastname'),
                        'studfn' => $this->request->getVar('firstname'),
                        'studmn' => $this->request->getVar('middlename'),
                        'studextension' => $this->request->getVar('extension'),
                        'studfullname' => $lastname.', '.$firstname.' '.$middlename,
                        'studbirthday' => $this->request->getVar('birthday'),
                        'studage' => $age,
                        'studgender' => $this->request->getVar('gender'),
                        'studstbarangay' => $this->request->getVar('barangay'),
                        'studcity' => $this->request->getVar('municipality'),
                        'studprovince' => $this->request->getVar('province'),
                        'studcontact' => $this->request->getVar('contact'),
                        'studcitizenship' => $this->request->getVar('citizenship'),
                        'studreligion' => $this->request->getVar('religion'),
                        'studemail' => $this->request->getVar('email'),
                        'studbirthplace' => $this->request->getVar('birthplace'),
                        'studcreatedat' => date('Y-m-d H:i:s'),
                        'studimage' => $photoPath,
                    ];
                    $this->shsStudentsModel->save($data);
                    $FINDSTUDENT = $this->shsStudentsModel
                    ->where('studfullname', $FULLNAME)
                    ->findAll();
                    foreach($FINDSTUDENT as $FS){
                        $STUDENTID = $FS['studid'];
                    }
                    $PRdata = [
                        'studid' => $STUDENTID,
                        'studfullname' => $lastname.', '.$firstname.' '.$middlename,
                        'eschool' => $this->request->getVar('elementaryschool'),
                        'eyeargraduate' => $this->request->getVar('elementaryyear'),
                        'jhschool' => $this->request->getVar('jhsschool'),
                        'jhyeargraduate' => $this->request->getVar('jhsyear'),
                    ];
                    $this->shspermanentrecordModel->save($PRdata);
                    $FINDSTUDENT = $this->shsStudentsModel
                    ->where('studfullname', $FULLNAME)
                    ->findAll();
                    foreach($FINDSTUDENT as $FS){
                        $STUDENTID = $FS['studid'];
                    }
                    $EHSHSdata = [
                        'studid' => $STUDENTID,
                        'studfullname' => $FULLNAME,
                        'date' => date('Y-m-d'),
                        'status' => 'Registered',
                    ];
                    $this->enrollmentHistorySHSModel->save($EHSHSdata);
                    return redirect()->to(base_url()."kiosk-registration-3");
                }
            } else {
                $data['validation'] = $this->validator;
            }
        }
        return view('onlineregistration/kioskshsregview');
    }
    public function kioskcollegeregistration()
    {
        return view('onlineregistration/kiosk2view');
    }
    public function kiosk3()
    {
        return view('onlineregistration/kiosk3view');
    }
    private function calculateAge($birthday)
    {
        $birthDate = new \DateTime($birthday);
        $today = new \DateTime();
        $age = $today->diff($birthDate)->y;
        return $age;
    }
    private function generateReferenceNumber()
    {
        $datePart = date('Ymd');
        $randomPart = str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);
        $referenceNumber = "RF-{$datePart}-{$randomPart}";
        
        // Check if reference number already exists in database
        $existing = $this->paymentransactionsModel->where('paymentreference', $referenceNumber)->first();
        
        // If exists, generate a new one recursively
        if($existing) {
            return $this->generateReferenceNumber();
        }
        
        return $referenceNumber;
    }
}
