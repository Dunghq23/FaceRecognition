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
	fk_employee_id int not null,
	fk_role_id int not null,
	foreign key (fk_employee_id) references employees(employee_id),
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
