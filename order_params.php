<?php

class OrderParams
{

    private string $param_as_array;
    private int $index_in_param = -1;

    protected function check_if_param_is_array_like_and_get_its_name_and_index(string $par): void
    {
        // change global vars to split array-like string into array-readable vars e.g. string 'tytul[0]' into tytul[0] where 'tytul' is an array while '0' number of index in this array
        $sing1 = "[";
        if ((@$pos1 = strpos($par, $sing1)) !== false) {

            $this->param_as_array = substr($par, 0, $pos1);

            $this->index_in_param = substr($par, $pos1 + 1, -1);
        } else {
            $this->index_in_param = -1;
        }
    }

    // order params from those starting with 'p' (like 'param', so e.g. -p1, -pbase1, etc.) with extracting of array-like string i.e. with array information hidden in param string e.g. "tytul[0]' or 'tytul[1]' to make out params needed to get the right data from database
    function order_params(array $params): array
    {
        $params_for_data = [];
        $ind_of_param_in_params_array_in_string = -1;
        $index_in_param_as_number_in_params_array_as_string = -1;
        foreach ($params as $ind_par => $par) {
            if ($ind_par[0] === "p") {

                $this->check_if_param_is_array_like_and_get_its_name_and_index($par);
                if ($this->index_in_param > -1) {
                    $index_in_param_as_number_in_params_array_as_string = intval($this->index_in_param);
                    $ind_of_param_in_params_array_in_string = $ind_par;
                    $params_for_data[$ind_of_param_in_params_array_in_string] = array("name" => $this->param_as_array, "index" => $index_in_param_as_number_in_params_array_as_string);
                } else {
                    $params_for_data[$ind_par] = $par;
                }
            }
        }

        return $params_for_data;
    }
}
