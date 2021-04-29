var key = localStorage.getItem("tempKey");  
console.log(key);
      
// GETTING ROLE STARTS
firebase.database().ref().child('users').child(key).once('value').then(function (snapshot) {
  role = snapshot.val().role;
  activated = snapshot.val().activated;
  if(role!="Secretariat"){
    window.location.href="login.html";
  }
});
// GETTING ROLE ENDS

// PROFILE STARTS
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
    // console.log(displayName);

    if(window.location.href == "http://localhost/sih/FrontEnd/views/secretariat.html")
    {     
      firebase.database().ref().child('users').child(uid).once('value').then(function (snapshot) {
        var role = snapshot.val().role;
        document.getElementById("role").innerHTML = role;
        document.getElementById("userName").innerHTML = snapshot.val().name;
      });
    } 
  } else {
    // User is signed out.
    window.location.href = "login.html";
  }
});
// PROFILE ENDS

if(window.location.href == "http://localhost/sih/FrontEnd/views/sec-viewprop.html"){

  var param = new URLSearchParams();
  param.append('action',"viewProposalBeforeDirector");
  var key = localStorage.getItem("tempKey");
  console.log(key);
  
  var xhttp1 = new XMLHttpRequest();
  xhttp1.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
          console.log(this.responseText);
          var myob = JSON.parse(this.responseText);
          if(myob['status1']=="true"){
            var tab = document.getElementById("projTable");
      for (var i = 0; i < Object.keys(myob['documents']).length; i++) {
        console.log(i);
        var tr = tab.insertRow();
        var td0 = tr.insertCell(0);
        td0.appendChild(document.createTextNode(myob['documents'][i]['document_name']));
        
        var td1 = tr.insertCell(1);
        td1.appendChild(document.createTextNode(myob['documents'][i]['document_status']));

        var td2 = tr.insertCell(2);
        td2.appendChild(document.createTextNode(myob['documents'][i]['document_description']));

        var td3 = tr.insertCell(3);
        td3.appendChild(document.createTextNode(myob['documents'][i]['submission_time']));
        
        var td4 = tr.insertCell(4);
        td4.appendChild(document.createTextNode(myob['documents'][i]['student_ID']));

        var td5 = tr.insertCell(5);
        var btn1 = document.createElement("button");
        btn1.innerHTML = "View";
        btn1.setAttribute('onclick', 'view(this)')
        btn1.setAttribute('id', myob['documents'][i]['student_ID']);
        btn1.setAttribute('data-time', myob['documents'][i]['submission_time']);
        btn1.setAttribute('class', "waves-effect waves-light btn");
        td5.appendChild(btn1);
        
        var td6 = tr.insertCell(6);
        var btn2 = document.createElement("button");
        btn2.innerHTML = "Forward";
        btn2.setAttribute('onclick', 'forward(this)')
        btn2.setAttribute('id', myob['documents'][i]['student_ID']);
        btn2.setAttribute('class', "waves-effect waves-light btn green");
        td6.appendChild(btn2);
      }
    }
   }
  }
  xhttp1.open("POST","../../Backend/controllers/controller-secretariat.php", true);

  xhttp1.send(param);
  function view(btn){
    var sid = btn.id;
    var time = btn.dataset.time;
    localStorage.setItem("tempid", sid);
    localStorage.setItem("time", time);
    window.location.href = "http://localhost/sih/FrontEnd/views/sec-proposal.html"
  }
  function forward(btn){
    var sid = btn.id;
    console.log(sid);
    var param = new URLSearchParams();
    param.append('action',"approveDocumentsBeforeDirector");
    param.append('studentID',sid);
    var key = localStorage.getItem("tempKey");
    console.log(key);
  
    var xhttp1 = new XMLHttpRequest();
    xhttp1.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
          console.log(this.responseText);
          var myob = JSON.parse(this.responseText);    
          window.location.reload();
      }
    }
    xhttp1.open("POST","../../Backend/controllers/controller-secretariat.php", true);
    xhttp1.send(param);
  }
}

