-- Admin User Setup for Pync Parcel Chateau
-- This script creates a default admin user

USE freela53_pyncparcelchateau;

-- Insert admin user into users table
-- Password is hashed using PHP password_hash() with PASSWORD_DEFAULT (bcrypt)
-- Default password: admin123 (you should change this after first login)
INSERT INTO users (first_name, last_name, email_address, password_hash, phone_number, address_line1, role_as) VALUES
('Admin', 'User', 'admin-ppc@pyncparcel.com', '$2y$10$RpzUk.ZhKMcbNYysNcPPFOrLBBL6FldHGptXJrJHqPl9GFBQV0mCy', '+1-123-456-7890', '123 Admin Street, Miami, FL', 1)
ON DUPLICATE KEY UPDATE
    first_name = VALUES(first_name),
    last_name = VALUES(last_name),
    password_hash = VALUES(password_hash),
    phone_number = VALUES(phone_number),
    address_line1 = VALUES(address_line1),
    role_as = VALUES(role_as);

-- Get the admin user ID
SET @admin_user_id = (SELECT id FROM users WHERE email_address = 'admin-ppc@pyncparcel.com' LIMIT 1);

-- Insert into authorized_users table
INSERT INTO authorized_users (user_id, role) VALUES
(@admin_user_id, 'admin')
ON DUPLICATE KEY UPDATE
    role = VALUES(role);

-- Initialize admin balance
INSERT INTO balance (user_id, amount, currency) VALUES
(@admin_user_id, 0.00, 'USD')
ON DUPLICATE KEY UPDATE
    amount = VALUES(amount),
    currency = VALUES(currency);

-- Display success message
SELECT 'Admin user setup completed successfully!' as Status,
       @admin_user_id as Admin_User_ID,
       'admin-ppc@pyncparcel.com' as Admin_Email,
       'Admin@123' as Default_Password;
