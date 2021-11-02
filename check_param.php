<?php
// include 'check_source.php';
include 'get_all_data.php';

class CheckParam
{
    private $url;
    // private $path_to_json_file;
    // private $path_to_xml_file;
    private $errors = array();

    // public function __construct($_url, $_path_to_xml_file)
    // public function __construct($_url)
    // {
    //     $this->url = $_url;
    //     // $this->path_to_xml_file = $_path_to_xml_file;
    // }

    public function check_param()
    {
        $param = getopt("f:u:p:");
        // $checkSource = [];
        // echo $param === true;
        echo "PARAM: \n";
        var_dump($param);
        // $url_param  = '';
        // $titlePL = @$param['p'][1];
        // $sing1 = "[";
        // // echo $titlePL . "\n";
        // if ((@$pos1 = strpos($titlePL, $sing1)) !== false) {
        //     // echo strpos($titlePL, $sing1) . "\n";
        //     echo $pos1 . "\n";
        //     $index = substr($titlePL, $pos1 + 1, -1);
        //     // echo $index . "\n";
        //     echo intval($index);
        //     echo "\nSign found\n";
        // } else {
        //     echo "Sign not found\n";
        // }
        // wybierz akcje ze względu na paramter
        // if ($param === false) {

        // dla browsera
        if (@!isset($param) || $param === false) {
            echo "Params ARE NOT SET\n";
            echo "Send data to the server\n";
            // call function with $arg = null
            // $helionBooks->call_get_data(null);

            $url_param = "https://dlabystrzakow.pl/xml/produkty-dlabystrzakow.xml";
            // $checkSource = new SourceToDB($url_param);

            // $checkSource = new SourceToDB($param['u']);

            // $sourceReport = json_decode($checkSource->choose_the_source(), true);
            // var_dump($sourceReport);
            // exit();
            // } else if ($param !== false) {
        }
        // dla konsoli
        else {
            echo "Params ARE SET\n";
            if (@$param['f'] !== false && @$param['f'] === 'write') {
                echo "Zapisz plik na dysk.\n";
                // call function with $arg = 'write'
                // exit($helionBooks->call_get_data('write'));
                // $url_param = @$param['u'] !== false ? @$param['u'] : "www";

                // if (@$param['u'] === false) {
                if (@!isset($param['u'])) {
                    $url_param = "";
                    // $url_param = null;
                    echo "False\n";

                    // } else if ((@$param['u'] === false)) {
                } else {
                    echo "True\n";
                    $url_param = @$param['u'];
                }
                echo "\nURL_PARAM: " . $url_param . "\n";
                // $checkSource = new SourceToDB(@$url_param);
                // $checkSource = new SourceToDB("https://dlabystrzakow.pl/xml/produkty-dlabystrzakow.xml");

                // wywołanie fn sprawdzającej url
                // $sourceReport = json_decode($checkSource->choose_the_source(), true);
                // var_dump($sourceReport);

                $checkSource = new SourceToDB(@$url_param);

                // decode json array with 3 indexes: ["correct"],["source"],["errors"] 
                $sourceReport = json_decode($checkSource->choose_the_source(), true);
                echo "\nLAST\n";
                var_dump($sourceReport);

                // utwórz obiekt z konkretnym źródłem do danych (url lub file)
                // $get_data = new GetData();
                $get_all_data = new GetAllData($sourceReport["source"]);
                $dataArr = $get_all_data->get_data_from_source();
                var_dump($dataArr['lista']['ksiazka'][0]['ident']);

                exit();
            } else {
                echo "Podaj właściwy parametr.\n";
                exit();
            }
        }
    }
}

// $checkParamForBooks = new CheckParam("https://dlabystrzakow.pl/xml/produkty-dlabystrzakow.xml3");
$checkParamForBooks = new CheckParam();
$checkParamForBooks->check_param();

// $checkSource = new SourceToDB("https://dlabystrzakow.pl/xml/produkty-dlabystrzakow.xml", "./booksHelion.xml");
// $whatSrc = $checkSource->choose_the_source();
// echo "\nWHATSRC\n";
// var_dump($whatSrc);
// echo "Correct or NOT: " . $whatSrc["correct"] . "\n";
// echo $whatSrc["source"] . "\n";
// echo $whatSrc["errors"][0] . "\n";
// echo $whatSrc["errors"][1] . "\n";


// echo "FIRST\n";
// $sourceReport = json_decode($checkSource->choose_the_source(), true);
// echo "\nSECOND\n";
// // echo $msg1;
// // $sourceReport = $checkSource->choose_the_source();
// if ($sourceReport) {
//     echo "\n Get data from the correct source \n";
//     var_dump($sourceReport);
//     echo "Correct or NOT: " . $sourceReport["correct"] . "\n";
//     echo $sourceReport["source"] . "\n";
//     // echo $sourceReport["errors"][0] . "\n";
//     // echo $sourceReport["errors"][1] . "\n";
//     foreach ($sourceReport["errors"] as $err) {
//         echo $err;
//     }
//     // echo $sourceReport->errors;
//     // echo $sourceReport['errors'];
// };
