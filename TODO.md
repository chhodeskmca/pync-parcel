# TODO: Make User Dashboard Dynamic

## Tasks
- [x] Add PHP code to user-dashboard/index.php to query packages table for user_id and count packages by status
- [x] Map package statuses to dashboard categories (e.g., 'Received at Origin' or 'At Sorting Facility' to 'Received at Warehouse', 'In Transit' to 'In transit to Jamaica', etc.)
- [x] Update the HTML in user-dashboard/index.php to display dynamic counts instead of static 0s
- [x] Test the changes to ensure correct data fetching and display

## Additional Tasks Completed
- [x] Fixed database schema by adding missing columns to packages table (tracking_name, dim_length, dim_width, dim_height, shipment_status, shipment_type, branch, tag)
- [x] Added "Pull Packages" functionality to user dashboard
  - Created user-dashboard/pull_packages.php to pull packages from warehouse API
  - Added "Pull Packages" button in user-dashboard/index.php
  - Updated user-dashboard/package.php to display packages from packages table instead of pre_alert, and added session message display for pull results
