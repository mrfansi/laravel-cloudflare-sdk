# Feature Specification: Cloudflare R2 Integration

**Feature Branch**: `001-cloudflare-r2`
**Created**: 2025-12-10
**Status**: Draft
**Input**: User description: "implementing https://developers.cloudflare.com/api/resources/r2/"

## Clarifications

### Session 2025-12-10

-   Q: How should the SDK handle listing when a user has many buckets? → A: **Return a Paginator/Cursor Object** - Returns an object allowing iteration or fetching next pages (e.g. `next()` method).
-   Q: How should the SDK handle location placement for new buckets? → A: **Optional Parameter** - `create([...])` accepts an optional `location` key. Defaults to 'auto' if omitted.
-   Q: Should domain management be a method on the Bucket service? → A: **Nested Accessor** - `Cloudflare::r2()->buckets()->domains($bucketName)->list()` keeps the API hierarchy intuitive.

## User Scenarios & Testing _(mandatory)_

### User Story 1 - Bucket Management (Priority: P1)

As a developer, I want to create, list, and manage R2 buckets programmatically so that I can automate resource provisioning.

**Why this priority**: Buckets are the fundamental container for R2. No other operations are possible without buckets.

**Independent Test**: Can be fully tested by creating a bucket, listing it to verify existence, retrieving its details, and then deleting it.

**Acceptance Scenarios**:

1. **Given** valid credentials, **When** I call `Cloudflare::r2()->buckets()->list()`, **Then** I receive a `CursorPaginator` object containing a collection of buckets and a cursor for the next page.
2. **Given** a unique bucket name, **When** I call `create(['name' => 'unique-bucket', 'location' => 'wnam'])`, **Then** the bucket is created in that region.
3. **Given** an existing bucket, **When** I call `delete('bucket-name')`, **Then** the bucket is removed.

---

### User Story 2 - Bucket Configuration (CORS & Lifecycle) (Priority: P2)

As a developer, I want to configure CORS policies and Lifecycle rules for my buckets so that I can control access and simple data retention.

**Why this priority**: Essential for web-facing applications (CORS) and cost management (Lifecycle).

**Independent Test**: Create a bucket, apply a CORS policy, verify it via API, then remove it.

**Acceptance Scenarios**:

1. **Given** a bucket, **When** I call `updateCors($bucket, $rules)`, **Then** the CORS policy is applied.
2. **Given** a bucket, **When** I call `getLifecycle($bucket)`, **Then** I receive the current lifecycle rules.

---

### User Story 3 - Custom Domains (Priority: P3)

As a developer, I want to connect custom domains to my R2 buckets so that I can serve content from my own brand.

**Why this priority**: Important for public production usage but not critical for backend storage operations.

**Independent Test**: Register a custom domain for a bucket and verify the mapping.

**Acceptance Scenarios**:

1. **Given** a bucket and a domain in my zone, **When** I call `Cloudflare::r2()->buckets()->domains($bucket)->add('cdn.example.com')`, **Then** the domain serves the bucket content.

## Requirements _(mandatory)_

### Functional Requirements

-   **FR-001**: System MUST allow users to List (with cursor-based pagination), Create, Get, and Delete R2 buckets.
-   **FR-002**: System MUST allow users to Get, Set, and Delete CORS policies for buckets.
-   **FR-003**: System MUST allow users to Get and Set object lifecycle rules for buckets.
-   **FR-004**: System MUST allow users to manage Custom and Managed domain mappings via a nested service accessor (e.g., `buckets()->domains($b)`).
-   **FR-005**: API responses MUST be transformed into structured data collections or objects, not raw JSON arrays.
-   **FR-006**: All R2 features MUST be accessible via a unified entry point (e.g., standard SDK facade).

### Edge Cases

-   **EC-001**: **Bucket Not Found**: Attempting to access a non-existent bucket should raise a specific `NotFound` exception.
-   **EC-002**: **Invalid Credentials**: Authentication failures should raise a clear `AuthenticationException`.
-   **EC-003**: **Name Conflict**: Creating a bucket with an existing name should raise a `BucketAlreadyExists` exception.
-   **EC-004**: **Invalid Configuration**: Setting a malformed CORS policy or Lifecycle rule should be caught before sending to API if possible, or handle the API bad request error gracefully.

### Key Entities

-   **Bucket**: Represents an R2 bucket (Name, CreationDate, Location).
-   **CorsPolicy**: Represents cross-origin resource sharing rules.
-   **LifecycleRule**: Represents object expiration/transition rules.
-   **Domain**: Represents a custom or managed domain mapping.

## Success Criteria _(mandatory)_

### Measurable Outcomes

-   **SC-001**: Developers can perform full CRUD on R2 Buckets using the SDK methods.
-   **SC-002**: CORS and Lifecycle configurations can be applied to buckets without raw JSON manipulation.
-   **SC-003**: 100% of implemented R2 services return strongly typed responses or Collections.
-   **SC-004**: The implementation adheres to the Modular & SOLID principles defined in the Constitution (Constitution Check).
