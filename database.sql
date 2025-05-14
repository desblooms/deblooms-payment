-- Create database
CREATE DATABASE IF NOT EXISTS payment_status_platform;
USE payment_status_platform;

-- Create users table
CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  user_type ENUM('admin', 'client') NOT NULL DEFAULT 'client',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create clients table
CREATE TABLE IF NOT EXISTS clients (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  phone VARCHAR(20),
  address TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create projects table
CREATE TABLE IF NOT EXISTS projects (
  id INT AUTO_INCREMENT PRIMARY KEY,
  client_id INT NOT NULL,
  name VARCHAR(100) NOT NULL,
  description TEXT,
  amount DECIMAL(10,2) NOT NULL,
  payment_status ENUM('paid', 'pending', 'overdue') NOT NULL DEFAULT 'pending',
  start_date DATE,
  due_date DATE NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (client_id) REFERENCES clients(id) ON DELETE CASCADE
);

-- Create payments table
CREATE TABLE IF NOT EXISTS payments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  project_id INT NOT NULL,
  amount DECIMAL(10,2) NOT NULL,
  payment_date DATE NOT NULL,
  payment_method VARCHAR(50),
  transaction_id VARCHAR(100),
  notes TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE
);

-- Create invoices table
CREATE TABLE IF NOT EXISTS invoices (
  id INT AUTO_INCREMENT PRIMARY KEY,
  project_id INT NOT NULL,
  invoice_number VARCHAR(50) NOT NULL UNIQUE,
  issue_date DATE NOT NULL,
  due_date DATE NOT NULL,
  subtotal DECIMAL(10,2) NOT NULL,
  tax_amount DECIMAL(10,2) DEFAULT 0.00,
  discount_amount DECIMAL(10,2) DEFAULT 0.00,
  total_amount DECIMAL(10,2) NOT NULL,
  status ENUM('paid', 'pending', 'overdue') NOT NULL DEFAULT 'pending',
  notes TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE
);

-- Create invoice_items table
CREATE TABLE IF NOT EXISTS invoice_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  invoice_id INT NOT NULL,
  description VARCHAR(255) NOT NULL,
  quantity INT NOT NULL DEFAULT 1,
  unit_price DECIMAL(10,2) NOT NULL,
  total_price DECIMAL(10,2) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (invoice_id) REFERENCES invoices(id) ON DELETE CASCADE
);

-- Create notifications table
CREATE TABLE IF NOT EXISTS notifications (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  title VARCHAR(255) NOT NULL,
  message TEXT NOT NULL,
  is_read BOOLEAN DEFAULT FALSE,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Insert default admin user (password: admin123)
INSERT INTO users (username, password, email, user_type) VALUES 
('admin', '$2y$10$8tPJXX8MwVRFYUwHbP4UJ.jyW6IgIWJw5mQYYIgQ2UwP2U5.fgiie', 'admin@example.com', 'admin');

-- Sample data: Insert clients
INSERT INTO clients (name, email, phone, address) VALUES
('Acme Corporation', 'contact@acmecorp.com', '123-456-7890', '123 Business Ave, Business City, 12345'),
('Globex Industries', 'info@globex.com', '987-654-3210', '456 Corporate Blvd, Enterprise City, 67890'),
('Smith & Associates', 'hello@smithassoc.com', '555-123-4567', '789 Consultant St, Consulting Town, 54321');

-- Link client accounts to users
INSERT INTO users (username, password, email, user_type) VALUES
('acmecorp', '$2y$10$8tPJXX8MwVRFYUwHbP4UJ.jyW6IgIWJw5mQYYIgQ2UwP2U5.fgiie', 'contact@acmecorp.com', 'client'),
('globex', '$2y$10$8tPJXX8MwVRFYUwHbP4UJ.jyW6IgIWJw5mQYYIgQ2UwP2U5.fgiie', 'info@globex.com', 'client'),
('smithassoc', '$2y$10$8tPJXX8MwVRFYUwHbP4UJ.jyW6IgIWJw5mQYYIgQ2UwP2U5.fgiie', 'hello@smithassoc.com', 'client');

-- Sample data: Insert projects
INSERT INTO projects (client_id, name, description, amount, payment_status, start_date, due_date) VALUES
(1, 'Website Redesign', 'Complete overhaul of company website with responsive design', 5000.00, 'pending', '2025-04-01', '2025-06-15'),
(1, 'Logo Design', 'New logo and brand identity design', 1200.00, 'paid', '2025-03-15', '2025-04-15'),
(2, 'E-commerce Platform', 'Development of online store with payment processing', 8500.00, 'pending', '2025-04-10', '2025-07-10'),
(3, 'Marketing Campaign', 'Digital marketing campaign for product launch', 3500.00, 'overdue', '2025-02-01', '2025-05-01');

-- Sample data: Insert payments
INSERT INTO payments (project_id, amount, payment_date, payment_method, transaction_id, notes) VALUES
(2, 1200.00, '2025-04-10', 'Credit Card', 'TXN123456', 'Full payment received'),
(3, 4250.00, '2025-04-30', 'Bank Transfer', 'BNK987654', '50% down payment');

-- Sample data: Insert invoices
INSERT INTO invoices (project_id, invoice_number, issue_date, due_date, subtotal, tax_amount, total_amount, status) VALUES
(1, 'INV-2025-001', '2025-04-01', '2025-05-01', 5000.00, 250.00, 5250.00, 'pending'),
(2, 'INV-2025-002', '2025-03-15', '2025-04-15', 1200.00, 60.00, 1260.00, 'paid'),
(3, 'INV-2025-003', '2025-04-10', '2025-05-10', 8500.00, 425.00, 8925.00, 'pending'),
(4, 'INV-2025-004', '2025-02-01', '2025-03-01', 3500.00, 175.00, 3675.00, 'overdue');

-- Sample data: Insert invoice items
INSERT INTO invoice_items (invoice_id, description, quantity, unit_price, total_price) VALUES
(1, 'Website Design and Development', 1, 3500.00, 3500.00),
(1, 'Content Migration', 1, 1000.00, 1000.00),
(1, 'SEO Setup', 1, 500.00, 500.00),
(2, 'Logo Design Package', 1, 1200.00, 1200.00),
(3, 'E-commerce Platform Development', 1, 6500.00, 6500.00),
(3, 'Payment Gateway Integration', 1, 1000.00, 1000.00),
(3, 'Product Import and Setup', 1, 1000.00, 1000.00),
(4, 'Social Media Campaign', 1, 2000.00, 2000.00),
(4, 'Google Ads Management', 1, 1500.00, 1500.00);

-- Sample notifications
INSERT INTO notifications (user_id, title, message, is_read) VALUES
(2, 'Payment Received', 'We have received your payment for Invoice #INV-2025-002. Thank you!', false),
(3, 'Payment Due', 'Reminder: Payment for Invoice #INV-2025-003 is due in 10 days.', false),
(4, 'Payment Overdue', 'Your payment for Invoice #INV-2025-004 is overdue. Please make payment as soon as possible.', false);