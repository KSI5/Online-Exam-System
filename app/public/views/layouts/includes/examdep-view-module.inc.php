<h1 class="page-header text-center">
  <small>Update Date for <?= get_module_code() ?></small>
</h1>

<form action="" method="POST" enctype="multipart/form-data">
  <div class="input-group">
    <span class="input-group-addon">
      <i class="fa fa-calendar"></i>
    </span>
    <input type="date" class="form-control" value="<?= date("Y-m-d") ?>" name="date" id="date">
  </div>
  <br>
  <div class="input-group">
    <span class="input-group-addon">
      <i class="fa fa-file"></i>
    </span>
    <input type="file" class="form-control" name="file" id="paper">
    <input type="hidden" class="form-control" id="module_code" value="<?= get_module_code() ?>">
  </div>

  <div class="form-group">
    <div id="response" class="text-center alert"></div>
  </div>
  <div class="input-group pull-right">
    <button class="btn btn-success" onclick="setDate()" id="submit">Set Exam</button>
  </div>
</form>