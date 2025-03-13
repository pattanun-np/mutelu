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

## Troubleshooting

If you encounter issues:

1. Make sure the database file exists and is writable
2. Check that SQLite support is enabled in PHP
3. Verify that the SQL statements in the `create_tables.sql` file are compatible with your version of SQLite

## Additional Resources

- [SQLite Documentation](https://www.sqlite.org/docs.html)
- [PHP PDO Documentation](https://www.php.net/manual/en/book.pdo.php) 