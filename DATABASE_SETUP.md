# Database Setup Instructions

This document provides instructions on how to set up the database for the Sacred Places application.

## Prerequisites

1. PHP installed on your system
2. SQLite support enabled in PHP

## Setup Steps

### 1. Create the Database File

If you don't already have a SQLite database file, you can create one by running:

```bash
touch database/database.sqlite
```

### 2. Create the Tables

Run the following command to create the necessary tables:

```bash
php database/create_tables.php
```

This will create the following tables:
- `tags` - For storing tag information

### 3. Seed the Database with Sample Data

Run the following command to insert sample data:

```bash
php database/seed_data.php
```

This will insert:
- Sample tags (temple, church, mosque, shrine, historical, natural)
- Sample sacred places with their associated tags

## Manual Database Setup

If you prefer to set up the database manually, you can use the SQL statements in the `database/create_tables.sql` file. You can run these statements using any SQLite client, such as the SQLite command-line tool:

```bash
sqlite3 database/database.sqlite < database/create_tables.sql
```

## Image Handling with Spatie Media Library

We've transitioned from storing images directly in the database to using Spatie Media Library. Here are the key changes:

1. **Model Configuration**:
   - The `Sacredplace` model has been updated to use Spatie Media Library with the `InteractsWithMedia` trait
   - The `image` field is kept in the `$fillable` array to maintain compatibility with existing code

2. **Seeder Updates**:
   - The `SacredplaceSeeder` now downloads images from URLs and adds them to sacred places using Spatie Media Library
   - It sets a default value of 'placeholder.jpg' for the `image` column when creating sacred places
   - After adding media, it updates the `image` column with the URL from Spatie Media Library

3. **Migration Considerations**:
   - If you encounter NOT NULL constraint violations on the `image` column, you can either:
     - Make the `image` column nullable in a migration
     - Ensure the `image` column always has a value (our current approach)

4. **Benefits**:
   - Better image management with automatic conversions and responsive images
   - Improved storage options with configurable disk drivers
   - Simplified image manipulation and retrieval

For more details on how to use Spatie Media Library in your application, refer to the [official documentation](https://spatie.be/docs/laravel-medialibrary/v10/introduction).

## Troubleshooting

If you encounter issues:

1. Make sure the database file exists and is writable
2. Check that SQLite support is enabled in PHP
3. Verify that the SQL statements in the `create_tables.sql` file are compatible with your version of SQLite

## Additional Resources

- [SQLite Documentation](https://www.sqlite.org/docs.html)
- [PHP PDO Documentation](https://www.php.net/manual/en/book.pdo.php) 