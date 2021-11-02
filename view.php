<?php

class View
{

    function display($msg): void
    {
        echo $msg;
    }

    function save($path, $data): void
    {
        file_put_contents($path, $data);
    }
}
