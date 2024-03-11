<?php require get_file('header'); ?>

    <div class="container-fluid">
      <div class="row">

        <?php require(navigation()); ?>

        <div class="container-fluid">
          <div class="col-xs-12 col-md-12">

            <?php
            
              if (isset($_GET['code'])) {
                
                require get_file('download-table');
                exit;
                
              }
              
              view_my_module();
            ?>

          </div>
        </div>

      </div>
    </div>

<?php require get_file('footer'); ?>