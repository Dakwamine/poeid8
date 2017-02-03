<?php

/**
 * @file
 * Custom Drush integration.
 */

/**
 * Implements hook_drush_command().
 */
function super_pomme_drush_command_drush_command() {
  $items = array();
  $items['hello_world'] = [
    'description' => 'Commande hello_world',
    'arguments' => [
      'name' => 'Argument name',
    ],
    'aliases' => ['hw'],
  ];
  
  return $items;
}

/**
 * The call back function name in the following format.
 * 
 * drush_(module_name)_(item_id_for_command)().
 */
function drush_super_pomme_drush_command_hello_world($env = '') {
  echo 'test ';
}
