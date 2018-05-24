     <!-- Chart code -->
     <script>
      var gaugeChart = AmCharts.makeChart("chartdiv", {
        "type": "gauge",
        "theme": "none",
        "axes": [{
          "axisAlpha": 0,
          "tickAlpha": 0,
          "labelsEnabled": false,
          "startValue": 0,
          "endValue": 100,
          "startAngle": -90,
          "endAngle": 180,
          "bands": [{
            "color": "#eee",
            "startValue": 0,
            "endValue": 100,
            "radius": "100%",
            "innerRadius": "85%"
          }, {
            "color": "#5587a2",
            "startValue": 0,
            "endValue": <?php echo $Totaloverdue; ?>,
            "radius": "100%",
            "innerRadius": "85%",
            "balloonText": "<?php echo $Totaloverdue."% Overdue"; ?>"
          }, {
            "color": "#eee",
            "startValue": 0,
            "endValue": 100,
            "radius": "80%",
            "innerRadius": "65%"
          }, {
            "color": "#f76e6e",
            "startValue": 0,
            "endValue": <?php echo $un_overdueporcentaje; ?>,
            "radius": "80%",
            "innerRadius": "65%",
            "balloonText": "<?php echo $un_overdueporcentaje."% UN Overdue"; ?>"
          }, {
            "color": "#eee",
            "startValue": 0,
            "endValue": 100,
            "radius": "60%",
            "innerRadius": "45%"
          }, {
            "color": "#f6a54c",
            "startValue": 0,
            "endValue": <?php echo $cantoipoverdue; ?>,
            "radius": "60%",
            "innerRadius": "45%",
            "balloonText": "<?php echo $cantoipoverdue."% IP Overdue"; ?>"
          }, {
            "color": "#eee",
            "startValue": 0,
            "endValue": 100,
            "radius": "40%",
            "innerRadius": "25%"
          }, {
            "color": "#1cb0b0",
            "startValue": 0,
            "endValue": <?php echo $un_porcentaje; ?>,
            "radius": "40%",
            "innerRadius": "25%",
            "balloonText": "<?php echo $un_porcentaje."% Unassigned"; ?>"
          }]
        }],
        "allLabels": [{
          "text": "Delayed %",
          "x": "49%",
          "y": "76%",
          "size": 14,
          "bold": true,
          "color": "#5587a2",
          "align": "right"
        }, {
          "text": "UN Overdue %",
          "x": "49%",
          "y": "70%",
          "size": 14,
          "bold": true,
          "color": "#f76e6e",
          "align": "right"
        }, {
          "text": "IP Overdue %",
          "x": "49%",
          "y": "64%",
          "size": 14,
          "bold": true,
          "color": "#f6a54c",
          "align": "right"
        }, {
          "text": "Unassigned %",
          "x": "49%",
          "y": "58%",
          "size": 14,
          "bold": true,
          "color": "#8aafc1",
          "align": "right"
        }],
        "export": {
          "enabled": false
        }
      });
      </script>
      <!-- HTML -->
      <div id="chartdiv"></div>