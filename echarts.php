<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <script src="rs/js/echarts.js"></script>
        <script src="rs/js/jquery-3.2.0.min.js"></script>
        <script src="rs/js/ajaxfileupload.js"></script>
        <title>csv自动生成图表</title>

        <link type="text/css" href="rs/css/reset.css" rel="stylesheet"/>
        <link type="text/css" href="rs/css/style.css" rel="stylesheet"/>
		<link rel="stylesheet" href="rs/css/my.css" type="text/css">

    </head>
    <body>
        <ul class="form_ul">
            <form action="data.php" method = "post" enctype="multipart/form-data" id = "get_data_form">
                <li>
                    <strong>请上传csv表格文件</strong>
                    <input id = "csv_file" type = "file" name = "csv_file"/>
                </li>
                <li>
                    <strong>请选择生成图种类</strong>
                    <select name = "table_type" id = "table_type">
                        <option value = "bar">bar</option>
                        <option value = "line">line</option>
                    </select>
                </li>
                <li><strong></strong><input type = "submit" class="blue_button2"/></li>
            </form>
        </ul>
        <div id="main" style="margin-left:200px;width:600px;height:400px;"></div>
        <script>
            var mychart = echarts.init(document.getElementById('main'));
            $("#get_data_form").submit(function(){
                $.ajaxFileUpload({
                    url: "data.php",
                    type: "POST",
                    secureuri: false,
                    fileElementId: 'csv_file',
                    dataType: 'JSON',
                    data: {table_type: $("#table_type").val()}, 
                    success: function (data, status){
                        var replace_opt = JSON.parse(data);
                        if (replace_opt.legend.length != 0 && replace_opt.category.length != 0) {
                            var category_name = replace_opt.legend.splice(0,1);
                            replace_opt.category.splice(0,1);
                        }
                        path = $("#csv_file").val();
                        var pos1 = path.lastIndexOf("\\");
                        var pos2 = path.lastIndexOf(".");
                        var pos = path.substring(pos1 + 1, pos2);
                        option = {
                            title: {
                                text: pos
                            },
                            tooltip: {},
                            toolbox: {
                                show: true,
                                feature: {
                                    mark: {
                                        show: true
                                    },
                                    dataView: {
                                        show: true,
                                        readOnly: true
                                    },
                                    magicType: {
                                        show: true,
                                        type: ["line", "bar"]
                                    },
                                    restore: {
                                        show: true
                                    },
                                    saveAsImage: {
                                        show: true
                                    }
                                }
                            },
                            legend: {
                                data:replace_opt.legend
                            },
                            xAxis: {
                                name:category_name,
                                data:replace_opt.category
                            },
                            yAxis: {},
                            series: []
                        };
                        for (i = 0; i < replace_opt.data.length; i++) {
                            option.series[i] = new Object();
                            if (replace_opt.legend.length != 0)
                                option.series[i].name = replace_opt.legend[i];
                            option.series[i].type = 'bar';
                            option.series[i].data = replace_opt.data[i];
                        }
                        mychart.setOption(option);
                    },
                    error: function (data, status, e)//服务器响应失败处理函数
                    {
                        alert(e);
                    }
                });
                return false;
            });
        </script>
        
    </body>
</html>