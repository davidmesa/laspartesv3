<?
/*
The reCaptcha server keys and API locations

Obtain your own keys from:
http://www.recaptcha.net
*/
$config['recaptcha'] = array(
  'public'=>'6LcBZsISAAAAAIZrPN75bk2G_LfazIra7XjHZlAy',
  'private'=>'6LcBZsISAAAAAD37qtQQ7L3hx-8r5AkmHAkRrkUi',
  'RECAPTCHA_API_SERVER' =>'http://www.google.com/recaptcha/api',
  'RECAPTCHA_API_SECURE_SERVER'=>'https://www.google.com/recaptcha/api',
  'RECAPTCHA_VERIFY_SERVER' =>'www.google.com',
  'RECAPTCHA_SIGNUP_URL' => 'https://www.google.com/recaptcha/admin/create',
  'theme' => 'red'
);
