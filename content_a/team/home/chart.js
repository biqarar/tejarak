function chartDrawer()
{
  if($("#chartdiv").length == 1){highChart();}
}



function highChart()
{

Highcharts.chart('chartdiv',
{
  chart: {
    zoomType: 'x',
    style: {
      fontFamily: 'IRANSans, Tahoma, sans-serif'
    }
  },
  title: {
    text: ''
  },
  xAxis: [{
    categories: {{hiChart.categories | raw}},
    crosshair: true
  }],
  yAxis: [{ // Primary yAxis
    labels: {
      format: '{value}',
      style: {
        color: Highcharts.getOptions().colors[0]
      }
    },
    title: {
      text: '',
      useHTML: Highcharts.hasBidiBug,
      style: {
        color: Highcharts.getOptions().colors[0]
      }
    }
  }],
  tooltip: {
    useHTML: true,
    borderWidth: 0,
    shared: true
  },
  exporting:
  {
    buttons:
    {
      contextButton:
      {
        menuItems:
        [
         'printChart',
         'separator',
         'downloadPNG',
         'downloadJPEG',
         'downloadSVG'
        ]
      }
    }
  },
  legend: {
    layout: 'vertical',
    align: 'left',
    x: 120,
    verticalAlign: 'top',
    y: 100,
    floating: true,
    backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || 'rgba(255,255,255,0.25)'
  },
  series: [
  {
    name: '{%trans "Sum hour"%}',
    type: 'column',
    data: {{hiChart.value | raw}},
    tooltip: {
      valueSuffix: ' {%trans "Hour"%}'
    }

  }
  ]
});
}