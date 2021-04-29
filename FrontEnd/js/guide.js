
//------------------------------------AUTHENTICATION-----------------------------------------------

var key = localStorage.getItem("tempKey");
console.log(key);
if(key!=null){
firebase.database().ref().child('users').child(key).once('value').then(function (snapshot) {
	role = snapshot.val().role;
	if (role != "Guide") {
		window.location.href = "login.html";
	}

});
}
firebase.auth().onAuthStateChanged(function (user) {
	if (user) {
		// User is signed in.
		var displayName = user.displayName;
		var email = user.email;
		var uid = user.uid;
		console.log(displayName);

		if (window.location.href == "http://localhost/sih/FrontEnd/views/guide_profile.html") {


			firebase.database().ref().child('users').child(uid).once('value').then(function (snapshot) {
				role = snapshot.val().role;
				document.getElementById("userName").innerHTML = snapshot.val().name;
				document.getElementById("role").innerHTML = role;
			});


		}
		// ...
	} else {
		// User is signed out.
		// ...
		window.location.href = "login.html";
	}
});

function logout() {
	firebase.auth().signOut().then(function () {
		// Sign-out successful.
		window.location.href = "login.html";
	}).catch(function (error) {
		// An error happened.
	});
}


//-------------------------------------------------------------------------------------------------------

function approveProposals(btn){
  var param = new URLSearchParams();
  var time = btn.dataset.subtime;
  var sid = btn.dataset.sid;
  
	firebase.database().ref().child('users').child(key).once('value').then(function (snapshot) {
  param.append('action', "approveProposals");
  param.append("guideID",snapshot.val().id);
  param.append('submission_time',time);
  param.append('studentID',sid);
  var xhttp1 = new XMLHttpRequest();
  xhttp1.onreadystatechange = function () {

        if (this.readyState == 4 && this.status == 200) {
          console.log(this.responseText);
           var myob = JSON.parse(this.responseText);
           if(myob['status1'] == 'true' && myob['status2']== 'true'){
           window.alert("Proposal has been approved and sent forward");
           location.reload();
          }
           else{
            window.alert("Error in approving Proposal");
           }

        }
    }

  xhttp1.open("POST","../../Backend/controllers/controller-guide.php", true);
  xhttp1.send(param);
  });
}

function viewPrincipleDocumentsPerProject(btn){
  var pid = btn.dataset.pid;
  var gid = btn.dataset.gid;
  localStorage.setItem("pid",pid);
  localStorage.setItem("gid",gid);
  window.location.href = "http://localhost/sih/FrontEnd/views/viewdoc.html";
  
}
function approveDocuments(btn){
  var xhttp1 = new XMLHttpRequest();
  var param = new URLSearchParams();
  param.append('action',"approveDocuments");
  param.append('guideID',localStorage.getItem('gid'));
  param.append("projectID",btn.name);
  param.append('description',btn.dataset.des);
  param.append("submission_time",btn.dataset.time);
xhttp1.onreadystatechange = function () {

      if (this.readyState == 4 && this.status == 200) {
          console.log(this.responseText);
          var myob = JSON.parse(this.responseText);

        


        
        
      }
    }
xhttp1.open("POST","../../Backend/controllers/controller-guide.php", true);

xhttp1.send(param);

}

