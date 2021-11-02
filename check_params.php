<?php
include './check_server.php';
include './get_params.php';
include './order_params.php';
include './check_source.php';
include './get_all_data.php';
include './get_required_data.php';
include './connect_to_db.php';


class CheckParams extends OrderParams
{
    // private $url_param = "com";
    private $params;
    private string $file_path_to_json = "./data.json";
    private array $params_for_data = [];



    public function check_params($init_params)
    {

        $success = true;
        echo "\nCheckParams class\n";
        // ponizsza metoda zwraca albo $this->params albo $this->url
        // $this->params = $this->getParams();
        $read_params = new ReadParams("");
        $this->params = $read_params->getParams($init_params);

        echo getType($this->params) . "\n";    // array

        echo "Params ARE AN ARRAY\n";
        $this->params_for_data = $this->order_params($this->params);
        echo "\nORIGINAL PARAMS\n";
        var_dump($this->params);
        echo "\nORDERED PARAMS FOR DATA\n";
        var_dump($this->params_for_data);

        return $this->params;

        // if (!@file_get_contents($source)) {
        //     $error = error_get_last();
        //     $this->errors .=  "HTTP request has failed from: " . $source . ". Check the url, path. ERROR WAS: " . $error['message'] . "\n";

        //     return false;
        // } else {
        //     echo "The source is correct!";
        //     return true;
        // }

        // }

    }
}


// $shortOpt = 

// $params_to_check = new CheckParams(@getopt("f:u::", ["pbase1::", "pbase2::", "p1::", "p2::", "p3::", "p4::"]));
// $params_to_check->check_params();

// $params_to_check = new CheckParams(@getopt("f:u::", ["p1::", "p2::", "p3::", "p4::", "p5::", "p6::"]));
// $params_to_check = new CheckParams(@getopt("f:u:p:"));



            // echo "\nPAR in loop: " . $par . "\n";
            // if ((@$pos1 = strpos($par, $sing1)) !== false) {
            //     // echo strpos($titlePL, $sing1) . "\n";
            //     // echo $pos1 . "\n";

            //     // echo $index . "\n";
            //     // echo intval($index_in_param);
            //     echo "\nSign found\n";
            //     return  substr($par, $pos1 + 1, -1);
            // } else {
            //     // echo "Sign not found\n";
            //     return "";
            // }

            // class CheckParams extends ReadParams