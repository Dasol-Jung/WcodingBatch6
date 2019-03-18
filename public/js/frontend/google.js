
/* function trigger when the login of the user succeed
** @param googleUser Object The googleUser
**
*/
function onSuccess(googleUser) {

    // Google treatment for the user
    var profile = googleUser.getBasicProfile();
    var idToken = googleUser.getAuthResponse().id_token;
    var profileData = {
        "google_id" : idToken,
        "first_name": profile.getGivenName(),
        "last_name": profile.getFamilyName(),
        "image_url": profile.getImageUrl(),
        "email": profile.getEmail()
    };

    // we trigger our ajax on success
    var ajax = new XMLHttpRequest();
    ajax.open("POST", 'index.php?action=loggedIn', true);
    ajax.setRequestHeader("Content-type", "application/json");
    ajax.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        var results = this.responseText;
        console.log(results);
        
    }
    };
    var params = JSON.stringify(profileData);
    ajax.send(params);
}

/**
 * Function triggered when the google auth fail
 * @param {String} error 
 */
function onFailure(error) {
    // change to throw new exception later .....
    console.log(error);
}

/**
 * Main function of google to trigger the sign/log in button
 */
function renderButton() {
    gapi.signin2.render("my-signin2", {
    "scope": "profile email",
    "width": 240,
    "height": 50,
    "longtitle": false,
    "theme": "dark",
    "onsuccess": onSuccess,
    "onfailure": onFailure
    });
}



/**
 * function to logout the user
 * NO USE for now we'll see later if we need
 */
function signOut() {
    var auth2 = gapi.auth2.getAuthInstance();
    if (googleIdSession){
        auth2.signOut().then(function () {
        console.log("User signed out.");
        });
    }
    else {
        console.log("Not logged in.");
    }
    }