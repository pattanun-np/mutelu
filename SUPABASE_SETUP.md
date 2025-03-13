# Supabase Storage Setup for Sacred Places

This document provides instructions on how to set up Supabase Storage for the Sacred Places application.

## Prerequisites

1. A Supabase account (sign up at [supabase.com](https://supabase.com))
2. A Supabase project created

## Setup Steps

### 1. Create a Storage Bucket

1. Log in to your Supabase dashboard
2. Navigate to the "Storage" section in the sidebar
3. Click "Create a new bucket"
4. Name the bucket `sacredplaces` (or choose your own name, but remember to update the `.env` file)
5. Set the bucket's privacy to "Public" to allow public access to the images

### 2. Configure Bucket Policies

1. Click on the newly created bucket
2. Go to the "Policies" tab
3. Create the following policies:

#### For Public Access to Images

1. Click "Add Policy"
2. Select "Custom Policy"
3. Use the following settings:
   - Name: `Public Read Access`
   - Allowed operations: `SELECT`
   - Policy definition: `true` (allows anyone to read files)
   - Click "Save"

#### For Authenticated Uploads

1. Click "Add Policy"
2. Select "Custom Policy"
3. Use the following settings:
   - Name: `Authenticated Upload Access`
   - Allowed operations: `INSERT`
   - Policy definition: `auth.role() = 'authenticated'` (only authenticated users can upload)
   - Click "Save"

#### For Authenticated Updates/Deletes

1. Click "Add Policy"
2. Select "Custom Policy"
3. Use the following settings:
   - Name: `Authenticated Update/Delete Access`
   - Allowed operations: `UPDATE, DELETE`
   - Policy definition: `auth.role() = 'authenticated'` (only authenticated users can update/delete)
   - Click "Save"

### 3. Get API Keys

1. Go to the "Settings" section in the sidebar
2. Click on "API" in the submenu
3. Copy the following values:
   - URL: Your project URL (e.g., `https://xyzproject.supabase.co`)
   - `anon` public key (for client-side access)
   - `service_role` key (for server-side access, keep this secret!)

### 4. Update Environment Variables

Add the following variables to your `.env` file:

```
SUPABASE_URL=your_project_url
SUPABASE_KEY=your_service_role_key
SUPABASE_BUCKET=sacredplaces
```

## Testing the Setup

After completing the setup, you should be able to:

1. Upload images when creating a new sacred place
2. View the images on the sacred place details page
3. Update images when editing a sacred place
4. Delete images when deleting a sacred place

## Troubleshooting

If you encounter issues:

1. Check that your bucket policies are correctly set
2. Verify that your environment variables are correctly configured
3. Check the Laravel logs for any error messages
4. Ensure that the Supabase service provider is registered in `config/app.php`

## Additional Resources

- [Supabase Storage Documentation](https://supabase.com/docs/guides/storage)
- [Laravel HTTP Client Documentation](https://laravel.com/docs/http-client) (used for API requests to Supabase) 