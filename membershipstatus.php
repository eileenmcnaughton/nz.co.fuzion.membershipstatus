<?php

require_once 'membershipstatus.civix.php';

/**
 * Implementation of hook_civicrm_config
 */
function membershipstatus_civicrm_config(&$config) {
  _membershipstatus_civix_civicrm_config($config);
}

/**
 * Implementation of hook_civicrm_xmlMenu
 *
 * @param $files array(string)
 */
function membershipstatus_civicrm_xmlMenu(&$files) {
  _membershipstatus_civix_civicrm_xmlMenu($files);
}

/**
 * Implementation of hook_civicrm_install
 */
function membershipstatus_civicrm_install() {
  return _membershipstatus_civix_civicrm_install();
}

/**
 * Implementation of hook_civicrm_uninstall
 */
function membershipstatus_civicrm_uninstall() {
  return _membershipstatus_civix_civicrm_uninstall();
}

/**
 * Implementation of hook_civicrm_enable
 */
function membershipstatus_civicrm_enable() {
  return _membershipstatus_civix_civicrm_enable();
}

/**
 * Implementation of hook_civicrm_disable
 */
function membershipstatus_civicrm_disable() {
  return _membershipstatus_civix_civicrm_disable();
}

/**
 * Implementation of hook_civicrm_upgrade
 *
 * @param $op string, the type of operation being performed; 'check' or 'enqueue'
 * @param $queue CRM_Queue_Queue, (for 'enqueue') the modifiable list of pending up upgrade tasks
 *
 * @return mixed  based on op. for 'check', returns array(boolean) (TRUE if upgrades are pending)
 *                for 'enqueue', returns void
 */
function membershipstatus_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _membershipstatus_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implementation of hook_civicrm_managed
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 */
function membershipstatus_civicrm_managed(&$entities) {
  return _membershipstatus_civix_civicrm_managed($entities);
}

/**
 * Implementation of hook_civicrm_caseTypes
 *
 * Generate a list of case-types
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 */
function membershipstatus_civicrm_caseTypes(&$caseTypes) {
  _membershipstatus_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implementation of hook_civicrm_alterCalculatedMembershipStatus
 * Set membership status according to membership type
 * @param array $membershipStatus
 * @param array $arguments
 * @param array $membership
 */
function membershipstatus_civicrm_alterCalculatedMembershipStatus(&$membershipStatus, $arguments, $membership) {
  //currently we are hardcoding a rule for membership type ids 14, 15, & 16
  if(empty($arguments['membership_type_id']) || !in_array($arguments['membership_type_id'], array(14, 15, 16))) {
    return;
  }
  $statusDate = strtotime($arguments['status_date']);
  $endDate = strtotime($arguments['end_date']);
  $graceEndDate = strtotime('+ 12 months', $endDate);
  if($statusDate >  $endDate && $statusDate <= $graceEndDate) {
    $membershipStatus['name'] = 'Grace';
    $membershipStatus['id'] = 8;
  }
}