<?php

namespace AdminNeo;

return [
	// text direction - 'ltr' or 'rtl'
	'ltr' => 'ltr',
	// thousands separator - must contain single byte
	',' => '.',
	'0123456789' => '0123456789',
	// Editor - date format: $1 yyyy, $2 yy, $3 mm, $4 m, $5 dd, $6 d
	'$1-$3-$5' => '$1-$3-$5',
	// Editor - hint for date format - use language equivalents for day, month and year shortcuts
	'YYYY-MM-DD' => 'YYYY-MM-DD',
	// Editor - hint for time format - use language equivalents for hour, minute and second shortcuts
	'HH:MM:SS' => 'HH:MM:SS',

	// Bootstrap.

	// Login.
	'System' => 'Sistem',
	'Server' => 'Server',
	'Username' => 'Pengguna',
	'Password' => 'Sandi',
	'Permanent login' => 'Masuk permanen',
	'Login' => 'Masuk',
	'Logout' => 'Keluar',
	'Logged as: %s' => 'Masuk sebagai: %s',
	'Logout successful.' => 'Berhasil keluar.',
	'Invalid CSRF token. Send the form again.' => 'Token CSRF tidak sah. Kirim ulang formulir.',

	// Connection.
	'No extension' => 'Ekstensi tidak ada',
	// %s contains the list of the extensions, e.g. 'mysqli, PDO_MySQL'
	'None of the supported PHP extensions (%s) are available.' => 'Ekstensi PHP yang didukung (%s) tidak ada.',
	'Session support must be enabled.' => 'Dukungan sesi harus aktif.',
	'Session expired, please login again.' => 'Sesi habis, silakan masuk lagi.',
	'%s version: %s through PHP extension %s' => 'Versi %s: %s dengan ekstensi PHP %s',

	// Settings.
	'Language' => 'Bahasa',

	'Refresh' => 'Segarkan',

	// Privileges.
	'Privileges' => 'Privilese',
	'Create user' => 'Buat pengguna',
	'User has been dropped.' => 'Pengguna berhasil dihapus.',
	'User has been altered.' => 'Pengguna berhasil diubah.',
	'User has been created.' => 'Pengguna berhasil dibuat.',
	'Hashed' => 'Hashed*',

	// Server.
	'Process list' => 'Daftar proses',
	'%d process(es) have been killed.' => '%d proses berhasil dihentikan.',
	'Kill' => 'Hentikan',
	'Variables' => 'Variabel',
	'Status' => 'Status',

	// Structure.
	'Column' => 'Kolom',
	'Routine' => 'Rutin',
	'Grant' => 'Beri',
	'Revoke' => 'Tarik',

	// Queries.
	'SQL command' => 'Perintah SQL',
	'%d query(s) executed OK.' => '%d kueri berhasil dijalankan.',
	'Query executed OK, %d row(s) affected.' => 'Kueri berhasil, %d baris terpengaruh.',
	'No commands to execute.' => 'Tidak ada perintah untuk dijalankan.',
	'Error in query' => 'Galat dalam kueri',
	'Execute' => 'Jalankan',
	'Stop on error' => 'Hentikan jika galat',
	'Show only errors' => 'Hanya tampilkan galat',
	'Time' => 'Waktu',
	// sprintf() format for time of the command
	'%.3f s' => '%.3f s',
	'History' => 'Riwayat',
	'Clear' => 'Bersihkan',
	'Edit all' => 'Sunting semua',

	// Import.
	'Import' => 'Impor',
	'File upload' => 'Unggah berkas',
	'From server' => 'Dari server',
	'Webserver file %s' => 'Berkas server web %s',
	'Run file' => 'Jalankan berkas',
	'File does not exist.' => 'Berkas tidak ada.',
	'File uploads are disabled.' => 'Pengunggahan berkas dimatikan.',
	'Unable to upload a file.' => 'Tidak dapat mengunggah berkas.',
	'Maximum allowed file size is %sB.' => 'Besar berkas yang diizinkan adalah %sB.',
	'Too big POST data. Reduce the data or increase the %s configuration directive.' => 'Data POST terlalu besar. Kurangi data atau perbesar direktif konfigurasi %s.',
	'%d row(s) have been imported.' => '%d baris berhasil diimpor.',

	// Export.
	'Export' => 'Ekspor',
	'Output' => 'Hasil',
	'open' => 'buka',
	'save' => 'simpan',
	'Format' => 'Format',
	'Data' => 'Data',

	// Databases.
	'Database' => 'Basis data',
	'Use' => 'Gunakan',
	'Invalid database.' => 'Basis data tidak sah.',
	'Alter database' => 'Ubah basis data',
	'Create database' => 'Buat basis data',
	'Database schema' => 'Skema basis data',
	'Permanent link' => 'Pranala permanen',
	'Database has been dropped.' => 'Basis data berhasil dihapus.',
	'Databases have been dropped.' => 'Basis data berhasil dihapus.',
	'Database has been created.' => 'Basis data berhasil dibuat.',
	'Database has been renamed.' => 'Basis data berhasil diganti namanya.',
	'Database has been altered.' => 'Basis data berhasil diubah.',
	// SQLite errors.
	'File exists.' => 'Berkas sudah ada.',
	'Please use one of the extensions %s.' => 'Harap gunakan salah satu ekstensi %s.',

	// Schemas (PostgreSQL, MS SQL).
	'Schema' => 'Skema',
	'Alter schema' => 'Ubah skema',
	'Create schema' => 'Buat skema',
	'Schema has been dropped.' => 'Skema berhasil dihapus.',
	'Schema has been created.' => 'Skema berhasil dibuat.',
	'Schema has been altered.' => 'Skema berhasil diubah.',
	'Invalid schema.' => 'Skema tidak sah.',

	// Table list.
	'Engine' => 'Mesin',
	'engine' => 'mesin',
	'Collation' => 'Kolasi',
	'collation' => 'kolasi',
	'Data Length' => 'Panjang Data',
	'Index Length' => 'Panjang Indeks',
	'Data Free' => 'Data Bebas',
	'Rows' => 'Baris',
	'%d in total' => '%d total',
	'Analyze' => 'Analisis',
	'Optimize' => 'Optimalkan',
	'Check' => 'Periksa',
	'Repair' => 'Perbaiki',
	'Truncate' => 'Kosongkan',
	'Tables have been truncated.' => 'Tabel berhasil dikosongkan.',
	'Move to other database' => 'Pindahkan ke basis data lain',
	'Move' => 'Pindahkan',
	'Tables have been moved.' => 'Tabel berhasil dipindahkan.',
	'Copy' => 'Salin',
	'Tables have been copied.' => 'Tabel berhasil disalin.',

	// Tables.
	'Tables' => 'Tabel',
	'Tables and views' => 'Tabel dan tampilan',
	'Table' => 'Tabel',
	'No tables.' => 'Tidak ada tabel.',
	'Alter table' => 'Ubah tabel',
	'Create table' => 'Buat tabel',
	'Table has been dropped.' => 'Tabel berhasil dihapus.',
	'Tables have been dropped.' => 'Tabel berhasil dihapus.',
	'Tables have been optimized.' => 'Tabel berhasil dioptimalkan.',
	'Table has been altered.' => 'Tabel berhasil diubah.',
	'Table has been created.' => 'Tabel berhasil dibuat.',
	'Table name' => 'Nama tabel',
	'Name' => 'Nama',
	'Show structure' => 'Lihat struktur',
	'Column name' => 'Nama kolom',
	'Type' => 'Jenis',
	'Length' => 'Panjang',
	'Auto Increment' => 'Inkrementasi Otomatis',
	'Options' => 'Opsi',
	'Comment' => 'Komentar',
	'Drop' => 'Hapus',
	'Are you sure?' => 'Anda yakin?',
	'Move up' => 'Naik',
	'Move down' => 'Turun',
	'Remove' => 'Hapus',
	'Maximum number of allowed fields exceeded. Please increase %s.' => 'Sudah lebih dumlah ruas maksimum yang diizinkan. Harap naikkan %s.',

	// Views.
	'View' => 'Tampilan',
	'View has been dropped.' => 'Tampilan berhasil dihapus.',
	'View has been altered.' => 'Tampilan berhasil diubah.',
	'View has been created.' => 'Tampilan berhasil dibuat.',
	'Alter view' => 'Ubah tampilan',
	'Create view' => 'Buat tampilan',

	// Partitions.
	'Partition by' => 'Partisi menurut',
	'Partitions' => 'Partisi',
	'Partition name' => 'Nama partisi',
	'Values' => 'Nilai',

	// Indexes.
	'Indexes' => 'Indeks',
	'Indexes have been altered.' => 'Indeks berhasil diubah.',
	'Alter indexes' => 'Ubah indeks',
	'Add next' => 'Tambah setelahnya',
	'Index Type' => 'Jenis Indeks',
	'length' => 'panjang',

	// Foreign keys.
	'Foreign keys' => 'Kunci asing',
	'Foreign key' => 'Kunci asing',
	'Foreign key has been dropped.' => 'Kunci asing berhasil dihapus.',
	'Foreign key has been altered.' => 'Kunci asing berhasil diubah.',
	'Foreign key has been created.' => 'Kunci asing berhasil dibuat.',
	'Target table' => 'Tabel sasaran',
	'Change' => 'Ubah',
	'Source' => 'Sumber',
	'Target' => 'Sasaran',
	'Add column' => 'Tambah kolom',
	'Alter' => 'Ubah',
	'Add foreign key' => 'Tambah kunci asing',
	'ON DELETE' => 'ON DELETE',
	'ON UPDATE' => 'ON UPDATE',
	'Source and target columns must have the same data type, there must be an index on the target columns and referenced data must exist.' => 'Kolom sumber dan sasaran harus memiliki jenis data yang sama. Kolom sasaran harus memiliki indeks dan data rujukan harus ada.',

	// Routines.
	'Routines' => 'Rutin',
	'Routine has been called, %d row(s) affected.' => 'Rutin telah dipanggil, %d baris terpengaruh.',
	'Call' => 'Panggilan',
	'Parameter name' => 'Nama parameter',
	'Create procedure' => 'Buat prosedur',
	'Create function' => 'Buat fungsi',
	'Routine has been dropped.' => 'Rutin berhasil dihapus.',
	'Routine has been altered.' => 'Rutin berhasil diubah.',
	'Routine has been created.' => 'Rutin berhasil dibuat.',
	'Alter function' => 'Ubah fungsi',
	'Alter procedure' => 'Ubah prosedur',
	'Return type' => 'Jenis pengembalian',

	// Events.
	'Events' => 'Even',
	'Event' => 'Even',
	'Event has been dropped.' => 'Even berhasil dihapus.',
	'Event has been altered.' => 'Even berhasil diubah.',
	'Event has been created.' => 'Even berhasil dibuat.',
	'Alter event' => 'Ubah even',
	'Create event' => 'Buat even',
	'At given time' => 'Pada waktu tertentu',
	'Every' => 'Setiap',
	'Schedule' => 'Jadwal',
	'Start' => 'Mulai',
	'End' => 'Selesai',
	'On completion preserve' => 'Pertahankan saat selesai',

	// Sequences (PostgreSQL).
	'Sequences' => 'Deret',
	'Create sequence' => 'Buat deret',
	'Sequence has been dropped.' => 'Deret berhasil dihapus.',
	'Sequence has been created.' => 'Deret berhasil dibuat.',
	'Sequence has been altered.' => 'Deret berhasil diubah.',
	'Alter sequence' => 'Ubah deret',

	// User types (PostgreSQL)
	'User types' => 'Jenis pengguna',
	'Create type' => 'Buat jenis',
	'Type has been dropped.' => 'Jenis berhasil dihapus.',
	'Type has been created.' => 'Jenis berhasil dibuat.',
	'Alter type' => 'Ubah jenis',

	// Triggers.
	'Triggers' => 'Pemicu',
	'Add trigger' => 'Tambah pemicu',
	'Trigger has been dropped.' => 'Pemicu berhasil dihapus.',
	'Trigger has been altered.' => 'Pemicu berhasil diubah.',
	'Trigger has been created.' => 'Pemicu berhasil dibuat.',
	'Alter trigger' => 'Ubah pemicu',
	'Create trigger' => 'Buat pemicu',

	// Table check constraints.

	// Selection.
	'Select data' => 'Pilih data',
	'Select' => 'Pilih',
	'Functions' => 'Fungsi',
	'Aggregation' => 'Agregasi',
	'Search' => 'Cari',
	'anywhere' => 'di mana pun',
	'Sort' => 'Urutkan',
	'descending' => 'menurun',
	'Limit' => 'Batas',
	'Text length' => 'Panjang teks',
	'Action' => 'Tindakan',
	'Full table scan' => 'Pindai tabel lengkap',
	'Unable to select the table' => 'Gagal memilih tabel',
	'Search data in tables' => 'Cari data dalam tabel',
	'No rows.' => 'Tidak ada baris.',
	'%d row(s)' => '%d baris',
	'Page' => 'Halaman',
	'last' => 'terakhir',
	'Whole result' => 'Seluruh hasil',
	'%d byte(s)' => '%d bita',

	// In-place editing in selection.
	'Use edit link to modify this value.' => 'Gunakan pranala suntingan untuk mengubah nilai ini.',

	// Editing.
	'New item' => 'Entri baru',
	'Edit' => 'Sunting',
	'original' => 'asli',
	// label for value '' in enum data type
	'empty' => 'kosong',
	'Insert' => 'Sisipkan',
	'Save' => 'Simpan',
	'Save and continue edit' => 'Simpan dan lanjut menyunting',
	'Save and insert next' => 'Simpan dan sisipkan berikutnya',
	'Clone' => 'Gandakan',
	'Delete' => 'Hapus',
	// %s can contain auto-increment value, e.g. ' 123'
	'Item%s has been inserted.' => 'Entri%s berhasil disisipkan.',
	'Item has been deleted.' => 'Entri berhasil dihapus.',
	'Item has been updated.' => 'Entri berhasil diperbarui.',
	'%d item(s) have been affected.' => '%d entri terpengaruh.',

	// Data type descriptions.
	'Numbers' => 'Angka',
	'Date and time' => 'Tanggal dan waktu',
	'Strings' => 'String',
	'Binary' => 'Binari',
	'Lists' => 'Daftar',
	'Network' => 'Jaringan',
	'Geometry' => 'Geometri',
	'Relations' => 'Relasi',

	// Editor - data values.
	'now' => 'now',
	'yes' => 'yes',
	'no' => 'no',

	// Plugins.
];
