<?php

class ConnectToDB extends HandleErrors
{
    private string $error = "";


    function connect_to_db($params, $url_param, $params_to_db): array
    {
        $success = false;

        // wywołanie fn sprawdzającej url
        $checkSource = new SourceToDB(@$url_param);

        $sourceReport = $checkSource->choose_the_source();
        $this->error .= "\n" . $sourceReport['errors'];

        $isSourceCorrect = $this->throw_exception_if_false($sourceReport['correct'], "Neither path nor url are incorrect" . $sourceReport['errors']);

        // utwórz obiekt z konkretnym źródłem do danych (url lub file path)
        $isSourceCorrect && $get_all_data = new GetAllData($sourceReport["source"], $params, $params_to_db);
        $dataArr = json_decode($get_all_data->get_data_from_source(), true);  // array("data" => $data, "errors" => $this->errors)
        $isGetDataSuccess = $this->throw_exception_if_false($dataArr['success'], $dataArr['errors']);
        $this->error .= $dataArr['errors'];

        $isGetDataSuccess ? $success = true : $success = false;
        $isGetDataSuccess && $selected_data = new GetRequiredData();
        $sought_data = $selected_data->get_sought_data($dataArr['data'], $params_to_db);

        $isSoughtDataArrNotNull = $this->check_array_length($sought_data, 0);

        if (!$isSoughtDataArrNotNull) {
            $this->error .= "There is no data from the source\n";
            $success = false;
        }
        return array("success" => $success, "data" => $sought_data, "errors" => $this->error);
    }

    function check_arg_for_server_or_cli_to_get_url($params)
    {
        $url_param = "";
        if (@$params['f'] !== false) {
            if (@$params['f'] === 'write' || @$params['f'] === 'server') {
                echo "Zapisz plik na dysk.\n";

                // set any url if there isn't any as url/path cannot be empty / null
                if (@!isset($params['u'])) {
                    $url_param = "url_param";
                } else {
                    $url_param = @$params['u'];
                }
                return $url_param;
            } else {

                throw new Exception("Podaj właściwy parametr dla argumentu '-f':  'write', 'server' or 'default'.\n");
            }
        } else {
            throw new Exception("Podaj parametr dla argumentu '-f'.\n");
        }
    }
}
