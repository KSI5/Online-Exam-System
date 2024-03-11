<?php require get_file('header'); ?>

    <div class="container-fluid">
      <div class="row">

        <?php require(navigation()); ?>
        <div class="container-fluid">
          <div class="row col-xs-12 col-md-12">

            <h1 class="page-header text-center">
              <small>Available Exams</small>
            </h1>

            <div class="search-wrapper">
              <input type="text" id="search" onkeyup="jsSearchTable()" placeholder="Search ...">
            </div>

            <div class="table-responsive">
              <table class="table table-bordered table-hover text-center" id="<?= user() ?>">
                <!-- On rows -->
                <thead>
                  <tr>
                    <th class="active text-center">#</th>
                    <th class="active text-center">Module Code</th>
                    <th class="active text-center">Start Date</th>
                    <th class="active text-center">Start Time</th>
                  </tr>
                </thead>

                <tbody>

                  <?= lecturer_available_exams(); ?>
                  
                </tbody>

              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

<?php require get_file('footer'); ?>