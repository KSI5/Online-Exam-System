<h1 class="page-header text-center">
  <small>Download and Upload Exams</small>
</h1>

<div class="container-fluid">
  <div class="row col-xs-12 col-md-12">

    <div class="search-wrapper">
      <input type="text" id="search" onkeyup="jsSearchTable()" placeholder="Search ...">
    </div>

    <div class="table-responsive">
      <table class="table table-bordered table-hover text-center" id="<?= user() ?>">
        <!-- On rows -->
        <thead>
          <tr>
            <th class="active text-center">Start Date</th>
            <th class="active text-center">Start Time</th>
            <th class="active text-center">End Time</th>
            <th class="active text-center">Download</th>
            <th class="active text-center">Submit</th>
          </tr>
        </thead>

        <tbody>
          <?= view_my_module() ?>
        </tbody>

      </table>
    </div>
  </div>
</div>

<?php require get_file('footer'); ?>