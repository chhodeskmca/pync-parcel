Summary of Changes Made to Handle Webhook Data Gracefully:

1. Fixed customer-view.php:
   - Changed query from 'pre_alert' table to 'packages' table to fetch packages correctly.

2. Fixed codes.php in admin-dashboard:
   - Corrected column name from 'add_new_credit' to 'amount' in the UPDATE query for credit updates.

3. Enhanced warehouse_api.php webhook handler:
   - Added support for all events: package.created, package.updated, package.deleted, package.added.to.shipment, package.removed.from.shipment, package.change.ownership, shipment.created, shipment.updated, shipment.deleted
   - Implemented processing functions for each event with proper validation, error logging, and database operations
   - Added checks for database connection, empty payload, invalid JSON
   - Fixed data type handling for shipment_id and other fields (using strings for UUIDs)
   - Added support for data sent via GET with 'data' query parameter as fallback
   - Ensured graceful handling with appropriate HTTP status codes and error messages

The webhook now receives data from the external system, validates it, and stores/updates the respective tables (packages and shipments) based on the event type.
   