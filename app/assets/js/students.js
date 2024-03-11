function validate()
{
  event.preventDefault();

  var name = document.getElementById("studentName");
  var pass = document.getElementById("studentPassword");
  var param = 'name='+name.value+'&pass='+pass.value;

  var xhttp = new XMLHttpRequest();
  xhttp.open("POST", "public/model/students-login.php", true);
  
  xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

  xhttp.onreadystatechange = function() {

      if (this.readyState == 4 && this.status == 200) {

        var res = JSON.parse(xhttp.responseText);
        var element = document.getElementById('response');
        element.classList.remove('alert-danger')

        if (res['status'] == false) {
            element.classList.add('alert')
            element.classList.add('alert')
            element.classList.add('alert-danger')
            document.getElementById("response").innerHTML = res['message'];

            return;
        }

        if (res['status'] == true) {
            element.classList.add('alert')
            element.classList.add('alert-success')
            document.getElementById("response").innerHTML = res['message'];
            window.location.href = '?action=students-home';
        }

      }

  };

  xhttp.send(param);

}


async function submitExam() {

  event.preventDefault();
  var button = document.getElementById("submit");
  var paper = document.getElementById("paper").files[0];
  var module_code = document.getElementById("module_code");
  let formData = new FormData();
  formData.append("paper", paper);
  formData.append("module_code", module_code.value);
  document.getElementById("response").style.display = 'none';
  document.getElementById("submit").innerText = 'Please wait';

  await fetch('public/model/students-submit.php', {
    method: "POST", 
    body: formData
  }).then(response => {
 
    return response.text();
 
  }).then(result => {

    var element = document.getElementById('response');
    element.style.marginTop = "10px";
    element.classList.remove('alert-danger')
    document.getElementById("response").style.display = 'block';
    document.getElementById("submit").innerText = 'Upload Exam';

    if(!result)
    {
      element.classList.add('alert')
      element.classList.add('alert-danger')
      document.getElementById("response").innerHTML = "Please select a .PDF file to upload";

      return;
    }
    else
    {
      
      var res = JSON.parse(result);

      if (res['status'] == true) {
          element.classList.add('alert')
          element.classList.add('alert-success')
          document.getElementById("response").innerHTML = res['message'];

          return;
      }

      if (res['status'] == false) {
          element.classList.add('alert')
          element.classList.add('alert-danger')
          document.getElementById("response").innerHTML = res['message'];

          return;
      }

    }

  })

}