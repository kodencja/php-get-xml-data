<?php

class ReadAndGetParams extends HandleErrors
{

    protected function get_default_params(): array
    {
        return array("f" => "write", "u" => "https://dlabystrzakow.pl/xml/produkty-dlabystrzakow.xml", "pbase1" => "lista", "pbase2" => "ksiazka", "p1" => "ident", "p2" => "tytul[0]", "p3" => "liczbastron", "p4" => "datawydania");
    }

    function getParams($init_params)
    {
        $params_lenght = $this->check_array_length($init_params, 0);
        $are_any_params = $this->throw_exception_if_false($params_lenght,  "Podaj parametry!");

        // zwróc parametry tylko wtedy gdy ich length > 0
        if ($are_any_params) {
            if (@$init_params['f'] === "default") {
                $init_params = $this->get_default_params();
            }
            return $init_params;
        }
    }
}
