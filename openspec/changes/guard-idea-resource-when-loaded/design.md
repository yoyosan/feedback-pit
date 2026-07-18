## Context

`IdeaResource` lines 25-26 access `$this->voters->contains(...)` and `$this->subscribers->contains(...)` as direct property access. In Laravel, accessing an unloaded relationship as a property triggers a lazy query. Every controller that uses `IdeaResource` must currently remember to eager-load these two relationships — a fragile contract.

Other relationships in the same resource (`user`, `latestStatusUpdate`, `statusUpdates`) already use `whenLoaded()` guards. The `voters` and `subscribers` accesses are the only unguarded ones.

## Goals / Non-Goals

**Goals:**
- Make `IdeaResource` safe to use without pre-loading `voters` and `subscribers`
- Default to `false` when the relationship isn't loaded (user hasn't voted/subscribed)
- Fix the existing bug in `UnsubscribeController`

**Non-Goals:**
- Changing how eager loading works in controllers that already do it correctly
- Optimizing the eager loading strategy (e.g., switching to `withExists`)
- Adding `whenLoaded` to other resources (they're already guarded)

## Decisions

**Guard with `relationLoaded()`**: Check if the relationship is loaded before accessing it. If not loaded, return `false`. This is the same pattern the resource already uses for other relationships via `whenLoaded()`.

```php
'has_voted' => $user && $this->relationLoaded('voters')
    ? $this->voters->contains('id', $user->id)
    : false,
```

**Keep eager loading in existing controllers**: Controllers that already load `voters` and `subscribers` (DashboardController, IdeaController, IdeaDetailController, IdeaDashboardController) continue to do so — the resource just won't break if they don't.

**Fix UnsubscribeController**: Add `$idea->load(['voters:id', 'subscribers:id'])` before creating the resource, since this controller currently triggers the lazy load.

## Risks / Trade-offs

- **Silent fallback to `false`**: If a controller genuinely needs `has_voted` or `is_subscribed` but forgets to eager-load, it will silently return `false` instead of triggering an error. This is acceptable because the alternative (N+1 queries) is worse, and the existing controllers already load these correctly.
