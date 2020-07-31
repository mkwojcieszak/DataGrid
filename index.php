<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.0/css/bootstrap.min.css' type='text/css'>
    <title>DataGrid by Mateusz Wojcieszak</title>
</head>
<body>
    <div class="container pt-5">
        <?php

        require 'DataGrid/vendor/autoload.php';

        use MKW\DataGridLib\HttpState;
        use MKW\DataGridLib\HtmlDataGrid;
        use MKW\DataGridLib\DefaultConfig;

        $rows = json_decode(file_get_contents("data.json"), true);
        $state = new HttpState();

        $dataGrid = new HtmlDataGrid();
        $config = (new DefaultConfig)
            // ->addIntColumn('id')
            // ->addTextColumn('name')
            // ->addIntColumn('age')
            // ->addTextColumn('company')
            // ->addCurrencyColumn('balance', 'USD')
            // ->addTextColumn('phone')
            // ->addTextColumn('email')

            ->addIntColumn('id')
            ->addTextColumn('name')
            ->addIntColumn('age')
            ->addTextColumn('company')
            ->addCurrencyColumn('balance', 'USD')
            ->addTextColumn('phone')

            ->setImageHeight(32)
            ->setImageWidth(32)
            ->addImageColumn('logo')

            ->setLinkClass('success')
            ->setLinkTag('a')
            ->addLinkColumn('email')

            ->setDateFormat('Y/m/d')
            ->addDateColumn('birth')

            ->setDateFormat('Y/m/d H-i-s')
            ->addDateColumn('last call')
            ;

        echo $dataGrid->withConfig($config)->render($rows, $state);
        ?>
    </div>
</body>
</html>
