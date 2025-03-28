use hrm;

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
select * from linkRoles;
select * from accounts;

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
CREATE TABLE systemLogs (
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

select *from systemLogs


---------------------------------------------------- Quản lý tuyển dụng
-- Cấp bậc => đổi tên thành mức độ kinh nghiệm
CREATE TABLE experienceLevels (
    level_id INT IDENTITY(1,1) PRIMARY KEY,
    level_name NVARCHAR(255) NOT NULL
);
insert into experienceLevels (level_name) values
(N'Mới tốt nghiệp'),
(N'Nhân viên/Chuyên viên'),
(N'Trưởng phòng/Quản lý')


-- Loại hình công việc
CREATE TABLE jobTypes (
    jobType_id INT IDENTITY(1,1) PRIMARY KEY,
    jobType_name NVARCHAR(255) NOT NULL
);
insert into jobTypes (jobType_name) values
(N'Toàn thời gian'),
(N'Bán thời gian'),
(N'Thực tập sinh'),
(N'Cộng tác viên'),
(N'Hợp đồng thời vụ'),
(N'Freelancer')

-- Ngành nghề -- đổi tên bảng => lĩnh vực chuyên môn
CREATE TABLE majors (
    major_id INT IDENTITY(1,1) PRIMARY KEY,
    major_name NVARCHAR(255) NOT NULL
);
insert into majors (major_name) values
(N'Bán hàng/ Kinh doanh'),
(N'Chăm sóc khách hàng'),
(N'CNTT - Phần mềm'),
(N'CNTT/ Phần cứng/ Mạng'),
(N'Dịch vụ khánh hàng'),
(N'Hành chính/ Thư ký'),
(N'Kế toán/ Kiểm toán'),
(N'Nhân sự')


-- Tin tuyển dụng
CREATE TABLE jobPosts (
    jobPost_id INT IDENTITY(1,1) PRIMARY KEY,
    fk_level_id INT NOT NULL, -- Cấp bậc tuyển dụng
    fk_jobType_id INT NOT NULL, -- Loại hình công việc tuyển dụng
    fk_major_id INT NOT NULL, -- Ngành nghề tuyển dụng
    fk_employee_id INT NOT NULL, -- Người đăng tin tuyển dụng
    title NVARCHAR(255) NOT NULL, -- Tiêu đề
    role_hire NVARCHAR(120) NOT NULL, -- Vị trí tuyển dụng
    work_place NVARCHAR(255), -- Nơi làm việc
    salary_range NVARCHAR(255), -- Khoảng lương
    quantity_hire INT NOT NULL, -- Số lượng tuyển
    expiried_date DATE NOT NULL, -- Thời gian hết hạn tuyển dụng
    description NVARCHAR(MAX) NOT NULL, -- Mô tả
    requirement NVARCHAR(MAX) NOT NULL, -- Yêu cầu
    benefits NVARCHAR(MAX) NOT NULL, -- Lợi ích
    status INT CHECK (status IN (0, 1, 2)) DEFAULT 0,
    -- 0: Đang tuyển dụng
    -- 1: Tạm dừng nhận hồ sơ
    -- 2: Đóng tuyển dụng
    created_at DATETIME2 DEFAULT SYSDATETIME(),
    updated_at DATETIME2 DEFAULT SYSDATETIME(),

    FOREIGN KEY (fk_level_id) REFERENCES experienceLevels(level_id),
    FOREIGN KEY (fk_jobType_id) REFERENCES jobTypes(jobType_id),
    FOREIGN KEY (fk_major_id) REFERENCES majors(major_id),
    FOREIGN KEY (fk_employee_id) REFERENCES employees(employee_id)
);

select * from jobPosts;


-- Nguồn ứng viên -- đổi tên bảng
CREATE TABLE candidateOrigins (
    origin_id INT IDENTITY(1,1) PRIMARY KEY,
    origin_name NVARCHAR(100) NOT NULL
)

insert into candidateOrigins (origin_name) values
(N'Giới thiệu nội bộ'),
('Facebook'),
('LinkedIn'),
(N'Website công ty'),
(N'Mạng xã hội tìm việc')


-- Hồ sơ ứng viên
CREATE TABLE candidates (
    candidate_id INT IDENTITY(1,1) PRIMARY KEY,
    fk_origin_id INT NOT NULL, -- Thuộc về nguồn ứng viên từ đâu
    fk_jobPost_id INT NOT NULL, -- Thuộc về tin tuyển dụng nào
    full_name NVARCHAR(255) NOT NULL, -- Họ và tên
    email NVARCHAR(255) UNIQUE NOT NULL, -- Email
    phone NVARCHAR(50) NOT NULL, -- Số điện thoại
    birthday DATE NOT NULL, -- Ngày sinh
    gender VARCHAR(1) CHECK (gender IN ('F', 'M')) NOT NULL, -- Giới tính
    address NVARCHAR(255) NOT NULL, -- Địa chỉ ứng viên
    education_level NVARCHAR(100) NOT NULL, -- Trình độ đào tạo
    education_place NVARCHAR(255) NOT NULL, -- Nơi đào tạo
    major NVARCHAR(100) NOT NULL, -- Chuyên ngành
    apply_time DATE NOT NULL, -- Thời gian nộp hồ sơ
    resumePath NVARCHAR(500), -- Đường dẫn file hồ sơ
    status INT CHECK (status IN (0, 1, 2, 3)) DEFAULT 0,
    -- 0: Chờ phỏng vấn
    -- 1: Đang phỏng vấn
    -- 2: Đạt phỏng vấn
    -- 3: Không đạt
    created_at DATETIME2 DEFAULT SYSDATETIME(),
    updated_at DATETIME2 DEFAULT SYSDATETIME(),

    FOREIGN KEY (fk_origin_id) REFERENCES candidateOrigins(origin_id),
    FOREIGN KEY (fk_jobPost_id) REFERENCES jobPosts(jobPost_id)
);

-- Kinh nghiệm làm việc của ứng viên
CREATE TABLE workExperiences (
    workExperience_id INT IDENTITY(1,1) PRIMARY KEY,
    fk_candidate_id INT NOT NULL, -- Ứng viên tương ứng
    workplace NVARCHAR(255) NOT NULL, -- Nơi làm việc
    work_description NVARCHAR(MAX) NOT NULL, -- Mô tả công việc
    time_start DATE NOT NULL, -- Thời gian bắt đầu
    time_end DATE NOT NULL, -- Thời gian kết thúc

    FOREIGN KEY (fk_candidate_id) REFERENCES candidates(candidate_id),
)


-- Lịch phỏng vấn
CREATE TABLE interviewSchedules (
    interview_id INT IDENTITY(1,1) PRIMARY KEY,
    fk_jobPost_id INT NOT NULL, -- Thuộc về tin tuyển dụng nào
    fk_employee_id INT NOT NULL, -- Nhân viên được giao việc phỏng vấn
    fk_candidate_id INT NOT NULL, -- Ứng viên phỏng vấn
    interview_time DATETIME NOT NULL, -- Thời gian phỏng vấn
    interview_location NVARCHAR(255) NOT NULL, -- Địa điểm phỏng vấn
    notes NVARCHAR(MAX), -- Ghi chú (nếu có)

    FOREIGN KEY (fk_jobPost_id) REFERENCES jobPosts(jobPost_id),
    FOREIGN KEY (fk_employee_id) REFERENCES employees(employee_id),
    FOREIGN KEY (fk_candidate_id) REFERENCES candidates(candidate_id)
);


-- drop table
--drop table interviewSchedules;
--drop table workExperiences;
--drop table candidates;
--drop table candidateOrigins;
--drop table jobPosts;
--drop table majors;
--drop table jobTypes;
--drop table experienceLevels;
