<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
  	<head>
        <meta http-equiv="content-type" content="text/html;charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1" />
    	<title>Sales Over</title>
        <!-- <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" media="all" rel="stylesheet" type="text/css"> -->
        <link rel="stylesheet" href="css/jquery-ui.css">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">
	</head>
	
	<body>
        <div class="container">
            <div class="whole-side">
                <div class="panel borderp">
                    <label>14% of customers make up 80% of sales revenue over the last 12 months</label>
                </div>
            </div>
            <div class="left-side">
                <div id="GSM" class="panel borderp"></div>
                <div id="YSbS" class="panel borderp"></div>
                <div class="panel">
                    <div id="GSY" class="h-panel borderp"></div>
                    <div id="GSL" class="h-panel borderp"></div>
                </div>
            </div>
            <div class="right-side">
                <div id="top10" class="panel borderp">
                    <div><label>Top 10 Customers last 12 months</label></div>
                    <div id="top10_inner"></div>
                </div>
                <div id="SCG" class="panel borderp"></div>
                <div id="CSG" class="panel borderp"></div>
                <div id="Inventory" class="panel borderp"></div>
            </div>
            <div class="side">
                <div class="panel borderp">
                    <div id="CCS"></div>
                </div>
            </div>
        </div>
        <!-- Trigger the modal with a button -->
        <button id="dialog" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#barchart">Open Modal</button>
        <!-- Modal -->
        <div id="barchart" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Modal Header</h4>
                </div>
                <div class="modal-body">
                    <p>Some text in the modal.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
                </div>

            </div>
        </div>
	</body>
    <script type="text/javascript">
        var backGroundColor = {linearGradient: [0, 0, 500, 500],stops: [[0, 'rgb(229, 239, 250)'],[1, 'rgb(254, 254, 255)']]};
        var budgetArray = [90000,92000,93000,93000,95000,95000,70000,85000,95000,95000,97000,100000];
    </script>
    <script src="js/d3.v4.min.js"></script>
    <script src="js/highcharts.js"></script>
    <!-- <script src="js/exporting.js"></script> -->
    <script src="js/highcharts-more.js"></script>
    <script src="js/solid-gauge.js"></script>
    <script src="js/jquery.js"></script>
    <script src="js/jquery-ui.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/script.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            d3.csv("data/MTD_Sales.csv", function(data){
                var GSM_Data = [];
                for(var i = 0; i < data.length; i++){
                    GSM_Data.push({name: getString(data[i].id), y: parseInt(data[i].MTD_SALES)});
                }
                drawPieChart('GSM', 'Group Sales MTD', 'MTD Sales = $14,552 (46.30% GM)', GSM_Data);
            });
            d3.csv("data/By_State.csv", function(data){
                var YSbS_Data = [{
                    name: 'Sales',
                    colorByPoint: true,
                    data: []
                }];
                for(var i = 0; i < data.length; i++){
                    YSbS_Data[0].data.push({name: data[i].del_suburb, y: parseInt(data[i].total)});
                }
                drawBarChart('YSbS', 'YTD Sales by State', 'Sales Figure', YSbS_Data);
            });
            d3.csv("data/YTD_Sales.csv", function(data){
                var GSY_Data = [];
                for(var i = 0; i < data.length; i++){
                    GSY_Data.push({name: getString(data[i].ID), y: parseInt(data[i].YTD_SALES)});
                }
                drawPieChart('GSY', 'Group Sales YTD', '$289,265 (45.73%)', GSY_Data);
            });
            d3.csv("data/LY_Sales.csv", function(data){
                var GSL_Data = [];
                for(var i = 0; i < data.length; i++){
                    GSL_Data.push({name: getString(data[i].ID), y: parseInt(data[i].LY_SALES)});
                }
                drawPieChart('GSL', 'Group Sales LY', 'LY Sales = $664,265', GSL_Data);
            });
            d3.csv("data/Cummulative_Sales.csv", function(data){
                var SCG_Data = [{
                    name: 'LY Sales',
                    data: [null,null,null,null,null,null,null,null,null,null,null,null]
                }, {
                    name: 'YTD Sales',
                    data: [null,null,null,null,null,null,null,null,null,null,null,null]
                }, {
                    name: 'YBL Sales',
                    data: [null,null,null,null,null,null,null,null,null,null,null,null]
                }];
                var CSG_Data = [{
                    name: 'LY Sales',
                    data: [0,0,0,0,0,0,0,0,0,0,0,0]
                }, {
                    name: 'YTD Sales',
                    data: [0,0,0,0,0,0,0,0,0,0,0,0]
                }, {
                    name: 'YBL Sales',
                    data: [0,0,0,0,0,0,0,0,0,0,0,0]
                }];
                for(var i = 0; i < data.length; i++){
                    for(k in data[i]){
                        var index = parseInt(k);
                        var val = parseInt(data[i][k]);
                        if(index > 17){
                            SCG_Data[2].data[index-13] = budgetArray[index-13];
                            CSG_Data[2].data[index-13] = budgetArray[index-13];
                        }else if(index > 5){
                            SCG_Data[0].data[17-index] = val;
                            CSG_Data[0].data[17-index] = val;
                        }else{
                            SCG_Data[1].data[5-index] = val;
                            CSG_Data[1].data[5-index] = val;
                        }
                    }
                }
                for(var i = 0; i < budgetArray.length; i++){
                    CSG_Data[2].data[i] = budgetArray[i];
                }
                for(var i = 0; i < CSG_Data.length; i++){
                    var dt = CSG_Data[i].data;
                    for(var j = 1; j < dt.length; j++){
                        if(dt[j] == 0){
                            dt[j] = null;
                        }else{
                            dt[j] += dt[j-1];
                        }
                    }
                }
                drawLineChart('SCG', 'Sales Comparison Graph', SCG_Data);
                drawLineChart('CSG', 'Cummulative Sales Graph', CSG_Data);
            });
            d3.csv("data/Customers.csv", function(data){
                var html = '';
                for(var i = 0; i < data.length; i++){
                    html += "<div class='clearfix'>";
                    html += "<div class='left_label'>"+data[i].debtor+"</div>";
                    html += "<div class='right_label'>$"+data[i].total+"</div>";
                    html += "</div>"
                }
                $('#top10_inner').html(html);
            });
            d3.csv("data/Cust_Category_Sales.csv", function(data){
                var CCS_Data = [], i;
                for(i = 0; i < data.length; i++){
                    CCS_Data.push({name:data[i].source+" Sales LY", data:[0,0,0,0,0,0,0,0,0,0,0,0]});
                    CCS_Data.push({name:data[i].source+" Sales YTD", data:[0,0,0,0,0,0,0,0,0,0,0,0]});
                }
                for(i = 0; i < data.length; i++){
                    for(k in data[i]){
                        var index = parseInt(k);
                        var val = parseInt(data[i][k]);
                        if(index < 6){
                            CCS_Data[i*2+1].data[5-index] = val;
                        }else if(index < 18){
                            CCS_Data[i*2].data[17-index] = val;
                        }
                    }
                }
                for(var i = 0; i < CCS_Data.length; i++){
                    var dt = CCS_Data[i].data;
                    for(var j = 1; j < dt.length; j++){
                        dt[j] += dt[j-1];
                    }
                }
                drawLineChart('CCS', 'Cummulative Sales Graph by Debtor Type', CCS_Data);
            });
            d3.csv("data/Inventory.csv", function(data){
                console.log(data);
                drawGauge("Inventory", data[0].name, parseInt(data[0].total), 200000);
            })
        });
    </script>
</html>