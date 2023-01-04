function graficoPizza(renderTo,title, serieName){
      var dados=[];
      var valores= $.parseJSON($("#"+renderTo).attr("data-valor"));
       // console.log(values);
      $.each(valores, function (i, item) {
       //console.log(item[Object.keys(item)[0]]);
       dados.push( { name:item[Object.keys(item)[0]],
                 y:parseFloat(item[Object.keys(item)[1]])
               })
      });
     //console.log( dados );
      var charts = new Highcharts.Chart({
        chart: {
         renderTo: renderTo,
         type: 'pie'
        },
       title: {
        text: title
       },
      credits: {
          enabled: false
      },
      plotOptions: {
          pie: {
              allowPointSelect: true,
              cursor: 'pointer',
              dataLabels: {
                  enabled: true,
                  format: '<b>{point.name}</b>: {point.percentage:.1f} %'
              },
              showInLegend: false
          }
      },

       series: [{
        name: serieName,
        colorByPoint: true,
        data: dados
       }]
      });

     return charts;

}

function graficoColunas(renderTo,title, serieName,yName){
    var dados=[];
    var valores= $.parseJSON($("#"+renderTo).attr("data-valor"));
    // console.log(values);
    $.each(valores, function (i, item) {
        //console.log(item[Object.keys(item)[0]]);
        dados.push( { name:item[Object.keys(item)[0]],
            data:[parseFloat(item[Object.keys(item)[1]])]
        })
    });
   // console.log( dados );
    var charts = new Highcharts.Chart({
        chart: {
            renderTo: renderTo,
            type: 'column'
        },
        title: {
            text: title
        },
        credits: {
            enabled: false
        },
        xAxis: {
            categories: [
                ''
            ],
            crosshair: true
        },
        yAxis: {
           // min: 0,
            title: {
                text: yName
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                /*'<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>'*/
            '<td style="padding:0"><b>{point.y}</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: dados
    });

    return charts;

}

function graficoLinhas(renderTo,title, serieName,yName){
    var dados=[];
    var categorias=[];
    var valores= $.parseJSON($("#"+renderTo).attr("data-valor"));

    var array = $.map(valores[1], function(value, index) {
        return [index];
    });

   //console.log(array);

    for (i = 1; i < array.length; i++) {
        dados[array[i]]=[];
    }

    

    $.each(valores, function (i, item) {
        for (i = 1; i < array.length; i++) {
            dados[array[i]].push(parseFloat(item[Object.keys(item)[i]]));
        }
        categorias.push(item[Object.keys(item)[0]]);

    });

    var series=[];
    var showLegend=false;
    if(serieName=="DEFAULT"){
        showLegend=true;
    }
    for (i = 1; i < array.length; i++) {
        series.push(
                    { name:array[i],
                      data:dados[array[i]],
                      visible: showLegend
                    })
    }


    var charts = new Highcharts.Chart({
        chart: {
            renderTo: renderTo,
            type: 'line'
        },
        title: {
            text: title
        },
        credits: {
            enabled: false
        },xAxis: {
            categories: categorias
        },
        yAxis: {
            title: {
                text: yName
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080',
            }]
        },
        plotOptions: {
            line: {
                dataLabels: {
                    enabled: true
                },
                enableMouseTracking: false
            }
        },

        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        },
        series: series
    });

    return charts;

}


