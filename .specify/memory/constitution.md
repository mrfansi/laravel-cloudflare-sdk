<!--
SYNC IMPACT REPORT
Version: 1.1.0 -> 1.2.0
Overview: Initial ratification of project constitution.
Principles:
- Added: Modularity & Service Isolation
- Added: Scalability via Contracts
- Added: Laravel Idiomatic & Readable
- Added: Testing & Type Safety
- Added: Consistency & Standardization
- Refined: Enforced SOLID Principles Pattern
Templates Update:
- ✅ plan-template.md (Generic "Constitution Check" compatible)
- ✅ spec-template.md (Compatible)
- ✅ tasks-template.md (Compatible)
-->

# Laravel Cloudflare SDK Constitution

<!-- Example: Spec Constitution, TaskFlow Constitution, etc. -->

## Core Principles

### I. Modularity & Service Isolation (SOLID: SRP, DIP)

<!-- Example: I. Library-First -->

Every Cloudflare API feature (e.g., DNS, Zones, Firewall) MUST be implemented as a standalone, self-contained service module following Single Responsibility and Dependency Inversion.

-   **Single Responsibility (SRP)**: Each service manages exactly one feature set. No God Classes.
-   **Directory Structure**: Organize services clearly (e.g., `src/Services/DNS/DNSRecordService.php`).
-   **Dependency Inversion (DIP)**: Services receive their dependencies (like the HTTP client) via interfaces/construction, not concrete global state.

### II. Scalability via Contracts (SOLID: OCP, LSP, ISP)

<!-- Example: II. CLI Interface -->

The architecture MUST support adding new Cloudflare endpoints without modifying existing core logic, adhering to Open/Closed, Liskov Substitution, and Interface Segregation.

-   **Open/Closed (OCP)**: Adding a new API group strictly requires adding a new Service class, not modifying the client core.
-   **Interface Segregation (ISP)**: Define focused interfaces for services. Clients shouldn't depend on methods they don't use.
-   **Liskov Substitution (LSP)**: Service implementations must be interchangeable if implementing a common interface.
-   **Future Proof**: Design with the assumption that Cloudflare will add more endpoints.

### III. Laravel Idiomatic & Readable

<!-- Example: III. Test-First (NON-NEGOTIABLE) -->

The SDK MUST feel native to Laravel developers.

-   **Facades**: Provide Facades for easy access (e.g., `Cloudflare::dns()->list()`).
-   **Fluent/Collections**: Return Laravel Collections instead of raw arrays where lists are involved.
-   **Naming**: Use verbose, clear method names (`createZone` vs `add`).
-   **Config**: Use `config/cloudflare.php` for all static configuration.

### IV. Testing & Type Safety (NON-NEGOTIABLE)

<!-- Example: IV. Integration Testing -->

Code quality is enforced via strict testing and static analysis.

-   **Pest Framework**: All tests MUST be written using Pest PHP.
-   **100% Coverage**: Aim for high test coverage; critical paths must be covered.
-   **Larastan/PHPStan**: Code must pass `max` level static analysis.
-   **Arch Tests**: Use Pest Architecture tests to enforce the modular structure (e.g., "Services must not depend on Controllers").

### V. Consistency & Standardization

<!-- Example: V. Consistency -->

The SDK MUST adhere to strict consistency across all features to reduce cognitive load.

-   **Uniform Signatures**: All services must use identical method signatures for similar actions (e.g., `list(array $params = [])`).
-   **Predictable Responses**: Methods usually return `Models` or `Collections`. Avoid returning raw API responses.
-   **Error Handling**: Use consistent exception types (e.g., `CloudflareSdkException`) across all services.

## Governance

<!-- Example: Constitution supersedes all other practices; Amendments require documentation, approval, migration plan -->

This Constitution governs the development of the Laravel Cloudflare SDK. It ensures that as the feature set grows, the package remains maintainable and developer-friendly.

-   **Amendments**: Changes to principles require a Pull Request updating this file and a version bump.
-   **Compliance**: Code Reviewers MUST reject PRs that violate Modularity or Readability principles.
-   **Verification**: New features must include proof of modular implementation (e.g., new Service class) and corresponding Tests.

**Version**: 1.2.0 | **Ratified**: 2025-12-10 | **Last Amended**: 2025-12-10

<!-- Example: Version: 2.1.1 | Ratified: 2025-06-13 | Last Amended: 2025-07-16 -->
