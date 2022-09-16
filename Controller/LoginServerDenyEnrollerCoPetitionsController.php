<?php

App::uses('CoPetitionsController', 'Controller');

class LoginServerDenyEnrollerCoPetitionsController extends CoPetitionsController {
  // Class name, used by Cake
  public $name = "LoginServerDenyEnrollerCoPetitions";

  public $uses = array('CoPetition',
                       'LoginServerDenyEnroller.LoginServerDenyEnroller');

  protected $cfg = null;

  protected function execute_plugin_processConfirmation($id, $onFinish) {
    $this->getCfg();

    $cfg = $this->cfg;

    // The processConfirmation step should only intercept when the enrollment flow authorization
    // is not configured for Authenticated User and also not configured for None, and
    // match policy is not self (to avoid an identity linking flow).
    if(($cfg['CoEnrollmentFlowWedge']['CoEnrollmentFlow']['authz_level'] == EnrollmentAuthzEnum::AuthUser) ||
       ($cfg['CoEnrollmentFlowWedge']['CoEnrollmentFlow']['authz_level'] == EnrollmentAuthzEnum::None) ||
       ($cfg['CoEnrollmentFlowWedge']['CoEnrollmentFlow']['match_policy'] == EnrollmentMatchPolicyEnum::Self) 
      ) {
      $this->redirect($onFinish);
    }

    $this->examine($onFinish);
  }

  protected function execute_plugin_start($id, $onFinish) {
    $this->getCfg();

    $cfg = $this->cfg;

    // The start step should only intercept when the enrollment flow authorization
    // is configured for 'Authenticated User'.
    if($cfg['CoEnrollmentFlowWedge']['CoEnrollmentFlow']['authz_level'] != EnrollmentAuthzEnum::AuthUser) {
      $this->redirect($onFinish);
    }

    $this->examine($onFinish);
  }

  protected function examine($onFinish) {
    $cfg = $this->cfg;

    $loginServerIdEnv = $cfg['LoginServerDenyEnroller']['env_login_server'];
    $denyGithub = $cfg['LoginServerDenyEnroller']['deny_github'];
    $denyGoogle = $cfg['LoginServerDenyEnroller']['deny_google'];
    $denyMicrosoft = $cfg['LoginServerDenyEnroller']['deny_microsoft'];
    $denyOrcid = $cfg['LoginServerDenyEnroller']['deny_orcid'];
    $denyRedirect = $cfg['LoginServerDenyEnroller']['deny_redirect'];

    // Get the login server identifier from the environment.
    $loginServerId = env($loginServerIdEnv);

    if(empty($loginServerId)) {
      throw new InvalidArgumentException(_txt('er.unknown', array($loginServerIdEnv)));
    }

    $isGithub    = ($loginServerId == 'http://github.com/login/oauth/authorize');
    $isGoogle    = ($loginServerId == 'http://google.com/accounts/o8/id');
    $isMicrosoft = ($loginServerId == 'http://login.microsoftonline.com/common/oauth2/v2.0/authorize');
    $isOrcid     = ($loginServerId == 'http://orcid.org/oauth/authorize');
 
    $deny = false;

    if($isGithub && $denyGithub) {
      $deny = true;
    }

    if($isGoogle && $denyGoogle) {
      $deny = true;
    }

    if($isMicrosoft && $denyMicrosoft) {
      $deny = true;
    }

    if($isOrcid && $denyOrcid) {
      $deny = true;
    }

    if($deny) {
      $this->redirect($denyRedirect);
    } else {
      $this->redirect($onFinish);
    }
  }

  protected function getCfg() {
    $efwid = $this->viewVars['vv_efwid'];

    // Pull our configuration.
    $args = array();
    $args['conditions']['LoginServerDenyEnroller.co_enrollment_flow_wedge_id'] = $efwid;
    $args['contain']['CoEnrollmentFlowWedge'] = 'CoEnrollmentFlow';

    $cfg = $this->LoginServerDenyEnroller->find('first', $args);

    if(empty($cfg)) {
      throw new InvalidArgumentException(_txt('er.unknown', array($efwid)));
    }

    $this->cfg = $cfg;
  }
} 
