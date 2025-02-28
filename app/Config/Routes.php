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

$routes->add('students/delete/(:segment)', 'StudentsController::deleteStudent/$1');
// COLLEGE
$routes->add('collegestudents', 'ColStudentsController::collegestudentdashboard');
$routes->get('collegestudentsgrades', 'ColStudentsController::index');
$routes->post('collegestudentsgrades', 'ColStudentsController::index');
$routes->get('collegestudentsgradesview', 'ColStudentsController::collegestudentgradesview');
$routes->post('collegestudentsgradesview', 'ColStudentsController::collegestudentgradesview');

$routes->set404Override(function() {
    echo view('errors/custom_error');
});