---
description: "Task list for R2 feature implementation"
---

# Tasks: Cloudflare R2 Integration

**Input**: Design documents from `/specs/001-cloudflare-r2/`
**Prerequisites**: plan.md (required), spec.md (required), research.md

## Phase 1: Setup & Foundation

-   [ ] T001 Define DTOs (`Bucket`, `CorsPolicy`, `LifecycleRule`) in `src/Services/R2/Data/` <!-- id: 14 -->
-   [ ] T002 Implement `CursorPaginator` generic class in `src/Services/R2/Data/` <!-- id: 15 -->
-   [ ] T003 Create `R2Client` factory and register in ServiceProvider <!-- id: 16 -->

## Phase 2: Bucket Management (Priority: P1)

-   [ ] T004 Define `R2BucketService` class structure <!-- id: 17 -->
-   [ ] T005 Implement `list()` method with cursor pagination <!-- id: 18 -->
-   [ ] T006 Implement `create()` method with location hint support <!-- id: 19 -->
-   [ ] T007 Implement `get()` and `delete()` methods <!-- id: 20 -->
-   [ ] T008 Register `buckets()` method in `R2Client` <!-- id: 21 -->
-   [ ] T009 Add Facade accessor `Cloudflare::r2()` <!-- id: 22 -->

## Phase 3: Configuration & Domains (Priority: P2/P3)

-   [ ] T010 Implement `R2CorsService` (get/update/delete) <!-- id: 23 -->
-   [ ] T011 Implement `R2LifecycleService` (get/update) <!-- id: 24 -->
-   [ ] T012 Implement `R2DomainService` (list/add/remove) <!-- id: 25 -->
-   [ ] T013 Connect sub-services to `R2Client` and `R2BucketService` <!-- id: 26 -->

## Phase 4: Testing & Polish

-   [ ] T014 Write Arch Tests: Ensure Services rely only on Contracts/HTTP <!-- id: 27 -->
-   [ ] T015 Write Feature Tests for Bucket CRUD <!-- id: 28 -->
-   [ ] T016 Write Feature Tests for CORS/Domains <!-- id: 29 -->
-   [ ] T017 Verify Quickstart code samples run correctly <!-- id: 30 -->
