<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// LOGIN
$routes->get('/', 'LoginController::index');
$routes->post('/', 'LoginController::index');
$routes->get('dashboard', 'DashboardController::index');
$routes->get('logout', 'DashboardController::logout');
$routes->add('students/login/(:segment)', 'LoginController::loginStudent/$1');
// ATTENDANCE
$routes->get('biometrics', 'AttendanceController::index');
$routes->post('biometrics', 'AttendanceController::index');
$routes->get('biometrics-out/(:segment)', 'AttendanceController::biometricsoout/$1');
$routes->get('biometrics-blank', 'AttendanceController::biometricsblank');
// SCHOOL YEAR
$routes->get('schoolyear', 'SYController::index');
$routes->post('schoolyear', 'SYController::index');
$routes->add('schoolyear/delete/(:segment)', 'SYController::deleteSY/$1');
$routes->add('schoolyear/end/(:segment)', 'SYController::endSY/$1');
$routes->post('schoolyear/update/(:segment)', 'SYController::updateSY/$1');
// SEMESTER
$routes->get('semester', 'SemesterController::index');
$routes->post('semester', 'SemesterController::index');
$routes->add('semester/delete/(:segment)', 'SemesterController::deleteSem/$1');
$routes->post('semester/update/(:segment)', 'SemesterController::updateSem/$1');
$routes->add('semester/disable/(:segment)', 'SemesterController::disableSem/$1');
$routes->add('semester/enable/(:segment)', 'SemesterController::enableSem/$1');
//COURSES
$routes->get('courses', 'CoursesController::index');
$routes->post('courses', 'CoursesController::index');
$routes->add('courses/delete/(:segment)', 'CoursesController::deleteCourse/$1');
$routes->post('courses/update/(:segment)', 'CoursesController::updateCourse/$1');
//SUBJECTS
$routes->get('subjects', 'SubjectsController::index');
$routes->post('subjects', 'SubjectsController::index');
$routes->add('subjects/delete/(:segment)', 'SubjectsController::deleteSubject/$1');
$routes->post('subjects/update/(:segment)', 'SubjectsController::updateSubject/$1');
// CURRICULUM
$routes->get('curriculum', 'CurriculumController::index');
$routes->post('curriculum', 'CurriculumController::index');
$routes->add('curriculum/delete/(:segment)', 'CurriculumController::deleteCurriculum/$1');
$routes->post('curriculum/update/(:segment)', 'CurriculumController::updateCurriculum/$1');
$routes->get('curriculum-setup/(:segment)', 'CurriculumController::curriculumsetup/$1');
$routes->post('curriculum-setup/(:segment)', 'CurriculumController::curriculumsetup/$1');
//DEPARTMENTS
$routes->get('departments', 'DepartmentsController::index');
$routes->post('departments', 'DepartmentsController::index');
$routes->add('departments/delete/(:segment)', 'DepartmentsController::deleteDept/$1');
$routes->post('departments/update/(:segment)', 'DepartmentsController::updateDept/$1');
//LEVELS
$routes->get('levels', 'LevelsController::index');
$routes->post('levels', 'LevelsController::index');
$routes->add('levels/delete/(:segment)', 'LevelsController::deleteLevel/$1');
$routes->post('levels/update/(:segment)', 'LevelsController::updateLevel/$1');
//SECTIONS
$routes->get('sections', 'SectionsController::index');
$routes->post('sections', 'SectionsController::index');
$routes->add('sections/delete/(:segment)', 'SectionsController::deleteSection/$1');
$routes->post('sections/update/(:segment)', 'SectionsController::updateSection/$1');
//EMPLOYEES
$routes->get('employees', 'EmployeesController::index');
$routes->post('employees', 'EmployeesController::index');
$routes->add('employees/delete/(:segment)', 'EmployeesController::deleteEmployee/$1');
$routes->post('employees/update/(:segment)', 'EmployeesController::updateEmployee/$1');
$routes->post('employees/rfid/(:segment)', 'EmployeesController::updateRfid/$1');
$routes->post('employees/image/(:segment)', 'EmployeesController::updateImage/$1');
//SCHEDULES
$routes->get('schedules', 'SchedulesController::index');
$routes->post('schedules', 'SchedulesController::index');
$routes->add('schedules/delete/(:segment)', 'SchedulesController::deleteSchedule/$1');
$routes->post('schedules/update/(:segment)', 'SchedulesController::updateSched/$1');
//ROOMS
$routes->get('rooms', 'RoomsController::index');
$routes->post('rooms', 'RoomsController::index');
$routes->add('rooms/delete/(:segment)', 'RoomsController::deleteRoom/$1');
$routes->post('rooms/update/(:segment)', 'RoomsController::updateRoom/$1');
//STUDENTS
$routes->get('students', 'StudentsController::index');
$routes->post('students', 'StudentsController::index');
$routes->add('students/activate/(:segment)', 'StudentsController::activateStudent/$1');
$routes->add('students/activate-m/(:segment)', 'StudentsController::activateStudentM/$1');
$routes->add('students/activate-f/(:segment)', 'StudentsController::activateStudentF/$1');
$routes->add('students/deactivate/(:segment)', 'StudentsController::deactivateStudent/$1');
$routes->add('students/resetpassword/(:segment)', 'StudentsController::resetpasswordStudent/$1');
$routes->get('studentsinfo/(:segment)', 'StudentsController::studentInfo/$1');
$routes->post('studentsinfo/update/(:segment)', 'StudentsController::studentInfoUpdate/$1');
$routes->add('students/delete/(:segment)', 'StudentsController::deleteStudent/$1');
// COLLEGE
$routes->add('collegestudents', 'ColStudentsController::collegestudentdashboard');
$routes->get('collegestudentsgrades', 'ColStudentsController::index');
$routes->post('collegestudentsgrades', 'ColStudentsController::index');
$routes->get('collegestudentsgradesview', 'ColStudentsController::collegestudentgradesview');
$routes->post('collegestudentsgradesview', 'ColStudentsController::collegestudentgradesview');
$routes->get('college-enrollment', 'EnrollmentController::collegeenrollment');
$routes->post('college-enrollment', 'EnrollmentController::collegeenrollment');
// PROFILE
$routes->get('profile', 'ProfileController::index');
$routes->post('profile/changepassword/(:segment)', 'ProfileController::changepassword/$1');
$routes->post('profile/updateaccount/(:segment)', 'ProfileController::updateAccount/$1');
// VIEWING GRADE
$routes->get('grades', 'GradeController::index');
$routes->post('grades', 'GradeController::index');
$routes->add('gradesimportedlock', 'GradeController::gradesImportedLock');
$routes->add('computesemestral', 'GradeController::setSemestral');
$routes->add('gradesdownload', 'GradeController::gradesDownload');
$routes->get('gradesview/(:segment)', 'GradeController::gradeView/$1');
$routes->post('gradesview/(:segment)', 'GradeController::gradeView/$1');
$routes->add('gradesview/result/(:segment)', 'GradeController::gradeViewResult/$1');
$routes->add('gradesview/update/(:segment)', 'GradeController::gradeViewUpdate/$1');
// USERSMANAGEMENT
$routes->get('users', 'UsersController::index');
$routes->post('users', 'UsersController::index');
$routes->add('users/delete/(:segment)', 'UsersController::deleteUsers/$1');
$routes->post('users/update/(:segment)', 'UsersController::updateUsers/$1');
$routes->add('users/disable/(:segment)', 'UsersController::disableUsers/$1');
$routes->add('users/enable/(:segment)', 'UsersController::enableUsers/$1');
$routes->get('studentmanagement', 'UsersController::studman');
$routes->post('studentmanagement', 'UsersController::studman');
$routes->add('studentmanagement/delete/(:segment)', 'UsersController::studmanDelete/$1');
$routes->post('studentmanagement/update/(:segment)', 'UsersController::studmanUpdate/$1');
$routes->add('studentmanagement/disable/(:segment)', 'UsersController::studmanDisable/$1');
$routes->add('studentmanagement/enable/(:segment)', 'UsersController::studmanEnable/$1');
// ENROLLMENT
$routes->get('registration-select', 'EnrollmentController::registrationselect');
$routes->get('registerstudent', 'EnrollmentController::index');
$routes->post('registerstudent', 'EnrollmentController::index');
$routes->get('register-oldstudent', 'EnrollmentController::oldstudent');
$routes->post('register-oldstudent-process/(:segment)', 'EnrollmentController::oldstudentprocess/$1');
$routes->get('admission', 'EnrollmentController::admission');
$routes->get('admission-view/(:segment)', 'EnrollmentController::admissionview/$1');
$routes->add('admission-generate/(:segment)', 'EnrollmentController::admissionGenerate/$1');
$routes->add('admission/delete/(:segment)', 'EnrollmentController::deleteAdmission/$1');
$routes->post('admission/process/(:segment)', 'EnrollmentController::processAdmission/$1');
$routes->get('assessment', 'EnrollmentController::assessment');
$routes->post('assessment', 'EnrollmentController::assessment');
$routes->get('assessment/process/(:segment)', 'EnrollmentController::assessmentProcess/$1');
$routes->add('assessment/curricullum-set/(:segment)', 'EnrollmentController::curricullumSet/$1');
$routes->add('assessment/process2/(:segment)', 'EnrollmentController::assessmentProcess2/$1');
$routes->get('assessment/viewsubjects/(:segment)', 'EnrollmentController::viewSubjects/$1');
// STUDENT FPA
$routes->get('studentfar', 'FARController::index');
$routes->get('studentfar/evaluation/(:segment)', 'FARController::farStudent/$1');
$routes->post('studentfar/evaluationfirst', 'FARController::farStudentfirst');
$routes->add('studentfar/evaluationsecond/(:segment)', 'FARController::farStudentsecond/$1');
$routes->post('studentfar/evaluationthird/(:segment)', 'FARController::farStudentthird/$1');
$routes->get('studentfar/evaluationfourth/(:segment)', 'FARController::farStudentfourth/$1');
$routes->post('studentfar/evaluationfifth/(:segment)', 'FARController::farStudentfifth/$1');
$routes->get('studentfar/evaluationsixth/(:segment)', 'FARController::farStudentsixth/$1');
$routes->add('studentfar/evaluationseventh/(:segment)', 'FARController::farStudentseventh/$1');
// HRD
$routes->get('hrd-fpareports', 'HRDController::index'); //di pa tapos
$routes->post('hrd-fpareports', 'HRDController::index'); //di pa tapos
$routes->add('hrd-fpareportsfaculty-result/(:segment)', 'HRDController::facultyView/$1'); //di pa tapos
$routes->add('hrd-fpareportsfaculty-view/(:segment)', 'HRDController::facultyResult/$1'); //di pa tapos
$routes->get('hrd-payslip', 'PayslipController::index');
$routes->post('hrd-payslip', 'PayslipController::index');
$routes->get('hrd-payslip-view/(:segment)', 'PayslipController::payslipView/$1');
$routes->get('payslip', 'PayslipController::payslip');
$routes->get('payslip-view/(:segment)', 'PayslipController::payslipviewview/$1');
$routes->get('hrd-attendance', 'AttendanceController::attendanceview');
$routes->post('hrd-attendance', 'AttendanceController::attendanceview');
$routes->get('hrd-attendance-generate', 'AttendanceController::attendancegenerate');
$routes->add('hrd-attendanc-download-excel/(:segment)/(:segment)', 'AttendanceController::downloadExcel/$1/$2');
// ACCOUNTING
$routes->get('rates', 'AccountingController::index');
$routes->post('rates', 'AccountingController::index');
$routes->get('rates/setup/(:segment)', 'AccountingController::ratesSetup/$1');
$routes->post('rates/setup/(:segment)', 'AccountingController::ratesSetup/$1');
// ENCODING GRADES
$routes->get('grades-college', 'GradeController::gradesCollege');
$routes->post('grades-college', 'GradeController::gradesCollege');
$routes->get('grades-college-result', 'GradeController::gradesCollegeResult');
$routes->get('grades-college-encoding/(:segment)', 'GradeController::gradesCollegeEncoding/$1');
$routes->post('grades-college-encoding-submit', 'GradeController::gradesCollegeEncodingSubmit');


$routes->set404Override(function() {
    echo view('errors/custom_error');
});