-- ===========================
-- 1. CREATE TABLES
-- ===========================

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    email_address VARCHAR(255) UNIQUE NOT NULL,
    phone_number VARCHAR(20),
    date_of_birth DATE,
    account_number VARCHAR(50),
    gender VARCHAR(10),
    file VARCHAR(255),
    address_type VARCHAR(50),
    parish VARCHAR(100),
    region VARCHAR(100),
    address_line1 TEXT,
    address_line2 TEXT,
    password_hash VARCHAR(255) NOT NULL,
    role_as INT DEFAULT 0,
    token_hash VARCHAR(255) DEFAULT NULL,
    token_expired_at DATETIME DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS delivery_preference (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    address_type VARCHAR(50),
    parish VARCHAR(100),
    region VARCHAR(100),
    address_line1 TEXT,
    address_line2 TEXT,
    create_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    -- FK will be added later
);

CREATE TABLE IF NOT EXISTS authorized_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    first_name VARCHAR(255),
    last_name VARCHAR(255),
    id_type VARCHAR(50),
    id_number VARCHAR(100),
    role VARCHAR(50) DEFAULT 'admin',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    -- FK will be added later
);

CREATE TABLE IF NOT EXISTS balance (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total_balance DECIMAL(10,2) DEFAULT 0.00,
    currency VARCHAR(10) DEFAULT 'USD',
    add_new_credit DECIMAL(10,2) DEFAULT 0.00,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    -- FK will be added later
);

CREATE TABLE IF NOT EXISTS pre_alert (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    tracking_number VARCHAR(255),
    describe_package TEXT,
    value_of_package DECIMAL(10,2),
    weight DECIMAL(10,2),
    quantity INT DEFAULT 1,
    status VARCHAR(50) DEFAULT 'pending',
    courier_company VARCHAR(100),
    merchant VARCHAR(255),
    invoice VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    -- FK will be added later
);

CREATE TABLE IF NOT EXISTS packages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tracking_number VARCHAR(50) NOT NULL UNIQUE,
    courier_company VARCHAR(100) DEFAULT NULL,
    describe_package TEXT DEFAULT NULL,
    user_id INT DEFAULT NULL,
    weight DECIMAL(10,2) DEFAULT NULL,
    weight_unit VARCHAR(10) DEFAULT 'lbs',
    value_of_package DECIMAL(10,2) DEFAULT NULL,
    currency VARCHAR(3) DEFAULT 'USD',
    status ENUM(
        'Received at Origin',
        'Preparing Shipment',
        'Shipped',
        'In Transit',
        'At Destination Port',
        'Processing at Customs',
        'Checking for Package',
        'At Sorting Facility',
        'Out for Delivery',
        'Ready for Pickup',
        'Scheduled for Delivery',
        'Delivered'
    ) DEFAULT 'Received at Origin',
    invoice_status ENUM('PENDING', 'PAID', 'OVERDUE') DEFAULT 'PENDING',
    invoice_number VARCHAR(50) DEFAULT NULL,
    invoice_total DECIMAL(10,2) DEFAULT NULL,
    shipment_id INT DEFAULT NULL,
    tracking_name VARCHAR(255) DEFAULT NULL,
    dim_length DECIMAL(10,2) DEFAULT NULL,
    dim_width DECIMAL(10,2) DEFAULT NULL,
    dim_height DECIMAL(10,2) DEFAULT NULL,
    shipment_status VARCHAR(100) DEFAULT NULL,
    shipment_type VARCHAR(100) DEFAULT NULL,
    branch VARCHAR(100) DEFAULT NULL,
    tag VARCHAR(100) DEFAULT NULL,
    courier_id VARCHAR(255) DEFAULT NULL,
    courier_customer_id VARCHAR(255) DEFAULT NULL,
    added_to_shipment_at TIMESTAMP DEFAULT NULL,
    shipment_simple_id VARCHAR(255) DEFAULT NULL,
    warehouse_package_id VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    KEY user_id (user_id),
    KEY shipment_id (shipment_id),
    KEY status (status),
    KEY courier_id (courier_id),
    KEY courier_customer_id (courier_customer_id),
    KEY shipment_simple_id (shipment_simple_id)
);

CREATE TABLE IF NOT EXISTS shipments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    shipment_number VARCHAR(50) NOT NULL UNIQUE,
    type VARCHAR(50) DEFAULT NULL,
    origin VARCHAR(255) DEFAULT NULL,
    destination VARCHAR(255) DEFAULT NULL,
    description TEXT DEFAULT NULL,
    gross_revenue DECIMAL(10,2) DEFAULT 0.00,
    total_packages INT DEFAULT 0,
    total_weight DECIMAL(10,2) DEFAULT 0.00,
    volume DECIMAL(10,2) DEFAULT 0.00,
    user_id INT DEFAULT NULL,
    departure_date DATE DEFAULT NULL,
    arrival_date DATE DEFAULT NULL,
    status ENUM(
        'Preparing',
        'Preparing Shipment',
        'Shipped',
        'In Transit',
        'At Destination Port',
        'Processing at Customs',
        'At Sorting Facility',
        'Ready for Pickup',
        'Delivered'
    ) DEFAULT 'Preparing',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    shipmentSimpleId VARCHAR(255) DEFAULT NULL,
    shipmentStatus VARCHAR(255) DEFAULT NULL,
    KEY user_id (user_id),
    KEY status (status),
    KEY shipmentSimpleId (shipmentSimpleId),
    KEY shipmentStatus (shipmentStatus)
);

CREATE TABLE IF NOT EXISTS shipment_packages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    shipment_id INT NOT NULL,
    package_id INT NOT NULL,
    type VARCHAR(50) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    KEY shipment_id (shipment_id),
    KEY package_id (package_id)
);

