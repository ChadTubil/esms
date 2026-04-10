<?php
namespace App\Controllers;
use App\Models\UsersModel;
use App\Models\StudentsModel;
use App\Models\SchoolRecordModel;
use App\Models\PermanentRecordModel;
use App\Models\FamilyBackgroundModel;
use App\Models\AdditionalInfoSHSModel;
use App\Models\RegStudentsModel;
use TCPDF;
class GuidanceController extends BaseController
{
    public $usersModel;
    public $studentsModel;
    public $srModel;
    public $prModel;
    public $fbModel;
    public $addinfoshsModel;
    public $session;
    public function __construct() {
        helper('form');
        $this->usersModel = new UsersModel();
        $this->studentsModel = new StudentsModel();
        $this->srModel = new SchoolRecordModel();
        $this->prModel = new PermanentRecordModel();
        $this->fbModel = new FamilyBackgroundModel();
        $this->addinfoshsModel = new AdditionalInfoSHSModel();
        $this->session = session();
    }
    public function index()
    {
        $data = [
            'page_title' => 'Holy Cross College | Guidance',
            'page_heading' => 'GUIDANCE RECORDS! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user'))
        {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();

        $data['admissionrecords'] = $this->regstudentsModel
        ->select('regstudents.*, permanentrecord.*, studentschoolrecord.*, familybackground.*, additional_information.*,regstudents.*')
        ->join('permanentrecord', 'permanentrecord.studid = regstudents.studid', 'left')
        ->join('familybackground', 'familybackground.studid = regstudents.studid', 'left')
        ->join('studentschoolrecord', 'studentschoolrecord.srstudid = regstudents.studid', 'left')
        ->join('additionalinfo_shs', 'additionalinfo_shs.studid = regstudents.studid', 'left')
        ->where('regstudents.studisdel', 0)
        ->findAll();
        return view('guidancerecordsview.php', $data);
    }
    public function printStudInfo($id=null){
        // Load TCPDF library
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $pdf->SetAuthor('TRS Department');
        $pdf->SetTitle('Copy of Student Information');

        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(5,40,5);
        //$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetHeaderMargin(0);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        // set font
        $pdf->SetFont('dejavusans', '', 10);
        // add a page
        $pdf->AddPage();

        // HEADER
        $imagePath = FCPATH .'public/uploads/hccheader.png';
        $pdf->Image($imagePath, $x = 5, $y = 0, $w = 206, $h = 36); 
        $pdf->Line(5, 37, 211, 37);

        $db = \Config\Database::connect();
        $studinfo = $db->query("SELECT * FROM enrollmenttempdata WHERE studno = '$id'");
        $studresult = $studinfo->getRow(0);
        $studinfoData = $this->etdModel->select('enrollmenttempdata.*, students.*, permanentrecord.*, studentschoolrecord.*, familybackground.*, additional_information.*, courses.*')
        ->join('courses', 'courses.courid = enrollmenttempdata.course', 'left')
        ->join('students', 'students.studid = enrollmenttempdata.studno', 'left')
        ->join('permanentrecord', 'permanentrecord.studid = students.studid', 'left')
        ->join('studentschoolrecord', 'studentschoolrecord.ssrid = students.studid', 'left')
        ->join('familybackground', 'familybackground.studid = students.studid', 'left')
        ->join('additionalinfo_shs', 'additionalinfo_shs.studid = students.studid', 'left')
        ->where('studno', $id)->findAll();

        $data2day = date('Y-m-d');

        foreach ($studinfoData as $std){
            $STDStudId = $std['studno'];
            $COURSE =$std['course'];
        }

        $regData = $this->regstudentsModel->where('studid',$STDStudId)->findAll();
        foreach($regData as $regD){

            $STUDIMAGE = $regD['studimage'];
            $STUDNO = $regD['studentno'];
            $STUDLN = $regD['studln'];
            $STUDFN = $regD['studfn'];
            $STUDMN = $regD['studmn'];
            $STUDFULLNAME = $STUDLN .',' .' ' .$STUDFN .' ' .$STUDMN;
            $STUDEXT = $regD['studextension'];
            $STUDBDAY = $regD['studbirthday'];
            $STUDAGE = $regD['studage'];
            $STUDGENDER = $regD['studgender'];
            $STUDBRGY = $regD['studstbarangay'];
            $STUDCITY = $regD['studcity'];
            $STUDPROV = $regD['studprovince'];
            $STUDADD = $STUDBRGY .',' . ' ' . $STUDCITY . ',' .' ' . $STUDPROV;
            $STUDCONTACT = $regD['studcontact'];
            $STUDCITIZEN = $regD['studcitizenship'];
            $STUDREL = $regD['studreligion'];
            $STUDEMAIL = $regD['studemail'];
            $STUDBP = $regD['studbirthplace'];
            $STUDIMG = $regD['studimage'];
        }
        $ssrData = $this->srModel->where('ssrid', $STDStudId)->findAll();
        foreach($ssrData as $ssrD){
            $SRSY=$ssrD['srsy'];
            $SRSEM=$ssrD['srsem'];
            $SRLEVEL=$ssrD['srlevel'];
            $SRSTUDID=$ssrD['srstudid'];
            $SRIR=$ssrD['srirregular'];
            $SRCID=$ssrD['srcourseid'];
            $SRMAJOR=$ssrD['srmajor'];
            $SRTELNO=$ssrD['srtelno'];
            $SRMOBNO=$ssrD['srmobno'];
            $SREMAIL=$ssrD['sremail'];
            $SRFBADD=$ssrD['srfbaddress'];
            $SRPLANS=$ssrD['srplans'];
            $SRAWARDS=$ssrD['srawards'];
            $SRORG=$ssrD['srorgname'];
            $SRORGPOS=$ssrD['srorgpos'];
            $SRORGNAMEO=$ssrD['srorgnameo'];
            $SRORGPOSO=$ssrD['srorgposo'];
        }
        $fbData = $this->fbModel->where('studid',$STDStudId)->findAll();
        foreach($fbData as $fbD){
            $NFATHER=$fbD['nfather'];
            $FDOB=$fbD['fdateofbirth'];
            $FPOB=$fbD['fplaceofbirth'];
            $FADD=$fbD['faddress'];
            $FMOB=$fbD['fmobile'];
            $FWORK=$fbD['fwork'];
            $FEDUC=$fbD['feduc'];
            $FOFFICE=$fbD['foffice'];
            $FLANG=$fbD['flanguage'];
            $NMOTHER=$fbD['nmother'];
            $MDOB=$fbD['mdateofbirth'];
            $MPOB=$fbD['mplaceofbirth'];
            $MADD=$fbD['maddress'];
            $MMOB=$fbD['mmobile'];
            $MWORK=$fbD['mwork'];
            $MEDUC=$fbD['meducation'];
            $MOFFICE=$fbD['moffice'];
            $MLANG=$fbD['mlanguage'];
            $PSTATUS=$fbD['pstatus'];
            $NAMEG=$fbD['nameg'];
            $CONTACTG=$fbD['contactg'];
            $GADD=$fbD['gaddress'];
            $CONPER=$fbD['contactperson'];
            $PCONTNO=$fbD['personcontactno'];
        }
        $prData = $this->prModel->where('studid',$STDStudId)->findAll();
        foreach($prData as $prD){
            $ESCHOOL=$prD['eschool'];
            $EYRGRAD=$prD['eyeargraduate'];
            $JHSCHOOL=$prD['jhschool'];
            $JHSYRGRAD=$prD['jhyeargraduate'];
            $SHSCHOOL=$prD['shschool'];
            $SHYRGRAD=$prD['shyeargraduate'];
        }
        $aiData = $this->addinfoshsModel->where('studid',$STDStudId)->findAll();
        foreach($aiData as $aiD){
            $SIBNAME=$aiD['siblingname'];
            $SIBWORK=$aiD['siblingwork'];
            $SIBAGE=$aiD['siblingage'];
            $INT=$aiD['interest'];
            $TALENTS=$aiD['talents'];
            $HOBBIES=$aiD['hobbies'];
            $GOALS=$aiD['goals'];
            $CHAR=$aiD['characteristics'];
            $FEARS=$aiD['fears'];
            $DISABILITIES=$aiD['disabilities'];
            $CHRONIC=$aiD['chronic_illnesses'];
            $MEDS=$aiD['medicine'];
            $VITS=$aiD['vitamins'];
            $RECACC=$aiD['recent_accidents'];
            $EXPACC=$aiD['experience_accidents'];
            $RECSUR=$aiD['recent_surgical'];
            $EXPSUR=$aiD['experience_surgical'];
            $VACC=$aiD['vaccines'];
            $CONPSY=$aiD['con_psy'];
            $CONPSYDATE=$aiD['con_psy_date'];
            $CONPSYSESS=$aiD['con_psy_sessions'];
            $CONPSYDIAG=$aiD['con_psy_diagnosis'];
            $CONREGPSY=$aiD['con_regpsy'];
            $CONREGPSYDATE=$aiD['con_regpsy_date'];
            $CONREGPSYSESS=$aiD['con_regpsy_sessions'];
            $CONREGPSYDIAG=$aiD['con_regpsy_diagnosis'];
            $CONREGGUID=$aiD['con_regguid'];
            $CONREGGUIDDATE=$aiD['con_regguid_date'];
            $CONREGGUIDSESS=$aiD['con_regguid_sessions'];
            $CONREGGUIDDIAG=$aiD['con_regguid_diagnosis'];
        }
        
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
                    <td style="width:100%; text-align: center"><h3>GUIDANCE AND COUNSELING SERVICES DIVISION</h3></td>
                </tr>
            </table>

            <table>
                <tr>
                    <td style="font-size: 20px; font-weight: bold; text-align: center; width: 100%;">INDIVIDUAL INFORMATION SHEET</td>
                </tr>
            </table>

            <table>
                <tr>
                    <td style="width: 100%; text-align: right;"> <img src="'. $STUDIMAGE .'" alt="Student Image" style="width: 150px; height: auto;"> </td>
                </tr>
                <tr><td></td></tr>
            </table>

            <table style="border: 1px thin black">
                <tr>
                    <td style="width: 100%; text-align: right;">Date: <strong> '. $data2day .' </strong></td>
                </tr>
                <tr>
                    <td style="width: 50%;">Student Fullname: <strong> '. $STUDFULLNAME .' </strong></td>
                    <td style="width: 25%;">Student No.: <strong> '. $STUDNO .' </strong></td>
                    <td style="width: 25%;">Year Level: <strong> '. $studresult->sy .'</strong></td>
                </tr>
                <tr>
                    <td style="width: 50%;">Course: <strong> '. $COURSE .'</strong></td>
                    <td style="width: 25%;">Gender: <strong> '. $STUDGENDER .'</strong></td>
                    <td style="width: 25%;">Contact No.: <strong> '. $STUDCONTACT .'</strong></td>
                </tr>
                <tr>
                    <td style="width: 50%;">Address: <strong> '. $STUDADD .' </strong></td>
                    <td style="width: 25%;">Age: <strong> '. $STUDAGE .'</strong></td>
                    <td style="width: 25%;">Citizenship: <strong> '. $STUDCITIZEN .'</strong></td>
                </tr>
                <tr>
                    <td style="width: 50%;">Birthplace: <strong> '. $STUDBP .'</strong></td> 
                    <td style="width: 25%;">Religion: <strong> '. $STUDREL .' </strong></td>
                    <td style="width: 25%;">Birthday: <strong> '. $STUDBDAY .'</strong></td>
                </tr>
                <tr>
                    <td style="width: 50%;">Telephone No.: <strong> '. $SRTELNO .'</strong></td> 
                    <td style="width: 50%;">Email: <strong> '. $STUDEMAIL .'</strong></td>
                </tr>
            </table>

            <table>
                <tr><td></td></tr>
            </table>

            <table style="border: 1px thin black; width: 100%">
                <tr>
                    <td style="font-size: 12; font-weight: bold; text-align: left;">EDUCATIONAL BACKGROUND</td>
                </tr>
                <tr><td></td></tr>
                <tr>
                    <td style="width: 50%;">Elementary: <strong> '. $ESCHOOL .' </strong></td>
                    <td style="width: 50%;">Year Graduated: <strong> '. $EYRGRAD .'</strong></td>
                </tr>
                <tr>
                    <td style="width: 50%;">Junior High School: <strong> '. $JHSCHOOL .' </strong></td>
                    <td style="width: 50%;">Year Graduated: <strong> '. $JHSYRGRAD .'</strong></td>
                </tr>
                <tr>
                    <td style="width: 50%;">Senior High School: <strong> '. $SHSCHOOL .' </strong></td>
                    <td style="width: 50%;">Year Graduated: <strong> '. $SHYRGRAD .'</strong></td>
                </tr>
                <tr>
                    <td style="width: 50%;">Plans After College: <strong> '. $SRPLANS .' </strong></td>
                    <td style="width: 50%;">Awards: <strong> '. $SRAWARDS .'</strong></td>
                </tr>
                <tr>
                    <td style="width: 50%;">Organization Joined: <strong> '. $SRORG .' </strong></td>
                    <td style="width: 50%;">Position: <strong> '. $SRORGPOS .'</strong></td>
                </tr>
                <tr>
                    <td style="width: 50%;">Other Organization Joined: <strong> '. $SRORGNAMEO .' </strong></td>
                    <td style="width: 50%;">Position: <strong> '. $SRORGPOSO .'</strong></td>
                </tr>
            </table>

            <table>
                <tr><td></td></tr>
            </table>

            <table style="border: 1px thin black;">
                <tr>
                    <td style="font-size: 12; font-weight: bold; text-align: left;">OTHER INFORMATION</td>
                </tr>
                <tr><td></td></tr>
                <tr>
                    <td style="width: 40%;">Characteristics: <strong> '. $CHAR .' </strong></td>
                    <td style="width: 30%;">Talents: <strong> '. $TALENTS .'</strong></td> 
                    <td style="width: 30%;">Interests: <strong> '. $INT .'</strong></td>
                </tr>
                <tr>
                    <td style="width: 40%;">Hobbies: <strong> '. $HOBBIES .'</strong></td>
                    <td style="width: 30%;">Goals: <strong> '. $GOALS .' </strong></td>
                    <td style="width: 30%;">Fears: <strong> '. $FEARS .'</strong></td>
                </tr>
                <tr>
                    <td style="width: 40%;">Facebook Address.: <strong> '. $SRFBADD .'</strong></td>
                    <td style="width: 30%;">Birthplace: <strong> '. $STUDBP .'</strong></td> 
                    <td style="width: 30%;">Citizenship: <strong> '. $STUDCITIZEN .'</strong></td>
                </tr>
                <tr>
                    <td style="width: 40%;">Sibling Name: <strong> '. $SIBNAME .' </strong></td>
                    <td style="width: 30%;">Sibling Work: <strong> '. $SIBWORK .'</strong></td> 
                    <td style="width: 30%;">Sibling Age: <strong> '. $SIBAGE .'</strong></td>
                </tr>
            </table>

            <table>
                <tr><td></td></tr>
            </table>

            <table style="border: 1px thin black;">
                <tr>
                    <td style="font-size: 12; font-weight: bold; text-align: left;">FAMILY BACKGROUND</td>
                </tr>
                <tr><td></td></tr>
                <tr>
                    <td style="width: 40%;">Name of Father: <strong> '. $NFATHER .' </strong></td>
                    <td style="width: 30%;">Date of Birth: <strong> '. $FDOB .'</strong></td> 
                    <td style="width: 30%;">Place of Birth: <strong> '. $FPOB .'</strong></td>
                </tr>
                <tr>
                    <td style="width: 40%;">Address: <strong> '. $FADD .'</strong></td>
                    <td style="width: 30%;">Contact No.: <strong> '. $FMOB .' </strong></td>
                    <td style="width: 30%;">Work: <strong> '. $FWORK .'</strong></td>
                </tr>
                <tr>
                    <td style="width: 40%;">Education: <strong> '. $FEDUC .' </strong></td>
                    <td style="width: 30%;">Office Number: <strong> '. $FOFFICE .'</strong></td> 
                    <td style="width: 30%;">Language Spoken: <strong> '. $FLANG .'</strong></td>
                </tr>
                <tr>
                    <td style="width: 40%;">Name of Mother: <strong> '. $NMOTHER .' </strong></td>
                    <td style="width: 30%;">Date of Birth: <strong> '. $MDOB .'</strong></td> 
                    <td style="width: 30%;">Place of Birth: <strong> '. $MPOB .'</strong></td>
                </tr>
                <tr>
                    <td style="width: 40%;">Address: <strong> '. $MADD .' </strong></td>
                    <td style="width: 30%;">Contact No.: <strong> '. $MMOB .'</strong></td> 
                    <td style="width: 30%;">Work: <strong> '. $MWORK .'</strong></td>
                </tr>
                <tr>
                    <td style="width: 40%;">Education: <strong> '. $MEDUC .' </strong></td>
                    <td style="width: 30%;">Office Number: <strong> '. $MOFFICE .'</strong></td> 
                    <td style="width: 30%;">Language Spoken: <strong> '. $MLANG .'</strong></td>
                </tr>
                <tr>
                    <td style="width: 40%;">Status of Parents: <strong> '. $PSTATUS .' </strong></td>
                    <td style="width: 30%;">Name of Guardian: <strong> '. $NAMEG .'</strong></td> 
                    <td style="width: 30%;">Contact No.: <strong> '. $CONTACTG .'</strong></td>
                </tr>
                <tr>
                    <td style="width: 40%;">Address: <strong> '. $GADD .' </strong></td>
                    <td style="width: 30%;">Contact Person: <strong> '. $CONPER .'</strong></td> 
                    <td style="width: 30%;">Contact No.: <strong> '. $PCONTNO .'</strong></td>
                </tr>
            </table>

            <table>
                <tr><td></td></tr>
                <tr><td></td></tr>
            </table>

            <table style="border: 1px thin black">
                <tr>
                    <td style="font-size: 12; font-weight: bold; text-align: left;">HEALTH INFORMATION</td>
                </tr>
                <tr><td></td></tr>
                <tr>
                    <td style="width: 40%;">Medications: <strong> '. $MEDS .'</strong></td>
                    <td style="width: 30%;">Vitamins: <strong> '. $VITS .'</strong></td>
                    <td style="width: 30%;">Vaccinations: <strong> '. $VACC .'</strong></td>
                </tr>
                <tr>
                    <td style="width: 50%;">Disabilities: <strong> '. $DISABILITIES .' </strong></td>
                    <td style="width: 50%;">Chronic Illnesses: <strong> '. $CHRONIC .'</strong></td> 
                </tr>
                <tr>
                    <td style="width: 50%;">Recent Accident: <strong> '. $RECACC .' </strong></td>
                    <td style="width: 50%;">Experience from Accident: <strong> '. $EXPACC .'</strong></td>
                </tr>
                <tr>
                    <td style="width: 50%;">Recent Surgery: <strong> '. $RECSUR .'</strong></td>
                    <td style="width: 50%;">Experience from Surgery: <strong> '. $EXPSUR .'</strong></td>
                </tr>
                <tr>
                    <td style="width: 50%;">Consultation with Psychiatrist: <strong> '. $CONPSY .'</strong></td>
                    <td style="width: 50%;">Date of Consultation: <strong> '. $CONPSYDATE .'</strong></td>
                </tr>
                <tr>
                    <td style="width: 50%;">How many sessions?: <strong> '. $CONPSYSESS .'</strong></td>
                    <td style="width: 50%;">Diagnosis: <strong> '. $CONPSYDIAG .'</strong></td>
                </tr>
                <tr>
                    <td style="width: 50%;">Consultation with Registred Pyschologist: <strong> '. $CONREGPSY .'</strong></td>
                    <td style="width: 50%;">Date of Consultation: <strong> '. $CONREGPSYDATE .'</strong></td>
                </tr>
                <tr>
                    <td style="width: 50%;">How many sessions?: <strong> '. $CONREGPSYSESS .'</strong></td>
                    <td style="width: 50%;">Diagnosis: <strong> '. $CONREGPSYDIAG .'</strong></td>
                </tr>
                <tr>
                    <td style="width: 50%;">Consultation with Registred Guidance Counselor: <strong> '. $CONREGGUID .'</strong></td>
                    <td style="width: 50%;">Date of Consultation: <strong> '. $CONREGGUIDDATE .'</strong></td>
                </tr>
                <tr>
                    <td style="width: 50%;">How many sessions?: <strong> '. $CONREGGUIDSESS .'</strong></td>
                    <td style="width: 50%;">Diagnosis: <strong> '. $CONREGGUIDDIAG .'</strong></td>
                </tr>
            </table>
            

        ';

        $pdf->writeHTML($html, true, false, false, false, '');
        $filename = strtoupper($studresult->fullname).'.pdf';
        $pdfContent = $pdf->Output($filename, 'S');

        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setHeader('Content-Disposition', 'inline; filename="' . $filename . '"')
            ->setBody($pdfContent);
    }
}