firebase.auth().onAuthStateChanged(function (user) {
  if (user) {
    if(localStorage.getItem("tempKey")){
      logout();
    }
  }
});


document.getElementById("role").addEventListener("click",function(){
  if( document.getElementById("role").value== "Student")
  {
  document.getElementById("student_type").style.display = "block";
  document.getElementById("dept_div").style.display = "block";
  document.getElementById("guide_type").style.display = "none";
  }
  if(document.getElementById("role").value== "Guide")
  {
    document.getElementById("guide_type").style.display = "block";
    document.getElementById("dept_div").style.display = "block";
    document.getElementById("student_type").style.display = "none";
    document.getElementById("start_date_div").style.display = "none";
  document.getElementById("end_date_div").style.display = "none";
  }
  if(document.getElementById("role").value== "Secretariat" || document.getElementById("role").value== "IRB")
  {
    document.getElementById("guide_type").style.display = "none";
    document.getElementById("dept_div").style.display = "none";
    document.getElementById("student_type").style.display = "none";
    document.getElementById("start_date_div").style.display = "none";
  document.getElementById("end_date_div").style.display = "none";
  }

});
document.getElementById("student_type").addEventListener("click",function(){
  if( document.getElementById("student_type").value== "PhD")
  {
  document.getElementById("start_date_div").style.display = "block";
  document.getElementById("end_date_div").style.display = "block";

  }
  if( document.getElementById("student_type").value== "MSc" || document.getElementById("student_type").value== "DNB")
  {
  document.getElementById("start_date_div").style.display = "none";
  document.getElementById("end_date_div").style.display = "none";

  }
});



function create(){
  var name = document.getElementById("name").value;
  if(name == ''){
    window.alert("Please fill in the name");
    throw new Error("Please fill in the name");
  }
  var phone = document.getElementById("phone").value;
  if(phone == ''){
    window.alert("Please fill in the phone number");
    throw new Error("Please fill in the degree");
  }
  else{
    var phoneno = /^\d{10}$/;
  if (!(phone.match(phoneno)))
  {
    window.alert("Please enter a valid 10 digit phone number");
    throw new Error("Phone error");
  }
 
  }
  var role = document.getElementById("role").value;
  if(role == 0){
    window.alert("Please fill in the role");
    throw new Error("Please fill in the role");
  }
  if(role == "Student")
  {
    var degree = document.getElementById("student_type").value;
    if(degree == ''){
      window.alert("Please fill in the degree");
      throw new Error("Please fill in the degree");
    }
    if(degree == "PhD")
    {
      var st_date = document.getElementById("start_date").value;
      if(st_date == ''){
        window.alert("Please fill in the start date");
      throw new Error("Please fill in the start date");
    }
    var end_date = document.getElementById("end_date").value;
    if(end_date == ''){
      window.alert("Please fill in the end date");
      throw new Error("Please fill in the end date");
    }
  }
    var department = document.getElementById("dept").value;
    if(department == ''){
      window.alert("Please fill in the department");
      throw new Error("Please fill in the department");
    }
  }
  if(role == "Guide")
  {
    var designation = document.getElementById("guide_type").value;
    if(designation == ''){
      window.alert("Please fill in the designation");
      throw new Error("Please fill in the designation");
    }
    var department = document.getElementById("dept").value;
    if(department == ''){
      window.alert("Please fill in the department");
      throw new Error("Please fill in the department");
    }
  }
  var email = document.getElementById("email").value;
  if(email == ''){
    window.alert("Please fill the email field")
    throw new Error("Please fill the email field");
  }
  else
{
  var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
if(!(email.match(mailformat)))
  {
    window.alert("Please enter a proper email id");
    document.getElementById("email").focus();
    throw new Error("Please enter a proper email id");
    
  }
}
  var password = document.getElementById("password").value;
  if(password.length < 6){
    window.alert("Please enter 6 or more digit password");
    throw new Error("Please enter 6 or more digit password");
  }
  var activated = "0";
  var id= "NA";

  firebase.auth().createUserWithEmailAndPassword(email, password).then(function(user) {
  var user = firebase.auth().currentUser;
  if(role == "Student" && degree == "PhD"){
    console.log("Hello");
  firebase.database().ref('users/' + user.uid).set({
    id:id,
    name: name,
    email: email,
    phone: phone,
    role: role,
    degree: degree,
    department:department,
    st_date: st_date,
    end_date: end_date,
    activated: activated
  });}
  else if(role == "Student" && degree == "DNB"){
    firebase.database().ref('users/' + user.uid).set({
      id:id,
      name: name,
      email: email,
      phone: phone,
      role: role,
      degree: degree,
      department:department,
      duration: "2",
      activated: activated
    });
  }
  else if(role == "Student" && degree == "MSc"){
    firebase.database().ref('users/' + user.uid).set({
      id:id,
      name: name,
      email: email,
      phone: phone,
      role: role,
      degree: degree,
      department:department,
      duration: "3",
      activated: activated
    });
  }
  else if(role == "Guide"){
    firebase.database().ref('users/' + user.uid).set({
      id:id,
      name: name,
      email: email,
      phone: phone,
      role: role,
      department:department,
      designation:designation,
      activated: activated
    });
  }
  else{
    firebase.database().ref('users/' + user.uid).set({
      id:id,
      name: name,
      email: email,
      phone: phone,
      role: role,
      activated: '1'
    });
  }
  user.updateProfile({displayName: name, email: email});
}).catch(function(error) {
  console.log(error);
});
}


function logout(){
  firebase.auth().signOut().then(function() {
  window.location.href="login.html";
}).catch(function(error) {
  // An error happened.
});
}