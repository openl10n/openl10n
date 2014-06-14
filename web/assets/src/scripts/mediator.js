define([], function() {
  var apps = {};
  var currentApp;

  return {
    registerApp: function(appName, app) {
      apps[appName] = app;
    },

    startApp: function(appName, options) {
      options = options || {};

      // If app is already started, do nothing
      if (appName === currentApp)
        return;

      // Stop previsou app
      if (apps[currentApp])
        apps[currentApp].stop(options);

      // Swith app
      currentApp = appName;

      // Start new app
      if (apps[currentApp])
        apps[currentApp].start(options);
    },
  };
})
