<?php require get_file('header'); ?>

    <div class="container-fluid">
      <div class="row">

        <?php require(navigation()); ?>

        <div class="container-fluid">
          <div class="col-xs-12 col-md-12">
            
            <div class="examdep-card-wrapper">
              <div class="card transition-2">
                <?php

                  examdep_daily_exams();
                  examdep_weekly_exams();
                  examdep_number_of_modules();
                  examdep_submitted_files();

                ?>
              </div>
            </div>

            <div class="chart">
              <h3 class="text-center">
                MIS REPORT LINE CHART
              </h3>
              <canvas id="total-daily-exams"></canvas>
            </div>

          </div>
        </div>

        <div class="container-fluid">
          <div class="col-xs-12 col-md-12">
            
            <?= examdep_modules('modules'); ?>

          </div>
        </div>

      </div>
    </div>

<script>

  var stats = document.getElementById('total-daily-exams').getContext('2d');

  var chart = new Chart(stats, {
      type: 'line',
       data: {
          labels: JSON.parse(JSON.stringify(<?= totalModules() ?>)),
          datasets: [{
              label: 'Number of Students Writing',
              data: JSON.parse(JSON.stringify(<?= totalStudents() ?>)), // background
              backgroundColor: 'transparent', // bar color 
              borderWidth: 3,
              borderColor: '#c1a149',
              hoverBorderWidth: 3,
              hoverBorderColor: '#00cbff'
          }]
      } 
  });
</script>
<?php require get_file('footer'); ?>