if(window.location.href == "http://localhost/sih/FrontEnd/views/viewdoc.html"){
  var key = localStorage.getItem("tempKey");

  console.log(key);

  var i = 0;
	var pidkey = localStorage.getItem("pid");


	console.log(key);
	var commentsRef = firebase.database().ref(`messages/${pidkey}`);
	commentsRef.on('child_added', function (data) {
		i = i + 1;
		var div = document.createElement("DIV");
		div.classList.add("containerchat");
		if (data.val().byWhom != "guide") {
			div.classList.add("darker");
		}
		var p = document.createElement("P");
		p.innerHTML = "<b>" + data.val().name + "</b>" + ": " + data.val().message;
		div.appendChild(p);
		div.setAttribute("data-index", i);
		document.getElementById("chat").appendChild(div);
		var objDiv = document.getElementById("chat");
		objDiv.scrollTop = objDiv.scrollHeight;
		//addCommentElement(postElement, data.key, data.val().text, data.val().author);
  });
  
  function send() {
		console.log("hello");
		/*var div = document.createElement("DIV");
		div.classList.add("containerchat");*/
		var p = document.createElement("P");
		var message = document.getElementById("text").value;

		/*p.innerHTML ="<b>"+name+"</b>"+": " + message;
		document.getElementById("text").value = null;
		div.appendChild(p);
		document.getElementById("chat").appendChild(div);*/
		var key = localStorage.getItem("tempKey");
		firebase.database().ref().child('users').child(key).once('value').then(function (snapshot) {
			id = snapshot.val().id;
			firebase.database().ref('messages/' + pidkey).push({
				id: id,
				message: message,
				name: name,
				byWhom: role,
				timeStamp: Date.now()
			});
		});
		document.getElementById("text").value = "";
	}
//firebase.database().ref().child('users').child(key).once('value').then(function (snapshot) {
 
  var tab2 = document.getElementById("revTable");
  var pid=localStorage.getItem("pid");
  var gid=localStorage.getItem("gid");
  var param = new URLSearchParams();
  param.append('action', "viewProjectDocuments");
  param.append("projectID",pid);
  param.append("guideID",gid);
  var xhttp1 = new XMLHttpRequest();
  xhttp1.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      console.log(this.responseText);
      var myob = JSON.parse(this.responseText);
      var tab2 = document.getElementById("revTable");
      for (var i = 0; i < Object.keys(myob['documents']).length; i++) {
    console.log(i);
    if(myob['documents'][i]['document_description']=="Review"){
    var tr = tab2.insertRow();

    var td0 = tr.insertCell(0);
    td0.appendChild(document.createTextNode(myob['documents'][i]['document_name']));
    
    var td1 = tr.insertCell(1);
    td1.appendChild(document.createTextNode(desc=myob['documents'][i]['document_description']));
              
    var td2 = tr.insertCell(2);
    td2.appendChild(document.createTextNode(myob['documents'][i]['submission_time']));

    var td3 = tr.insertCell(3);
    var downloadURL = myob['documents'][i]['document'];
    var anc = document.createElement("a");
    anc.setAttribute("href",downloadURL);
    anc.innerHTML = "Download";
    td3.append(anc);
    } 
    else{

      if(myob['documents'][i]['document_status'] == 0){
      var tab3 = document.getElementById("projTable"); 
      var tr = tab3.insertRow();

    var td0 = tr.insertCell(0);
    td0.appendChild(document.createTextNode(myob['documents'][i]['document_name']));
    
    var td1 = tr.insertCell(1);
    td1.appendChild(document.createTextNode(myob['documents'][i]['document_description']));
              
    var td2 = tr.insertCell(2);
    td2.appendChild(document.createTextNode(myob['documents'][i]['submission_time']));

    if(myob['documents'][i]['document_description'] == "voucher"){
      var td3 = tr.insertCell(3);
    var btn = document.createElement('button');
    //btn.setAttribute("id",`btn${i}`);
    btn.setAttribute("class","waves-effect waves-light btn teal");
    btn.type = "button";
    btn.className = "waves-effect waves-light btn teal";
    btn.appendChild(document.createTextNode("View"));
    btn.setAttribute("onclick","viewVoucher(this)");
    btn.setAttribute("name",pid);
    btn.setAttribute("data-doc",myob['documents'][i]['document']);
    btn.setAttribute("data-des",myob['documents'][i]['document_description']);
    btn.setAttribute("data-time",myob['documents'][i]['submission_time']);
    td3.appendChild(btn);
    }
    else if(myob['documents'][i]['document_description'] == "budget"){
      var td3 = tr.insertCell(3);
    var btn = document.createElement('button');
    //btn.setAttribute("id",`btn${i}`);
    btn.setAttribute("class","waves-effect waves-light btn teal");
    btn.type = "button";
    btn.className = "waves-effect waves-light btn teal";
    btn.appendChild(document.createTextNode("View"));
    btn.setAttribute("onclick","viewBudget(this)");
    btn.setAttribute("name",pid);
    btn.setAttribute("data-doc",myob['documents'][i]['document']);
    btn.setAttribute("data-des",myob['documents'][i]['document_description']);
    btn.setAttribute("data-time",myob['documents'][i]['submission_time']);
    td3.appendChild(btn);
    }
    else{
    var td3 = tr.insertCell(3);
    var downloadURL = myob['documents'][i]['document'];
    var anc = document.createElement("a");
    anc.setAttribute("href",downloadURL);
    anc.innerHTML = "Download";
    td3.append(anc);
    }

      var td4 = tr.insertCell(4);
    var btn = document.createElement('button');
    //btn.setAttribute("id",`btn${i}`);
    btn.setAttribute("class","waves-effect waves-light btn teal");
    btn.type = "button";
    btn.className = "waves-effect waves-light btn teal";
    btn.appendChild(document.createTextNode("Approve"));
    btn.setAttribute("onclick","approveDocuments(this)");
    btn.setAttribute("name",pid);
    btn.setAttribute("data-des",myob['documents'][i]['document_description']);
    btn.setAttribute("data-time",myob['documents'][i]['submission_time']);
    td4.appendChild(btn);
    
    
    var btn1 = document.createElement('button');
    //btn.setAttribute("id",`btn${i}`);
    btn1.type = "button";
    btn1.className = "waves-effect waves-light btn red";
    btn1.appendChild(document.createTextNode("Disapprove"));
    btn1.setAttribute("onclick","disapproveDocuments(this)");
    btn1.setAttribute("name",pid);
    btn1.setAttribute("data-des",myob['documents'][i]['document_description']);
    btn.setAttribute("data-time",myob['documents'][i]['submission_time']);
    td4.appendChild(btn1);

  
    }
    else{
      var tab4 = document.getElementById("appTable"); 
      var tr = tab4.insertRow();

    var td0 = tr.insertCell(0);
    td0.appendChild(document.createTextNode(myob['documents'][i]['document_name']));
    
    var td1 = tr.insertCell(1);
    td1.appendChild(document.createTextNode(myob['documents'][i]['document_description']));

    if(myob['documents'][i]['document_description'] == "voucher"){
      var td2 = tr.insertCell(2);
    var btn = document.createElement('button');
    //btn.setAttribute("id",`btn${i}`);
    btn.setAttribute("class","waves-effect waves-light btn teal");
    btn.type = "button";
    btn.className = "waves-effect waves-light btn teal";
    btn.appendChild(document.createTextNode("View"));
    btn.setAttribute("onclick","viewVoucher(this)");
    btn.setAttribute("name",pid);
    btn.setAttribute("data-doc",myob['documents'][i]['document']);
    btn.setAttribute("data-des",myob['documents'][i]['document_description']);
    btn.setAttribute("data-time",myob['documents'][i]['submission_time']);
    td2.appendChild(btn);
    }
    else if(myob['documents'][i]['document_description'] == "budget"){
      var td2 = tr.insertCell(2);
    var btn = document.createElement('button');
    //btn.setAttribute("id",`btn${i}`);
    btn.setAttribute("class","waves-effect waves-light btn teal");
    btn.type = "button";
    btn.className = "waves-effect waves-light btn teal";
    btn.appendChild(document.createTextNode("View"));
    btn.setAttribute("onclick","viewBudget(this)");
    btn.setAttribute("name",pid);
    btn.setAttribute("data-doc",myob['documents'][i]['document']);
    btn.setAttribute("data-des",myob['documents'][i]['document_description']);
    btn.setAttribute("data-time",myob['documents'][i]['submission_time']);
    td2.appendChild(btn);
    }
    else{
    
    var td2 = tr.insertCell(2);
    var downloadURL = myob['documents'][i]['document'];
    var anc = document.createElement("a");
    anc.setAttribute("href",downloadURL);
    anc.innerHTML = "Download";
    td2.append(anc);
    

    }
    var td3 = tr.insertCell(3);
    td3.appendChild(document.createTextNode(myob['documents'][i]['submission_time']));
  }
    
  }

}
    }
  }
