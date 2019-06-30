
<!doctype html>
<html>

    <head>
        <title>Line Chart</title>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
        <script src="<?php echo base_url(); ?>public/js/Chart.min.js"></script>
        <script src="<?php echo base_url(); ?>public/js/utils.js"></script>
        <script src="<?php echo base_url(); ?>public/bower_components/jquery/dist/jquery.min.js"></script>
        <style>
            canvas {
                -moz-user-select: none;
                -webkit-user-select: none;
                -ms-user-select: none;
            }
        </style>
    </head>

    <body>
        <div style="width:1000px">
            <canvas id="chart1"></canvas>
        </div>
        <br>
        <br>
        Chart Type:
        <select id="type">
            <option value="line">Line</option>
            <option value="bar">Bar</option>
        </select>
        <button id="update">update</button>
        <script>
             var dados = [];
    /*        
    function randomNumber(min, max) {
                return Math.random() * (max - min) + min;
            }

            function randomBar(date, lastClose) {
                var open = randomNumber(lastClose * 0.95, lastClose * 1.05).toFixed(2);
                var close = randomNumber(open * 0.95, open * 1.05).toFixed(2);
                return {
                    t: date.valueOf(),
                    y: close
                };
            }

            var dateFormat = 'MMMM DD YYYY';
            var date = moment('April 01 2017', dateFormat);
            var data = [randomBar(date, 30)];
            while (data.length < 60) {
                date = date.clone().add(1, 'd');
                if (date.isoWeekday() <= 5) {
                    data.push(randomBar(date, data[data.length - 1].y));
                }
            }

            console.log(data);
     * 
     */
            var ctx = document.getElementById('chart1').getContext('2d');
            ctx.canvas.width = 1000;
            ctx.canvas.height = 300;

            var color = Chart.helpers.color;
            var cfg = {
                type: 'bar',
                data: {
                    datasets: [{
                            label: 'CHRT - Chart.js Corporation',
                            backgroundColor: color(window.chartColors.red).alpha(0.5).rgbString(),
                            borderColor: window.chartColors.red,
                            data: dados,
                            type: 'line',
                            pointRadius: 0,
                            fill: false,
                            lineTension: 0,
                            borderWidth: 2
                        }]
                },
                options: {
                    scales: {
                        xAxes: [{
                                type: 'time',
                                distribution: 'series',
                                ticks: {
                                    source: 'data',
                                    autoSkip: true
                                }
                            }],
                        yAxes: [{
                                scaleLabel: {
                                    display: true,
                                    labelString: 'Power',                                    
                                }//,
                               // ticks: {
                               //     beginAtZero: true,
                               //     max: 300
                               // }
                            }]
                    }
                }
            };

            var chart = new Chart(ctx, cfg);

            document.getElementById('update').addEventListener('click', function () {
                var type = document.getElementById('type').value;
                chart.config.data.datasets[0].type = type;
                chart.update();
            });

        </script>
    </body>

</html>
<script>
//grafico intertivo potencia
$(function(){   
    var update = setTimeout(grafico_potencia, 500);
    
    function grafico_potencia(){
      $.ajax({
          url: "<?= site_url('energia_gerada/get_potencia_realtime/1'); ?>"  
      })
      .done(function( data ) { 
        var json = JSON.parse(data);
            json.t = new Date(json.t);
            dados.push(json);            
            console.log(dados);
            chart.config.data.datasets[0].data = dados;            
            chart.update();
            if(dados.length > 100){
               dados.shift(); 
               
            }          
      });  
          setTimeout(grafico_potencia, 2000);      
    }
    
     //REALTIME TOGGLE
    $('#realtime .btn').click(function () {
      if ($(this).data('toggle') === 'on') {
        realtime = 'on';
      }
      else {
        realtime = 'off';
      }
    });
});


</script>

