## Why

`IdeaResource` directly accesses `$this->voters` and `$this->subscribers` without checking if they're eager-loaded. This silently fires N+1 queries whenever a controller forgets to load these relationships. The `UnsubscribeController` already triggers this bug. Making the resource defensive prevents future N+1 issues from being introduced.

## What Changes

- Guard `has_voted` and `is_subscribed` in `IdeaResource` with `relationLoaded()` checks
- Return `false` as default when the relationship isn't loaded (safe fallback)
- Fix `UnsubscribeController` to eager-load the relationships before passing to the resource

## Capabilities

### New Capabilities

(none)

### Modified Capabilities

(none — the behavior stays the same, just making it N+1-safe)

## Impact

- `app/Http/Resources/IdeaResource.php` — guard two relationship accesses
- `app/Http/Controllers/UnsubscribeController.php` — add eager loading
