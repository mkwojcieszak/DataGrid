<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.0/css/bootstrap.min.css' type='text/css'>
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
    integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"> -->
    <title>DataGrid by Mateusz Wojcieszak</title>
</head>
<body>
    <div class="container pt-5 pb-5">
        <?php

        require 'DataGrid/vendor/autoload.php';

        use MKW\DataGridLib\HttpState;
        use MKW\DataGridLib\HtmlDataGrid;
        use MKW\DataGridLib\DefaultConfig;

        $rows = json_decode(file_get_contents("data.json"), true);
        $file = file_get_contents("data.json");
        $state = new HttpState();

        $dataGrid = new HtmlDataGrid();
        $config = (new DefaultConfig)
            // Początkowe ustawienia:
            // ->addIntColumn('id')
            // ->addTextColumn('name')
            // ->addIntColumn('age')
            // ->addTextColumn('company')
            // ->addCurrencyColumn('balance', 'USD')
            // ->addTextColumn('phone')
            // ->addTextColumn('email')

            // Ustawienia pokazujące działanie klasy Config
            ->setMoneyTousandsSeparator(" spacja ")
            ->setMoneyDecimalsSeparator(" : ")
            //->setShowCents(false)

            ->setNumbersTousandsSeparator(",")
            ->setNumbersDecimalsSeparator(".")
            ->setNumbersDecimals(2)
            //->setStaticDecimals(false)

            ->setImageHeight(32)
            ->setImageWidth(32)

            ->setLinkClass('success')
            ->setLinkTag('a')

            ->setDateFormat('Y/m/d')

            ->setDateTimeFormat('Y/m/d H-i-s')

            ->addIntColumn('id')
            ->addTextColumn('name')
            ->addIntColumn('age')
            ->addTextColumn('company')
            ->addCurrencyColumn('balance', 'USD')
            ->addTextColumn('phone')
            ->addLinkColumn('email')
            ->addImageColumn('logo')
            ->addDateColumn('birth')
            ->addDateTimeColumn('last call')
            ;

        echo $dataGrid->render($rows, $state, $config);
        ?>
    </div>
    <h4 class='d-flex justify-content-center'><a href="https://github.com/mkwojcieszak/DataGrid">Repozytorium tego projektu</a></h4>
    <h4 class='d-flex justify-content-center'><a href="http://mateuszwojcieszak.com/">Moje Portfolio</a></h4>
</body>
</html>