xhttp1.open("POST","../../Backend/controllers/controller-guide.php", true);

xhttp1.send(param);

//==========================================================================================

  function viewVoucher(btn){
    localStorage.setItem("subtime", btn.dataset.time);
    localStorage.setItem("doc",btn.dataset.doc);
		window.location.href = "http://localhost/sih/FrontEnd/views/guide_viewVoucher.html";
  }

  function viewBudget(btn){
    localStorage.setItem("subtime", btn.dataset.time);
    localStorage.setItem("doc",btn.dataset.doc);
		window.location.href = "http://localhost/sih/FrontEnd/views/guide_viewBudget.html";

  }

//==========================================================================================

//});
}

//------------------------------------------------------------------------------------------

if (window.location.href == "http://localhost/sih/FrontEnd/views/guide_viewBudget.html") {
  doc = localStorage.getItem("doc");
	console.log(doc);
	console.log(doc = JSON.stringify(doc));
	a = doc.split("&");
	console.log(a);
	for (var i = 0; i < 78; i++) {
		console.log(i);
		var b = a[i].split('=')[1].split('+');
		console.log(b);

		if (b.length != 1) {
			var c = "";
			for (var j = 0; j < b.length; j++) {
				c = c + b[j] + " ";
			}

			document.getElementById(i + 1).value = c;

		} else {
			document.getElementById(i + 1).value = b[0];
		}
		//   console.log(b);
		// }
	}

}

