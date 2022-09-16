<?php

global $cm_lang, $cm_texts;

// When localizing, the number in format specifications (eg: %1$s) indicates the argument
// position as passed to _txt.  This can be used to process the arguments in
// a different order than they were passed.

$cm_login_server_deny_enroller_texts['en_US'] = array(
  // Titles, per-controller
  'ct.login_server_deny_enrollers.1'  => 'Login Server Deny Enroller',
  'ct.login_server_deny_enrollers.pl' => 'Login Server Deny Enrollers',
  
  // Plugin texts
  'pl.loginserverdenyenroller.env_login_server'      => 'Login Server Environment Variable',
  'pl.loginserverdenyenroller.env_login_server.desc' => 'Environment variable containing the login server identifier',
  'pl.loginserverdenyenroller.deny_github'           => 'Deny GitHub',
  'pl.loginserverdenyenroller.deny_github.desc'      => 'Deny authenticating using GitHub',
  'pl.loginserverdenyenroller.deny_google'           => 'Deny Google',
  'pl.loginserverdenyenroller.deny_google.desc'      => 'Deny authenticating using Google',
  'pl.loginserverdenyenroller.deny_microsoft'        => 'Deny Microsoft',
  'pl.loginserverdenyenroller.deny_microsoft.desc'   => 'Deny authenticating using Microsoft',
  'pl.loginserverdenyenroller.deny_orcid'            => 'Deny ORCID',
  'pl.loginserverdenyenroller.deny_orcid.desc'       => 'Deny authenticating using ORCID',
  'pl.loginserverdenyenroller.deny_redirect'         => 'Redirect URL',
  'pl.loginserverdenyenroller.deny_redirect.desc'    => 'URL to which the denied user will be redirected',
);
