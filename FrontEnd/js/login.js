
firebase.auth().onAuthStateChanged(function(user) {
  if (user) {
    // User is signed in.\
     key = user.uid;
     localStorage.setItem("tempKey",key);
     console.log(key);
     firebase.database().ref().child('users').child(key).once('value').then(function (snapshot) {
      activated = snapshot.val().activated;
      if(activated == '0'){
        window.alert("Your account is not activated.<br>Please contact Secretariat for activation ");
        firebase.auth().signOut().then(function() {
          localStorage.removeItem('tempKey');
      // Sign-out successful.
      window.location.href = "login.html";
    }).catch(function(error) {
      // An error happened.
    });
      }
      role = snapshot.val().role;
      if(role=="Student"){
        window.location.href = "user.html";
      }
      if(role=="Guide"){
        window.location.href ="guide_profile.html";
      }
      if(role=="IRB"){
        window.location.href ="irb-allproposals.html";
      }
      if(role=="Director"){
        window.location.href ="director_user.html";
      }
      if(role=="HR"){
        window.location.href ="hr.html";
      }
      if(role== "Secretariat"){
        window.location.href ="secretariat.html";
      }
    });
 
}
  else {
    // No user is signed in.
  }
});

function login(btn){
 
  var userEmail = document.getElementById("email_field").value;
  var userPass = document.getElementById("password_field").value;
  if( userEmail== ''){
    window.alert("Please fill the email field")
    throw new Error("Please fill the email field");
  }
  else
{
  var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
if(!(userEmail.match(mailformat)))
  {
    window.alert("Please enter a proper email id");
    document.getElementById("email").focus();
    throw new Error("Please enter a proper email id");
    
  }
}
  if(userPass.length < 6){
    window.alert("Please enter 6 or more digit password");
    throw new Error("Please enter 6 or more digit password");
  }
  btn.innerHTML = `<i class="fa fa-spinner fa-spin"></i>`;
  firebase.auth().signInWithEmailAndPassword(userEmail, userPass).catch(function(error) {
    // Handle Errors here.
    var errorCode = error.code;
    var errorMessage = error.message;

    window.alert("Error : " + errorMessage);

    // ...
  });

}