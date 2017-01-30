(function($, Drupal, drupalSettings) {
  Drupal.behaviors.myTabs = {
    attach: function(context, settings) {
      $( "#tabs", context).tabs();
    }
  }
})(jQuery, Drupal, drupalSettings);