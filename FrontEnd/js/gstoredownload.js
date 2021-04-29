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

function store() {
  var x = document.getElementById("myFile");
 var desc = "form"+x;
 var pid = localStorage.getItem("tempKey");

file = x.files[0];
console.log(file);
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

    param.append("variablePath",downloadURL);
    param.append("action","addDocuments");
    param.append("document_name",fileName);
    param.append("documentDescription",desc);
    //param.append("projectID",pid);
    if (firebase.auth().currentUser !== null) 
        var key = firebase.auth().currentUser.uid;
    firebase.database().ref().child('users').child(key).once('value').then(function (snapshot) {
      param.append("studentID", id = "2"/*snapshot.val().id*/);

      param.append("name", name = snapshot.val().name);

      param.append("role", role = snapshot.val().role);


      var xhttp1 = new XMLHttpRequest();

      xhttp1.onreadystatechange = function () {

      if (this.readyState == 4 && this.status == 200) {
        console.log(this.responseText);
        var myob = JSON.parse(this.responseText);
        if(myob['status'] =='true'){
          window.alert("File Uploaded Successfully");
         // window.location.reload();
        }
      }
    }
    xhttp1.open("POST","../../Backend/controllers/controller-student.php", true);

    xhttp1.send(param);
  });
});
});

}