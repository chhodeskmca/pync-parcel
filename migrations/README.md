This folder contains SQL migrations you can run against your MySQL database.

001_add_payment_status.sql
- Adds a `payment_status` VARCHAR(20) column to the `packages` table (default 'Pending').

How to run (locally):
1. Backup your DB first.
2. From terminal (using mysql client):

   mysql -u <user> -p <database> < migrations/001_add_payment_status.sql

Or execute the ALTER TABLE statement in your DB GUI.

Notes:
- The web endpoint `update_payment_status.php` tries to ALTER TABLE at runtime for convenience but it's safer to run the migration above.
- If your MySQL version does not support `ADD COLUMN IF NOT EXISTS`, running the migration explicitly is recommended.
