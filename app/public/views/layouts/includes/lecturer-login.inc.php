
      <div class="container">
      <div class="row">
        <div class="col-md-6 col-md-offset-3">
          <div class="panel panel-login">
            <div class="panel-heading">
              <div class="row">
                <div class="col-xs-12"></div>
              <h2 class="card-title text-center text-capitalize text-black mb-3 fw-bold fs-3">
                <i class="fa fa-chalkboard-teacher color-two"></i> Lecturer Login
              </h2>
              <hr>
            </div>
            <div class="panel-body">
              <div class="row">
                <div class="col-lg-12">
                  <form id="login-form" action="" method="post" role="form" style="display: block;">
                    <div class="form-group">
            					<label>User Name</label>
                        <input type="text" name="staffNumber" id="staffNumber" tabindex="1" class="form-control" placeholder="Enter staffNumber" value="" >
                    </div>

                    <div class="form-group">
					<label>Password</label>

            <input type="Password" name="staffPassword" id="staffPassword" tabindex="2" class="form-control" placeholder="Enter Password"  value=""required>
                    </div>
                    
                    <div class="form-group">
                  
                      <span id="response" role="alert" class="text-center col-sm-12"></span>

                    </div>

            <div class="form-group">

                      <div class="row">
                        <div class="col-sm-6 col-sm-offset-3">
                          <span id="response"></span>
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
                    <hr>
                      <strong>Copyright &copy; 2022 || UNISA Online Examination Portal  </strong>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>