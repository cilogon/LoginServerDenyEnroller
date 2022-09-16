<?php

class LoginServerDenyEnroller extends AppModel {
  // Required by COmanage Plugins
  public $cmPluginType = "enroller";

  // Document foreign keys
  public $cmPluginHasMany = array();

  // Add behaviors
  public $actsAs = array('Containable', 'Changelog' => array('priority' => 5));

  // Association rules from this model to other models
  public $belongsTo = array("CoEnrollmentFlowWedge");

  public $hasMany = array(
    "LoginServerDenyEnroller.SamlLoginServer"
  );

  // Validation rules for table elements
  public $validate = array(
    'co_enrollment_flow_wedge_id' => array(
      'rule' => 'numeric',
      'required' => true,
      'allowEmpty' => false
    ),
    'env_login_server' => array(
      'rule' => 'notBlank',
      'required' => true,
      'allowEmpty' => false
    ),
    'deny_github' => array(
      'rule' => array('boolean')
    ),
    'deny_google' => array(
      'rule' => array('boolean')
    ),
    'deny_microsoft' => array(
      'rule' => array('boolean')
    ),
    'deny_orcid' => array(
      'rule' => array('boolean')
    ),
    'deny_redirect' => array(
      'rule' => array('custom', '/^https?:\/\/.*/'),
      'required' => true,
      'allowEmpty' => false
    )
  );

  /**
   * Expose menu items.
   * 
   * @return Array with menu location type as key and array of labels, controllers, actions as values.
   */
  public function cmPluginMenus() {
    return array();
  }
}
