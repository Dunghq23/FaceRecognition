use TimeKeeping;

--
create table roleParents (
	roleParent_id int not null identity(1,1) primary key,
	roleParent_name nvarchar(150) not null
)

insert into roleParents (roleParent_name) values
(N'Quản trị Hệ thống'),
(N'Quản lý Tuyển dụng'),
(N'Quản lý Hồ sơ nhân viên'),
(N'Quản lý Chấm công và Tính lương'),
(N'Báo cáo và Thống kê'),
(N'Chức năng khác')

select * from roleParents;

----
create table roles (
	role_id int not null identity(1,1) primary key,
	role_name nvarchar(150) not null,
	fk_roleParent_id int not null
	foreign key (fk_roleParent_id) references dbo.roleParents(roleParent_id)
)

insert into roles (role_name, fk_roleParent_id) values
(N'Quản lý người dùng', 1),(N'Phân quyền người dùng', 1),(N'Nhật ký thao tác hệ thống', 1),
(N'Hồ sơ ứng viên', 2),(N'Lịch phỏng vấn', 2),(N'Thông báo phỏng vấn', 2)


select * from roles;

----
create table linkRoles (
	fk_account_id int not null,
	fk_role_id int not null,
	foreign key (fk_account_id) references accounts(account_id),
	foreign key (fk_role_id) references roles(role_id)
)

--
CREATE TABLE accounts (
    account_id int not null identity(1,1) primary key,
    fk_employee_id INT not null unique,
    username varchar(50) unique NOT NULL,
    password varchar(255) NOT NULL, 
	created_at DATETIME2 DEFAULT SYSDATETIME(),
	updated_at DATETIME2 DEFAULT SYSDATETIME()
    foreign key (fk_employee_id) references employees(employee_id) on delete cascade
);

select * from accounts;

---
CREATE TABLE system_logs (
    log_id int not null identity(1,1) primary key,
    fk_account_id int not null,            -- ID người thực hiện (nullable nếu không đăng nhập)
    action nvarchar(255) not null,         -- Hành động thực hiện (ví dụ: "Thêm sản phẩm", "Xóa tài khoản")
    table_name nvarchar(100) null,         -- Bảng dữ liệu bị tác động (nếu có)
    record_id int null,                    -- ID bản ghi bị tác động (nếu có)
    details nvarchar(MAX) null,            -- Chi tiết thay đổi (JSON hoặc text mô tả)
    user_agent nvarchar(500) not null,     -- Thông tin trình duyệt, thiết bị
    created_at DATETIME2 DEFAULT SYSDATETIME()
    foreign key (fk_account_id) references accounts(account_id) on delete cascade
);

select *from system_logs

