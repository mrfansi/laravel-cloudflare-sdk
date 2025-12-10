<!--
SYNC IMPACT REPORT
Version: 0.0.0 -> 1.0.0
Overview: Initial ratification of project constitution.
Principles:
- Added: Modularity & Service Isolation
- Added: Scalability via Contracts
- Added: Laravel Idiomatic & Readable
- Added: Testing & Type Safety
Templates Update:
- ✅ plan-template.md (Generic "Constitution Check" compatible)
- ✅ spec-template.md (Compatible)
- ✅ tasks-template.md (Compatible)
-->

# Laravel Cloudflare SDK Constitution

<!-- Example: Spec Constitution, TaskFlow Constitution, etc. -->

## Core Principles

### I. Modularity & Service Isolation

<!-- Example: I. Library-First -->

Every Cloudflare API feature (e.g., DNS, Zones, Firewall) MUST be implemented as a standalone, self-contained service module.

-   **No God Classes**: Do not add all methods to the main SDK class.
-   **Directory Structure**: Organize services clearly (e.g., `src/Services/DNS/DNSRecordService.php`).
-   **Dependency Injection**: Services receive their dependencies (like the HTTP client) via construction, not global state.

### II. Scalability via Contracts

<!-- Example: II. CLI Interface -->

The architecture MUST support adding new Cloudflare endpoints without modifying existing core logic.

-   **Interfaces**: Define contracts for services where strict polymorphism is beneficial.
-   **Extensible**: Adding a new API group should only strictly require adding a new Service class and binding it.
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

## Governance

<!-- Example: Constitution supersedes all other practices; Amendments require documentation, approval, migration plan -->

This Constitution governs the development of the Laravel Cloudflare SDK. It ensures that as the feature set grows, the package remains maintainable and developer-friendly.

-   **Amendments**: Changes to principles require a Pull Request updating this file and a version bump.
-   **Compliance**: Code Reviewers MUST reject PRs that violate Modularity or Readability principles.
-   **Verification**: New features must include proof of modular implementation (e.g., new Service class) and corresponding Tests.

**Version**: 1.0.0 | **Ratified**: 2025-12-10 | **Last Amended**: 2025-12-10

<!-- Example: Version: 2.1.1 | Ratified: 2025-06-13 | Last Amended: 2025-07-16 -->
