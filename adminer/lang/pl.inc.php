<?php
$translations = array(
	// label for database system selection (MySQL, SQLite, ...)
	'Home' => null,
	'System' => 'Rodzaj bazy',
	'Server' => 'Serwer',
	'Username' => 'Użytkownik',
	'Password' => 'Hasło',
	'Permanent login' => 'Zapamiętaj sesję',
	'Login' => 'Zaloguj się',
	'Logout' => 'Wyloguj',
	'Logged as: %s' => 'Zalogowany jako: %s',
	'Logout successful.' => 'Wylogowano pomyślnie.',
	'Invalid server or credentials.' => 'Nieprawidłowy serwer lub dane logowania.',
	'Too many unsuccessful logins, try again in %d minute(s).' => array('Za dużo nieudanych prób logowania, spróbuj ponownie za %d minutę.', 'Za dużo nieudanych prób logowania, spróbuj ponownie za %d minuty.', 'Za dużo nieudanych prób logowania, spróbuj ponownie za %d minut.'),
	'Master password expired. <a href="https://www.adminer.org/en/extension/"%s>Implement</a> %s method to make it permanent.' => 'Ważność hasła głównego wygasła. <a href="https://www.adminer.org/pl/extension/"%s>Zaimplementuj</a> własną metodę %s, aby ustawić je na stałe.',
	'Language' => 'Język',
	'Invalid CSRF token. Send the form again.' => 'Nieprawidłowy token CSRF. Spróbuj wysłać formularz ponownie.',
	'If you did not send this request from Adminer then close this page.' => 'Jeżeli nie wywołałeś tej strony z Adminera, zamknij to okno.',
	'No extension' => 'Brak rozszerzenia',
	'None of the supported PHP extensions (%s) are available.' => 'Żadne z rozszerzeń PHP umożliwiających połączenie się z bazą danych (%s) nie jest dostępne.',
	'Connecting to privileged ports is not allowed.' => 'Łączenie do portów uprzywilejowanych jest niedozwolone.',
	'Session support must be enabled.' => 'Wymagana jest obsługa sesji w PHP.',
	'Session expired, please login again.' => 'Sesja wygasła, zaloguj się ponownie.',
	'%s version: %s through PHP extension %s' => 'Wersja %s: %s za pomocą %s',
	'Refresh' => 'Odśwież',

	// text direction - 'ltr' or 'rtl'
	'ltr' => 'ltr',

	'Privileges' => 'Uprawnienia użytkowników',
	'Create user' => 'Dodaj użytkownika',
	'User has been dropped.' => 'Użytkownik został usunięty.',
	'User has been altered.' => 'Użytkownik został zmieniony.',
	'User has been created.' => 'Użytkownik został dodany.',
	'Hashed' => 'Zahashowane',
	'Column' => 'Kolumna',
	'Routine' => 'Procedura',
	'Grant' => 'Uprawnienia',
	'Revoke' => 'Usuń uprawnienia',

	'Process list' => 'Lista procesów',
	'%d process(es) have been killed.' => array('Przerwano %d wątek.', 'Przerwano %d wątki.', 'Przerwano %d wątków.'),
	'Kill' => 'Przerwij wykonywanie',

	'Variables' => 'Zmienne',
	'Status' => 'Status',

	'SQL command' => 'Zapytanie SQL',
	'%d query(s) executed OK.' => array('Pomyślnie wykonano %d zapytanie.', 'Pomyślnie wykonano %d zapytania.', 'Pomyślnie wykonano %d zapytań.'),
	'Query executed OK, %d row(s) affected.' => array('Zapytanie wykonane pomyślnie, zmieniono %d rekord.', 'Zapytanie wykonane pomyślnie, zmieniono %d rekordy.', 'Zapytanie wykonane pomyślnie, zmieniono %d rekordów.'),
	'No commands to execute.' => 'Nic do wykonania.',
	'Error in query' => 'Błąd w zapytaniu',
	'ATTACH queries are not supported.' => 'Zapytania ATTACH są niewspierane.',
	'Execute' => 'Wykonaj',
	'Stop on error' => 'Zatrzymaj w przypadku błędu',
	'Show only errors' => 'Pokaż tylko błędy',
	// sprintf() format for time of the command
	'%.3f s' => '%.3f s',
	'History' => 'Historia',
	'Clear' => 'Wyczyść',
	'Edit all' => 'Edytuj wszystkie',

	'File upload' => 'Wgranie pliku',
	'From server' => 'Z serwera',
	'Webserver file %s' => 'Plik %s na serwerze',
	'Run file' => 'Uruchom z pliku',
	'File does not exist.' => 'Plik nie istnieje.',
	'File uploads are disabled.' => 'Wgrywanie plików jest wyłączone.',
	'Unable to upload a file.' => 'Wgranie pliku było niemożliwe.',
	'Maximum allowed file size is %sB.' => 'Maksymalna wielkość pliku to %sB.',
	'Too big POST data. Reduce the data or increase the %s configuration directive.' => 'Przesłano zbyt dużo danych. Zmniejsz objętość danych lub zwiększ zmienną konfiguracyjną %s.',
	'You can upload a big SQL file via FTP and import it from server.' => 'Większe pliki SQL możesz wgrać na serwer poprzez FTP przed zaimportowaniem.',
	'You are offline.' => 'Jesteś offline.',

	'Export' => 'Eksport',
	'Output' => 'Rezultat',
	'open' => 'otwórz',
	'save' => 'zapisz',
	'Format' => 'Format',
	'Data' => 'Dane',

	'Database' => 'Baza danych',
	'Use' => 'Wybierz',
	'Select database' => 'Wybierz bazę danych',
	'Invalid database.' => 'Nie znaleziono bazy danych.',
	'Database has been dropped.' => 'Baza danych została usunięta.',
	'Databases have been dropped.' => 'Bazy danych zostały usunięte.',
	'Database has been created.' => 'Baza danych została utworzona.',
	'Database has been renamed.' => 'Nazwa bazy danych została zmieniona.',
	'Database has been altered.' => 'Baza danych została zmieniona.',
	'Alter database' => 'Zmień bazę danych',
	'Create database' => 'Utwórz bazę danych',
	'Database schema' => 'Schemat bazy danych',

	// link to current database schema layout
	'Permanent link' => 'Trwały link',

	// thousands separator - must contain single byte
	',' => ' ',
	'0123456789' => '0123456789',
	'Engine' => 'Składowanie',
	'Collation' => 'Porównywanie znaków',
	'Data Length' => 'Rozmiar danych',
	'Index Length' => 'Rozmiar indeksów',
	'Data Free' => 'Wolne miejsce',
	'Rows' => 'Liczba rekordów',
	'%d in total' => '%d w sumie',
	'Analyze' => 'Analizuj',
	'Optimize' => 'Optymalizuj',
	'Vacuum' => 'Wyczyść',
	'Check' => 'Sprawdź',
	'Repair' => 'Napraw',
	'Truncate' => 'Opróżnij',
	'Tables have been truncated.' => 'Tabele zostały opróżnione.',
	'Move to other database' => 'Przenieś do innej bazy danych',
	'Move' => 'Przenieś',
	'Tables have been moved.' => 'Tabele zostały przeniesione.',
	'Copy' => 'Kopiuj',
	'Tables have been copied.' => 'Tabele zostały skopiowane.',

	'Routines' => 'Procedury i funkcje',
	'Routine has been called, %d row(s) affected.' => array('Procedura została uruchomiona, zmieniono %d rekord.', 'Procedura została uruchomiona, zmieniono %d rekordy.', 'Procedura została uruchomiona, zmieniono %d rekordów.'),
	'Call' => 'Uruchom',
	'Parameter name' => 'Nazwa parametru',
	'Create procedure' => 'Utwórz procedurę',
	'Create function' => 'Utwórz funkcję',
	'Routine has been dropped.' => 'Procedura została usunięta.',
	'Routine has been altered.' => 'Procedura została zmieniona.',
	'Routine has been created.' => 'Procedura została utworzona.',
	'Alter function' => 'Zmień funkcję',
	'Alter procedure' => 'Zmień procedurę',
	'Return type' => 'Zwracany typ',

	'Events' => 'Wydarzenia',
	'Event has been dropped.' => 'Wydarzenie zostało usunięte.',
	'Event has been altered.' => 'Wydarzenie zostało zmienione.',
	'Event has been created.' => 'Wydarzenie zostało utworzone.',
	'Alter event' => 'Zmień wydarzenie',
	'Create event' => 'Utwórz wydarzenie',
	'At given time' => 'O danym czasie',
	'Every' => 'Wykonuj co',
	'Schedule' => 'Harmonogram',
	'Start' => 'Początek',
	'End' => 'Koniec',
	'On completion preserve' => 'Nie kasuj wydarzenia po przeterminowaniu',

	'Tables' => 'Tabele',
	'Tables and views' => 'Tabele i perspektywy',
	'Table' => 'Tabela',
	'No tables.' => 'Brak tabel.',
	'Alter table' => 'Zmień tabelę',
	'Create table' => 'Utwórz tabelę',
	'Table has been dropped.' => 'Tabela została usunięta.',
	'Tables have been dropped.' => 'Tabele zostały usunięte.',
	'Tables have been optimized.' => 'Tabele zostały zoptymalizowane.',
	'Table has been altered.' => 'Tabela została zmieniona.',
	'Table has been created.' => 'Tabela została utworzona.',
	'Table name' => 'Nazwa tabeli',
	'Show structure' => 'Struktura tabeli',
	'engine' => 'składowanie',
	'collation' => 'porównywanie znaków',
	'Column name' => 'Nazwa kolumny',
	'Type' => 'Typ',
	'Length' => 'Długość',
	'Auto Increment' => 'Auto Increment',
	'Options' => 'Opcje',
	'Comment' => 'Komentarz',
	'Default value' => 'Wartość domyślna',
	'Drop' => 'Usuń',
	'Drop %s?' => 'Usunąć %s?',
	'Are you sure?' => 'Czy jesteś pewien?',
	'Size' => 'Wielkość',
	'Compute' => 'Oblicz',
	'Move up' => 'Przesuń w górę',
	'Move down' => 'Przesuń w dół',
	'Remove' => 'Usuń',
	'Maximum number of allowed fields exceeded. Please increase %s.' => 'Przekroczono maksymalną liczbę pól. Zwiększ %s.',

	'Partition by' => 'Partycjonowanie',
	'Partition' => null,
	'Partitions' => 'Partycje',
	'Partition name' => 'Nazwa partycji',
	'Values' => 'Wartości',

	'View' => 'Perspektywa',
	'Materialized view' => 'Zmaterializowana perspektywa',
	'View has been dropped.' => 'Perspektywa została usunięta.',
	'View has been altered.' => 'Perspektywa została zmieniona.',
	'View has been created.' => 'Perspektywa została utworzona.',
	'Alter view' => 'Zmień perspektywę',
	'Create view' => 'Utwórz perspektywę',

	'Indexes' => 'Indeksy',
	'Indexes have been altered.' => 'Indeksy zostały zmienione.',
	'Alter indexes' => 'Zmień indeksy',
	'Add next' => 'Dodaj następny',
	'Index Type' => 'Typ indeksu',
	'Column (length)' => 'Kolumna (długość)',

	'Foreign keys' => 'Klucze obce',
	'Foreign key' => 'Klucz obcy',
	'Foreign key has been dropped.' => 'Klucz obcy został usunięty.',
	'Foreign key has been altered.' => 'Klucz obcy został zmieniony.',
	'Foreign key has been created.' => 'Klucz obcy został utworzony.',
	'Target table' => 'Tabela docelowa',
	'Change' => 'Zmień',
	'Source' => 'Źródło',
	'Target' => 'Cel',
	'Add column' => 'Dodaj kolumnę',
	'Alter' => 'Zmień',
	'Add foreign key' => 'Dodaj klucz obcy',
	'ON DELETE' => 'W przypadku usunięcia',
	'ON UPDATE' => 'W przypadku zmiany',
	'Source and target columns must have the same data type, there must be an index on the target columns and referenced data must exist.' => 'Źródłowa i docelowa kolumna muszą być tego samego typu, powinien istnieć indeks na docelowej kolumnie oraz muszą istnieć dane referencyjne.',

	'Triggers' => 'Wyzwalacze',
	'Add trigger' => 'Dodaj wyzwalacz',
	'Trigger has been dropped.' => 'Wyzwalacz został usunięty.',
	'Trigger has been altered.' => 'Wyzwalacz został zmieniony.',
	'Trigger has been created.' => 'Wyzwalacz został utworzony.',
	'Alter trigger' => 'Zmień wyzwalacz',
	'Create trigger' => 'Utwórz wyzwalacz',
	'Time' => 'Czas',
	'Event' => 'Wydarzenie',
	'Name' => 'Nazwa',

	'select' => 'przeglądaj',
	'Select' => 'pokaż',
	'Select data' => 'Pokaż dane',
	'Functions' => 'Funkcje',
	'Aggregation' => 'Agregacje',
	'Search' => 'Szukaj',
	'anywhere' => 'gdziekolwiek',
	'Search data in tables' => 'Wyszukaj we wszystkich tabelach',
	'as a regular expression' => null,
	'Sort' => 'Sortuj',
	'descending' => 'malejąco',
	'Limit' => 'Limit',
	'Limit rows' => 'Limit rekordów',
	'Text length' => 'Długość tekstu',
	'Action' => 'Czynność',
	'Full table scan' => 'Wymaga pełnego przeskanowania tabeli',
	'Unable to select the table' => 'Nie udało się pobrać danych z tabeli',
	'No rows.' => 'Brak rekordów.',
	'%d / ' => '%d / ',
	'%d row(s)' => array('%d rekord', '%d rekordy', '%d rekordów'),
	'Page' => 'Strona',
	'last' => 'ostatni',
	'Load more data' => 'Wczytaj więcej danych',
	'Loading' => 'Wczytywanie',
	'Whole result' => 'Wybierz wszystkie',
	'%d byte(s)' => array('%d bajt', '%d bajty', '%d bajtów'),

	'Import' => 'Import',
	'%d row(s) have been imported.' => array('%d rekord został zaimportowany.', '%d rekordy zostały zaimportowane.', '%d rekordów zostało zaimportowanych.'),
	'File must be in UTF-8 encoding.' => 'Kodowanie pliku musi być ustawione na UTF-8.',

	// in-place editing in select
	'Modify' => 'Zmień',
	'Ctrl+click on a value to modify it.' => 'Ctrl+kliknij wartość, aby ją edytować.',
	'Use edit link to modify this value.' => 'Użyj linku edycji aby zmienić tę wartość.',

	// %s can contain auto-increment value
	'Item%s has been inserted.' => 'Rekord%s został dodany.',
	'Item has been deleted.' => 'Rekord został usunięty.',
	'Item has been updated.' => 'Rekord został zaktualizowany.',
	'%d item(s) have been affected.' => array('Zmieniono %d rekord.', 'Zmieniono %d rekordy.', 'Zmieniono %d rekordów.'),
	'New item' => 'Nowy rekord',
	'original' => 'bez zmian',
	// label for value '' in enum data type
	'empty' => 'puste',
	'edit' => 'edytuj',
	'Edit' => 'Edytuj',
	'Insert' => 'Dodaj',
	'Save' => 'Zapisz zmiany',
	'Saving' => 'Zapisywanie',
	'Save and continue edit' => 'Zapisz i kontynuuj edycję',
	'Save and insert next' => 'Zapisz i dodaj następny',
	'Selected' => 'Zaznaczone',
	'Clone' => 'Duplikuj',
	'Delete' => 'Usuń',
	'You have no privileges to update this table.' => 'Brak uprawnień do edycji tej tabeli',

	'E-mail' => 'E-mail',
	'From' => 'Nadawca',
	'Subject' => 'Temat',
	'Attachments' => 'Załączniki',
	'Send' => 'Wyślij',
	'%d e-mail(s) have been sent.' => array('Wysłano %d e-mail.', 'Wysłano %d e-maile.', 'Wysłano %d e-maili.'),

	// data type descriptions
	'Numbers' => 'Numeryczne',
	'Date and time' => 'Data i czas',
	'Strings' => 'Tekstowe',
	'Binary' => 'Binarne',
	'Lists' => 'Listy',
	'Network' => 'Sieć',
	'Geometry' => 'Geometria',
	'Relations' => 'Relacje',

	// 'Editor' => 'Edytor',
	// date format in Editor: $1 yyyy, $2 yy, $3 mm, $4 m, $5 dd, $6 d
	'$1-$3-$5' => '$6.$4.$1',
	// hint for date format - use language equivalents for day, month and year shortcuts
	'[yyyy]-mm-dd' => 'd.m.[rrrr]',
	// hint for time format - use language equivalents for hour, minute and second shortcuts
	'HH:MM:SS' => 'HH:MM:SS',
	'now' => 'teraz',
	'yes' => 'tak',
	'no' => 'nie',

	// general SQLite error in create, drop or rename database
	'File exists.' => 'Plik już istnieje.',
	'Please use one of the extensions %s.' => 'Proszę użyć jednego z rozszerzeń: %s.',

	// PostgreSQL and MS SQL schema support
	'Alter schema' => 'Zmień schemat',
	'Create schema' => 'Utwórz schemat',
	'Schema has been dropped.' => 'Schemat został usunięty.',
	'Schema has been created.' => 'Schemat został utworzony.',
	'Schema has been altered.' => 'Schemat został zmieniony.',
	'Schema' => 'Schemat',
	'Invalid schema.' => 'Nieprawidłowy schemat.',

	// PostgreSQL sequences support
	'Sequences' => 'Sekwencje',
	'Create sequence' => 'Utwórz sekwencję',
	'Sequence has been dropped.' => 'Sekwencja została usunięta.',
	'Sequence has been created.' => 'Sekwencja została utworzona.',
	'Sequence has been altered.' => 'Sekwencja została zmieniona.',
	'Alter sequence' => 'Zmień sekwencję',

	// PostgreSQL user types support
	'User types' => 'Typy użytkownika',
	'Create type' => 'Utwórz typ',
	'Type has been dropped.' => 'Typ został usunięty.',
	'Type has been created.' => 'Typ został utworzony.',
	'Alter type' => 'Zmień typ',

	'overwrite' => null,
	'DB' => null,
	'Warnings' => null,
	'Adminer does not support accessing a database without a password, <a href="https://www.adminer.org/en/password/"%s>more information</a>.' => null,
	'The action will be performed after successful login with the same credentials.' => null,
	'There is a space in the input password which might be the cause.' => null,
	'Unknown error.' => null,
	'Database does not support password.' => null,
	'Disable %s or enable %s or %s extensions.' => null,

	'Columns' => null,
	'Nullable' => null,
	'Default' => null,
	'Yes' => 'Tak',
	'No' => 'Nie',
	'One Time Password' => null,
	'Invalid OTP code.' => null,

	'Schemas' => null,
	'No schemas.' => null,
	'Show schema' => null,
	'No driver' => null,
	'Database driver not found.' => null,
);
