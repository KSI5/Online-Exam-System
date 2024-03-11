<?php require get_file('header'); ?>

    <div class="container-fluid">
      <div class="row">

        <?php require(navigation()); ?>

        <div class="container-fluid">
          <div class="col-xs-12 col-md-12">
            <div class="text-center">
              <h1 class="page-header">
                <small>Your Registered Modules</small>
              </h1>
              <div class="card transition-2">
                <?= students_modules(); ?>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>

<?php require get_file('footer'); ?>