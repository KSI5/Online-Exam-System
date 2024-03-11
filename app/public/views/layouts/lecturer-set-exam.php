<?php require get_file('header'); ?>

    <div class="container-fluid">
      <div class="row">

        <?php require(navigation()); ?>

        <div class="container">
          <div class="col-xs-12 col-md-12">

            <div class="col-xs-12 col-md-12">
              <?php lecturer_set_exam_form('set-exam') ?>
            </div>

          </div>
        </div>

      </div>
    </div>

<?php require get_file('footer'); ?>