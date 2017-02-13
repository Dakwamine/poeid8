<?php

namespace Drupal\annonce\Entity;

use Drupal\views\EntityViewsData;
use Drupal\views\EntityViewsDataInterface;

/**
 * Provides the views data for the Annonce entity type.
 */
class AnnonceViewsData extends EntityViewsData implements EntityViewsDataInterface {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    // https://api.drupal.org/api/drupal/core%21modules%21views%21views.api.php/function/hook_views_data/8.2.x
//    $data['annonce']['table']['base'] = array(
//      'field' => 'id',
//      'title' => t('Annonce'),
//      'help' => t('The annonce entity ID.'),
//    );

    $data['annonce_history'] = [
      'table' => [
        'group' => t('Annonce tatable'),
        'base' => [
          'field' => 'id',
          'title' => t('Annonce history'),
          'help' => t('The annonce history')
        ]
      ],
      'uid' => [
        'title' => t('Id of the user who accessed the annonce.'),
        'field' => [
          // ID of field handler plugin to use.
          'id' => 'standard'
        ],
        'relationship' => [
          // Views name of the table to join to for the relationship.
          'base' => 'users_field_data',
          // Database field name in the other table to join on.
          'base field' => 'uid',
          // ID of relationship handler plugin to use.
          'id' => 'standard',
          // Default label for relationship in the UI.
          'label' => t('Info of the user who accessed the annonce.')
        ]
      ],
      'access_time' => [
        'title' => t('When was the annonce visited.'),
        'field' => [
          // ID of field handler plugin to use.
          'id' => 'date'
        ]
      ],
      'annonce_id' => [
        'title' => t('Id of the visited annonce.'),
        'field' => [
          // ID of field handler plugin to use.
          'id' => 'standard'
        ],
        'relationship' => [
          // Views name of the table to join to for the relationship.
          'base' => 'annonce',
          // Database field name in the other table to join on.
          'base field' => 'id',
          // ID of relationship handler plugin to use.
          'id' => 'standard',
          // Default label for relationship in the UI.
          'label' => t('Info of the visited annonce.')
        ]
      ]
    ];

    return $data;
  }

}
