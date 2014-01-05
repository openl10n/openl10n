window.fbAsyncInit = function() {
  // init the FB JS SDK
  FB.init({
    appId      : '561139240630280',                    // App ID from the app dashboard
    channelUrl : '//openl10n.local/channel.html',      // Channel file for x-domain comms
    status     : true,                                 // Check Facebook Login status
    xfbml      : true                                  // Look for social plugins on the page
  });
};

// Load the SDK asynchronously
(function(d, s, id){
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) {return;}
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

function fb_login() {
  FB.getLoginStatus(function(response) {
    if (response.status === 'connected') {
      // connected
      console.log('Already connected, redirect to login page to create token.');
      document.location = "{{ url("hwi_oauth_service_redirect", {service: "facebook"}) }}";
    } else {
        // not_authorized
        FB.login(function(response) {
          if (response.authResponse) {
            document.location = "{{ url("hwi_oauth_service_redirect", {service: "facebook"}) }}";
          } else {
            console.log('Cancelled.');
          }
        }, {scope: 'email'});
      }
  });
}

$('.btn-oauth-facebook').on('click', function(evt) {
  evt.preventDefault();
  fb_login();
});