//------------------------------------------------------------------------------------------
if (window.location.href == "http://localhost/sih/FrontEnd/views/guide_viewVoucher.html") {

	doc = localStorage.getItem("doc");
	console.log(doc);
	console.log(doc = JSON.stringify(doc));
	a = doc.split("&");
	console.log(a);
	for (var i = 0; i < 19; i++) {
		console.log(i);
		var b = a[i].split('=')[1].split('+');
		console.log(b);

		if (b.length != 1) {
			var c = "";
			for (var j = 0; j < b.length; j++) {
				c = c + b[j] + " ";
			}

			document.getElementById(i + 1).value = c;

		} else {
			document.getElementById(i + 1).value = b[0];
		}
		//   console.log(b);
		// }
	}

}

//------------------------------------------------------------------------------------------

if(window.location.href == "http://localhost/sih/FrontEnd/views/guide_proposal.html"){
  var key = localStorage.getItem("tempKey");
  	console.log(key);
  firebase.database().ref().child('users').child(key).once('value').then(function (snapshot) {
    var param = new URLSearchParams();
    param.append("guideID", snapshot.val().id);
  	param.append('action',"viewProposals");
    var xhttp1 = new XMLHttpRequest();
    xhttp1.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        console.log(this.responseText);
        var myob = JSON.parse(this.responseText);
        if(myob['status1']=="true"){
        var tab = document.getElementById("table1");
        for (var i = 0; i < Object.keys(myob['documents']).length; i++) {
          console.log(i);
          var tr = tab.insertRow();
          var td0 = tr.insertCell(0);
          
          td0.appendChild(document.createTextNode(project_ID = myob['documents'][i]['document_name']));
          
          var td1 = tr.insertCell(1);
          td1.appendChild(document.createTextNode(myob['documents'][i]['document_description']));
          
          var td2 = tr.insertCell(2);
          td2.appendChild(document.createTextNode(myob['documents'][i]['submission_time']));
            var td3 = tr.insertCell(3);
            td3.appendChild(document.createTextNode(myob['documents'][i]['student_ID']));

          var td4 = tr.insertCell(4);
          var btn1 = document.createElement("button");
          btn1.innerHTML = "View";
          btn1.setAttribute("class","btn btn-default");
          btn1.setAttribute('data-sid',myob['documents'][i]['student_ID']);
          btn1.setAttribute('data-subtime',myob['documents'][i]['submission_time']);
          btn1.setAttribute('onclick', 'view(this)')
          td4.appendChild(btn1);

          var td5 = tr.insertCell(5);
          var btn = document.createElement("button");
          btn.type = "button";
          btn.setAttribute("class","btn btn-success");
          btn.appendChild(document.createTextNode("Approve"));
          btn.setAttribute('data-sid',myob['documents'][i]['student_ID']);
          btn.setAttribute("onclick","approveProposals(this)");
          btn.setAttribute('data-subtime',myob['documents'][i]['submission_time']);
          if(myob['documents'][i]['document_status'] == "1"||myob['documents'][i]['document_status'] == "2"||myob['documents'][i]['document_status'] =="3"){
            btn.disabled=true;
            btn =document.createTextNode("Approved");
          }
          td5.appendChild(btn);
          
        }
      }
     }
    }
    xhttp1.open("POST","../../Backend/controllers/controller-guide.php", true);

    xhttp1.send(param);
  });
    function view(btn){
      var sid = btn.dataset.sid;
      var subtime = btn.dataset.subtime;
      localStorage.setItem("sid",sid);
      localStorage.setItem("subtime",subtime);
      window.location.href = "http://localhost/sih/FrontEnd/views/guide_viewprop.html"
    }

  }
