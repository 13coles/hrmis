-- Employees Table
CREATE TABLE employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employee_no INT NOT NULL UNIQUE,
    date_hired DATE NOT NULL,
    year_service INT,
    status ENUM('Coterminous', 'Permanent', 'Elected', 'Temporary') NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    first_name VARCHAR(255) NOT NULL,
    middle_name VARCHAR(255),
    extension_name VARCHAR(50),
    sex ENUM('male', 'female') NOT NULL,
    civil_status ENUM('single', 'married', 'widowed', 'separated') NOT NULL,
    birth_date DATE NOT NULL,
    birth_place VARCHAR(255) NOT NULL,
    contact_number VARCHAR(25) NOT NULL,
    height DECIMAL(5,2) NOT NULL,
    weight DECIMAL(5,2) NOT NULL,
    educational_attainment ENUM('college_graduate', 'vocational', 'highschool_graduate', 'masteral_graduate', 'vocational_trade_course') NOT NULL,
    course VARCHAR(255),
    blood_type ENUM('A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-') NOT NULL,
    nationality VARCHAR(255) NOT NULL,
    spouse_name VARCHAR(255),
    spouse_occupation VARCHAR(255),
    employee_type ENUM('permanent', 'jo') NOT NULL,
    department_name VARCHAR(255) NOT NULL,
    position VARCHAR(255) NOT NULL,
    salary_grade VARCHAR(50) NOT NULL,
    step INT NOT NULL,
);

-- Address Table
CREATE TABLE address (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employee_id INT NOT NULL,
    street VARCHAR(255) NOT NULL,
    barangay VARCHAR(255) NOT NULL,
    city VARCHAR(255) NOT NULL,
    province VARCHAR(255) NOT NULL,
    FOREIGN KEY (employee_id) REFERENCES employees(id) ON DELETE CASCADE
);

-- Emergency Contacts Table
CREATE TABLE emergency_contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employee_id INT NOT NULL,
    person_name VARCHAR(255) NOT NULL,
    relationship VARCHAR(255) NOT NULL,
    tel_no VARCHAR(25) NOT NULL,
    e_street VARCHAR(255) NOT NULL,
    e_barangay VARCHAR(255) NOT NULL,
    e_city VARCHAR(255) NOT NULL,
    e_province VARCHAR(255) NOT NULL,
    FOREIGN KEY (employee_id) REFERENCES employees(id) ON DELETE CASCADE
);

-- Government IDs Table
CREATE TABLE government_ids (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employee_id INT NOT NULL,
    gsis_number VARCHAR(50),
    sss_number VARCHAR(50),
    philhealth_number VARCHAR(50),
    pagibig_number VARCHAR(50),
    eligibility VARCHAR(255),
    prc_number VARCHAR(50),
    prc_expiry_date DATE,
    FOREIGN KEY (employee_id) REFERENCES employees(id) ON DELETE CASCADE
);



CREATE TABLE residential_add (
    id INT AUTO_INCREMENT PRIMARY key,
    employee_id INT NOT NULL,
    street VARCHAR(255),
    sub VARCHAR(255),
    brgy VARCHAR(255),
    city VARCHAR(255),
    province VARCHAR(255),
    zip_code VARCHAR(255)   
);

CREATE TABLE permanent_add (
    id INT AUTO_INCREMENT PRIMARY key,
    employee_id INT NOT NULL,
    street VARCHAR(255),
    sub VARCHAR(255),
    brgy VARCHAR(255),
    city VARCHAR(255),
    province VARCHAR(255),
    zip_code VARCHAR(255)   
);

CREATE TABLE family_background (
    id INT AUTO_INCREMENT PRIMARY key,
    employee_id INT NOT NULL,
    spouse_sname VARCHAR(255),
    spouse_fname VARCHAR(255), 
    spouse_mname VARCHAR(255),
    spouse_extname VARCHAR(255),
    spouse_occupation VARCHAR(255),
    spouse_business VARCHAR(255),
    business_add VARCHAR(255),
    tel VARCHAR(255)
);

CREATE TABLE children_info (
    id INT AUTO_INCREMENT PRIMARY key,
    employee_id INT NOT NULL,
    c_fulname VARCHAR(255),
    date_b DATE
);

CREATE TABLE educational_background (
    id INT AUTO_INCREMENT PRIMARY key,
    employee_id INT NOT NULL,
   level_type INT NOT NULL,
   scholl_name VARCHAR(255),
   course VARCHAR(255),
   attemdance VARCHAR(255),
   units_earned VARCHAR(255),
   year_graduated DATE,
   hours VARCHAR(255)

);

CREATE TABLE personal_info (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employee_no VARCHAR(50) NOT NULL,
    csc VARCHAR(255) NOT NULL,
    sname VARCHAR(255) NOT NULL,
    fname VARCHAR(255) NOT NULL,
    mname VARCHAR(255),
    extension VARCHAR(10),
    datebirth DATE,
    placebirth VARCHAR(255),
    sex ENUM('Male', 'Female'),
    status ENUM('Single', 'Married', 'Widowed', 'Separated', 'Other'),
    height DECIMAL(5,2),
    weight DECIMAL(5,2),
    bloodtype VARCHAR(10),
    gsis_id VARCHAR(50),
    pagibig_id VARCHAR(50),
    philhealth_id VARCHAR(50),
    sss_id VARCHAR(50),
    tin_id VARCHAR(50),
    citizenship ENUM('Filipin', 'Dual Citizenship', 'By Birth', 'By Naturalization'),
    country VARCHAR(255),
    resAdd VARCHAR(255),
    street VARCHAR(255),
    subdivision VARCHAR(255),
    barangay VARCHAR(255),
    city VARCHAR(255),
    province VARCHAR(255),
    zipcode VARCHAR(20),
    permaAdd VARCHAR(255),
    permaStreet VARCHAR(255),
    permaSub VARCHAR(255),
    permaBarangay VARCHAR(255),
    permaCity VARCHAR(255),
    permaProvince VARCHAR(255),
    permaZip VARCHAR(20),
    telno VARCHAR(15),
    mobileno VARCHAR(15),
    email VARCHAR(255)
);

CREATE TABLE family_info (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employee_no VARCHAR(255),
    spouse_sname VARCHAR(255),
    spouse_fname VARCHAR(255),
    spouse_mname VARCHAR(255),
    spouse_ext VARCHAR(50),
    occupation VARCHAR(255),
    bussAdd VARCHAR(255),
    telephone VARCHAR(50),
    father_sname VARCHAR(255),
    father_fname VARCHAR(255),
    father_mname VARCHAR(255),
    mothers_sname VARCHAR(255),
    mothers_fname VARCHAR(255),
    mothers_mname VARCHAR(255),
    child_name VARCHAR(255),
    child_birth DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
