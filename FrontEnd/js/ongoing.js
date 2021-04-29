firebase.auth().onAuthStateChanged(function(user) {
  if (user) {
    // User is signed in.
    var displayName = user.displayName;
    var email = user.email;
    var emailVerified = user.emailVerified;
    var photoURL = user.photoURL;
    var isAnonymous = user.isAnonymous;
    var uid = user.uid;
    var providerData = user.providerData;

    console.log(displayName);
    // ...
  } else {
    // User is signed out.
    // ...
    window.location.href = "login.html";
  }
});

function logout(){
  firebase.auth().signOut().then(function() {
  // Sign-out successful.
  window.location.href = "login.html";
}).catch(function(error) {
  // An error happened.
});
}

function viewDocuments(pid){
  console.log(pid.name);
  window.location.href=`viewdoc.html?pid=${pid.name}`;
}

if(window.location.href == "http://localhost/sih/FrontEnd/views/guide.html"){
  var key = localStorage.getItem("tempKey");

  console.log(key);
firebase.database().ref().child('users').child(key).once('value').then(function (snapshot) {

    guideID= "ID1"/*snapshot.val().id*/;

    document.getElementById("name").innerHTML= snapshot.val().name;

    document.getElementById("role").innerHTML= snapshot.val().role;

});
}
if(window.location.href == "http://localhost/sih/FrontEnd/views/ongoing.html")
{
  var param = new URLSearchParams();

  param.append('action',"viewProjects");

  var key = localStorage.getItem("tempKey");

  console.log(key);


  firebase.database().ref().child('users').child(key).once('value').then(function (snapshot) {

    param.append("guideID", id = "ID1"/*snapshot.val().id*/);

    param.append("name", name = snapshot.val().name);

    param.append("role", role = snapshot.val().role);

    var select = document.getElementById("ddlProject");

    var xhttp1 = new XMLHttpRequest();

    xhttp1.onreadystatechange = function () {

      if (this.readyState == 4 && this.status == 200) {
        console.log(this.responseText);
        var myob = JSON.parse(this.responseText);

        var tab = document.getElementById("projTable");
        for (var i = 0; i < Object.keys(myob['deadlines']).length; i++) {
          console.log(i);
          var tr = tab.insertRow();
          var td = tr.insertCell(0);
          td.appendChild(document.createTextNode(project_ID = myob['deadlines'][i]['project_ID']));
          
          var td1 = tr.insertCell(1);
          td1.appendChild(document.createTextNode(myob['deadlines'][i]['project_name']));
          
          var td2 = tr.insertCell(2);
          td2.appendChild(document.createTextNode(myob['deadlines'][i]['derived_from']));
          
          var td3 = tr.insertCell(3);
          td3.appendChild(document.createTextNode(myob['deadlines'][i]['date_of_start']));
          
          var td4 = tr.insertCell(4);
          td4.appendChild(document.createTextNode(myob['deadlines'][i]['budget_proposed']));

          var td5 = tr.insertCell(5);
          var btn = document.createElement('button');
          //btn.setAttribute("id",`btn${i}`);
          btn.type = "button";
          btn.className = "waves-effect waves-light btn teal";
          btn.appendChild(document.createTextNode("View"));
          btn.setAttribute("onclick","viewDocuments(this)");
          btn.setAttribute("name",project_ID);
          td5.appendChild(btn);
          }
      }
      }
    xhttp1.open("POST","../../Backend/controllers/controller-guide.php", true);

    xhttp1.send(param);
  });

}