else if(window.location.href == "http://localhost/sih/FrontEnd/views/guide_prin_projects.html"){

  firebase.database().ref().child('users').child(key).once('value').then(function (snapshot) {
  var param = new URLSearchParams();
  
  param.append("guideID", snapshot.val().id);
  param.append('action',"viewPrincipleProjects");
  var key = localStorage.getItem("tempKey");
  console.log(key);
  var xhttp1 = new XMLHttpRequest();
  xhttp1.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      console.log(this.responseText);
      var myob = JSON.parse(this.responseText);
      if(myob.status1 == "true"){
      var tab = document.getElementById("table2");
      for (var i = 0; i < Object.keys(myob['documents']).length; i++) {
        console.log(i);
        var tr = tab.insertRow();
        var td0 = tr.insertCell(0);
       
        td0.appendChild(document.createTextNode(project_ID = myob['documents'][i]['project_ID']));
        
        var td1 = tr.insertCell(1);
        td1.appendChild(document.createTextNode(myob['documents'][i]['project_name']));

        var td2 = tr.insertCell(2);
        td2.appendChild(document.createTextNode(myob['documents'][i]['guide_ID']));

        var td3 = tr.insertCell(3);
        td3.appendChild(document.createTextNode(myob['documents'][i]['budget_proposed']));

        var td4 = tr.insertCell(4);
        var btn = document.createElement("button");
        btn.type = "button";
        btn.appendChild(document.createTextNode("View"));
        btn.setAttribute("class","waves-effect waves-light btn dark");
        btn.setAttribute("onclick","viewPrincipleDocumentsPerProject(this)");
        btn.setAttribute("data-pid", myob['documents'][i]['project_ID']);
        btn.setAttribute("data-gid", myob['documents'][i]['guide_ID']);
        td4.appendChild(btn);
      }

    }
   }
  }
  xhttp1.open("POST","../../Backend/controllers/controller-guide.php", true);

  xhttp1.send(param);
});
 
}
else if(window.location.href == "http://localhost/sih/FrontEnd/views/guide_part_projects.html"){
  firebase.database().ref().child('users').child(key).once('value').then(function (snapshot) {
  var param = new URLSearchParams();
  param.append("guideID", snapshot.val().id);
  param.append('action',"viewParticipatingProjects");
  var xhttp1 = new XMLHttpRequest();
  xhttp1.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      console.log(this.responseText);
      var myob = JSON.parse(this.responseText);
      if(myob['status1']=="true"){
      var tab1 = document.getElementById("table3");
      console.log(tab1);  
      for (var i = 0; i < Object.keys(myob['documents']).length; i++) {
        
        console.log(i);
        var tr = tab1.insertRow();
        var td0 = tr.insertCell(0);
       
        td0.appendChild(document.createTextNode(project_ID = myob['documents'][i]['project_ID']));
        
        var td1 = tr.insertCell(1);
        td1.appendChild(document.createTextNode(myob['documents'][i]['project_name']));
        
        var td2 = tr.insertCell(2);
        td2.appendChild(document.createTextNode(myob['documents'][i]['completed']));

        var td3 = tr.insertCell(3);
        td3.appendChild(document.createTextNode(myob['documents'][i]['guide_ID']));
      }

    }
   }
  }
  xhttp1.open("POST","../../Backend/controllers/controller-guide.php", true);

  xhttp1.send(param);
});
}

