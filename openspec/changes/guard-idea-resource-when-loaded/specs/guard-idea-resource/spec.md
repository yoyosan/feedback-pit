## ADDED Requirements

### Requirement: IdeaResource safely accesses voter and subscriber relationships
`IdeaResource` SHALL check if `voters` and `subscribers` relationships are loaded before accessing them. When not loaded, `has_voted` and `is_subscribed` SHALL default to `false`.

#### Scenario: Relationships are eager-loaded
- **WHEN** a controller passes an idea with `voters` and `subscribers` eager-loaded
- **THEN** `has_voted` and `is_subscribed` reflect the actual vote/subscription state

#### Scenario: Relationships are not eager-loaded
- **WHEN** a controller passes an idea without eager-loading `voters` or `subscribers`
- **THEN** `has_voted` and `is_subscribed` return `false` without triggering lazy queries
