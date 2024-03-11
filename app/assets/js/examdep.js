function validate()
{
  event.preventDefault();

  var staffEmail = document.getElementById("staffEmail");
  var staffPassword = document.getElementById("staffPassword");
  var param = 'staffEmail='+staffEmail.value+'&staffPassword='+staffPassword.value;

  var xhttp = new XMLHttpRequest();
  xhttp.open("POST", "public/model/examdep-login.php", true);
  
  xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

  xhttp.onreadystatechange = function() {

      if (this.readyState == 4 && this.status == 200) {

        var res = JSON.parse(xhttp.responseText);
        var element = document.getElementById('response');
        element.classList.remove('alert-danger')

        if (res['status'] == false) {
            element.classList.add('alert')
            element.classList.add('alert-danger')
            document.getElementById("response").innerHTML = res['message'];

            return;
        }

        if (res['status'] == true) {
            element.classList.add('alert')
            element.classList.add('alert-success')
            document.getElementById("response").innerHTML = res['message'];
            window.location.href = '?action=examdep-home';
        }

      }

  };

  xhttp.send(param);

}

function extract(transactionID)
{

  var element = document.getElementById(transactionID);
  var param = 'id=' + transactionID;
  var xhttp = new XMLHttpRequest();
  xhttp.open("POST", "public/model/examdep-extract.php", true);
  
  xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

  xhttp.onreadystatechange = function() {

      if (this.readyState == 4 && this.status == 200) {

        var res = JSON.parse(xhttp.responseText);

        if (res['status'] == true) {
            element.classList.add('btn-danger');
        }
        else
        {
          alert(res['message'])
        }

      }

  };

  xhttp.send(param);
}