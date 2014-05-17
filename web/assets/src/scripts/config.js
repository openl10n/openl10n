require.config({
  baseUrl: '/assets/dist/js',
  paths: {
    'jquery': '../vendor/jquery/dist/jquery.min',
    'bootstrap': '../vendor/bootstrap/dist/js/bootstrap.min',
    'domReady': '../vendor/requirejs-domready/domReady',
    'string': '../vendor/string/lib/string',
    'backbone': '../vendor/backbone/backbone',
    'backbone.wreqr': '../vendor/backbone.wreqr/lib/backbone.wreqr',
    'backbone.babysitter': '../vendor/backbone.babysitter/lib/backbone.babysitter',
    'backbone.select': '../vendor/backbone.select/dist/amd/backbone.select',
    'marionette': '../vendor/marionette/lib/core/amd/backbone.marionette',
    'underscore': '../vendor/underscore/underscore',
    'text': '../vendor/requirejs-text/text',
    'tpl': '../vendor/requirejs-tpl-jfparadis/tpl',
    'json': '../vendor/requirejs-plugins/src/json',
  },
  shim: {
    'bootstrap': ['jquery'],
    'string': {
      exports: 'S'
    },
    'backbone': {
      deps: ['underscore', 'jquery'],
      exports: 'Backbone'
    }
  },
  tpl: {
    extension: '.tpl' // default = '.html'
  }
});

define(['domReady', 'jquery', 'bootstrap'], function() {});
