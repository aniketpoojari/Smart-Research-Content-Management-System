
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
    window.location.href = "../HTML/login.html";
  }
});

function logout(){
  firebase.auth().signOut().then(function() {
  // Sign-out successful.
  window.location.href = "../HTML/login.html";
}).catch(function(error) {
  // An error happened.
});
}

function viewTenure(sid){
  console.log(sid.name);
  window.location.href=`viewdoc.html?sid=${sid.name}`;
}

console.log(window.location.href);
if(window.location.href == "http://localhost/sih_NEW/FrontEnd/views/viewtenure.html")
{
  
  var param = new URLSearchParams();

  param.append('action',"viewProposalBeforeDirector");

  var key = localStorage.getItem("tempKey");

  console.log(key);


  firebase.database().ref().child('users').child(key).once('value').then(function (snapshot) {

    param.append("student_ID", id = ""/*snapshot.val().id*/);

    param.append("name", name = snapshot.val().name);

    param.append("role", role = snapshot.val().role);

    var select = document.getElementById("projTable");

    var xhttp1 = new XMLHttpRequest();

    xhttp1.onreadystatechange = function () {


      if (this.readyState == 4 && this.status == 200) {
        console.log(this.responseText);
        var myob = JSON.parse(this.responseText);

        var tab = document.getElementById("projTable");
        for (var i = 0; i < Object.keys(myob['students']).length; i++) {
          console.log(i);
          var tr = tab.insertRow();
          var td = tr.insertCell(0);
          td.appendChild(document.createTextNode(project_ID = myob['students'][i]['student_ID']));
          
          var td1 = tr.insertCell(1);
          td1.appendChild(document.createTextNode(myob['students'][i]['student_name']));
          
          var td2 = tr.insertCell(2);
          td2.appendChild(document.createTextNode(myob['students'][i]['tenure_start']));
          
          var td3 = tr.insertCell(3);
          td3.appendChild(document.createTextNode(myob['students'][i]['tenure_end']));
          

          /*var td4 = tr.insertCell(4);
          var btn = document.createElement('button');
          //btn.setAttribute("id",`btn${i}`);
          btn.type = "button";
          btn.className = "waves-effect waves-light btn teal";
          btn.appendChild(document.createTextNode("View"));
          btn.setAttribute("onclick","viewDocuments(this)");
          btn.setAttribute("name",project_ID);
          td5.appendChild(btn);*/
          }
      }
      }
    xhttp1.open("POST","../../Backend/controllers/controller-HR.php", true);

    xhttp1.send(param);
  });

}

function extendTenure(){
    window.location.href=``;
  }
  
  console.log(window.location.href);
  if(window.location.href == "http://localhost/sih_NEW/FrontEnd/views/extendtenure.html")
  {
    
    var param = new URLSearchParams();
  
    param.append('action',"extendTenure");
  
    var key = localStorage.getItem("tempKey");
  
    console.log(key);
  
  
    firebase.database().ref().child('users').child(key).once('value').then(function (snapshot) {
  
      param.append("student_ID", id = ""/*snapshot.val().id*/);
  
      param.append("name", name = snapshot.val().name);
  
      param.append("role", role = snapshot.val().role);
  
      var select = document.getElementById("projTable");
  
      var xhttp1 = new XMLHttpRequest();
  
      xhttp1.onreadystatechange = function () {
  
  
        if (this.readyState == 4 && this.status == 200) {
          console.log(this.responseText);
          var myob = JSON.parse(this.responseText);
  
          var tab = document.getElementById("projTable");
          for (var i = 0; i < Object.keys(myob['students']).length; i++) {
            console.log(i);
            var tr = tab.insertRow();
            var td = tr.insertCell(0);
            td.appendChild(document.createTextNode(project_ID = myob['students'][i]['student_ID']));
            
            var td1 = tr.insertCell(1);
            td1.appendChild(document.createTextNode(myob['students'][i]['student_name']));
            
            var td2 = tr.insertCell(2);
            td2.appendChild(document.createTextNode(myob['students'][i]['tenure_start']));
            
            var td3 = tr.insertCell(3);
            td3.appendChild(document.createTextNode(myob['students'][i]['tenure_end']));
            
  
            var td4 = tr.insertCell(4);
            var btn = document.createElement('button');
            //btn.setAttribute("id",`btn${i}`);
            btn.type = "button";
            btn.className = "waves-effect waves-light btn teal";
            btn.appendChild(document.createTextNode("View"));
            btn.setAttribute("onclick","extendTenure(this)");
            localStorage.setItem("sid",student_ID);
           localStorage.setItem("date",new_date);
            td4.appendChild(btn);
        
            }
        }
        }
      xhttp1.open("POST","../../Backend/controllers/controller-HR.php", true);
  
      xhttp1.send(param);
    });
  
  }

