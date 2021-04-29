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


if(window.location.href == "http://localhost/sih/FrontEnd/views/notifications.html"){
  var key = localStorage.getItem("tempKey");

  console.log(key);
  var param = new URLSearchParams;
  firebase.database().ref().child('users').child(key).once('value').then(function (snapshot) {
    var param = new URLSearchParams();
    param.append("action","viewNotifications");

    param.append("guideID", id = "ID1"/*snapshot.val().id*/);
  var xhttp1 = new XMLHttpRequest();
  xhttp1.onreadystatechange = function () {

    if (this.readyState == 4 && this.status == 200) {
        console.log(this.responseText);
        var myob = JSON.parse(this.responseText);
        for ( i=0; i<Object.keys(myob['documents']).length;i++){
        var divc = document.createElement("div");
        divc.setAttribute("class","alert alert-success");
        btn = document.createElement("button");
        btn.setAttribute("class","close");
        btn.setAttribute("type","button");
        btn.setAttribute("data-dismiss","alert");
        btn.setAttribute("aria-label","Close");
        matic = document.createElement("i");
        matic.setAttribute("class","material-icons");
        matic.innerHTML = "close"
        btn.appendChild(matic);
        divc.appendChild(btn);
        h = document.createElement("h3");
        h.innerHTML = "<b>Project ID :"+myob['documents'][i]['project_ID'];
        divc.appendChild(h);
        b=document.createElement("b");
        b.innerHTML = myob['documents'][i]['message'];
        divc.appendChild(b);
        p=document.createElement("p");
        p.innerHTML = myob['documents'][i]['date'];
        divc.appendChild(p);
        var notifcard = document.getElementById("notifcard");
        notifcard.append(divc);
        

    }
  }
  }
  xhttp1.open("POST","../../Backend/controllers/controller-guide.php",true);
  xhttp1.send(param);
  });
}

if((window.location.href).split('?')[0] == "http://localhost/sih/FrontEnd/views/viewdoc.html")

