## ADDED Requirements

### Requirement: Public dashboard displays paginated ideas
The public dashboard SHALL display ideas in pages of 15, ordered newest first, with pagination navigation below the list.

#### Scenario: First page of ideas
- **WHEN** a user visits the dashboard and there are 20 ideas
- **THEN** the page shows the 15 newest ideas and pagination controls indicating 2 pages

#### Scenario: Navigating to next page
- **WHEN** a user clicks the "Next" button on the pagination controls
- **THEN** the page shows the remaining 5 ideas

#### Scenario: Empty state with no ideas
- **WHEN** a user visits the dashboard and there are no ideas
- **THEN** the page shows an empty state message with no pagination controls

### Requirement: Internal ideas list displays paginated ideas
The internal ideas list SHALL display ideas in pages of 15, ordered newest first, with pagination navigation below the list.

#### Scenario: Internal page pagination
- **WHEN** a team member visits the internal ideas page and there are 30 ideas
- **THEN** the page shows 15 ideas with pagination indicating 2 pages

### Requirement: Pagination preserves query state
Pagination links SHALL preserve the current URL structure without adding unnecessary query parameters.

#### Scenario: Clean pagination URLs
- **WHEN** a user clicks page 2 on the dashboard
- **THEN** the URL changes to `/dashboard?page=2` and the page shows the next set of ideas
