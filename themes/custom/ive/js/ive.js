(function($, Drupal, drupalSettings) {
  // External links
  Drupal.behaviors.externalLink = {
    attach: function(context, settings) {
      $("a[href^='http']", context).attr('target', '_blank').addClass('external');
    }
  }
  
  Drupal.behaviors.collapsableBlock = {
    attach: function(context, settings) {
      $('.sidebar .block h2', context).click(function() {
        $(this).parent().find('.content').slideToggle('fast');
      });
    }
  }
  
  Drupal.behaviors.matchHeight = {
    attach: function(context, settings) {
      $('.row > .matchHeight', context).matchHeight();
    }
  }
})(jQuery, Drupal, drupalSettings);