## ADDED Requirements

### Requirement: User can request a magic link
The system SHALL provide a page at `/magic-link` where a user can enter their email address and receive a magic link email.

#### Scenario: Request magic link
- **WHEN** a user enters a valid email on the magic link page and submits the form
- **THEN** the system sends an email containing a magic link to that address and shows a confirmation message

#### Scenario: Rate limiting
- **WHEN** a user requests more than 3 magic links for the same email within 5 minutes
- **THEN** the system rejects the request with a rate limit error

### Requirement: Magic link logs in existing users
When an existing user clicks a valid magic link, the system SHALL log them in and redirect to the dashboard.

#### Scenario: Existing user clicks magic link
- **WHEN** an existing user clicks a valid, unexpired magic link
- **THEN** the user is authenticated and redirected to `/dashboard`

#### Scenario: Expired magic link
- **WHEN** a user clicks a magic link that was sent more than 15 minutes ago
- **THEN** the system rejects the link and redirects to `/magic-link` with an error

#### Scenario: Invalid magic link
- **WHEN** a user clicks a magic link with a tampered or invalid signature
- **THEN** the system rejects the link and redirects to `/magic-link` with an error

### Requirement: Magic link creates accounts for new users
When a new user (no existing account with that email) clicks a valid magic link, the system SHALL create an account with empty name fields and redirect to onboarding.

#### Scenario: New user clicks magic link
- **WHEN** a user with no existing account clicks a valid magic link
- **THEN** a new user account is created with empty `first_name` and `last_name`, email is auto-verified, and the user is redirected to `/onboarding`

### Requirement: New users complete their profile
The system SHALL redirect users with empty `first_name` to an onboarding page where they can enter their name.

#### Scenario: Onboarding page displayed
- **WHEN** a user with empty `first_name` navigates to any protected route
- **THEN** the system redirects them to `/onboarding`

#### Scenario: Profile completed
- **WHEN** a user enters their first and last name on the onboarding page and submits
- **THEN** the name is saved and the user is redirected to `/dashboard`

#### Scenario: Onboarding validation
- **WHEN** a user submits the onboarding form with an empty first name or last name
- **THEN** the system rejects the submission with a validation error

### Requirement: Registration redirects to magic link
The `/register` route SHALL redirect to `/magic-link`.

#### Scenario: Visit registration page
- **WHEN** a user navigates to `/register`
- **THEN** they are redirected to `/magic-link`

### Requirement: Login and magic link pages cross-link
The `/login` page SHALL link to `/magic-link`, and the `/magic-link` page SHALL link to `/login`.

#### Scenario: Login page links to magic link
- **WHEN** a user views the login page
- **THEN** they see a link to use magic link instead

#### Scenario: Magic link page links to login
- **WHEN** a user views the magic link page
- **THEN** they see a link to sign in with password instead
