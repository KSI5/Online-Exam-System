<?php require get_file('header'); ?>

    <div class="container-fluid">
      <div class="row">

        <?php require(navigation()); ?>

        <div class="container">
          <div class="col-xs-12 col-md-12">

            <?php require (students_uploader()); ?>

          </div>
        </div>

      </div>
    </div>

<?php require get_file('footer'); ?>