else if(window.location.href == "http://localhost/sih/FrontEnd/views/sec-viewpropdirec.html"){

    var param = new URLSearchParams();
  	param.append('action',"viewProposalAfterDirector");
  	var key = localStorage.getItem("tempKey");
  	console.log(key);
    var xhttp1 = new XMLHttpRequest();
    xhttp1.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        console.log(this.responseText);
        var myob = JSON.parse(this.responseText);
        if(myob['status1']=="true"){
        var tab = document.getElementById("projTable");
        for (var i = 0; i < Object.keys(myob['documents']).length; i++) {
          var tr = tab.insertRow();
          var td0 = tr.insertCell(0);
          td0.appendChild(document.createTextNode(project_ID = myob['documents'][i]['document_name']));

          var td1 = tr.insertCell(1);
          td1.appendChild(document.createTextNode(myob['documents'][i]['document_status']));
          
          var td2 = tr.insertCell(2);
          td2.appendChild(document.createTextNode(myob['documents'][i]['document_description']));
          
          var td3 = tr.insertCell(3);
          td3.appendChild(document.createTextNode(myob['documents'][i]['submission_time']));
          
          var td4 = tr.insertCell(4);
          td4.appendChild(document.createTextNode(myob['documents'][i]['student_ID']));
          
          var td5 = tr.insertCell(5);
          var i1 = document.createElement("input")
          i1.type = "text";
          td5.appendChild(i1);
          
          
          var td6 = tr.insertCell(6);
          var btn = document.createElement('button');
          btn.innerHTML = "Add";
          btn.setAttribute('onclick', 'add(this)')
          btn.setAttribute('id', myob['documents'][i]['student_ID']);
          btn.setAttribute("data-gid", myob['documents'][i]['document'].split('&59=')[1]);
          btn.setAttribute("data-end", myob['documents'][i]['document'].split('&23=')[1]);
          btn.setAttribute("data-budget", myob['documents'][i]['document'].split('&24=')[1]);
          btn.setAttribute('class', "waves-effect waves-light btn green");
          td6.appendChild(btn);


        }
      }
     }
    }
    xhttp1.open("POST","../../Backend/controllers/controller-secretariat.php", true);

    xhttp1.send(param);
    
    function add(btn){
      var pid = btn.parentNode.parentNode.childNodes[5].childNodes[0].value;
      if(pid != ""){
        var sid = btn.id;
        btn.innerHTML = `<i class="fa fa-spinner fa-spin"></i>`;
        btn.disabled = true;
        var pname = btn.parentNode.parentNode.childNodes[0].innerHTML;
        var gid = btn.dataset.gid.split('&')[0];
        var end = btn.dataset.end.split('&24=')[0];
        var budget = btn.dataset.budget.split('&25=')[0];
        console.log(sid);
        console.log(pid);
        console.log(pname);
        console.log(gid);
        console.log(end);
        console.log(budget);
        
        // var param = new URLSearchParams();
        // param.append('action',"addProjects");
        // param.append('studentID', sid);
        // param.append('projectID', pid);
        // param.append('guideID', gid);
        // param.append('projectname', pname);
        // param.append('endDate', end);
        // var key = localStorage.getItem("tempKey");
        // console.log(key);
      
        // var xhttp1 = new XMLHttpRequest();
        // xhttp1.onreadystatechange = function () {
        //   if (this.readyState == 4 && this.status == 200) {
        //         alert("Project Added Successfully");
        //       // window.location.reload();
        //   }
        // }
        // xhttp1.open("POST","../../Backend/controllers/controller-secretariat.php", true);
        // xhttp1.send(param);
      }
      else{
        alert("Please Enter ID");
      }
    }

    
    
} else if(window.location.href == "http://localhost/sih/FrontEnd/views/sec-proposal.html"){
    var sid = localStorage.getItem('tempid');
    var time = localStorage.getItem('time');
    var param = new URLSearchParams();
    param.append('action',"viewDocument");
    param.append('studentID', sid);
    param.append('submission_time', time);
    var key = localStorage.getItem("tempKey");
    console.log(key);
    
    var xhttp1 = new XMLHttpRequest();
    xhttp1.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            var myob = JSON.parse(this.responseText);
            if(myob['status1']=="true"){
              document.getElementById("proName").value = myob['documents'][0]['document_name'];
              document.getElementById("proName").disabled = true;
              var a = (myob['documents'][0]['document'].split('&'));
              for( var i=0; i<60; i++){
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
    }
    xhttp1.open("POST","../../Backend/controllers/controller-secretariat.php", true);
    xhttp1.send(param);
}
else if( window.location.href == "http://localhost/sih/FrontEnd/views/sec-register.html"){

  firebase.database().ref().child('users').once('value').then(function (snapshot) {
    var table1 = document.getElementById("projTable1");
    var table2 = document.getElementById("projTable2");
    snapshot.forEach(function(childSnapshot){
              console.log(childSnapshot.val());
              var name = childSnapshot.val().name;
              var department = childSnapshot.val().department;
              var email = childSnapshot.val().email;
              var phone = childSnapshot.val().phone;
              var activated = childSnapshot.val().activated;
              var key = childSnapshot.key;
              var role = childSnapshot.val().role;
              if( activated == "0"){
                if(role == "Student"){
                  var degree = childSnapshot.val().degree;
                  var st_date = childSnapshot.val().st_date;
                  var end_date = childSnapshot.val().end_date;
                  var tr1 = table1.insertRow();
                  
                  var td0 = tr1.insertCell(0);
                  td0.appendChild(document.createTextNode(name));
                  
                  var td1 = tr1.insertCell(1);
                  td1.appendChild(document.createTextNode(degree));
                  
                  var td2 = tr1.insertCell(2);
                  td2.appendChild(document.createTextNode(department));
                  
                  var td3 = tr1.insertCell(3);
                  td3.appendChild(document.createTextNode(phone));
                  
                  var td4 = tr1.insertCell(4);
                  td4.appendChild(document.createTextNode(email));
            
                  var td5 = tr1.insertCell(5);
                  var i = document.createElement("input")
                  i.type = "text";
                  td5.appendChild(i);
            
            
                  var td6 = tr1.insertCell(6);
                  var btn1 = document.createElement('button');
                  btn1.innerHTML = "Approve";
                  btn1.setAttribute('onclick', 'approve(this)')
                  btn1.setAttribute('data-key', key);
                  btn1.setAttribute('data-role', role);
                  btn1.setAttribute('data-st', st_date);
                  btn1.setAttribute('data-end', end_date);
                  btn1.setAttribute('class', "waves-effect waves-light btn green");
                  td6.appendChild(btn1);

                  var td7 = tr1.insertCell(7);
                  var btn2 = document.createElement('button');
                  btn2.innerHTML = "Disapprove";
                  btn2.setAttribute('onclick', 'disapprove(this)')
                  btn2.setAttribute('data-key', key);
                  btn2.setAttribute('class', "waves-effect waves-light btn red");
                  td7.appendChild(btn2);



                } else if(role == "Guide"){
                  var designation = childSnapshot.val().designation;
                  var tr = table2.insertRow();
                  
                  var td01 = tr.insertCell(0);
                  td01.appendChild(document.createTextNode(name));
                  
                  var td11 = tr.insertCell(1);
                  td11.appendChild(document.createTextNode(designation));
                  
                  var td21 = tr.insertCell(2);
                  td21.appendChild(document.createTextNode(department));
                  
                  var td31 = tr.insertCell(3);
                  td31.appendChild(document.createTextNode(phone));
                  
                  var td41 = tr.insertCell(4);
                  td41.appendChild(document.createTextNode(email));
            
                  var td51 = tr.insertCell(5);
                  var i = document.createElement("input")
                  i.type = "text";
                  td51.appendChild(i);
            
            
                  var td61 = tr.insertCell(6);
                  var btn1 = document.createElement('button');
                  btn1.innerHTML = "Approve";
                  btn1.setAttribute('onclick', 'approve(this)')
                  btn1.setAttribute('data-key', key);
                  btn1.setAttribute('data-role', role);
                  btn1.setAttribute('class', "waves-effect waves-light btn green");
                  td61.appendChild(btn1);

                  var td71 = tr.insertCell(7);
                  var btn2 = document.createElement('button');
                  btn2.innerHTML = "Disapprove";
                  btn2.setAttribute('onclick', 'disapprove(this)')
                  btn2.setAttribute('data-key', key);
                  btn2.setAttribute('class', "waves-effect waves-light btn red");
                  td71.appendChild(btn2);

                }
              }
            });
  });

  function approve(btn){

    var role = btn.dataset.role;
    var key = btn.dataset.key;
    if(role == "Student"){
      var sid = btn.parentNode.parentNode.childNodes[5].childNodes[0].value;
      if(sid != ""){
          btn.innerHTML = `<i class="fa fa-spinner fa-spin"></i>`;
          btn.disabled = true;
          btn.parentNode.parentNode.childNodes[7].childNodes[0].disabled = true;
          var sname = btn.parentNode.parentNode.childNodes[0].innerHTML;
          var degree = btn.parentNode.parentNode.childNodes[1].innerHTML;
          var email = btn.parentNode.parentNode.childNodes[4].innerHTML;
          var st_date = btn.dataset.st;
          var end_date = btn.dataset.end;

          firebase.database().ref().child('users').child(key).update({activated:'1',id:sid});


          var param = new URLSearchParams();
          param.append('action',"addStudents");
          param.append('studentID', sid);
          param.append('studentName', sname);
          param.append('degree', degree);
          param.append('email', email);
          param.append('st_date', st_date);
          param.append('end_date', end_date);
          var key = localStorage.getItem("tempKey");
          console.log(key);
          
          var xhttp1 = new XMLHttpRequest();
          xhttp1.onreadystatechange = function () {
              if (this.readyState == 4 && this.status == 200) {
                  console.log(this.responseText);
                  var myob = JSON.parse(this.responseText);
                  if(myob['status']=="true"){
                    alert("Student Added Successfully");
                    window.location.reload();            
                  }
              }
          }
          xhttp1.open("POST","../../Backend/controllers/controller-secretariat.php", true);
          xhttp1.send(param);
        } else {
          alert("Please Enter ID");
        }

      } else if(role == "Guide"){
          var gid = btn.parentNode.parentNode.childNodes[5].childNodes[0].value;
          if(gid != ""){
              btn.innerHTML = `<i class="fa fa-spinner fa-spin"></i>`;
              btn.disabled = true;
              btn.parentNode.parentNode.childNodes[7].childNodes[0].disabled = true;
              btn.parentNode.parentNode.childNodes[7].childNodes[0].disabled
              var gname = btn.parentNode.parentNode.childNodes[0].innerHTML;
              var designation = btn.parentNode.parentNode.childNodes[1].innerHTML;
              var department = btn.parentNode.parentNode.childNodes[2].innerHTML;
              var phone = btn.parentNode.parentNode.childNodes[3].innerHTML;
              var email = btn.parentNode.parentNode.childNodes[4].innerHTML;
              
              firebase.database().ref().child('users').child(key).update({activated:'1',id:gid});
              
              var param = new URLSearchParams();
              param.append('action',"addGuides");
              param.append('guideID', gid);
              param.append('guideName', gname);
              param.append('designation', designation);
              param.append('department', department);
              param.append('contactNo', phone);
              param.append('guide_email', email);
              var key = localStorage.getItem("tempKey");
              console.log(key);

              var xhttp1 = new XMLHttpRequest();
              xhttp1.onreadystatechange = function () {
                  if (this.readyState == 4 && this.status == 200) {
                      console.log(this.responseText);
                      var myob = JSON.parse(this.responseText);
                      if(myob['status']=="true"){
                        alert("Guide Added Successfully");
                        window.location.reload();            
                      }
                  }
              }
              xhttp1.open("POST","../../Backend/controllers/controller-secretariat.php", true);
              xhttp1.send(param);
          } else {
            alert("Please Enter ID");
          }
          
      }
  }
  function disapprove(btn){
    var key = btn.dataset.key;
    firebase.database().ref().child('users').child(key).remove();
    alert("User Removed");
    window.location.reload();
  }
}
else if( window.location.href == "http://localhost/sih/FrontEnd/views/sec-queryletters.html"){

    var param = new URLSearchParams();
    param.append('action',"viewUnapprovedProjects");
    var key = localStorage.getItem("tempKey");
    console.log(key);
    
    var xhttp1 = new XMLHttpRequest();
    xhttp1.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            var myob = JSON.parse(this.responseText);


            if(myob['status1']=="true"){
              var tab = document.getElementById("projTable");
              for (var i = 0; i < Object.keys(myob['documents']).length; i++) {
                var tr = tab.insertRow();
                var td0 = tr.insertCell(0);
                td0.appendChild(document.createTextNode(myob['documents'][i]['project_ID']));
      
                var td1 = tr.insertCell(1);
                td1.appendChild(document.createTextNode(myob['documents'][i]['project_name']));
                
                var td2 = tr.insertCell(2);
                td2.appendChild(document.createTextNode(myob['documents'][i]['guide_ID']));

                var td3 = tr.insertCell(3);
                td3.appendChild(document.createTextNode(myob['documents'][i]['approved_by_IRB']));
                
                
                var td4 = tr.insertCell(4);
                var inp = document.createElement("input")
                inp.type = "file";
                inp.id = myob['documents'][i]['project_ID'];
                td4.appendChild(inp);
                
                
                var td5 = tr.insertCell(5);
                var btn = document.createElement('button');
                btn.innerHTML = "Upload";
                btn.setAttribute('onclick', 'store(this)')
                btn.setAttribute('id', myob['documents'][i]['project_ID'] + "load");
                btn.setAttribute('data-pid', myob['documents'][i]['project_ID']);
                btn.setAttribute("data-gid", myob['documents'][i]['guide_ID']);
                btn.setAttribute('class', "waves-effect waves-light btn green");
                td5.appendChild(btn);
              }
            }
          }
    }
    xhttp1.open("POST","../../Backend/controllers/controller-secretariat.php", true);
    xhttp1.send(param);

      
        function store(btn) {
            var id = btn.dataset.pid;
            localStorage.setItem("pid", id);
            localStorage.setItem("gid", btn.dataset.gid);
            var x = document.getElementById(id);

          if(x.files.length != 0){
            document.getElementById(btn.id).innerHTML = `<i class="fa fa-spinner fa-spin"></i>`;
            document.getElementById(btn.id).disabled = true;
            file = x.files[0];
            fileName = file.name;
            storageRef = firebase.storage().ref("files/" + fileName);
            uploadTask = storageRef.put(file);
      
            uploadTask.on('state_changed', function(snapshot){
                // Observe state change events such as progress, pause, and resume
                // Get task progress, including the number of bytes uploaded and the total number of bytes to be uploaded
                var progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
                console.log('Upload is ' + progress + '% done');
                switch (snapshot.state) {
                    case firebase.storage.TaskState.PAUSED: // or 'paused'
                        console.log('Upload is paused');
                        break;
                    case firebase.storage.TaskState.RUNNING: // or 'running'
                        console.log('Upload is running');
                        break;
                }
            }, function(error) {
                  // Handle unsuccessful uploads
              }, function() {
                  // Handle successful uploads on complete
                  // For instance, get the download URL: https://firebasestorage.googleapis.com/...
                  uploadTask.snapshot.ref.getDownloadURL().then(function(downloadURL) {
                  console.log('File available at', downloadURL);
                  param = new URLSearchParams();
      
                  param.append("action","sendQueryLetters");
                  param.append("document",downloadURL);
                  param.append("documentname",fileName);
                  param.append("projectID", localStorage.getItem("pid"));
                  param.append("guideID", localStorage.getItem("gid"));
                  if (firebase.auth().currentUser !== null){ 
                    var key = firebase.auth().currentUser.uid;
                  }
                  
                  firebase.database().ref().child('users').child(key).once('value').then(function (snapshot) {
                
                  param.append("secretariatID", snapshot.val().id);
                  var xhttp1 = new XMLHttpRequest();
                  xhttp1.onreadystatechange = function () {
      
                  if (this.readyState == 4 && this.status == 200) {
                    console.log(this.responseText);
                    if(this.responseText.substring(11, 15) =='true'){
                      window.alert("File Uploaded Successfully");
                    }
                    else{
                      window.alert("File Upload Failed");
                    }
                    window.location.reload();
                  }
                }
                xhttp1.open("POST","../../Backend/controllers/controller-secretariat.php", true);
      
                xhttp1.send(param);
              });
            });
          });
        }//if check for empty upload
        else {
          alert("Please Select a File");
        }
      
      }
    

}else if(window.location.href == "http://localhost/sih/FrontEnd/views/sec_setmeetings.html"){
    
    var param = new URLSearchParams();
    param.append('action',"viewProjectsForMeetings");
    var key = localStorage.getItem("tempKey");
    console.log(key);
    
    var xhttp1 = new XMLHttpRequest();
    xhttp1.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            var myob = JSON.parse(this.responseText);


            if(myob['status1']=="true"){
              var tab = document.getElementById("projTable");
              for (var i = 0; i < Object.keys(myob['documents']).length; i++) {
                var tr = tab.insertRow();
                var td0 = tr.insertCell(0);
                td0.appendChild(document.createTextNode(myob['documents'][i]['project_ID']));
      
                var td1 = tr.insertCell(1);
                td1.appendChild(document.createTextNode(myob['documents'][i]['project_name']));
                
                var td2 = tr.insertCell(2);
                td2.appendChild(document.createTextNode(myob['documents'][i]['guide_ID']));

                var td3 = tr.insertCell(3);
                td3.appendChild(document.createTextNode(myob['documents'][i]['approved_by_IRB']));
                
                
                var td4 = tr.insertCell(4);
                var btn = document.createElement('button');
                btn.innerHTML = "Set";
                btn.setAttribute('onclick', 'setmeeting(this)')
                btn.setAttribute('data-pid', myob['documents'][i]['project_ID']);
                btn.setAttribute('data-pname',myob['documents'][i]['project_name'])
                btn.setAttribute('class', "waves-effect waves-light btn green");
                td4.appendChild(btn);
              }
            }
          }
    }
    xhttp1.open("POST","../../Backend/controllers/controller-secretariat.php", true);
    xhttp1.send(param);

    function setmeeting(btn){
      var pid = btn.dataset.pid;
      localStorage.setItem("pid",pid);
      var pname = btn.dataset.pname;
      localStorage.setItem('pname',pname);
      window.location.href = "http://localhost/sih/FrontEnd/views/sec_setmeetingsprojects.html";

    }

} else if(window.location.href =="http://localhost/sih/FrontEnd/views/sec_setmeetingsprojects.html"){
  var pid= localStorage.getItem("pid");
  var pname = localStorage.getItem('pname');
  document.getElementById('projName').innerHTML = pname;
  document.getElementById('projID').innerHTML = pid;
  
  var param = new URLSearchParams();
  param.append("action","viewIRBMembers");
  var xhttp1 = new XMLHttpRequest();
  xhttp1.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
        console.log(this.responseText);
        var myob = JSON.parse(this.responseText);
        var tab = document.getElementById("irb-people")
        for (var i = 0; i < Object.keys(myob['documents']).length; i++) {
          var tr = tab.insertRow();
          var td0 = tr.insertCell(0);
          td0.appendChild(document.createTextNode(myob['documents'][i]['IRB_ID']));

          var td1 = tr.insertCell(1);
          td1.appendChild(document.createTextNode(myob['documents'][i]['name']));
          
          var td2 = tr.insertCell(2);
          td2.appendChild(document.createTextNode(myob['documents'][i]['IRB_email']));

           var td3 = tr.insertCell(3);
          
           var chkbox =` <p>
           <label>
             <input type="checkbox"  id=${myob['documents'][i]['IRB_ID']} data-email=${myob['documents'][i]['IRB_email']} class="filled-in"  />
             <span>Tick to send</span>
           </label>
         </p> `;
           td3.innerHTML=chkbox;



        }
    }
  }
  xhttp1.open("POST","../../Backend/controllers/controller-secretariat.php", true);
  xhttp1.send(param);


  function setmeet(){

  var param = new URLSearchParams();
  var xhttp1 = new XMLHttpRequest();
  
  var x = document.getElementsByClassName('filled-in');
  var irbids = [];
  var irbemails = [];
  var j=0;
  for(i=0;i<x.length;i++){
    if(x[i].checked == true){
      console.log( x[i].id );
      irbids[j] = x[i].id;
      irbemails[j++] = x[i].dataset.email;
    }
  }
  if(irbemails.length != 0){
      var agenda = document.getElementById('agenda').value;
      if(agenda != ""){
          document.getElementById("submit").style.display = "none";
          document.getElementById("loader").style.display = "block";
          document.getElementById("btn").disabled = true;
          param.append("projectID",pid);
          param.append("action","setMeetings")
          param.append("agenda",agenda);
          param.append("arr_length",x.length);
          param.append("irbids",irbids);
          param.append("irbmails",irbemails);
          xhttp1.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                console.log(this.responseText);
                alert("Mail Sent");
                window.location.reload();
            }
          }
          xhttp1.open("POST","../../Backend/controllers/controller-secretariat.php", true);
          xhttp1.send(param);
      } else {
          alert("Please Enter the Agenda");
      }
  } else {
    alert("Please Select Members");
  }
  

  }

}
else if(window.location.href == "http://localhost/sih/FrontEnd/views/sec-viewallvouc.html"){
  console.log("hi bosdiwale");
  var param = new URLSearchParams();
  param.append('action',"viewVouchers");
  var key = localStorage.getItem("tempKey");
  console.log(key);
  
  var xhttp1 = new XMLHttpRequest();
  xhttp1.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
          console.log(this.responseText);
          var myob = JSON.parse(this.responseText);
          if(myob['status1']=="true"){
            var tab = document.getElementById("projTable");
      for (var i = 0; i < Object.keys(myob['documents']).length; i++) {
        console.log(i);
        var tr = tab.insertRow();
        var td0 = tr.insertCell(0);
        td0.appendChild(document.createTextNode(myob['documents'][i]['document_name']));
        
        var td1 = tr.insertCell(1);
        td1.appendChild(document.createTextNode(myob['documents'][i]['document_status']));

        var td2 = tr.insertCell(2);
        td2.appendChild(document.createTextNode(myob['documents'][i]['document_description']));

        var td3 = tr.insertCell(3);
        td3.appendChild(document.createTextNode(myob['documents'][i]['submission_time']));
        
        var td4 = tr.insertCell(4);
        td4.appendChild(document.createTextNode(myob['documents'][i]['student_ID']));

        var td5 = tr.insertCell(5);
        var btn1 = document.createElement("button");
        btn1.innerHTML = "View";
        btn1.setAttribute('onclick', 'view(this)')
        btn1.setAttribute('id', myob['documents'][i]['student_ID']);
        btn1.setAttribute('data-time', myob['documents'][i]['submission_time']);
        btn1.setAttribute('class', "waves-effect waves-light btn");
        td5.appendChild(btn1);
        
        var td6 = tr.insertCell(6);
        var btn2 = document.createElement("button");
        btn2.innerHTML = "Forward";
        btn2.setAttribute('onclick', 'forward(this)')
        btn2.setAttribute('id', myob['documents'][i]['student_ID']);
        btn2.setAttribute('data-time', myob['documents'][i]['submission_time']);
        btn2.setAttribute('data-document', myob['documents'][i]['document']);
        btn2.setAttribute('class', "waves-effect waves-light btn green");
        td6.appendChild(btn2);
      }
    }
   }
  }
  xhttp1.open("POST","../../Backend/controllers/controller-secretariat.php", true);

  xhttp1.send(param);

  function view(btn){
    var sid = btn.id;
    var time = btn.dataset.time;
    console.log(sid);
    console.log(time);
    localStorage.setItem("tempid", sid);
    localStorage.setItem("time", time);
    window.location.href = "http://localhost/sih/FrontEnd/views/sec-viewvouc.html"
  }
  function forward(btn){
    var sid = btn.id;
    var time = btn.dataset.time;
    var document = btn.dataset.document;
    console.log(sid);
    console.log(time);
    console.log(document);
    var param = new URLSearchParams();
    param.append('action',"approveVouchers");
    param.append('studentID', sid);
    param.append('timestamp', time);
    param.append('document', document);
    var key = localStorage.getItem("tempKey");
    console.log(key);
  
    var xhttp1 = new XMLHttpRequest();
    xhttp1.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
          console.log(this.responseText);
          var myob = JSON.parse(this.responseText);    
          window.location.reload();
      }
    }
    xhttp1.open("POST","../../Backend/controllers/controller-secretariat.php", true);
    xhttp1.send(param);
  }
} else if(window.location.href == "http://localhost/sih/FrontEnd/views/sec-viewvouc.html"){
    var sid = localStorage.getItem('tempid');
    var time = localStorage.getItem('time');
    var param = new URLSearchParams();
    param.append('action',"viewIndividualVoucher");
    param.append('studentID', sid);
    param.append('submission_time', time);
    var key = localStorage.getItem("tempKey");
    console.log(key);
    
    var xhttp1 = new XMLHttpRequest();
    xhttp1.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            var myob = JSON.parse(this.responseText);
            if(myob['status1']=="true"){
              

              var a = (myob['documents'][0]['document'].split('&'));
              for( var i=0; i<19; i++){
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
    }
    xhttp1.open("POST","../../Backend/controllers/controller-secretariat.php", true);
    xhttp1.send(param);
}