function graficoColunasEmpilhadas(renderTo,title, serieName,yName){

    var dados=[];
    var categorias=[];
    var valores= $.parseJSON($("#"+renderTo).attr("data-valor"));

    var array = $.map(valores[1], function(value, index) {
        return [index];
    });

    for (i = 1; i < array.length; i++) {
        dados[array[i]]=[];
    }

    $.each(valores, function (i, item) {


        for (i = 1; i < array.length; i++) {
            if(Object.keys(item)[i] != 'TOTAL'){
                dados[array[i]].push(parseFloat(item[Object.keys(item)[i]]));
            }



        }



       categorias.push(item[Object.keys(item)[0]]);




    });

    var series=[];
    for (i = 1; i < array.length; i++) {

        if(array[i]!='TOTAL')
        {
            series.push(
                { name:array[i],
                    data:dados[array[i]]
                })
        }

    }

    console.log(series);
    
    var charts = new Highcharts.Chart({

        /*
        chart: {
            renderTo: renderTo,
            type: 'line'
        },
        title: {
            text: title
        },
        credits: {
            enabled: false
        },xAxis: {
            categories: categorias
        },
        yAxis: {
            title: {
                text: yName
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },

        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        },
        series: series
        */
        chart: {
            type: 'column',
            renderTo: renderTo,
        },
        title: {
            text: title
        },
        credits: {
            enabled: false
        },
        xAxis: {
            //categories: ['Apples', 'Oranges', 'Pears', 'Grapes', 'Bananas']
            categories: categorias
        },
        yAxis: {
            min: 0,
            title: {
                text: yName
            },
            stackLabels: {
                enabled: true,
                style: {
                    fontWeight: 'bold',
                    color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                }
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        },
        tooltip: {
            headerFormat: '<b>{point.x}</b><br/>',
            pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
        },
        plotOptions: {
            column: {
                stacking: 'normal',
                dataLabels: {
                    enabled: true,
                    color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white',
                    style: {
                        textShadow: '0 0 3px black'
                    }
                }
            }
        },
        /*series: [{
            name: 'John',
            data: [5, 3, 4, 7, 2]
        }, {
            name: 'Jane',
            data: [2, 2, 3, 2, 1]
        }, {
            name: 'Joe',
            data: [3, 4, 4, 2, 5]
        }]*/
        series: series

    });

    return charts;
}


function graficoColunasEmpilhadasStack(renderTo,title, serieName,yName){

    var dados=[];
    var categorias=[];
    var valores= $.parseJSON($("#"+renderTo).attr("data-valor"));

    var array = $.map(valores[1], function(value, index) {
        return [index];
    });

    for (i = 1; i < array.length; i++) {
        dados[array[i]]=[];
    }

    $.each(valores, function (i, item) {


        for (i = 1; i < array.length; i++) {
            if(Object.keys(item)[i] != 'TOTAL'){
                dados[array[i]].push(parseFloat(item[Object.keys(item)[i]]));
            }



        }



       categorias.push(item[Object.keys(item)[0]]);




    });

    var series=[];
    for (i = 1; i < array.length; i++) {

        if(array[i]!='TOTAL')
        {
            var res=array[i].split("@");

            series.push(
                { name:res[0]+'-'+res[1],
                    data:dados[array[i]],
                    stack:res[1]
                })
        }

    }

    console.log(series);
    
    var charts = new Highcharts.Chart({

        /*
        chart: {
            renderTo: renderTo,
            type: 'line'
        },
        title: {
            text: title
        },
        credits: {
            enabled: false
        },xAxis: {
            categories: categorias
        },
        yAxis: {
            title: {
                text: yName
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },

        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        },
        series: series
        */
        chart: {
            type: 'column',
            renderTo: renderTo,
        },
        title: {
            text: title
        },
        credits: {
            enabled: false
        },
        xAxis: {
            //categories: ['Apples', 'Oranges', 'Pears', 'Grapes', 'Bananas']
            categories: categorias
        },
        yAxis: {
            min: 0,
            title: {
                text: yName
            },
            stackLabels: {
                enabled: true,
                style: {
                    fontWeight: 'bold',
                    color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                }
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        },
        tooltip: {
            headerFormat: '<b>{point.x}</b><br/>',
            pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
        },
        plotOptions: {
            column: {
                stacking: 'normal',
                dataLabels: {
                    enabled: true,
                    color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white',
                    style: {
                        textShadow: '0 0 3px black'
                    }
                }
            }
        },
        /*series: [{
            name: 'John',
            data: [5, 3, 4, 7, 2]
        }, {
            name: 'Jane',
            data: [2, 2, 3, 2, 1]
        }, {
            name: 'Joe',
            data: [3, 4, 4, 2, 5]
        }]*/
        series: series

    });

    return charts;
}