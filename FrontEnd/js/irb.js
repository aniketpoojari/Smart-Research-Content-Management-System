function work(btn){
    var type = btn.innerHTML;
    var pid = btn.id;
    var param = new URLSearchParams();
    if(type == "View"){
        localStorage.setItem("tempid",pid);
        window.location.href = "http://localhost/sih/FrontEnd/views/irb-proposals.html"
    } else {
        if(type == "Approve"){
            param.append('action',"approveProposals");
        } else if(type == "Disapprove"){
            param.append('action',"disapproveProposals");
        } else if(type == "Drop"){
            param.append('action',"dropProposals");
        }
        param.append('projectID', pid);
        var xhttp1 = new XMLHttpRequest();
        xhttp1.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                console.log(this.responseText);
                var myob = JSON.parse(this.responseText);   
            }
        }
        xhttp1.open("POST","../../Backend/controllers/controller-IRB.php", true);
        xhttp1.send(param);

    }
}
if( window.location.href == "http://localhost/sih/FrontEnd/views/irb-allproposals.html" ){
    var param = new URLSearchParams();
    param.append('action',"viewProposals");
    var key = localStorage.getItem("tempKey");
    console.log(key);
    console.log("hi");
    
    var xhttp1 = new XMLHttpRequest();
    xhttp1.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            var myob = JSON.parse(this.responseText);

            if(myob.status1 =="true"){
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
          td4.appendChild(document.createTextNode(myob['documents'][i]['project_ID']));
          
          var td5 = tr.insertCell(5);
          td5.appendChild(document.createTextNode(myob['documents'][i]['student_ID']));

          var pid = myob['documents'][i]['project_ID'];
          
          var td6 = tr.insertCell(6);
          var btn1 = document.createElement("button");
          btn1.innerHTML = "View";
          btn1.setAttribute('onclick', 'work(this)')
          btn1.setAttribute('id', pid);
          td6.appendChild(btn1);

          var td7 = tr.insertCell(7);
          var btn2 = document.createElement("button");
          btn2.innerHTML = "Approve";
          btn2.setAttribute('onclick', 'work(this)')
          btn2.setAttribute('id', pid);
          td7.appendChild(btn2);
          
          var td8 = tr.insertCell(8);
          var btn3 = document.createElement("button");
          btn3.innerHTML = "Disapprove";
          btn3.setAttribute('onclick', 'work(this)')
          btn3.setAttribute('id', pid);
          td8.appendChild(btn3);
          
          var td9 = tr.insertCell(9);
          var btn4 = document.createElement("button");
          btn4.innerHTML = "Drop";
          btn4.setAttribute('onclick', 'work(this)')
          btn4.setAttribute('id', pid);
          td9.appendChild(btn4); 
        }
      }
     }
    }
    xhttp1.open("POST","../../Backend/controllers/controller-IRB.php", true);

    xhttp1.send(param);
    
} else if( window.location.href == "http://localhost/sih/FrontEnd/views/irb-proposals.html" ){
    var pid = localStorage.getItem('tempid');
    
    var param = new URLSearchParams();
    param.append('action',"viewviewDocumentsPerProjectsDocument");
    param.append('projectID', pid);
    var key = localStorage.getItem("tempKey");
    console.log(key);
    
    var xhttp1 = new XMLHttpRequest();
    xhttp1.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            var myob = JSON.parse(this.responseText);
            if(myob['status1']=="true"){
                var a = (myob['documents'][0]['document'].split('&'));
                for( var i=0; i<58; i++){
                    console.log(i);
                    var b = a[i].split('=')[1].split('+');
                    console.log(b);
                    if(b.length != 1){
                        var c ="";
                        for(var j =0;j<b.length;j++){
                            c = c + b[j] + " ";
                        }
                        document.getElementById(i+1).value = c;
                    } else {
                        document.getElementById(i+1).value = b[0];
                    }
                }
            }
        }
    }
    xhttp1.open("POST","../../Backend/controllers/controller-IRB.php", true);
    xhttp1.send(param);
}