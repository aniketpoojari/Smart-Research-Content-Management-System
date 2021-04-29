//------------------------------------AUTHENTICATION-----------------------------------------------


var key = localStorage.getItem("tempKey");
if (key != null) {
	firebase.database().ref().child('users').child(key).once('value').then(function (snapshot) {
		role = snapshot.val().role;
		if (role != "Director") {
			window.location.href = "login.html";
		}

	});
}
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
        if(window.location.href == "http://localhost/sih/FrontEnd/views/director_user.html")
      {     
        firebase.database().ref().child('users').child(uid).once('value').then(function (snapshot) {
          var role = snapshot.val().role;
          document.getElementById("role").innerHTML = role;
          document.getElementById("userName").innerHTML = snapshot.val().name;
        });
      }
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
  console.log(window.location.href);
  if(window.location.href == "http://localhost/sih/FrontEnd/views/director_viewpro.html")
  {
    console.log("hello");
    
    var param = new URLSearchParams();
  
    param.append('action',"viewProposals");
  
    var key = localStorage.getItem("tempKey");
  
    console.log(key);
  
  
    firebase.database().ref().child('users').child(key).once('value').then(function (snapshot) {
  
      var select = document.getElementById("projTable");
  
      var xhttp1 = new XMLHttpRequest();
  
      xhttp1.onreadystatechange = function () {
  
  
        if (this.readyState == 4 && this.status == 200) {
          console.log(this.responseText);
          var myob = JSON.parse(this.responseText);
  
          var tab = document.getElementById("projTable");
          for (var i = 0; i < Object.keys(myob['documents']).length; i++) {
            console.log(i);
            var tr = tab.insertRow();
            var td = tr.insertCell(0);
            td.appendChild(document.createTextNode(myob['documents'][i]['student_ID']));
            
            var td1 = tr.insertCell(1);
            td1.appendChild(document.createTextNode(myob['documents'][i]['project_ID']));
            
            var td2 = tr.insertCell(2);
            td2.appendChild(document.createTextNode(myob['documents'][i]['document_name']));
            

            var td3 = tr.insertCell(3);
            var btn = document.createElement('button');
            btn.type = "button";
            btn.setAttribute("class", "waves-effect waves-light btn teal");
            btn.setAttribute("onclick","viewIndividualProposal(this)");
            btn.setAttribute("data-sid", myob['documents'][i]['student_ID']);
            btn.setAttribute("data-subtime", myob['documents'][i]['submission_time']);
            btn.setAttribute("data-name", myob['documents'][i]['document_name']);
            btn.appendChild(document.createTextNode("View"));
            td3.appendChild(btn);

            var td4 = tr. insertCell(4);
            var td5 = tr. insertCell(5);
            var btn1 = document.createElement('button');
            var btn2 = document.createElement('button');
            var br = document.createElement('br');
            btn1.type = "button";
            btn2.type = "button";
            btn1.setAttribute("class", "waves-effect waves-light btn green");
            btn2.setAttribute("class", "waves-effect waves-light btn red");
            btn1.setAttribute("onclick","approveProjects(this)");
            btn2.setAttribute("onclick","disapproveProject(this)");
            btn1.setAttribute("data-sid", myob['documents'][i]['student_ID']);
            btn1.setAttribute("data-time", myob['documents'][i]['submission_time']);
            btn2.setAttribute("data-sid", myob['documents'][i]['student_ID']);
            btn2.setAttribute("data-time", myob['documents'][i]['submission_time']);
            btn1.appendChild(document.createTextNode("Approve"));
            btn2.appendChild(document.createTextNode("Disapprove"));
            td4.appendChild(btn1);
            td5.appendChild(btn2);
            
            }
        }
        }
      xhttp1.open("POST","../../Backend/controllers/controller-director.php", true);
  
      xhttp1.send(param);
    });




    // -----------------------------------------------------------------------------------------
    function viewIndividualProposal(btn){

        var sid = btn.dataset.sid;
        var time = btn.dataset.subtime;
        var name = btn.dataset.name;
        localStorage.setItem("sid",sid);
        localStorage.setItem("time",time);
        localStorage.setItem("name",name);
        window.location.href = "http://localhost/sih/FrontEnd/views/director_viewindipro.html";
    }

    

    //----------------------------------------------------
    
    


    function approveProjects(btn1){
        var sid = btn1.dataset.sid;
        var time = btn1.dataset.time;
        console.log(sid);
        console.log(time);
        var param = new URLSearchParams();
        param.append("action","approveProjects");
        param.append("studentID",sid);
        param.append("timestamp",time);
        
  
      var xhttp1 = new XMLHttpRequest();
  
      xhttp1.onreadystatechange = function () {
  
  
        if (this.readyState == 4 && this.status == 200) {
          console.log(this.responseText);
          var myob = JSON.parse(this.responseText);
          window.location.reload();
        }
      }
      xhttp1.open("POST","../../Backend/controllers/controller-director.php", true);
      
      xhttp1.send(param);
    }

    function disapproveProject(btn2){
      var sid = btn2.dataset.sid;
      var time = btn2.dataset.time;
      console.log(sid);
      console.log(time);
      var param = new URLSearchParams();
      param.append("action","disapproveProjects");
      param.append("studentID",sid);
      param.append("timestamp",time);
      
      
      var xhttp1 = new XMLHttpRequest();
      
      xhttp1.onreadystatechange = function () {
        
        
        if (this.readyState == 4 && this.status == 200) {
          console.log(this.responseText);
          var myob = JSON.parse(this.responseText);
          window.location.reload();
        }
      }
      xhttp1.open("POST","../../Backend/controllers/controller-director.php", true);
  
      xhttp1.send(param);
    }


  }


  //--------------------------------------------------------------------------------------


  if(window.location.href == "http://localhost/sih/FrontEnd/views/director_viewindipro.html"){
    var param = new URLSearchParams();
    var sid = localStorage.getItem("sid");
    var time = localStorage.getItem("time");
    var name = localStorage.getItem("name");

    param.append("studentID",sid);
    param.append("submission_time",time);
    param.append("action","viewIndividualProposal");

    var xhttp1 = new XMLHttpRequest();
    xhttp1.onreadystatechange = function () {
  
  
        if (this.readyState == 4 && this.status == 200) {
          console.log(this.responseText);
          var myob = JSON.parse(this.responseText);
          document.getElementById("proName").value = name;
          document.getElementById("proName").disabled = true;
          var a = (myob['documents'][0]['document'].split('&'));
          console.log(a);
          // console.log(a[1]);
          for( var i=0; i<60; i++)
          {
            console.log(i);
            var b = a[i].split('=')[1].split('+');
            console.log(b);
            if(b.length != 1){
              var c ="";
            for(var j =0;j<b.length;j++){
              c = c + b[j] + " ";
            }
            document.getElementById(i+1).value = c;
          }else{
            document.getElementById(i+1).value = b[0];
          }
          document.getElementById(i+1).disabled = true;
        }

          
    }
}
    xhttp1.open("POST","../../Backend/controllers/controller-director.php", true);
  
      xhttp1.send(param);

  


  }

  //--------------------------------------------------------------------------------------
  console.log(window.location.href);
  if(window.location.href == "http://localhost/sih/FrontEnd/views/director_viewbud.html")
  {
    console.log("hello");
    
    var param = new URLSearchParams();
  
    param.append('action',"viewBudgets");
  
    var key = localStorage.getItem("tempKey");
  
    console.log(key);
  
  
    firebase.database().ref().child('users').child(key).once('value').then(function (snapshot) {
  
      var select = document.getElementById("projTable");
  
      var xhttp1 = new XMLHttpRequest();
  
      xhttp1.onreadystatechange = function () {
  
  
        if (this.readyState == 4 && this.status == 200) {
          console.log(this.responseText);
          var myob = JSON.parse(this.responseText);
  
          var tab = document.getElementById("projTable");
          for (var i = 0; i < Object.keys(myob['documents']).length; i++) {
            console.log(i);
            var tr = tab.insertRow();
            var td = tr.insertCell(0);
            td.appendChild(document.createTextNode(myob['documents'][i]['student_ID']));
            
            var td1 = tr.insertCell(1);
            td1.appendChild(document.createTextNode(myob['documents'][i]['project_ID']));
            
            var td2 = tr.insertCell(2);
            td2.appendChild(document.createTextNode(myob['documents'][i]['document_name']));
            

            var td3 = tr.insertCell(3);
            var btn = document.createElement('button');
            btn.type = "button";
            btn.setAttribute("class", "waves-effect waves-light btn teal");
            btn.setAttribute("onclick","viewIndividualBudget(this)");
            btn.setAttribute("data-sid", myob['documents'][i]['student_ID']);
            btn.setAttribute("data-time", myob['documents'][i]['submission_time']);
            btn.appendChild(document.createTextNode("View"));
            td3.appendChild(btn);

           
            }
        }
        }
      xhttp1.open("POST","../../Backend/controllers/controller-director.php", true);
  
      xhttp1.send(param);
    });
    function viewIndividualBudget(btn){
      var sid = btn.dataset.sid;
      var time = btn.dataset.time;
      localStorage.setItem("sid",sid);
      localStorage.setItem("time",time);
      window.location.href = "http://localhost/sih/FrontEnd/views/director_viewindibud.html"
    }

  }
  //-------------------------------------------------------------------------------------------

  if(window.location.href == "http://localhost/sih/FrontEnd/views/director_viewindibud.html"){

    var param = new URLSearchParams();
    var sid = localStorage.getItem("sid");
    var time = localStorage.getItem("time");
    
    param.append("action","viewIndividualBudget");
    param.append("studentID",sid);
    param.append("submission_time",time);

    var xhttp1 = new XMLHttpRequest();
    xhttp1.onreadystatechange = function () {
  
  
        if (this.readyState == 4 && this.status == 200) {
          console.log(this.responseText);
          var myob = JSON.parse(this.responseText);
          var a = (myob['documents'][0]['document'].split('&'));
          console.log(a);
          console.log(a[1]);
          for( var i=0; i<78; i++)
          {
            console.log(i);
            var b = a[i].split('=')[1].split('+');
            console.log(b);
            if(b.length != 1){
              var c ="";
            for(var j =0;j<b.length;j++){
              c = c + b[j] + " ";
            }
            document.getElementById(i+1).value = c;
          }else{
            document.getElementById(i+1).value = b[0];
          }
          document.getElementById(i+1).disabled = true;
        }
      }
          
    }

    xhttp1.open("POST","../../Backend/controllers/controller-director.php", true);
  
      xhttp1.send(param);
  }
  //----------------------------------------------------------------------------------------
  if(window.location.href == "http://localhost/sih/FrontEnd/views/director_viewmins.html"){
    
      console.log("hello");
      
      var param = new URLSearchParams();
    
      param.append('action',"viewMinutes");
    
      var key = localStorage.getItem("tempKey");
    
      console.log(key);
    
    
      firebase.database().ref().child('users').child(key).once('value').then(function (snapshot) {
    
        var select = document.getElementById("projTable");
    
        var xhttp1 = new XMLHttpRequest();
    
        xhttp1.onreadystatechange = function () {
    
    
          if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            var myob = JSON.parse(this.responseText);
    
            var tab = document.getElementById("projTable");
            for (var i = 0; i < Object.keys(myob['documents']).length; i++) {
              console.log(i);
              var tr = tab.insertRow();
              var td = tr.insertCell(0);
              td.appendChild(document.createTextNode(myob['documents'][i]['student_ID']));
              
              var td1 = tr.insertCell(1);
              td1.appendChild(document.createTextNode(myob['documents'][i]['project_ID']));
              
              var td2 = tr.insertCell(2);
              td2.appendChild(document.createTextNode(myob['documents'][i]['document_name']));
         
              var td3 = tr.insertCell(3);
              var anc = document.createElement('a');
              anc.setAttribute("onclick","");
              anc.setAttribute("download","");
              anc.appendChild(document.createTextNode("Download"));
              td3.appendChild(anc);
  
              
            }
          }
          }
        xhttp1.open("POST","../../Backend/controllers/controller-director.php", true);
    
        xhttp1.send(param);
      });
  
  }
  //---------------------------------------------------------------------------------------------
  if(window.location.href == "http://localhost/sih/FrontEnd/views/director_aftermeet.html")
  {
    console.log("hello");
    
    var param = new URLSearchParams();
  
    param.append('action',"viewProposalsAfterMeeting");
  
    var key = localStorage.getItem("tempKey");
  
    console.log(key);
  
  
    firebase.database().ref().child('users').child(key).once('value').then(function (snapshot) {
  
      var select = document.getElementById("projTable");
  
      var xhttp1 = new XMLHttpRequest();
  
      xhttp1.onreadystatechange = function () {
  
  
        if (this.readyState == 4 && this.status == 200) {
          console.log(this.responseText);
          var myob = JSON.parse(this.responseText);
  
          var tab = document.getElementById("projTable");
          for (var i = 0; i < Object.keys(myob['documents']).length; i++) {
            console.log(i);
            var tr = tab.insertRow();
            var td = tr.insertCell(0);
            td.appendChild(document.createTextNode(myob['documents'][i]['student_ID']));
            
            var td1 = tr.insertCell(1);
            td1.appendChild(document.createTextNode(myob['documents'][i]['project_ID']));
            
            var td2 = tr.insertCell(2);
            td2.appendChild(document.createTextNode(myob['documents'][i]['document_name']));
            

            var td3 = tr.insertCell(3);
            var btn = document.createElement('button');
            btn.type = "button";
            btn.setAttribute("class", "waves-effect waves-light btn teal");
            btn.setAttribute("onclick","viewIndividualProposal(this)");
            btn.setAttribute("data-sid", myob['documents'][i]['student_ID']);
            btn.setAttribute("data-subtime", myob['documents'][i]['submission_time']);
            btn.setAttribute("data-name", myob['documents'][i]['document_name']);
            btn.appendChild(document.createTextNode("View"));
            td3.appendChild(btn);

            var td4 = tr. insertCell(4);
            var td5 = tr. insertCell(5);
            var btn1 = document.createElement('button');
            var btn2 = document.createElement('button');
            btn1.type = "button";
            btn2.type = "button";
            btn1.setAttribute("class", "waves-effect waves-light btn green");
            btn2.setAttribute("class", "waves-effect waves-light btn red");
            btn1.setAttribute("onclick","approveProposalsAfterMeeting(this)");
            btn2.setAttribute("onclick","disapproveProposalsAfterMeeting(this)");
            btn1.setAttribute("data-pid", myob['documents'][i]['project_ID']);
            btn2.setAttribute("data-pid", myob['documents'][i]['project_ID']);
            btn1.appendChild(document.createTextNode("Approve"));
            btn2.appendChild(document.createTextNode("Disapprove"));
            td4.appendChild(btn1);
            td5.appendChild(btn2);

            var td6 = tr.insertCell(6);
            var btn3 = document.createElement('button');
            btn3.type = "button";
            btn3.setAttribute("class", "waves-effect waves-light btn grey darken-4");
            btn3.setAttribute("onclick","dropProposalAfterMeeting(this)");
            btn3.setAttribute("data-pid", myob['documents'][i]['project_ID']);
            btn3.appendChild(document.createTextNode("Drop"));
            td6.appendChild(btn3);

            
            }
        }
        }
      xhttp1.open("POST","../../Backend/controllers/controller-director.php", true);
  
      xhttp1.send(param);
    });

    function viewIndividualProposal(btn){

      var sid = btn.dataset.sid;
      var time = btn.dataset.subtime;
      var name = btn.dataset.name;
      localStorage.setItem("sid",sid);
      localStorage.setItem("time",time);
      localStorage.setItem("name",name);
      window.location.href = "http://localhost/sih/FrontEnd/views/director_viewindipro.html";
  }

  function approveProposalsAfterMeeting(btn1){
    var pid = btn1.dataset.pid;
    console.log(pid);
    var param = new URLSearchParams();
    param.append("action","approveProposalsAfterMeeting");
    param.append("projectID",pid);
    

  var xhttp1 = new XMLHttpRequest();

  xhttp1.onreadystatechange = function () {


    if (this.readyState == 4 && this.status == 200) {
      console.log(this.responseText);
      var myob = JSON.parse(this.responseText);
      window.location.reload();
    }
  }
  xhttp1.open("POST","../../Backend/controllers/controller-director.php", true);
  
  xhttp1.send(param);
}

function disapproveProposalsAfterMeeting(btn2){
  var pid = btn2.dataset.pid;
  console.log(pid);
  var param = new URLSearchParams();
  param.append("action","disapproveProposalsAfterMeeting");
  param.append("projectID",pid);
  

var xhttp1 = new XMLHttpRequest();

xhttp1.onreadystatechange = function () {


  if (this.readyState == 4 && this.status == 200) {
    console.log(this.responseText);
    var myob = JSON.parse(this.responseText);
    window.location.reload();
  }
}
xhttp1.open("POST","../../Backend/controllers/controller-director.php", true);

xhttp1.send(param);
}

function dropProposalAfterMeeting(btn3){
  var pid = btn1.dataset.pid;
  console.log(pid);
  var param = new URLSearchParams();
  param.append("action","dropProposalAfterMeeting");
  param.append("projectID",pid);
  

var xhttp1 = new XMLHttpRequest();

xhttp1.onreadystatechange = function () {


  if (this.readyState == 4 && this.status == 200) {
    console.log(this.responseText);
    var myob = JSON.parse(this.responseText);
    window.location.reload();
  }
}
xhttp1.open("POST","../../Backend/controllers/controller-director.php", true);

xhttp1.send(param);
}

  }
