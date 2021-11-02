<?php

class GetAllData
{
    private array $params_to_db;
    public string $errors = "";
    private string $source;
    private bool $success = true;

    function __construct($_source, $_params, $_params_to_db)
    {
        $this->source = $_source;
        $this->params = $_params;
        $this->params_to_db = $_params_to_db;
    }

    // Check if param --pbase is an array or a string - if array use splitted vars with values and index e.g. tytul[0], otherwise (if it's string) use simply string value e.g. 'liczbastron'
    protected function use_right_pbase_params($param, $decodeJsonArray, $arrData)
    {
        if (getType($param)  === "array") {
            if (@count($arrData) <= 0) {
                $arrData = @$decodeJsonArray[$param['name']][$param['index']];
            } else {
                $arrData = @$arrData[$param['name']][$param['index']];
            }
        } else if (gettype($param)  === "string") {
            if (@count($arrData) <= 0) {
                $arrData = @$decodeJsonArray[$param];
            } else {
                $arrData = @$arrData[$param];
            }
        } else {
            throw new Exception("\nParams starting with -pbase must be either of type string e.g. 'liczbastron' being reference to string data in db or stringified reference to string data in an array in db e.g. 'ksiazka[0]'.\n");
        };
        return $arrData;
    }

    protected function check_if_file_is_readable($response, $err_msg): bool
    {
        if (!$response) {
            $error = error_get_last();
            $this->success = false;
            $this->errors .= $err_msg . $error['message'] . "\n";
            return false;
        } else {
            return true;
        }
    }

    protected function check_if_there_is_any_data($decodeJsonArray)
    {
        $data = [];
        $error_in_loop = "";
        foreach ($this->params_to_db as $key => $param) {
            if ($data === null) {
                $error_in_loop = "There is no data from the source\n";
            } else {
                if ($key[1] === "b") {
                    $data = $this->use_right_pbase_params($param, $decodeJsonArray, $data);
                }
            }
        }
        $this->errors .= $error_in_loop;
        return $data;
    }

    function get_data_from_source()
    {
        $response = @file_get_contents($this->source);
        $isSourceReadable = $this->check_if_file_is_readable(@$response, "Failed to open the file. Check the url. Error was: ");

        if ($isSourceReadable) {
            $xml_string = @simplexml_load_string($response);
            $this->check_if_file_is_readable(@$xml_string, "Cannot load xml source. Error was: ");

            $jsonString = json_encode($xml_string);

            $decodeJsonArray = json_decode($jsonString, true);

            // loop over --pbase# to get dynamically include all --pbase# params
            // curtail the result to particular array e.g. 'lista' ['pbase1'] & 'ksiazka' ['pbase2']
            $data = $this->check_if_there_is_any_data($decodeJsonArray);
        }
        return json_encode(array("data" => $data, "success" => $this->success, "errors" => $this->errors));
    }
}
