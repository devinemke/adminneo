<?php

namespace AdminNeo;

return [
	// text direction - 'ltr' or 'rtl'
	'ltr' => 'ltr',
	// thousands separator - must contain single byte
	',' => ',',
	'0123456789' => '0123456789',
	// Editor - date format: $1 yyyy, $2 yy, $3 mm, $4 m, $5 dd, $6 d
	'$1-$3-$5' => '$1-$3-$5',
	// Editor - hint for date format - use language equivalents for day, month and year shortcuts
	'YYYY-MM-DD' => 'YYYY-MM-DD',
	// Editor - hint for time format - use language equivalents for hour, minute and second shortcuts
	'HH:MM:SS' => 'HH:MM:SS',

	// Bootstrap.

	// Login.
	'System' => 'Hệ thống',
	'Server' => 'Máy chủ',
	'Username' => 'Tên người dùng',
	'Password' => 'Mật khẩu',
	'Permanent login' => 'Giữ đăng nhập một thời gian',
	'Login' => 'Đăng nhập',
	'Logout' => 'Thoát',
	'Logged as: %s' => 'Vào dưới tên: %s',
	'Logout successful.' => 'Đã thoát xong.',
	'Too many unsuccessful logins, try again in %d minute(s).' => 'Bạn gõ sai tài khoản quá nhiều lần, hãy thử lại sau %d phút nữa.',
	'Invalid CSRF token. Send the form again.' => 'Mã kiểm tra CSRF sai, hãy nhập lại biểu mẫu.',

	// Connection.
	'No extension' => 'Không có phần mở rộng',
	// %s contains the list of the extensions, e.g. 'mysqli, PDO_MySQL'
	'None of the supported PHP extensions (%s) are available.' => 'Bản cài đặt PHP thiếu hỗ trợ cho %s.',
	'Session support must be enabled.' => 'Cần phải bật session.',
	'Session expired, please login again.' => 'Phiên làm việc đã hết, hãy đăng nhập lại.',
	'%s version: %s through PHP extension %s' => 'Phiên bản %s: %s (PHP extension: %s)',

	// Settings.
	'Language' => 'Ngôn ngữ',

	'Refresh' => 'Làm mới',

	// Privileges.
	'Privileges' => 'Quyền truy cập',
	'Create user' => 'Tạo người dùng',
	'User has been dropped.' => 'Đã xoá người dùng.',
	'User has been altered.' => 'Đã sửa người dùng.',
	'User has been created.' => 'Đã tạo người dùng.',
	'Hashed' => 'Mã hoá',

	// Server.
	'Process list' => 'Danh sách tiến trình',
	'%d process(es) have been killed.' => '%d tiến trình đã dừng.',
	'Kill' => 'Dừng',
	'Variables' => 'Biến',
	'Status' => 'Trạng thái',

	// Structure.
	'Column' => 'Cột',
	'Routine' => 'Hàm tích hợp',
	'Grant' => 'Cấp quyền',
	'Revoke' => 'Tước quyền',

	// Queries.
	'SQL command' => 'Câu lệnh SQL',
	'%d query(s) executed OK.' => '%d câu lệnh đã chạy thành công.',
	'Query executed OK, %d row(s) affected.' => 'Đã thực hiện xong, ảnh hưởng đến %d dòng.',
	'No commands to execute.' => 'Chẳng có gì để thực hiện!.',
	'Error in query' => 'Có lỗi trong câu lệnh',
	'Execute' => 'Thực hiện',
	'Stop on error' => 'Dừng khi có lỗi',
	'Show only errors' => 'Chỉ hiện lỗi',
	'Time' => 'Thời gian',
	// sprintf() format for time of the command
	'%.3f s' => '%.3f s',
	'History' => 'Lịch sử',
	'Clear' => 'Xoá',
	'Edit all' => 'Sửa tất cả',

	// Import.
	'Import' => 'Nhập khẩu',
	'File upload' => 'Tải tệp lên',
	'From server' => 'Dùng tệp trên máy chủ',
	'Webserver file %s' => 'Tệp trên máy chủ %s',
	'Run file' => 'Chạy tệp',
	'File does not exist.' => 'Tệp không tồn tại.',
	'File uploads are disabled.' => 'Chức năng tải tệp lên đã bị cấm.',
	'Unable to upload a file.' => 'Không thể tải tệp lên.',
	'Maximum allowed file size is %sB.' => 'Kích thước tệp tối đa là %sB.',
	'Too big POST data. Reduce the data or increase the %s configuration directive.' => 'Dữ liệu tải lên/POST quá lớn. Hãy giảm kích thước tệp hoặc tăng cấu hình (hiện tại %s).',
	'You can upload a big SQL file via FTP and import it from server.' => 'Bạn có thể tải tệp lên dùng FTP và nhập vào cơ sở dữ liệu.',
	'File must be in UTF-8 encoding.' => 'Tệp phải mã hoá bằng chuẩn UTF-8.',
	'%d row(s) have been imported.' => 'Đã nhập % dòng dữ liệu.',

	// Export.
	'Export' => 'Xuất',
	'Output' => 'Kết quả',
	'open' => 'xem',
	'save' => 'lưu',
	'Format' => 'Định dạng',
	'Data' => 'Dữ liệu',

	// Databases.
	'Database' => 'Cơ sở dữ liệu',
	'Use' => 'Sử dụng',
	'Invalid database.' => 'CSDL sai.',
	'Alter database' => 'Thay đổi CSDL',
	'Create database' => 'Tạo CSDL',
	'Database schema' => 'Cấu trúc CSDL',
	'Permanent link' => 'Liên kết cố định',
	'Database has been dropped.' => 'CSDL đã bị xoá.',
	'Databases have been dropped.' => 'Các CSDL đã bị xoá.',
	'Database has been created.' => 'Đã tạo CSDL.',
	'Database has been renamed.' => 'Đã đổi tên CSDL.',
	'Database has been altered.' => 'Đã thay đổi CSDL.',
	// SQLite errors.
	'File exists.' => 'Tệp đã có rồi.',
	'Please use one of the extensions %s.' => 'Cần phải dùng một trong các phần mở rộng sau: %s.',

	// Schemas (PostgreSQL, MS SQL).
	'Schema' => 'Schema',
	'Alter schema' => 'Thay đổi schema',
	'Create schema' => 'Tạo schema',
	'Schema has been dropped.' => 'Đã xoá schema.',
	'Schema has been created.' => 'Đã tạo schema.',
	'Schema has been altered.' => 'Đã thay đổi schema.',
	'Invalid schema.' => 'Schema không hợp lệ.',

	// Table list.
	'Engine' => 'Cơ chế lưu trữ',
	'engine' => 'cơ chế lưu trữ',
	'Collation' => 'Bộ mã',
	'collation' => 'bảng mã',
	'Data Length' => 'Kích thước dữ liệu',
	'Index Length' => 'Kích thước chỉ mục',
	'Data Free' => 'Dữ liệu trống',
	'Rows' => 'Số dòng',
	'%d in total' => '%s',
	'Analyze' => 'Phân tích',
	'Optimize' => 'Tối ưu',
	'Vacuum' => 'Dọn dẹp',
	'Check' => 'Kiểm tra',
	'Repair' => 'Sửa chữa',
	'Truncate' => 'Làm rỗng',
	'Tables have been truncated.' => 'Bảng đã bị làm rỗng.',
	'Move to other database' => 'Chuyển tới cơ sở dữ liệu khác',
	'Move' => 'Chuyển đi',
	'Tables have been moved.' => 'Bảng.',
	'Copy' => 'Sao chép',
	'Tables have been copied.' => 'Bảng đã được sao chép.',

	// Tables.
	'Tables' => 'Các bảng',
	'Tables and views' => 'Bảng và khung nhìn',
	'Table' => 'Bảng',
	'No tables.' => 'Không có bảng nào.',
	'Alter table' => 'Sửa bảng',
	'Create table' => 'Tạo bảng',
	'Table has been dropped.' => 'Bảng đã bị xoá.',
	'Tables have been dropped.' => 'Các bảng đã bị xoá.',
	'Tables have been optimized.' => 'Bảng đã được tối ưu.',
	'Table has been altered.' => 'Bảng đã thay đổi.',
	'Table has been created.' => 'Bảng đã được tạo.',
	'Table name' => 'Tên bảng',
	'Name' => 'Tên',
	'Show structure' => 'Hiện cấu trúc',
	'Column name' => 'Tên cột',
	'Type' => 'Loại',
	'Length' => 'Độ dài',
	'Auto Increment' => 'Tăng tự động',
	'Options' => 'Tuỳ chọn',
	'Comment' => 'Chú thích',
	'Drop' => 'Xoá',
	'Are you sure?' => 'Bạn có chắc',
	'Size' => 'Kích thước',
	'Compute' => 'Tính',
	'Move up' => 'Chuyển lên trên',
	'Move down' => 'Chuyển xuống dưới',
	'Remove' => 'Xoá',
	'Maximum number of allowed fields exceeded. Please increase %s.' => 'Thiết lập %s cần tăng thêm. (Đã vượt giới hạnố trường tối đa cho phép trong một biểu mẫu).',

	// Views.
	'View' => 'Khung nhìn',
	'View has been dropped.' => 'Khung nhìn đã bị xoá.',
	'View has been altered.' => 'Khung nhìn đã được sửa.',
	'View has been created.' => 'Khung nhìn đã được tạo.',
	'Alter view' => 'Sửa khung nhìn',
	'Create view' => 'Tạo khung nhìn',

	// Partitions.
	'Partition by' => 'Phân chia bằng',
	'Partitions' => 'Phân hoạch',
	'Partition name' => 'Tên phân hoạch',
	'Values' => 'Giá trị',

	// Indexes.
	'Indexes' => 'Chỉ mục',
	'Indexes have been altered.' => 'Chỉ mục đã được sửa.',
	'Alter indexes' => 'Sửa chỉ mục',
	'Add next' => 'Thêm tiếp',
	'Index Type' => 'Loại chỉ mục',
	'length' => 'độ dài',

	// Foreign keys.
	'Foreign keys' => 'Các khoá ngoại',
	'Foreign key' => 'Khoá ngoại',
	'Foreign key has been dropped.' => 'Khoá ngoại đã bị xoá.',
	'Foreign key has been altered.' => 'Khoá ngoại đã được sửa.',
	'Foreign key has been created.' => 'Khoá ngoại đã được tạo.',
	'Target table' => 'Bảng đích',
	'Change' => 'Thay đổi',
	'Source' => 'Nguồn',
	'Target' => 'Đích',
	'Add column' => 'Thêm cột',
	'Alter' => 'Sửa',
	'Add foreign key' => 'Thêm khoá ngoại',
	'ON DELETE' => 'Khi xoá',
	'ON UPDATE' => 'Khi cập nhật',
	'Source and target columns must have the same data type, there must be an index on the target columns and referenced data must exist.' => 'Cột gốc và cột đích phải cùng kiểu, phải đặt chỉ mục trong cột đích và dữ liệu tham chiếu phải tồn tại.',

	// Routines.
	'Routines' => 'Routines',
	'Routine has been called, %d row(s) affected.' => 'Đã chạy routine, thay đổi %d dòng.',
	'Call' => 'Gọi',
	'Parameter name' => 'Tham số',
	'Create procedure' => 'Tạo lệnh',
	'Create function' => 'Tạo hàm',
	'Routine has been dropped.' => 'Đã xoá routine.',
	'Routine has been altered.' => 'Đã thay đổi routine.',
	'Routine has been created.' => 'Đã tạo routine.',
	'Alter function' => 'Thay đổi hàm',
	'Alter procedure' => 'Thay đổi thủ tục',
	'Return type' => 'Giá trị trả về',

	// Events.
	'Events' => 'Sự kiện',
	'Event' => 'Sự kiện',
	'Event has been dropped.' => 'Đã xoá sự kiện.',
	'Event has been altered.' => 'Đã thay đổi sự kiện.',
	'Event has been created.' => 'Đã tạo sự kiện.',
	'Alter event' => 'Sửa sự kiện',
	'Create event' => 'Tạo sự kiện',
	'At given time' => 'Vào thời gian xác định',
	'Every' => 'Mỗi',
	'Schedule' => 'Đặt lịch',
	'Start' => 'Bắt đầu',
	'End' => 'Kết thúc',
	'On completion preserve' => 'Khi kết thúc, duy trì',

	// Sequences (PostgreSQL).
	'Sequences' => 'Dãy số',
	'Create sequence' => 'Tạo dãy số',
	'Sequence has been dropped.' => 'Dãy số đã bị xoá.',
	'Sequence has been created.' => 'Đã tạo dãy số.',
	'Sequence has been altered.' => 'Đã sửa dãy số.',
	'Alter sequence' => 'Thay đổi dãy số',

	// User types (PostgreSQL)
	'User types' => 'Kiểu tự định nghĩa',
	'Create type' => 'Tạo kiểu',
	'Type has been dropped.' => 'Đã xoá kiểu.',
	'Type has been created.' => 'Đã tạo kiểu.',
	'Alter type' => 'Sửa kiểu dữ liệu',

	// Triggers.
	'Triggers' => 'Phản xạ',
	'Add trigger' => 'Thêm phản xạ',
	'Trigger has been dropped.' => 'Đã xoá phản xạ.',
	'Trigger has been altered.' => 'Đã sửa phản xạ.',
	'Trigger has been created.' => 'Đã tạo phản xạ.',
	'Alter trigger' => 'Sửa phản xạ',
	'Create trigger' => 'Tạo phản xạ',

	// Table check constraints.

	// Selection.
	'Select data' => 'Xem dữ liệu',
	'Select' => 'Xem',
	'Functions' => 'Các chức năng',
	'Aggregation' => 'Tổng hợp',
	'Search' => 'Tìm kiếm',
	'anywhere' => 'bất cứ đâu',
	'Sort' => 'Sắp xếp',
	'descending' => 'giảm dần',
	'Limit' => 'Giới hạn',
	'Text length' => 'Chiều dài văn bản',
	'Action' => 'Hành động',
	'Full table scan' => 'Quét toàn bộ bảng',
	'Unable to select the table' => 'Không thể xem dữ liệu',
	'Search data in tables' => 'Tìm kiếm dữ liệu trong các bảng',
	'No rows.' => 'Không có dòng dữ liệu nào.',
	'%d row(s)' => '%s dòng',
	'Page' => 'trang',
	'last' => 'cuối',
	'Load more data' => 'Xem thêm dữ liệu',
	'Loading' => 'Đang nạp',
	'Whole result' => 'Toàn bộ kết quả',
	'%d byte(s)' => '%d byte(s)',

	// In-place editing in selection.
	'Modify' => 'Sửa',
	'Ctrl+click on a value to modify it.' => 'Nhấn Ctrl và bấm vào giá trị để sửa.',
	'Use edit link to modify this value.' => 'Dùng nút sửa để thay đổi giá trị này.',

	// Editing.
	'New item' => 'Thêm',
	'Edit' => 'Sửa',
	'original' => 'bản gốc',
	// label for value '' in enum data type
	'empty' => 'trống',
	'Insert' => 'Thêm',
	'Save' => 'Lưu',
	'Save and continue edit' => 'Lưu và tiếp tục sửa',
	'Save and insert next' => 'Lưu và thêm tiếp',
	'Selected' => 'Chọn',
	'Clone' => 'Sao chép',
	'Delete' => 'Xoá',
	// %s can contain auto-increment value, e.g. ' 123'
	'Item%s has been inserted.' => 'Đã thêm%s.',
	'Item has been deleted.' => 'Đã xoá.',
	'Item has been updated.' => 'Đã cập nhật.',
	'%d item(s) have been affected.' => '%d phần đã thay đổi.',
	'You have no privileges to update this table.' => 'Bạn không có quyền sửa bảng này.',

	// Data type descriptions.
	'Numbers' => 'Số',
	'Date and time' => 'Ngày giờ',
	'Strings' => 'Chuỗi',
	'Binary' => 'Mã máy',
	'Lists' => 'Danh sách',
	'Network' => 'Mạng',
	'Geometry' => 'Toạ độ',
	'Relations' => 'Quan hệ',

	// Editor - data values.
	'now' => 'hiện tại',
	'yes' => 'có',
	'no' => 'không',

	// Plugins.
];
