## 1. IdeaResource

- [ ] 1.1 Guard `has_voted` with `relationLoaded('voters')` check, default to `false`
- [ ] 1.2 Guard `is_subscribed` with `relationLoaded('subscribers')` check, default to `false`

## 2. UnsubscribeController

- [ ] 2.1 Add `$idea->load(['voters:id', 'subscribers:id'])` before creating the resource

## 3. Verification

- [ ] 3.1 Run `composer lint` and fix any issues
- [ ] 3.2 Run `composer analyse` and fix any issues
- [ ] 3.3 Run `composer test` and fix any issues
