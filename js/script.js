function drawPieChart(id, title, subtitle, data){
    Highcharts.chart(id, {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            backgroundColor: backGroundColor,
            type: 'pie'
        },
        title: {
            text: title
        },
        subtitle: {
            text: subtitle
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    formatter: function () {
                        var number = getSimpleValue(this.y);
                        var str = number[0]+number[1];
                        if(this.key){
                            str = this.key+", "+str;
                        }
                        return str;
                    },
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
        series: [{
            name: 'Sales',
            colorByPoint: true,
            data: data
        }]
    });
}

function drawBarChart(id, title, yAxisTitle, data){
    Highcharts.chart(id, {
        chart: {
            type: 'column',
            backgroundColor: backGroundColor
        },
        legend:{
            enabled:false
        },
        title: {
            text: title
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            min: 0,
            title: {
                text: yAxisTitle
            }
        },
        plotOptions: {
            series: {
                dataLabels: {
                    enabled: true,
                    formatter:function() {
                        var number = getSimpleValue(this.y);
                        return number[0]+number[1];
                    }
                },
                cursor: 'pointer',
                point: {
                    events: {
                        click: function () {
                            // $('#dialog').trigger("click");
                            // $('#barchart .modal-header .modal-title').html(this.name);
                            // $('#barchart .modal-body p').html(this.y);
                            window.open("new.php?name="+this.name+"&value="+this.y,'mywin','width=500,height=500');
                        }
                    }
                }
            }
        },
        tooltip: {
            format: '{series.name}:<b>{point.y:.1f}</b>',
            shared: true
        },
        series: data
    });
}
function drawLineChart(id, title, data){
    Highcharts.chart(id, {

        chart: {
            backgroundColor: backGroundColor
        },
        title: {
            text: title
        },
    
        subtitle: {
            text: ''
        },
    
        yAxis: {
            title: {
                text: ''
            }
        },
        legend: {
            // layout: 'vertical',
            // align: 'right',
            // verticalAlign: 'middle'
        },
    
        xAxis:{
            categories: ["July", "August", "Septemper", "October", "November", "December", "January", "February", "March", "April", "May", "June"],
            tickInterval: 2
        },
        series: data,
    
        responsive: {
            rules: [{
                condition: {
                    maxWidth: 500
                },
                chartOptions: {
                    legend: {
                        layout: 'horizontal',
                        align: 'center',
                        verticalAlign: 'bottom'
                    }
                }
            }]
        }
    
    });
}

function getSimpleValue(x){
    if(x < 1000) return [x, ''];
    if(x < 1000000) return [x/1000, 'K'];
    if(x < 1000000000) return [x/1000000, 'M'];
    if(x < 1000000000000) return [x/1000000000, 'B'];
    return [x/1000000000000, 'T'];
}

function getString(val){
    var GroupID = "Miscellaneous";
    switch(val){
        case "1980":
            GroupID = "Absorbents";
            break;
        case "1981":
            GroupID = "Spill Kits";
            break;
        case "1982":
            GroupID = "Spill Barriers"
            break;
        case "1983":
            GroupID = "Personal Safety"
            break;
        case "1984":
            GroupID = "Plant Safety"
            break;
        case "1985":
            GroupID = "Maintenance"
            break;
        case "1986":
            GroupID = "Materials Handling"
            break;
        case "1987":
            GroupID = "Containment"
            break;
    }
    return GroupID;
}