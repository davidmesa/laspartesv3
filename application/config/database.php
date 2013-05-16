<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the 'Database Connection'
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	['hostname'] The hostname of your database server.
|	['username'] The username used to connect to the database
|	['password'] The password used to connect to the database
|	['database'] The name of the database you want to connect to
|	['dbdriver'] The database type. ie: mysql.  Currently supported:
				 mysql, mysqli, postgre, odbc, mssql, sqlite, oci8
|	['dbprefix'] You can add an optional prefix, which will be added
|				 to the table name when using the  Active Record class
|	['pconnect'] TRUE/FALSE - Whether to use a persistent connection
|	['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
|	['cache_on'] TRUE/FALSE - Enables/disables query caching
|	['cachedir'] The path to the folder where cache files should be stored
|	['char_set'] The character set used in communicating with the database
|	['dbcollat'] The character collation used in communicating with the database
|	['swap_pre'] A default table prefix that should be swapped with the dbprefix
|	['autoinit'] Whether or not to automatically initialize the database.
|	['stricton'] TRUE/FALSE - forces 'Strict Mode' connections
|							- good for ensuring strict SQL while developing
|
| The $active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the 'default' group).
|
| The $active_record variables lets you determine whether or not to load
| the active record class
*/


//credenciales para la DB del CRM
$active_group = "CRM";
$active_record = TRUE;
$db['CRM']['hostname'] = '98.130.0.94';
$db['CRM']['username'] = 'laspart_version2';
$db['CRM']['password'] = 'V2rs34n2';
$db['CRM']['database'] = 'laspart_crm';
$db['CRM']['dbdriver'] = 'mysql';
$db['CRM']['dbprefix'] = '';  
$db['CRM']['pconnect'] = TRUE;
$db['CRM']['db_debug'] = TRUE;
$db['CRM']['cache_on'] = FALSE;
$db['CRM']['cachedir'] = '';
$db['CRM']['char_set'] = 'utf8';
$db['CRM']['dbcollat'] = 'utf8_general_ci';
$db['CRM']['swap_pre'] = '';
$db['CRM']['autoinit'] = TRUE;
$db['CRM']['stricton'] = FALSE;

$active_group = 'default';
$active_record = TRUE;

$db['default']['hostname'] = '98.130.0.94'; 
$db['default']['username'] = 'laspart_version2';
$db['default']['password'] = 'V2rs34n2';
$db['default']['database'] = 'laspart_version2';
$db['default']['dbdriver'] = 'mysql';
$db['default']['dbprefix'] = '';  
$db['default']['pconnect'] = TRUE;
$db['default']['db_debug'] = TRUE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = '';
$db['default']['char_set'] = 'utf8';
$db['default']['dbcollat'] = 'utf8_general_ci';
$db['default']['swap_pre'] = '';
$db['default']['autoinit'] = TRUE;
$db['default']['stricton'] = FALSE;

/* End of file database.php */
/* Location: ./application/config/database.php */