if(window.location.href == "http://localhost/sih/FrontEnd/views/guide_viewprop.html"){

  var key = localStorage.getItem("tempKey");
  
  console.log(key);
  var doc = localStorage.getItem('doc');
  var subtime = localStorage.getItem("subtime");
  var sid = localStorage.getItem("sid");
  firebase.database().ref().child('users').child(key).once('value').then(function (snapshot) {
    var param1 = new URLSearchParams();
    param1.append("projectID","PD1");
    param1.append("guideID",snapshot.val().id);
    param1.append("studentID",sid);
    param1.append("submission_time",subtime);
    param1.append("action",'viewProposalWithTime');
    var xhttp1 = new XMLHttpRequest();
    xhttp1.onreadystatechange = function () {
      
      if (this.readyState == 4 && this.status == 200) {
        console.log(this.responseText);
        var myob = JSON.parse(this.responseText);
        var a = (myob['documents'][0]['document'].split('&'));
        document.getElementById("projName").value = myob['documents'][0]['document_name'];
          for( var i=0; i<60; i++)
          {
            document.getElementById(i+1).disabled = true;
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
          }
          var btn=document.createElement("button");
        btn.type="button";
        btn.setAttribute("class","btn btn-success");
        btn.appendChild(document.createTextNode("Submit"));
        btn.setAttribute("data-sid",myob['documents'][0]['student_ID']);
        btn.setAttribute("data-doc_name",myob['documents'][0]['document_name']);
        btn.setAttribute("data-sub_time",myob['documents'][0]['submission_time']);
        btn.setAttribute("onclick","editDocuments(this)");
        var form=document.getElementById("col");
        form.appendChild(btn);
        }
        
      }

  xhttp1.open("POST","../../Backend/controllers/controller-guide.php", true);
  xhttp1.send(param1);
  
    });
    
function editDocuments(btn){
  var sid=btn.dataset.sid;
  var doc_name=btn.dataset.doc_name;
  var sub_time=btn.dataset.sub_time;
  var param1 = new URLSearchParams();
  var param = new URLSearchParams();
  param1.append('action', "editDocuments");
  for (var i = 1; i <= 60; i++) {
    console.log(i);
    param.append(i, document.getElementById(i).value);
    console.log(document.getElementById(i).value)
  }
  firebase.database().ref().child('users').child(key).once('value').then(function (snapshot) {
  param1.append("guideID",snapshot.val().id);
  param1.append('document',param);
  param1.append("studentID",sid);
  param1.append("documentname",doc_name);
  param1.append("submission_time",sub_time);
  var xhttp1 = new XMLHttpRequest();
  xhttp1.onreadystatechange = function () {

    if (this.readyState == 4 && this.status == 200) {
    console.log(this.responseText);
    var myob = JSON.parse(this.responseText);

  }
}
xhttp1.open("POST","../../Backend/controllers/controller-guide.php", true);
  xhttp1.send(param1);
});
}
}
