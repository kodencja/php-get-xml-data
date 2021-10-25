<?php

class Books
{
    private $url;
    private $file_path_to_json;
    private $file_path_to_xml;


    public function __construct($uri, $f_path, $f_path_xml)
    {
        $this->url = $uri;
        $this->file_path_to_json = $f_path;
        $this->file_path_to_xml = $f_path_xml;
    }

    protected function get_data_array($ksiazka)
    {
        $data = array();
        foreach ($ksiazka as $book) {
            $arr =  (["ident" => $book['@attributes']['ident'], "tytul_polski" => $book['tytul'][0], "liczba_stron" => $book['liczbastron'], "data_wydania" => $book['datawydania']]);

            array_push($data, $arr);
        }

        return $data;
    }

    protected function get_final_response($success, $errors, $data)
    {
        return json_encode(array("success" => $success, "errors" => $errors, "data" => $data, JSON_FORCE_OBJECT));
    }

    protected function choose_the_source($url)
    {
        try {
            $contents = file_get_contents($url);
            if ($contents === null) return false;
            else return true;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    protected function get_data_from_source($source)
    {
        $response = file_get_contents($source);
        $xml_string = simplexml_load_string($response);
        $jsonString = json_encode($xml_string);
        $jsonArray = json_decode($jsonString, true);
        return $jsonArray['lista']['ksiazka'];
    }

    public function call_get_data($arg)
    {
        try {
            $source = "";
            $errors = "";
            $success = true;
            $url_success = $this->choose_the_source($this->url);

            if ($url_success) {
                $source = $this->url;
            } else {
                $source = $this->file_path_to_xml;
            }

            $ksiazka = $this->get_data_from_source($source);

            $data = $this->get_data_array($ksiazka);
            if ($data !== false) {
                $success = true;
            } else {
                $success = false;
            }

            if ($arg === 'write') {
                $finalJsonResponse = $this->get_final_response($success, $errors, $data);
                echo 'arg: ';
                echo $arg;;
            } else if ($arg === null) {

                echo  $finalJsonResponse = $this->get_final_response($success, $errors, $data);
                echo $arg;
            }


            if ($url_success) file_put_contents($this->file_path_to_json, $finalJsonResponse);
            return $finalJsonResponse;
        } catch (Exception $err) {
            $success = false;
            $errors = $err->getMessage();
            print($errors);
            return json_encode(array("success" => $success, "errors" => $errors, "data" => $data));
        }
    }
}

$helionBooks = new Books("https://dlabystrzakow.pl/xml/produkty-dlabystrzakow.xml", "data.json", "booksHelion.xml");

$param = getopt("p:");
// jesli nie ma parametru czyli rowne null
if ($param === false) {
    $helionBooks->call_get_data(null);
    exit();
} else if ($param !== false) {
    if ($param['p'] !== false && $param['p'] === 'write') {
        echo 'Zapisz plik na dysk';
        exit($helionBooks->call_get_data('write'));
    } else {
        echo 'Podaj właściwy parametr';
    }
}
