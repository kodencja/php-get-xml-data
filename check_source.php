<?php

class SourceToDB
{
    private string $url;
    private string $path_to_xml_file = "./books.xml";
    public string $source;
    public string $errors = "";

    public function __construct($_url)
    {
        $this->url = $_url;
        $this->source = $_url;
    }

    function check_if_source_is_correct($source)
    {
        if (!@file_get_contents($source)) {
            $error = error_get_last();
            $this->errors .=  "HTTP request has failed from: " . $source . ". Check the url, path. ERROR WAS: " . $error['message'] . "\n";

            return false;
        } else {
            echo "\nThe path / url is correct: " . $source . "\n";
            return true;
        }
    }

    function choose_the_source()
    {
        $correct = true;
        $res = "";

        // check if url is correct
        if ($this->check_if_source_is_correct($this->url) === false) {

            // if url is incorrect check if the path to file is correct, if not throw an error
            if ($this->check_if_source_is_correct($this->path_to_xml_file) === false) {
                $correct = false;
            } else {
                $correct = true;
                $this->source = $this->path_to_xml_file;
            }
        }
        $res = array("correct" => $correct, "source" => $this->source, "errors" => $this->errors);
        return $res;
    }
}
