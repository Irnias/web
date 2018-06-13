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
            "balloonText": "Delayed <b><?php echo $totun." (".$Totaloverdue."%)</b>"; ?>"
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
            "balloonText": "UN Overdue <b><?php echo $cantidadUNoverdue." (".$un_overdueporcentaje."%)</b>"; ?>"
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
            "balloonText": "IP Overdue <b><?php echo $totalopeoverdue. " (".$cantoipoverdue."%)<b>"; ?>"
          }, {
            "color": "#eee",
            "startValue": 0,
            "endValue": 100,
            "radius": "40%",
            "innerRadius": "25%"
          }, {
            "color": "#8aafc1",
            "startValue": 0,
            "endValue": <?php echo $un_porcentaje; ?>,
            "radius": "40%",
            "innerRadius": "25%",
            "balloonText": "Unassigned <b><?php echo $total_unnasigned." (".$un_porcentaje."%)<b>"; ?>"
          }]
        }],
        "allLabels": [{
          "text": "Delayed",
          "x": "40%",
          "y": "76%",
          "size": 14,
          "bold": true,
          "color": "#5587a2",
          "align": "right"
        }, {
          "text": "UN Overdue",
          "x": "40%",
          "y": "70%",
          "size": 14,
          "bold": true,
          "color": "#f76e6e",
          "align": "right"
        }, {
          "text": "IP Overdue",
          "x": "40%",
          "y": "64%",
          "size": 14,
          "bold": true,
          "color": "#f6a54c",
          "align": "right"
        }, {
          "text": "Unassigned",
          "x": "40%",
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
      <div id="chartdiv" style="max-height: 200px; max-width: 400px;"></div>
