# Instalacja i uruchomienie projektu

## Wymagania

- PHP 7.4.7
- MySql 5.7.11
- Composer

## Pobieramy projekt 

`https://github.com/karolinascibek/praktyki.git`

Wpisz następujące polecenie w wierszu poleceń z katalogu głównego projektu 
`composer update`

Skopiuj plik `env` (znajduję się w głównym katalogu) i zmień nazwę na `.env`

W pliku `.env` zmień `# CI_ENVIROMENT = production` na `CI_ENVIROMENT = development`.

W sekcji `# DATABASE` usuń `#` tam gdzie jest `database.default. ` i skonfiguruj swoją bazę danych.

Jeśli nie masz stworzonej bazy danych o nazwie którą podałeś w pliku `.env` stwórz ją np. za pomocą phpmyadmin.

Wpisz następujące polecenia w wierszu poleceń z katalogu głównego:
`php spark migrate` - w twojej bazie danych powinny pojawić się tabele.
`php spark serve`

W przeglądarkę wpisz adres http://localhost:8080/, powinna pojawić się strona powitalna aplikacji.
