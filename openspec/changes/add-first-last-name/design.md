## Context

The user model currently stores a single `name` string column. This field is used throughout the application: in the Fortify registration and profile update actions, in the `UserResource` shared via Inertia, in the `avatarUrl()` method, and across 9 Vue components for display purposes.

The current `name` field limits the ability to address users by last name, sort alphabetically by surname, or integrate with external systems expecting separate name components.

## Goals / Non-Goals

**Goals:**
- Replace the single `name` column with `first_name` and `last_name` columns
- Provide a computed `full_name` accessor for backward compatibility in display contexts
- Update all layers: database, model, Fortify actions, API resources, and frontend
- Maintain data integrity by backfilling existing names during migration

**Non-Goals:**
- Adding middle name or suffix/prefix fields
- Supporting multiple name formats (e.g., mononyms,CJK names) — we assume Western name order
- Changing the avatar URL generation strategy (just updating the source field)

## Decisions

**Add new columns and remove old `name` column**: Rather than keeping `name` alongside new columns, we do a clean replacement. The migration will add `first_name` and `last_name`, backfill from `name` (splitting on the first space), then drop `name`. This avoids data duplication and confusion about which field is authoritative.

**Expose `full_name` in UserResource**: Add a `fullName()` method on the model that concatenates `first_name` and `last_name`. The resource will expose `first_name`, `last_name`, and `full_name` (via `$this->fullName()`). Vue components that currently display `user.name` will switch to `user.full_name`, minimizing logic changes in the frontend. Using a method instead of an accessor avoids serialization surprises, naming conflicts, and keeps the computed value explicit.

**Backfill strategy**: Split existing `name` on the first space: everything before becomes `first_name`, everything after becomes `last_name`. Users with single-word names get an empty `last_name` (acceptable since `last_name` is not nullable but will be empty string). Alternative: make `last_name` nullable — but empty string is simpler and avoids null checks everywhere.

**Two separate inputs in forms**: Registration and account settings will show two inputs (First name, Last name) instead of one. Both are required.

## Risks / Trade-offs

- **Single-word names**: Users whose current `name` has no space will get an empty `last_name`. This is acceptable; they can update it later.
- **Frontend churn**: 9 Vue files reference `user.name`. Switching to `user.full_name` is a mechanical find-and-replace, but it touches many files.
- **Migration rollback**: The migration is destructive (drops `name` column). The `down()` method will re-add `name` and backfill from `first_name . ' ' . last_name`, but any data in `last_name` that came from multi-word last names will be merged back imperfectly.

## Migration Plan

1. Create migration: add `first_name` and `last_name` columns (both string, non-nullable, default empty string)
2. Backfill: `UPDATE users SET first_name = SUBSTRING_INDEX(name, ' ', 1), last_name = SUBSTRING(name, LOCATE(' ', name) + 1)`
3. Drop `name` column
4. Deploy and verify

**Rollback**: The `down()` method re-adds `name`, backfills from `first_name . ' ' . last_name`, then drops `first_name` and `last_name`.

## Open Questions

(none)
