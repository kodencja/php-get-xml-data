<?php

// include 'get_data_xml_to_json.php';

class SourceToDataBase
{
    private string $url;
    private $path_to_json_file = "./data.json";
    private string $path_to_xml_file = "./booksHelion.xml";
    public string $source = "ABC";
    public array $errors = array();

    // public function __construct($_url, $_path_to_xml_file)
    public function __construct($_url)
    {
        // echo type($_url);
        // echo "\nURL: " . $_url . "\n";
        $this->url = $_url || "com.pl";
        $this->source = $_url;
        echo "\nURL: " . $this->url . "\n";
        if ($this->url === null) echo "NULL URL\n";
        // $this->path_to_xml_file = $_path_to_xml_file;
    }

    protected function getUrl($arg)
    {
        return $this->url . "Stop: " . $arg;
    }
    protected function getSource()
    {
        return $this->source;
    }

    public function check_if_source_is_correct($source)
    {

        if (!@file_get_contents($source)) {
            $error = error_get_last();
            array_push($this->errors,  "HTTP request failed from: " . $source . ". Check the url, path. ERROR WAS: " . $error['message'] . "\n");
            return false;
        } else {
            echo "The source is correct!";
            return true;
        }
    }

    public function choose_the_source()
    {
        $error = array();
        $correct = true;
        $res = "";
        $source = $this->url;

        // if url === false
        if ($this->check_if_source_is_correct($this->url) === false) {

            // check if path to file is correct
            if ($this->check_if_source_is_correct($this->path_to_xml_file) === false) {
                $correct = false;
                $source = "";
            }
            // if the path to file is correct
            else {
                $correct = true;
                $source = $this->path_to_xml_file;
            }
        }
        $this->source = $source;
        echo "\nSource_0: " . $this->source . "\n";
        $res = json_encode(array("correct" => $correct, "source" => $source, "errors" => $this->errors));
        return $res;
    }
}

// $checkSource = new SourceToDB("https://dlabystrzakow.pl/xml/produkty-dlabystrzakow.xml", "./booksHelion.xml");
// // $whatSrc = $checkSource->choose_the_source();
// // echo "\nWHATSRC\n";
// // var_dump($whatSrc);
// // echo "Correct or NOT: " . $whatSrc["correct"] . "\n";
// // echo $whatSrc["source"] . "\n";
// // echo $whatSrc["errors"][0] . "\n";
// // echo $whatSrc["errors"][1] . "\n";
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


// class GetData extends SourceToDB
// {

//     // private int $source;
//     // private array $errors = array();

//     // public function __construct($_source)
//     // {
//     //     // parent::__construct();
//     //     $this->source = $_source;
//     // }

//     // public function __construct()
//     // {
//     // }

//     public function get_data_from_source()
//     {
//         echo "SOURCE in get_data: " . $this->source . "\n";
//         // $response = @file_get_contents($source);
//         echo "\nSOURCE: " . $this->source . "\n";
//         if (!$response = @file_get_contents($this->source)) {
//             $error = error_get_last();
//             echo "Failed to open the file. Check the url.\n ";
//             // echo "Failed to open the file. Check the url. Error was: " . $error['message'];
//             // throw new Exception("Failed to open the file. Check the url. Error was: " . $error['message']);
//             // $this->errors[1] = "Failed to open the file. Check the url. Error was: " . $error['message'] . "\n";
//             array_push($this->errors, "Failed to open the file. Check the url. Error was: " . $error['message'] . "\n");
//             // $this->errors['message_2'] = "Failed to open the file. Check the url. Error was: " . $error['message'] . "\n";
//         } else {
//             // echo 'RESPONSE: ' . $response . ' RESPONSE';
//             // echo $source;
//             echo "\nRESPONSE 1\n";
//             // echo ($response);
//             // var_dump($response);
//             // $use_errors = libxml_use_internal_errors(false);
//             $xml_string = @simplexml_load_string($response);
//             // var_dump($xml_string);
//             // $xml_string = simplexml_load_file($response);
//             // echo 'xml_string: ' . $xml_string;
//             if ($xml_string === false) {
//                 // throw new Exception("Cannot load xml source.\n");
//                 // $this->errors[2] = "Cannot load xml source.\n";
//                 array_push($this->errors, "Cannot load xml source.\n");
//                 // $this->errors['message_3'] = "Cannot load xml source.\n";
//                 // libxml_use_internal_errors(!$use_errors);
//             }
//             // libxml_clear_errors();

//             echo 'RESPONSE 2 ';
//             $jsonString = json_encode($xml_string);
//             // var_dump($jsonString);
//             // print_r($jsonString);
//             echo 'RESPONSE 3 ';
//             $jsonArray = json_decode($jsonString, true);
//             // var_dump($jsonArray);
//             // var_dump($jsonArray['lista']['ksiazka']);
//             // print_r($jsonArray);
//             echo 'RESPONSE 4 ';
//             // return $jsonArray['lista']['ksiazka'];
//             return $jsonArray;
//         }
//     }
// }
