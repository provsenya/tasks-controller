USE testdb;

CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employee_name VARCHAR(100) NOT NULL,
    task_name VARCHAR(255) NOT NULL,
    status ENUM('new', 'in_progress', 'done') DEFAULT 'new',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
