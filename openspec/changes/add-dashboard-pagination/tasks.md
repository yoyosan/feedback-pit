## 1. Backend

- [ ] 1.1 Update `DashboardController` to use `->paginate(15)` instead of `->get()`
- [ ] 1.2 Update `IdeaDashboardController` to use `->paginate(15)` instead of `->get()`

## 2. Frontend Component

- [ ] 2.1 Create `resources/js/Components/Pagination.vue` that renders Previous/Next and page number links from the `links` array

## 3. Frontend Pages

- [ ] 3.1 Update `Dashboard.vue` to iterate `ideas.data` and include the `Pagination` component
- [ ] 3.2 Update `Internal/Ideas/Index.vue` to iterate `ideas.data` and include the `Pagination` component

## 4. Verification

- [ ] 4.1 Run `composer lint` and fix any issues
- [ ] 4.2 Run `npm run lint:fix` and fix any issues
- [ ] 4.3 Run `composer analyse` and fix any issues
- [ ] 4.4 Run `composer test` and fix any issues
