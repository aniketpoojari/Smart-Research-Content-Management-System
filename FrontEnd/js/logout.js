document.getElementById("ancLogout").addEventListener('click',function(event){
      event.preventDefault();
      firebase.auth().signOut().then(function() {
      // Sign-out successful.
      window.location.href = "login.html";
      localStorage.removeItem("tempKey");
    }).catch(function(error) {
      // An error happened.
    });
    });