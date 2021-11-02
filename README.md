Aim of the code is to get data (in json format) from source url (xml file); if the url fails, data should be drawn from the local file books.xml. Data can be get either by CLI or SERVER; if by SERVER data are displayed in the browser, if by CLI - data are saved locally to data.json file.

Calling the app by CLI you have to provide right params as followns:
A) SHORTPARAMS

1. 'f' that can have 3 correct values: write, server or default. The latter has the following values:
   "f" => "write", "u" => "https://dlabystrzakow.pl/xml/produkty-dlabystrzakow.xml", "pbase1" => "lista", "pbase2" => "ksiazka", "p1" => "ident", "p2" => "tytul[0]", "p3" => "liczbastron", "p4" => "datawydania"

2. 'u' - url address

B) LONGPARAMS 3. 'p1, p2, p3' etc. - they describe detail params available inside the target array from database 4. 'pbase1, pbase2' etc. - they describe params outisde the target array from database - they are like track to the target array

only critical errors are thrown as Exceptions, others are caught in string 'errors' and displayed
tested params:

Examples of cli requests with params
--- CORRECT:

php index.php -f default
php index.php -f write --pbase1="lista" --pbase2="ksiazka" --p1="ident" --p2="tytul[0]" --p3="liczbastron" --p4="datawydania"

php index.php -f write --pbase1="lista" --pbase2="ksiazka[2]" --p1="ident" --p2="tytul[0]" --p3="liczbastron" --p4="datawydania"

php index.php -f write --pbase1="lista" --pbase2="ksiazka[2]" --p1="ident" --p2="tyt[0]" --p3="liczbastr" --p4="datawydan"

--- with ERRORS

php index.php
php index.php -f write --pbase1="lista" --pbase2="ksiazki[3]" --p1="ident" --p2="tytul[0]" --p3="liczbastron" --p4="datawydania"

php index.php -f write --pbase1="lista[2]" --pbase2="ksiazka[3]" --p1="ident" --p2="tytul[0]" --p3="liczbastron" --p4="datawydania"
