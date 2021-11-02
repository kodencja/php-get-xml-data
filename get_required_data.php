<?php

class GetRequiredData
{

    protected function search_for_sought_data_in_db($params_to_db, $book)
    {
        $arr = [];
        foreach ($params_to_db as $key => $par) {
            // check if other params (from starting with 'p') than pbase# are arrays locked up in string e.g. "tytul[0]" and if so split them as an array to index 'name' impling string e.g. "tytul", and to the very index called 'index' impling int number e.g. "0";  so the result is e.g. ( "tytul" => $book['tytul'][0] ) instead of ( ["tytul"][0]] => $book["tytul"][0]] )

            if ($key[0] === "p" && $key[1] !== 'b') {

                if (getType($par)  === "array") {
                    $arr[$par['name']] = @$book[$par['name']][$par['index']];
                } else if (gettype($par)  === "string") {
                    $arr[$par] = @$book[$par];
                } else {
                    throw new Exception("\nParams starting with -p must be either of type string e.g. 'liczbastron' being reference to string data in db or stringified reference to string data in an array in db e.g. 'tytul[0]'.\n");
                };
            }
        }
        return $arr;
    }

    // repeating indexes we find in array e.g. when there are many indexes (of type integer) named ['ksiazka'], but e.g. the single index of ['ksiazka'] has its own indexes that are of type 'string'
    protected function check_if_data_is_array_of_repeating_indexes($data): bool
    {
        $isDataRepeatedArray = false;
        foreach ($data as $ind => $book) {
            if (getType($ind) === 'string') {
                $isDataRepeatedArray = false;
            } else if (getType($ind) === 'integer') {
                $isDataRepeatedArray = true;
            }
        }

        return $isDataRepeatedArray;
    }

    // $params here equals $params_to_db so only params starting with 'p'
    function get_sought_data($data, $params_to_db)
    {
        $data_final = array();
        $isDataRepeatedArray = $this->check_if_data_is_array_of_repeating_indexes($data);

        if (!$isDataRepeatedArray) {
            $data_from_each_record = $this->search_for_sought_data_in_db($params_to_db, $data);
            array_push($data_final, $data_from_each_record);
        } else {
            foreach ($data as $ind => $book) {
                $data_from_each_record = $this->search_for_sought_data_in_db($params_to_db, $book);
                array_push($data_final, $data_from_each_record);
            }
        }
        return $data_final;
    }
}
