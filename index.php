<?php

include './handle_errors.php';
include './check_server.php';
include './get_params.php';
include './order_params.php';
include './check_source.php';
include './get_all_data.php';
include './get_required_data.php';
include './connect_to_db.php';
include './view.php';

class Controller
{
    private array $params = [];
    private string $file_path_to_json = "./data.json";
    private array $params_for_data = [];
    private string $errors = "";

    const Default_Params_Server = array("f" => "server", "u" => "https://dlabystrzakow.pl/xml/produkty-dlabystrzakow.xml", "pbase1" => "lista", "pbase2" => "ksiazka", "p1" => "ident", "p2" => "tytul[0]", "p3" => "liczbastron", "p4" => "datawydania");

    protected function get_final_response($success, $errors, $data)
    {
        return json_encode(array("success" => $success, "errors" => $errors, "data" => $data));
    }

    function check_incoming_request()
    {
        $view_mode = new View();
        try {
            $success = true;
            $checkServer = new CheckServer();
            $isServer = $checkServer->server_or_cli();
            $params_to_check = new ReadAndGetParams();

            // set params for running from server
            if ($isServer) {
                echo ("<br /> Running from SERVER");
                // $params_to_check->check_params(self::Default_Params_Server);

                $this->params = $params_to_check->getParams(self::Default_Params_Server);
            }
            // read provided or set default params for running from cli
            else {
                $this->params = $params_to_check->getParams(@getopt("f:u::", ["pbase1::", "pbase2::", "p1::", "p2::", "p3::", "p4::"]));
            }

            // select and order params needed to read and get right data from database
            $orderedParams = new OrderParams();

            $this->params_for_data = $orderedParams->order_params($this->params);
            // echo "\nORIGINAL PARAMS\n";
            // var_dump($this->params);
            // echo "\nORDERED PARAMS FOR DATA\n";
            // var_dump($this->params_for_data);

            $connectionWithDB = new ConnectToDB();
            @$url_param = $connectionWithDB->check_arg_for_server_or_cli_to_get_url($this->params);

            @$selected_data = $connectionWithDB->connect_to_db($this->params, $url_param, $this->params_for_data);

            $success = $selected_data['success'];
            // if (!$selected_data['success']) {
            //     $success = false;
            // }
            $this->errors .= "\n" . $selected_data['errors'];
            $finalJsonResponse = $this->get_final_response($success, $this->errors, $selected_data['data']);

            echo "\nFINAL ERRORS: " . $this->errors;

            if ($this->params['f'] === 'write') {
                $view_mode->save($this->file_path_to_json, $finalJsonResponse);
            } else {
                $view_mode->display($finalJsonResponse);
            }
            return $finalJsonResponse;
            exit();
        } catch (\Throwable $err) {
            echo "\nThrow ERROR in Index.php: ";
            $view_mode->display($err->getMessage());
            exit();
        }
    }
}

$start_ctrl = new Controller();
$start_ctrl->check_incoming_request();
