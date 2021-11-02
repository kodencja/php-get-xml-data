<?php

class SearchForData
{

    function search_for_sought_data($params, $book)
    {
        $arr = [];
        foreach ($params as $key => $par) {
            // check if other params than pbase# are arrays locked up in string e.g. "tytul[0]" and if so read them as an array with index 'name' impling string e.g. "tytul", and index 'index' impling int e.g. "0";  so the result is e.g. ( "tytul" => $book['tytul'][0] ) instead of ( "tytul" => $book['tytul[0]'] )
            if ($key[1] !== "b") {
                // echo $key[1] . "\n";     // 1, 2
                // echo $par . "\n";    // ident
                if (getType($par)  === "array") {
                    // echo $par['name'] . "\n";   // tytul
                    // echo $par['index'] . "\n";  // 0
                    $arr[$par['name']] = @$book[$par['name']][$par['index']];
                } else if (gettype($par)  === "string") {
                    $arr[$par] = @$book[$par];
                }
            }
        }
        return $arr;
    }
}
