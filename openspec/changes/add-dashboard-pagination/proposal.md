## Why

The public dashboard and internal ideas list load every idea from the database with `->latest()->get()` — no pagination, no limit. As the number of ideas grows, these pages will use increasing amounts of memory and database time. The dashboard is the most-visited page, so this is the highest-impact performance fix.

## What Changes

- Replace `->get()` with `->paginate()` in `DashboardController` and `IdeaDashboardController`
- Update `Dashboard.vue` and `Internal/Ideas/Index.vue` to iterate `ideas.data` instead of `ideas`
- Create a reusable `Pagination` component
- Add pagination links below the idea lists on both pages

## Capabilities

### New Capabilities

- `dashboard-pagination`: Paginated idea lists on the public dashboard and internal ideas page

### Modified Capabilities

(none — the data shape changes but the requirements don't)

## Impact

- `app/Http/Controllers/DashboardController.php` — swap `get()` for `paginate()`
- `app/Http/Controllers/Internal/IdeaDashboardController.php` — same
- `resources/js/Pages/Dashboard.vue` — update to use paginated data
- `resources/js/Pages/Internal/Ideas/Index.vue` — same
- `resources/js/Components/Pagination.vue` — new component (or use Inertia's built-in paginator)
