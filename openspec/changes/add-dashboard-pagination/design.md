## Context

Both `DashboardController` and `IdeaDashboardController` use `->latest()->get()` to fetch all ideas. The frontend receives a flat array and renders a `v-for` loop with no pagination UI. There are no existing pagination components in the codebase.

Laravel's `->paginate()` returns a `LengthAwarePaginator` which serializes through Inertia as `{ data, links, meta }`. `IdeaResource::collection()` works with both `Collection` and `Paginator` — no changes needed to the resource.

## Goals / Non-Goals

**Goals:**
- Paginate the idea lists on the public dashboard and internal ideas page
- Use a reasonable page size (15 ideas per page)
- Provide Previous/Next and page number navigation
- Keep the implementation simple and consistent across both pages

**Non-Goals:**
- Infinite scroll or "load more" patterns
- Cursor-based pagination
- Filtering or sorting beyond the existing `latest()` order
- Paginating other list pages (notifications, comments) — those are smaller datasets

## Decisions

**Use Laravel's built-in `->paginate(15)`**: No custom pagination logic needed. Laravel's paginator handles the SQL (LIMIT/OFFSET), total count, and serialization. Inertia passes it through cleanly.

**Page size of 15**: A reasonable default that balances content density with load time. Not too many to overwhelm, not too few to require constant clicking.

**Simple Previous/Next + page numbers**: Use a straightforward pagination component with Previous/Next buttons and numbered page links. No jump-to-page or custom UI.

**Component approach**: Create a single `Pagination.vue` component that accepts the `links` array from the paginator. Both dashboard pages will use it.

## Risks / Trade-offs

- **OFFSET-based pagination**: Laravel's default paginator uses OFFSET, which can skip or duplicate items if data changes between page loads. Acceptable for a feedback board where real-time accuracy isn't critical.
- **Total count query**: `paginate()` runs a separate `COUNT(*)` query. For the ideas table this is fast, but worth noting.
- **Frontend prop shape change**: `ideas` changes from an array to an object with `.data`, `.links`, `.meta`. Existing `v-for="idea in ideas"` must become `v-for="idea in ideas.data"`.
