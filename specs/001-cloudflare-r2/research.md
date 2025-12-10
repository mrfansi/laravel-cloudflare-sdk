# Research: R2 Implementation Details

## Dependency Injection Strategy (DIP)

**Decision**: Use a main `R2Client` factory class that is bound in the Service Provider. Sub-services (`R2BucketService`, etc.) are instantiated by `R2Client` passing the authenticated `PendingRequest`.

**Rationale**:

-   **Strict DIP**: Services don't depend on the global `Cloudflare` facade or container. They just need an `Http` client.
-   **Testability**: Easy to mock the HTTP client in unit tests without booting the full Laravel app.
-   **Scalability**: `R2Client` acts as the entry point (Aggregate Root for the R2 domain), keeping the main ServiceProvider clean.

**Alternatives Considered**:

-   _Injecting everything in ServiceProvider_: Too messy as the SDK grows.
-   _Static Facade Calls inside Services_: Violates DIP/Testability principles of the Constitution.

## R2 API Structures

**Research**: Validated JSON schemas for CORS and Lifecycle.

-   **CORS**: Requires `AllowedOrigins`, `AllowedMethods` (GET, PUT, etc.), `MaxAgeSeconds`.
-   **Lifecycle**: Requires `Rules` array with `ID`, `Status` (Enabled/Disabled), `Filter` (Prefix), and `Expiration/Transition` actions.

**Decision**: Create strict DTOs (`CorsPolicy`, `LifecycleRule`) that map 1:1 to these schemas to prevent invalid configuration errors (EC-004).
