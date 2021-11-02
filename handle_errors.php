<?php

class HandleErrors
{
    private string $errors = "";

    function throw_exception_if_false($arg_to_check, string $msg_if_false)
    {
        if (!$arg_to_check) {
            $this->errors .= $msg_if_false . ".\n";
            throw new Exception($this->errors);
            return false;
        } else {
            return true;
        }
    }

    protected function check_if_array_has_arrays($arr)
    {
        $hasArrayMoreArrays = true;
        if ($arr !== NULL) {
            foreach ($arr as $key => $val) {
                if (getType($key) === 'string') $hasArrayMoreArrays = false;
                else if (getType($key) === 'array') $hasArrayMoreArrays = true;
            }
        }
        return $hasArrayMoreArrays;
    }

    protected function start_flaten_arr_or_not($hasArrayMoreArrays, $arr)
    {
        $arr_flat = [];
        if ($hasArrayMoreArrays) {
            $arr_flat = array_merge(...array_values(@$arr));
        } else {
            $arr_flat = $arr;
        }

        return $arr_flat;
    }

    protected function continue_flaten_arr_or_not($arr_flaten, $length)
    {
        if ($arr_flaten === NULL || sizeof(@$arr_flaten) <= $length) {
            return false;
        } else {
            foreach ($arr_flaten as $arg) {
                if (getType($arg) === "array") {
                    $this->check_array_length($arg, $length);
                } else if ($arg === NULL) {
                    return true;
                } else {
                    return true;
                }
            }
        }
    }

    function check_array_length($arr, $length): bool
    {
        $hasArrayMoreArrays = $this->check_if_array_has_arrays($arr);
        $arr_flaten = $this->start_flaten_arr_or_not($hasArrayMoreArrays, $arr);

        // if there are some data / arrays in $arr flaten $arr
        $flaten_more =  $this->continue_flaten_arr_or_not($arr_flaten, $length);
        return $flaten_more;
    }
}
