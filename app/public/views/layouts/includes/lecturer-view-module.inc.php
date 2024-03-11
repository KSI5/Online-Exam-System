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
            <th class="active text-center">#</th>
            <th class="active text-center">Transaction ID</th>
            <th class="active text-center">Student Number</th>
            <th class="active text-center">Module Code</th>
            <th class="active text-center">Submission Date</th>
            <th class="active text-center">Submission Time</th>
            <th class="active text-center">Download</th>
            <th class="active text-center">Marks</th>
            <th class="active text-center">Update Marks</th>
          </tr>
        </thead>

        <tbody>
          <?= lecturer_get_submitted_exams() ?>
        </tbody>

      </table>
    </div>
  </div>
</div>