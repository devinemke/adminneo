<?php
$translations = array(
	// label for database system selection (MySQL, SQLite, ...)
	'Home' => null,
	'System' => 'System',
	'Server' => 'Server',
	'Username' => 'Användarnamn',
	'Password' => 'Lösenord',
	'Permanent login' => 'Permanent inloggning',
	'Login' => 'Logga in',
	'Logout' => 'Logga ut',
	'Logged as: %s' => 'Inloggad som: %s',
	'Logout successful.' => 'Du är nu utloggad.',
	'Thanks for using Adminer, consider <a href="https://www.adminer.org/en/donation/">donating</a>.' => 'Tack för att du använder Adminer, vänligen fundera över att <a href="https://www.adminer.org/en/donation/">donera</a>.',
	'Invalid server or credentials.' => null,
	'There is a space in the input password which might be the cause.' => 'Det finns ett mellanslag i lösenordet, vilket kan vara anledningen.',
	'Adminer does not support accessing a database without a password, <a href="https://www.adminer.org/en/password/"%s>more information</a>.' => 'Adminer tillåter inte att ansluta till en databas utan lösenord. <a href="https://www.adminer.org/en/password/"%s>Mer information</a>.',
	'Database does not support password.' => 'Databasen stödjer inte lösenord.',
	'Too many unsuccessful logins, try again in %d minute(s).' => array('För många misslyckade inloggningar, försök igen om %d minut.', 'För många misslyckade inloggningar, försök igen om %d minuter.'),
	'Master password expired. <a href="https://www.adminer.org/en/extension/"%s>Implement</a> %s method to make it permanent.' => 'Huvudlösenordet har löpt ut. <a href="https://www.adminer.org/en/extension/"%s>Implementera</a> %s en metod för att göra det permanent.',
	'Language' => 'Språk',
	'Invalid CSRF token. Send the form again.' => 'Ogiltig CSRF-token. Skicka formuläret igen.',
	'If you did not send this request from Adminer then close this page.' => 'Om du inte skickade en förfrågan från Adminer så kan du stänga den här sidan.',
	'No extension' => 'Inget tillägg',
	'None of the supported PHP extensions (%s) are available.' => 'Inga av de PHP-tilläggen som stöds (%s) är tillgängliga.',
	'Connecting to privileged ports is not allowed.' => 'Anslutning till privilegierade portar är inte tillåtet.',
	'Disable %s or enable %s or %s extensions.' => 'Stäng av %s eller sätt på %s eller %s tilläggen.',
	'Session support must be enabled.' => 'Support för sessioner måste vara på.',
	'Session expired, please login again.' => 'Session har löpt ut, vänligen logga in igen.',
	'The action will be performed after successful login with the same credentials.' => 'Åtgärden kommer att utföras efter en lyckad inloggning med samma inloggningsuppgifter.',
	'%s version: %s through PHP extension %s' => '%s version: %s genom PHP-tillägg %s',
	'Refresh' => 'Ladda om',

	// text direction - 'ltr' or 'rtl'
	'ltr' => 'ltr',

	'Privileges' => 'Privilegier',
	'Create user' => 'Skapa användare',
	'User has been dropped.' => 'Användare har blivit borttagen.',
	'User has been altered.' => 'Användare har blivit ändrad.',
	'User has been created.' => 'Användare har blivit skapad.',
	'Hashed' => 'Hashad',
	'Column' => 'Kolumn',
	'Routine' => 'Rutin',
	'Grant' => 'Tillåt',
	'Revoke' => 'Neka',

	'Process list' => 'Processlista',
	'%d process(es) have been killed.' => array('%d process har avslutats.', '%d processer har avslutats.'),
	'Kill' => 'Avsluta',

	'Variables' => 'Variabler',
	'Status' => 'Status',

	'SQL command' => 'SQL-kommando',
	'%d query(s) executed OK.' => array('%d förfrågan lyckades.', '%d förfrågor lyckades.'),
	'Query executed OK, %d row(s) affected.' => array('Förfrågan lyckades, %d rad påverkades.', 'Förfrågan lyckades, %d rader påverkades.'),
	'No commands to execute.' => 'Inga kommandon att köra.',
	'Error in query' => 'Fel i förfrågan',
	'Unknown error.' => 'Okänt fel.',
	'Warnings' => 'Varningar',
	'ATTACH queries are not supported.' => 'ATTACH-förfrågor stöds inte.',
	'Execute' => 'Kör',
	'Stop on error' => 'Stanna på fel',
	'Show only errors' => 'Visa bara fel',
	// sprintf() format for time of the command
	'%.3f s' => '%.3f s',
	'History' => 'Historia',
	'Clear' => 'Rensa',
	'Edit all' => 'Redigera alla',

	'File upload' => 'Ladda upp fil',
	'From server' => 'Från server',
	'Webserver file %s' => 'Serverfil %s',
	'Run file' => 'Kör fil',
	'File does not exist.' => 'Filen finns inte.',
	'File uploads are disabled.' => 'Filuppladdningar är avstängda.',
	'Unable to upload a file.' => 'Det går inte add ladda upp filen.',
	'Maximum allowed file size is %sB.' => 'Högsta tillåtna storlek är %sB.',
	'Too big POST data. Reduce the data or increase the %s configuration directive.' => 'POST-datan är för stor. Minska det eller höj %s-direktivet.',
	'You can upload a big SQL file via FTP and import it from server.' => 'Du kan ladda upp en stor SQL-fil via FTP och importera det från servern.',
	'You are offline.' => 'Du är offline.',

	'Export' => 'Exportera',
	'Output' => 'Utmatning',
	'open' => 'Öppna',
	'save' => 'Spara',
	'Saving' => 'Sparar',
	'Format' => 'Format',
	'Data' => 'Data',

	'Database' => 'Databas',
	'database' => 'databas',
	'DB' => 'DB',
	'Use' => 'Använd',
	'Select database' => 'Välj databas',
	'Invalid database.' => 'Ogiltig databas.',
	'Database has been dropped.' => 'Databasen har tagits bort.',
	'Databases have been dropped.' => 'Databaserna har tagits bort.',
	'Database has been created.' => 'Databasen har skapats.',
	'Database has been renamed.' => 'Databasen har fått sitt namn ändrat.',
	'Database has been altered.' => 'Databasen har ändrats.',
	'Alter database' => 'Ändra databas',
	'Create database' => 'Skapa databas',
	'Database schema' => 'Databasschema',

	// link to current database schema layout
	'Permanent link' => 'Permanent länk',

	// thousands separator - must contain single byte
	',' => ',',
	'0123456789' => '0123456789',
	'Engine' => 'Motor',
	'Collation' => 'Kollationering',
	'Data Length' => 'Datalängd',
	'Index Length' => 'Indexlängd',
	'Data Free' => 'Ledig data',
	'Rows' => 'Rader',
	'%d in total' => 'totalt %d',
	'Analyze' => 'Analysera',
	'Optimize' => 'Optimera',
	'Vacuum' => 'Städa',
	'Check' => 'Kolla',
	'Repair' => 'Reparera',
	'Truncate' => 'Avkorta',
	'Tables have been truncated.' => 'Tabeller har blivit avkortade.',
	'Move to other database' => 'Flytta till en annan databas',
	'Move' => 'Flytta',
	'Tables have been moved.' => 'Tabeller har flyttats.',
	'Copy' => 'Kopiera',
	'Tables have been copied.' => 'Tabeller har kopierats.',
	'overwrite' => 'Skriv över',

	'Routines' => 'Rutiner',
	'Routine has been called, %d row(s) affected.' => array('Rutin har kallats, %d rad påverkades.', 'Rutin har kallats, %d rader påverkades.'),
	'Call' => 'Kalla',
	'Parameter name' => 'Namn på parameter',
	'Create procedure' => 'Skapa procedur',
	'Create function' => 'Skapa funktion',
	'Routine has been dropped.' => 'Rutin har tagits bort.',
	'Routine has been altered.' => 'Rutin har ändrats.',
	'Routine has been created.' => 'Rutin har skapats.',
	'Alter function' => 'Ändra funktion',
	'Alter procedure' => 'Ändra procedur',
	'Return type' => 'Återvändningstyp',

	'Events' => 'Event',
	'Event has been dropped.' => 'Event har tagits bort.',
	'Event has been altered.' => 'Event har ändrats.',
	'Event has been created.' => 'Event har skapats.',
	'Alter event' => 'Ändra event',
	'Create event' => 'Skapa event',
	'At given time' => 'Vid en tid',
	'Every' => 'Varje',
	'Schedule' => 'Schemalägga',
	'Start' => 'Start',
	'End' => 'Slut',
	'On completion preserve' => 'Bibehåll vid slutet',

	'Tables' => 'Tabeller',
	'Tables and views' => 'Tabeller och vyer',
	'Table' => 'Tabell',
	'No tables.' => 'Inga tabeller.',
	'Alter table' => 'Ändra tabell',
	'Create table' => 'Skapa tabell',
	'Table has been dropped.' => 'Tabell har tagits bort.',
	'Tables have been dropped.' => 'Tabeller har tagits bort.',
	'Tables have been optimized.' => 'Tabeller har optimerats.',
	'Table has been altered.' => 'Tabell har ändrats.',
	'Table has been created.' => 'Tabell har skapats.',
	'Table name' => 'Tabellnamn',
	'Show structure' => 'Visa struktur',
	'engine' => 'motor',
	'collation' => 'kollationering',
	'Column name' => 'Kolumnnamn',
	'Type' => 'Typ',
	'Length' => 'Längd',
	'Auto Increment' => 'Automatisk uppräkning',
	'Options' => 'Inställningar',
	'Comment' => 'Kommentar',
	'Default value' => 'Standardvärde',
	'Default values' => 'Standardvärden',
	'Drop' => 'Ta bort',
	'Drop %s?' => 'Ta bort %s?',
	'Are you sure?' => 'Är du säker?',
	'Size' => 'Storlek',
	'Compute' => 'Beräkna',
	'Move up' => 'Flytta upp',
	'Move down' => 'Flytta ner',
	'Remove' => 'Ta bort',
	'Maximum number of allowed fields exceeded. Please increase %s.' => 'Högsta nummer tillåtna fält är överskridet. Vänligen höj %s.',

	'Partition by' => 'Partitionera om',
	'Partition' => null,
	'Partitions' => 'Partitioner',
	'Partition name' => 'Partition',
	'Values' => 'Värden',

	'View' => 'Vy',
	'Materialized view' => 'Materialiserad vy',
	'View has been dropped.' => 'Vy har tagits bort.',
	'View has been altered.' => 'Vy har ändrats.',
	'View has been created.' => 'Vy har skapats.',
	'Alter view' => 'Ändra vy',
	'Create view' => 'Skapa vy',

	'Indexes' => 'Index',
	'Indexes have been altered.' => 'Index har ändrats.',
	'Alter indexes' => 'Ändra index',
	'Add next' => 'Lägg till nästa',
	'Index Type' => 'Indextyp',
	'Column (length)' => 'Kolumn (längd)',

	'Foreign keys' => 'Främmande nycklar',
	'Foreign key' => 'Främmande nyckel',
	'Foreign key has been dropped.' => 'Främmande nyckel har tagits bort.',
	'Foreign key has been altered.' => 'Främmande nyckel har ändrats.',
	'Foreign key has been created.' => 'Främmande nyckel har skapats.',
	'Target table' => 'Måltabell',
	'Change' => 'Ändra',
	'Source' => 'Källa',
	'Target' => 'Mål',
	'Add column' => 'Lägg till kolumn',
	'Alter' => 'Ändra',
	'Add foreign key' => 'Lägg till främmande nyckel',
	'ON DELETE' => 'VID BORTTAGNING',
	'ON UPDATE' => 'VID UPPDATERING',
	'Source and target columns must have the same data type, there must be an index on the target columns and referenced data must exist.' => 'Käll- och mål-tabellen måste ha samma datatyp, ett index på målkolumnerna och refererad data måste finnas.',

	'Triggers' => 'Avtryckare',
	'Add trigger' => 'Lägg till avtryckare',
	'Trigger has been dropped.' => 'Avtryckare har tagits bort.',
	'Trigger has been altered.' => 'Avtryckare har ändrats.',
	'Trigger has been created.' => 'Avtryckare har skapats.',
	'Alter trigger' => 'Ändra avtryckare',
	'Create trigger' => 'Skapa avtryckare',
	'Time' => 'Tid',
	'Event' => 'Event',
	'Name' => 'Namn',

	'select' => 'välj',
	'Select' => 'Välj',
	'Select data' => 'Välj data',
	'Functions' => 'Funktioner',
	'Aggregation' => 'Aggregation',
	'Search' => 'Sök',
	'anywhere' => 'överallt',
	'Search data in tables' => 'Sök data i tabeller',
	'as a regular expression' => null,
	'Sort' => 'Sortera',
	'descending' => 'Fallande',
	'Limit' => 'Begränsning',
	'Limit rows' => 'Begränsa rader',
	'Text length' => 'Textlängd',
	'Action' => 'Åtgärd',
	'Full table scan' => 'Full tabellskanning',
	'Unable to select the table' => 'Kunde inte välja tabellen',
	'No rows.' => 'Inga rader.',
	'%d / ' => '%d / ',
	'%d row(s)' => array('%d rad', '%d rader'),
	'Page' => 'Sida',
	'last' => 'sist',
	'Load more data' => 'Ladda mer data',
	'Loading' => 'Laddar',
	'Whole result' => 'Hela resultatet',
	'%d byte(s)' => array('%d byte', '%d bytes'),

	'Import' => 'Importera',
	'%d row(s) have been imported.' => array('%d rad har importerats.', '%d rader har importerats.'),
	'File must be in UTF-8 encoding.' => 'Filer måste vara i UTF-8-format.',

	// in-place editing in select
	'Modify' => 'Ändra',
	'Ctrl+click on a value to modify it.' => 'Ctrl+klicka på ett värde för att ändra det.',
	'Use edit link to modify this value.' => 'Använd redigeringslänken för att ändra värdet.',

	// %s can contain auto-increment value
	'Item%s has been inserted.' => 'Sak%s har skapats.',
	'Item has been deleted.' => 'En sak har tagits bort.',
	'Item has been updated.' => 'En sak har ändrats.',
	'%d item(s) have been affected.' => array('%d sak har blivit förändrad.', '%d saker har blivit förändrade.'),
	'New item' => 'Ny sak',
	'original' => 'original',
	// label for value '' in enum data type
	'empty' => 'tom',
	'edit' => 'redigera',
	'Edit' => 'Redigera',
	'Insert' => 'Infoga',
	'Save' => 'Spara',
	'Save and continue edit' => 'Spara och fortsätt att redigera',
	'Save and insert next' => 'Spara och infoga nästa',
	'Selected' => 'Vald',
	'Clone' => 'Klona',
	'Delete' => 'Ta bort',
	'You have no privileges to update this table.' => 'Du har inga privilegier för att uppdatera den här tabellen.',

	'E-mail' => 'Email',
	'From' => 'Från',
	'Subject' => 'Ämne',
	'Attachments' => 'Bilagor',
	'Send' => 'Skicka',
	'%d e-mail(s) have been sent.' => array('%d email har blivit skickat.', '%d email har blivit skickade.'),

	// data type descriptions
	'Numbers' => 'Nummer',
	'Date and time' => 'Datum och tid',
	'Strings' => 'Strängar',
	'Binary' => 'Binärt',
	'Lists' => 'Listor',
	'Network' => 'Nätverk',
	'Geometry' => 'Geometri',
	'Relations' => 'Relationer',

	'Editor' => 'Redigerare',
	// date format in Editor: $1 yyyy, $2 yy, $3 mm, $4 m, $5 dd, $6 d
	'$1-$3-$5' => '$1-$3-$5',
	// hint for date format - use language equivalents for day, month and year shortcuts
	'[yyyy]-mm-dd' => 'yyyy-mm-dd',
	// hint for time format - use language equivalents for hour, minute and second shortcuts
	'HH:MM:SS' => 'HH:MM:SS',
	'now' => 'nu',
	'yes' => 'ja',
	'no' => 'nej',

	// general SQLite error in create, drop or rename database
	'File exists.' => 'Filen finns redan.',
	'Please use one of the extensions %s.' => 'Vänligen använd en av filändelserna %s.',

	// PostgreSQL and MS SQL schema support
	'Alter schema' => 'Redigera schema',
	'Create schema' => 'Skapa schema',
	'Schema has been dropped.' => 'Schema har tagits bort.',
	'Schema has been created.' => 'Schema har skapats.',
	'Schema has been altered.' => 'Schema har ändrats.',
	'Schema' => 'Schema',
	'Invalid schema.' => 'Ogiltigt schema.',

	// PostgreSQL sequences support
	'Sequences' => 'Sekvenser',
	'Create sequence' => 'Skapa sekvens',
	'Sequence has been dropped.' => 'Sekvens har tagits bort.',
	'Sequence has been created.' => 'Sekvens har skapats.',
	'Sequence has been altered.' => 'Sekvens har ändrats.',
	'Alter sequence' => 'Ändra sekvens',

	// PostgreSQL user types support
	'User types' => 'Användartyper',
	'Create type' => 'Skapa typ',
	'Type has been dropped.' => 'Typ har, typ, tagits bort.',
	'Type has been created.' => 'Typ har skapats.',
	'Alter type' => 'Ändra typ',

	'Columns' => null,
	'Nullable' => null,
	'Default' => null,
	'Yes' => 'Ja',
	'No' => 'Nej',
	'One Time Password' => null,
	'Invalid OTP code.' => null,
);