-- ===========================
-- 2. INSERT SAMPLE DATA
-- ===========================

-- ✅ Insert a dummy user first so customer_id=1 references are valid
INSERT INTO users (first_name, last_name, email_address, phone_number,account_number, password_hash, role_as)
VALUES ('Test', 'User', 'test-ppc@pyncparcel.com', '1234567890', 'QSL0113','$2y$10$RpzUk.ZhKMcbNYysNcPPFOrLBBL6FldHGptXJrJHqPl9GFBQV0mCy', 0);

INSERT INTO users (first_name, last_name, email_address, phone_number, password_hash, role_as)
VALUES ('Admin', 'User', 'admin-ppc@pyncparcel.com', '1234567890', '$2y$10$RpzUk.ZhKMcbNYysNcPPFOrLBBL6FldHGptXJrJHqPl9GFBQV0mCy', 1);

INSERT INTO shipments (shipment_number, type, origin, destination, status, description, gross_revenue, total_packages, total_weight, volume, created_at, shipmentSimpleId, shipmentStatus) VALUES
('038NA4KFTQPLOZN-HH96', 'Air', 'Half Tree (Drop Off)', 'Miami Warehouse', 'Preparing', 'N/A', 0.00, 0, 0.00, 0.00, '2025-07-25 10:10:00', '038NA4KFTQPLOZN-HH96', 'Preparing'),
('0H70-B6S23D0G132V06R', 'Air Express', 'May Pen (Plaza)', 'May Pen (Plaza)', 'Shipped', 'Sesha MBJ', 150.00, 2, 8.50, 1200.00, '2025-04-09 02:25:00', '0H70-B6S23D0G132V06R', 'Shipped'),
('WSUMBK0L05X0860-XE6R', 'Sea', 'Miami Warehouse', 'Montego Bay Fairview Branch', 'At Sorting Facility', 'Free me', 300.00, 5, 25.00, 45896.00, '2025-06-26 21:59:00', 'WSUMBK0L05X0860-XE6R', 'At Sorting Facility');

INSERT INTO packages (tracking_number, courier_company, describe_package, user_id, weight, value_of_package, status, invoice_status, invoice_number, invoice_total, shipment_id, created_at) VALUES
('76rt3276i45786324', 'FedEx', 'Laptop', 1, 6.00, 800.00, 'Delivered', 'PAID', 'N/A', 10.00, 3, '2025-04-29 22:43:00'),
('76rt3276i45786325', 'Amazon', 'Laptop', 1, 6.00, 750.00, 'Delivered', 'PAID', 'N/A', 10.00, 3, '2025-04-29 22:43:00'),
('76rt3276i45786326', 'UPS', 'Laptop', 1, 6.00, 900.00, 'Delivered', 'PAID', 'N/A', 10.00, 3, '2025-04-29 22:43:00');

INSERT INTO shipment_packages (shipment_id, package_id, type) VALUES
(3, 1, NULL),
(3, 2, NULL),
(3, 3, NULL);

-- ===========================
-- 3. ADD FOREIGN KEYS SAFELY
-- ===========================

ALTER TABLE delivery_preference
    ADD CONSTRAINT fk_delivery_preference_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE;

ALTER TABLE authorized_users
    ADD CONSTRAINT fk_authorized_users_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE;

ALTER TABLE balance
    ADD CONSTRAINT fk_balance_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE;

ALTER TABLE pre_alert
    ADD CONSTRAINT fk_pre_alert_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE;

ALTER TABLE packages
    ADD CONSTRAINT fk_packages_user FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT fk_packages_shipment FOREIGN KEY (shipment_id) REFERENCES shipments (id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE shipment_packages
    ADD CONSTRAINT fk_shipment_packages_shipment FOREIGN KEY (shipment_id) REFERENCES shipments (id) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT fk_shipment_packages_package FOREIGN KEY (package_id) REFERENCES packages (id) ON DELETE CASCADE ON UPDATE CASCADE;

-- ===========================
-- 4. ADD MISSING COLUMNS TO EXISTING TABLES
-- ===========================

-- Add token_hash and token_expired_at to users table if not exists
ALTER TABLE users ADD COLUMN IF NOT EXISTS token_hash VARCHAR(255) DEFAULT NULL;
ALTER TABLE users ADD COLUMN IF NOT EXISTS token_expired_at DATETIME DEFAULT NULL;
ALTER TABLE users ADD COLUMN warehouse_customer_id VARCHAR(255) DEFAULT NULL

-- Add new columns to packages table if not exists
ALTER TABLE packages ADD COLUMN IF NOT EXISTS courier_id VARCHAR(255) DEFAULT NULL;
ALTER TABLE packages ADD COLUMN IF NOT EXISTS courier_customer_id VARCHAR(255) DEFAULT NULL;
ALTER TABLE packages ADD COLUMN IF NOT EXISTS added_to_shipment_at TIMESTAMP DEFAULT NULL;
ALTER TABLE packages ADD COLUMN IF NOT EXISTS shipment_simple_id VARCHAR(255) DEFAULT NULL;
ALTER TABLE packages ADD COLUMN IF NOT EXISTS warehouse_package_id VARCHAR(255) DEFAULT NULL;
ALTER TABLE packages ADD COLUMN IF NOT EXISTS tracking_progress VARCHAR(255) DEFAULT NULL;
ALTER TABLE packages ADD COLUMN IF NOT EXISTS invoice_file VARCHAR(255) DEFAULT NULL;
ALTER TABLE packages ADD COLUMN store VARCHAR(255) DEFAULT '-' AFTER value_of_package;