<?php
require_once _WEB_PATH_TEMPLATE . '/admin/layouts/header.php';
// Lấy dữ liệu
$listAllCate = getRaw("SELECT type.*,count(products.id) as count_id, max(products.price) as max_price ,min(products.price) as min_price,avg(products.price)  as avg_price FROM type INNER JOIN products ON products.type_id=type.id WHERE products.type_id=type.id GROUP BY type.id ORDER BY id DESC");

$listAllProduct = getRaw("SELECT * FROM products ORDER BY price");
?>
<div class="row2 form_content ">
    <h1>Biểu đồ thống kê</h1>
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <div class="row">
        <div class="col-6">
            <div id="myChart" style="width:100%; width:800px; height:500px; align-items: center">
            </div>
        </div>
        <div class="col-6">
            <div id="myChart1" style="width:100%; width:800px; height:500px; align-items: center">
            </div>
        </div>
    </div>




    <script>
    google.charts.load('current', {
        'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        // Set Data
        const data = google.visualization.arrayToDataTable([
            ['Danh mục', 'Số lượng sản phẩm'],
            <?php if (!empty($listAllCate)) {
                    foreach ($listAllCate as $item) {
                        extract($item);
                        echo "['$name', $count_id],";
                    }
                }
                ?>
        ]);

        // Set Options
        const options = {
            title: 'Thống kê sản phẩm theo loại',
            is3D: true
        };

        // Draw
        const chart = new google.visualization.PieChart(document.getElementById('myChart'));
        chart.draw(data, options);

    }

    google.charts.setOnLoadCallback(drawChart1);

    function drawChart1() {
        // Set Data
        const data = google.visualization.arrayToDataTable([
            ['Price', 'View'],
            <?php if (!empty($listAllProduct)) {
                    foreach ($listAllProduct as $item) {
                        extract($item);
                        echo "[$price, $view],";
                    }
                }
                ?>
        ]);
        // Set Options
        const options = {
            title: 'Biểu đồ giá, lượt xem sản phẩm',
            hAxis: {
                title: 'Giá sản phẩm'
            },
            vAxis: {
                title: 'Lượt xem sản phẩm'
            },
            legend: 'none'
        };
        // Draw Chart
        const chart = new google.visualization.LineChart(document.getElementById('myChart1'));
        chart.draw(data, options);
    }
    </script>

</div>
<?php
require_once _WEB_PATH_TEMPLATE . '/admin/layouts/footer.php';
?>
<!-- <div class="row">
    <div class="piechart"></div>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <script type="text/javascript">
    // load google charts
    google.charts.load('current', {
        'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawChart);

    // Draw the chart and set the chart values
    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Danh mục', 'Số lượng sản phẩm'],
            ['word', 8],
            ['word', 8],
            ['word', 8],
            ['word', 8],
            ['word', 8],
        ]);

        // Optional; add a title and set the width and height of the chart
        var options = {
            'title': 'Thống kê sản phẩm theo danh mục',
            'width': 1100,
            'height': 800
        };

        // display the chart inside the <div> element with id="piechart"
        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        chart.draw(data, options);
    }
    </script>
</div> -->