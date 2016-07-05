<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/
/*********************************************************************
 *                        User routes
 * *******************************************************************/
$route['login']					= 'users/login';
$route['register']				= 'users/register';
$route['register/(:any)']		= 'users/register/$1';
$route['disconnect']			= 'users/disconnect';
$route['users/process/(:any)']	= 'users/$1';
$route['users/(:any)']			= "users/profile/$1";

/*********************************************************************
 *                        Ajax routes
 * *******************************************************************/
$route['ajax/quizz/(:any)']				= 'quizz/ajax/$1';
$route['ajax/roles/(:any)']				= 'roles/ajax/$1';

/*********************************************************************
 *                        Roles routes
 * *******************************************************************/
 //tmp
 //$route['roles/dom']					= 'roles/dom';
 $route['roles']						= 'roles';
 $route['roles/test']					= 'roles/test';
 $route['domains']						= 'roles/domains';
 $route['domains/(:any)/(:any)']		= 'roles/role_details/$1/$2';
 $route['roles/domains/(:any)']			= 'roles/domain_details/$1';
 $route['privileges']					= 'roles/privileges';
 $route['privileges/(:any)']			= 'roles/privilege_managment/$1';

 /*********************************************************************
 *                        List routes
 * *******************************************************************/
$route['lists']							= 'lists';
$route['lists/create']					= 'lists/create_list';
$route['lists/process/create/(:any)']	= 'lists/creation_form/$1';
$route['lists/update']					= 'lists/update_list';
$route['lists/process/create']			= 'lists/creation_form';
$route['lists/(:any)']					= 'lists/display_list/$1';



$route['default_controller'] 	= "quizz/quizz";
$route['404_override'] 			= 'page_not_found_404';


/* End of file routes.php */
/* Location: ./application/config/routes.php */