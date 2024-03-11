<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="javascript:void">
        UNISA ONLINE EXAMINATION FILE SUBMISSION SYSTEM
      </a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      
      <ul class="nav navbar-nav navbar-right">
        <li>
          <a href="/?action=students-home">
            <i class="fa fa-home"></i>
          </a>
        </li>
        <li>
          <a href="/?action=students-exams">Exams</a>
        </li>
        <li>
          <a href="/?action=students-logout">Logout</a>
        </li>
        <li>
          <a href="javascript:void">
            <?= identifiyer()['studentName'] ?>
          </a>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>