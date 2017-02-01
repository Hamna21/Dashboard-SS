<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'Login';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


//---------------Dashboard------------//
$route['dashboard'] = 'Dashboard';
$route['lectures'] = 'Dashboard/lectures';
$route['courses'] = 'Dashboard/courses';
$route['categories'] = 'Dashboard/categories';
$route['teachers'] = 'Dashboard/teachers';
$route['second-screen/resetPassword'] = 'Login/resetPasswordView';

//---------------Courses------------//
$route['courses'] = 'Dashboard/courses';
$route['courses/:num'] = 'Dashboard/courses';
$route['course/add'] = 'Course/add';
$route['course/edit'] = 'Course/edit';
$route['course/delete'] = 'Course/deleteCourse';
$route['course/comments'] = 'Course/course_comments';
$route['course/comments/:num'] = 'Course/course_comments';

//-------------Category-------------//
$route['categories'] = 'Dashboard/categories';
$route['categories/:num'] = 'Dashboard/categories';
$route['category/add'] = 'Category/add';
$route['category/edit'] = 'Category/edit';

//---------------Teacher------------//
$route['teachers'] = 'Dashboard/teachers';
$route['teachers/:num'] = 'Dashboard/teachers';
$route['teacher/add'] = 'Teacher/add';
$route['teacher/edit'] = 'Teacher/edit';
$route['teacher/delete'] = 'Teacher/deleteTeacher';

//---------------Lecture------------//
$route['lectures'] = 'Dashboard/lectures';
$route['lectures/:num'] = 'Dashboard/lectures';
$route['lecture/add'] = 'Lecture/add';
$route['lecture/edit'] = 'Lecture/edit';
$route['lecture/delete'] = 'Lecture/deleteLecture';
$route['lecture/comments'] = 'Lecture/lecture_comments';
$route['lecture/comments/:num'] = 'Lecture/lecture_comments';

//--------------QUIZ-----------------//
$route['quiz/:num'] = 'Quiz/view';
$route['quiz'] = 'Quiz/view';

$route['quiz/add'] = 'Quiz/addQuiz';
$route['quiz/delete'] = 'Quiz/deleteQuiz';


//--------------QUESTION-----------------//
$route['questions/:num'] = 'Question/view';
$route['questions'] = 'Question/view';


$route['question/add'] = 'Question/addQuestion';
$route['question/edit'] = 'Question/editQuestion';
$route['question/delete'] = 'Question/deleteQuestion';

//-----------REFERENCE---------------------
$route['reference/:num'] = 'Lecture_Reference/view';
$route['reference'] = 'Lecture_Reference/view';
$route['reference/delete'] = 'Lecture_Reference/deleteReference';