{
  console.log("hi");

  var queryString=decodeURIComponent(window.location.search);
  queryString = queryString.substring(1);
  q=queryString.split("=");
  console.log(q[1]);

  firebase.database().ref().child('messages').child("PD104").once('value').then(function (snapshot){
    snapshot.forEach(function (childSnapshot) {
        var key;
        key = childSnapshot.key;
        console.log(key);
        firebase.database().ref().child('messages').child("PD104").child(key).once('value').then(function(snapshot){
          var div = document.createElement("DIV");
          div.classList.add("containerchat");
          if(snapshot.val().byWhom!="guide"){
            div.classList.add("darker");
          }
          var p = document.createElement("P");
          p.innerHTML ="<b>"+snapshot.val().name+"</b>"+": " + snapshot.val().message;
          div.appendChild(p);
          document.getElementById("chat").appendChild(div);          
        })
      });
     
  });


  //CODE FOR FILLING A SINGLE PROJECT INFORMATION

  

  var key = localStorage.getItem("tempKey");

  console.log(key);


  firebase.database().ref().child('users').child(key).once('value').then(function (snapshot) {
    var param = new URLSearchParams();

  param.append('action',"viewDocuments");
  param.append("projectID",proj_ID=q[1]);

    param.append("guideID", id = "ID1"/*snapshot.val().id*/);

    param.append("name", name = snapshot.val().name);

    param.append("role", role = snapshot.val().role);


    var xhttp1 = new XMLHttpRequest();
    var tab = document.getElementById("projTable");
    var tab2 = document.getElementById("revTable");
  xhttp1.onreadystatechange = function () {

        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            var myob = JSON.parse(this.responseText);
            for (var i = 0; i < Object.keys(myob['documents']).length; i++) {
          console.log(i);
          if(myob['documents'][i]['description']=="Review"){
          var tr = tab2.insertRow();

          var td0 = tr.insertCell(0);
          td0.appendChild(document.createTextNode(myob['documents'][i]['document_name']));
          
          var td1 = tr.insertCell(1);
          td1.appendChild(document.createTextNode(desc=myob['documents'][i]['description']));
                    
          var td2 = tr.insertCell(2);
          td2.appendChild(document.createTextNode(myob['documents'][i]['Time_of_submission']));
      
          var td3 = tr.insertCell(3);
          var downloadURL = myob['documents'][i]['Document_ID'];
          var anc = document.createElement("a");
          anc.setAttribute("href",downloadURL);
          anc.innerHTML = "Download";
          td3.append(anc);

          
          }
          else{
            var tr = tab.insertRow();

          var td0 = tr.insertCell(0);
          td0.appendChild(document.createTextNode(myob['documents'][i]['document_name']));
          
          var td1 = tr.insertCell(1);
          td1.appendChild(document.createTextNode(desc=myob['documents'][i]['description']));
                    
          var td2 = tr.insertCell(2);
          td2.appendChild(document.createTextNode(myob['documents'][i]['Time_of_submission']));
          var td3 = tr.insertCell(3);
          var downloadURL = myob['documents'][i]['Document_ID'];
          var anc = document.createElement("a");
          anc.setAttribute("href",downloadURL);
          anc.innerHTML = "Download";
          td3.append(anc);

            var td4 = tr.insertCell(4);
          var btn = document.createElement('button');
          //btn.setAttribute("id",`btn${i}`);
          btn.type = "button";
          btn.className = "waves-effect waves-light btn teal";
          btn.appendChild(document.createTextNode("Approve"));
          btn.setAttribute("onclick","approveDocuments(this)");
          btn.setAttribute("name",q[1]);
          btn.setAttribute("data-des",myob['documents'][i]['description']);
          td4.appendChild(btn);
          
          
          var btn1 = document.createElement('button');
          //btn.setAttribute("id",`btn${i}`);
          btn1.type = "button";
          btn1.className = "waves-effect waves-light btn red";
          btn1.appendChild(document.createTextNode("Disapprove"));
          btn1.setAttribute("onclick","disapproveDocuments(this)");
          btn1.setAttribute("name",q[1]);
          btn1.setAttribute("data-des",myob['documents'][i]['description']);
          td4.appendChild(btn1);

          var td5 = tr.insertCell(5);
          var upload = document.createElement('input');
          upload.setAttribute("id","myFile");
          upload.setAttribute("type","file");
          td5.appendChild(upload);
          var updbtn = document.createElement('button');
          updbtn.setAttribute("type","button");
          updbtn.setAttribute("onclick","store()");
          updbtn.innerHTML="Upload";
          td5.appendChild(updbtn);
          
            
          }
          
        }
      
      }
          }
  xhttp1.open("POST","../../Backend/controllers/controller-guide.php", true);

  xhttp1.send(param);

param.delete('action',"viewDocuments");


param.append('action',"viewApprovedDocuments");
  
var xhttp1 = new XMLHttpRequest();
  var tab1 = document.getElementById("appTable");
  var tab5=document.getElementById("decTable");
  xhttp1.onreadystatechange = function () {

        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            var myob = JSON.parse(this.responseText);
            for (var i = 0; i < Object.keys(myob['documents']).length; i++) {
          console.log(i);
          if(myob['documents'][i]['document_status']==1){
          var tr = tab1.insertRow();

          var td0 = tr.insertCell(0);
          td0.appendChild(document.createTextNode(myob['documents'][i]['document_name']));
          
          var td1 = tr.insertCell(1);
          td1.appendChild(document.createTextNode(desc=myob['documents'][i]['description']));
                    
          var td2 = tr.insertCell(2);
          td2.appendChild(document.createTextNode(myob['documents'][i]['Time_of_submission']));

          
          var td3 = tr.insertCell(3);
          var downloadURL = myob['documents'][i]['Document_ID'];
          var anc = document.createElement("a");
          anc.setAttribute("href",downloadURL);
          anc.innerHTML = "Download";
          td3.append(anc);
            }
            else{
              var tr = tab5.insertRow();

          var td0 = tr.insertCell(0);
          td0.appendChild(document.createTextNode(myob['documents'][i]['document_name']));
          
          var td1 = tr.insertCell(1);
          td1.appendChild(document.createTextNode(desc=myob['documents'][i]['description']));
                    
          var td2 = tr.insertCell(2);
          td2.appendChild(document.createTextNode(myob['documents'][i]['Time_of_submission']));

          
          var td3 = tr.insertCell(3);
          var downloadURL = myob['documents'][i]['Document_ID'];
          var anc = document.createElement("a");
          anc.setAttribute("href",downloadURL);
          anc.innerHTML = "Download";
          td3.append(anc);
            }
          }
          }
        }
        xhttp1.open("POST","../../Backend/controllers/controller-guide.php", true);
        xhttp1.send(param);




      
  });
  function send(){
    var div = document.createElement("DIV");
    div.classList.add("containerchat");
    var p = document.createElement("P");
    var message = document.getElementById("text").value;
    p.innerHTML ="<b>"+name+"</b>"+": " + message;
    document.getElementById("text").value = null;
    div.appendChild(p);
    document.getElementById("chat").appendChild(div);
    var key = localStorage.getItem("tempKey");
    firebase.database().ref().child('users').child(key).once('value').then(function (snapshot) {
    id = snapshot.val().id;
    firebase.database().ref('messages/' + proj_ID).push({
      id: id,
      message:message,
      name:name,
      byWhom: "guide",
      timeStamp:Date.now()
    });
    });

    
 }


  function approveDocuments(btn){
    var projectID = btn.name;
    var description = btn.parentNode.parentNode.children[1].innerHTML;
    
    console.log(projectID);
    console.log(description);
    var xhttp1 = new XMLHttpRequest();
    var param = new URLSearchParams;
    param.append("guideID",id);
    param.append("projectID",projectID);
    param.append("description",description);
    param.append("action",'approveDocuments');
  xhttp1.onreadystatechange = function () {

        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            var myob = JSON.parse(this.responseText);
           window.location.reload();

          


          
          
        }
      
            
          }
  xhttp1.open("POST","../../Backend/controllers/controller-guide.php", true);

  xhttp1.send(param);

  }
  function disapproveDocuments(btn){
    var projectID = btn.name;
    var description = btn.parentNode.parentNode.children[1].innerHTML;
    
    console.log(projectID);
    console.log(description);
    var xhttp1 = new XMLHttpRequest();
    var param = new URLSearchParams;
    param.append("guideID",id);
    param.append("projectID",projectID);
    param.append("description",description);
    param.append("action",'disapproveDocuments');
  xhttp1.onreadystatechange = function () {

        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            var myob = JSON.parse(this.responseText);
            window.location.reload();

          


          
          
        }
      
            
          }
  xhttp1.open("POST","../../Backend/controllers/controller-guide.php", true);

  xhttp1.send(param);

}
}