# Data Model: Cloudflare R2

## Entities

### Bucket

Represents a storage container.

-   `name`: string (required, unique)
-   `creation_date`: timestamp (ISO 8601)
-   `location`: string (optional hint, e.g., 'wnam')

### CorsPolicy

Controls browser access to bucket.

-   `allowed_origins`: array (e.g., ["*"])
-   `allowed_methods`: array (e.g., ["GET", "PUT"])
-   `allowed_headers`: array (optional)
-   `max_age_seconds`: integer (optional)

### LifecycleRule

Auto-manages object retention/transition.

-   `id`: string (unique identifier)
-   `status`: enum ('Enabled', 'Disabled')
-   `prefix`: string (filter, optional)
-   `expiration`: object (days or date)
-   `abort_multipart_upload`: object (days after initiation)

### Domain

Public access configuration.

-   `domain`: string (e.g., 'cdn.example.com')
-   `enabled`: boolean
-   `type`: enum ('custom', 'managed')

## Usage

These entities are returned wrapped in `Illuminate\Support\Collection` for lists, or as standalone DTO instances.
