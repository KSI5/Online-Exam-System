<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Examination Portal</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <link rel="stylesheet" href="http://kayseye.unisa.ac.za/assets/css/style.css">
  </head>
  <body>
  <div class="container">
<div class="row">
        <div class="col-md-6 col-md-offset-3">
          <div class="panel panel-login">
            <div class="panel-heading">
              <div class="row">
                <div class="col-xs-12">   </div>
                <h3 class="card-title text-center text-uppercase text-black mb-3 fw-bold fs-4">
                      <i class="fa fa-users color-one"></i> Exams Department Login
                    </h3>
            </div>
            <div class="panel-body">
              <div class="row">
                <div class="col-lg-12">
                  <form id="login-form" action="" method="post" role="form" style="display: block;">
                    <div class="form-group">
					<label>User Name</label>
  <input type="text" name="staffEmail" id="staffEmail" tabindex="1" class="form-control" placeholder="Enter Admin Email" value="" >
                    </div>

                    <div class="form-group">
					<label>Password</label>
 <input type="Password" name="staffPassword" id="staffPassword" tabindex="2" class="form-control" placeholder="Enter Password"  value=""required>
                    </div>
<div class="form-group">
  <div class="row">
                        <div class="col-sm-6 col-sm-offset-3">
  <input type="submit" value="LOGIN" id="login-submit" name="login-submit"tabindex="4" class="form-control btn btn-login" onclick="validate()"/>
                   </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-12">
                          <div class="text-center">
                            <a href="https://phpoll.com/recover" tabindex="5" class="forgot-password">Forgot Password?</a>

                          <div>For security reasons, please <a href="#"><strong>log out</strong></a> and exit your web browser when you are done accessing services that require authentication!</div>
                        </div>
                      </div>
                    </div>
                    <br>
                    <br>
                    <br>
                    <hr>
                 <strong>Copyright &copy; 2022 | | UNISA Online Examination Portal  </strong>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>