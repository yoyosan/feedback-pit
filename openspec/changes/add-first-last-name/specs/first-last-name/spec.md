## ADDED Requirements

### Requirement: User has first and last name fields
The user model SHALL have separate `first_name` and `last_name` string fields, both required and non-nullable.

#### Scenario: User is created with first and last name
- **WHEN** a new user registers with first name "Jane" and last name "Doe"
- **THEN** the user record stores `first_name = "Jane"` and `last_name = "Doe"`

### Requirement: Full name is computed from first and last name
The system SHALL provide a `fullName()` method that concatenates `first_name` and `last_name` separated by a space and returns the result.

#### Scenario: Full name method
- **WHEN** a user has `first_name = "Jane"` and `last_name = "Doe"`
- **THEN** `$user->fullName()` returns "Jane Doe"

### Requirement: Registration collects first and last name separately
The registration form SHALL display two separate input fields for first name and last name, both required.

#### Scenario: Successful registration with separate names
- **WHEN** a user submits the registration form with valid first name, last name, email, and password
- **THEN** a new user account is created with the provided first and last name

#### Scenario: Missing first name
- **WHEN** a user submits the registration form without a first name
- **THEN** the system rejects the submission with a validation error on the first name field

#### Scenario: Missing last name
- **WHEN** a user submits the registration form without a last name
- **THEN** the system rejects the submission with a validation error on the last name field

### Requirement: Account settings allows editing first and last name
The account settings page SHALL display two separate input fields for first name and last name, pre-populated with the current values.

#### Scenario: Update name in account settings
- **WHEN** a user changes both first and last name and submits the profile form
- **THEN** both fields are persisted and the displayed full name updates accordingly

#### Scenario: Validation errors on name fields
- **WHEN** a user submits the profile form with an empty first name or last name
- **THEN** the system rejects the submission with inline validation errors on the relevant field(s)

### Requirement: User resource exposes structured name fields
The `UserResource` SHALL expose `first_name`, `last_name`, and `full_name` fields (where `full_name` is computed via the `fullName()` method). It SHALL NOT expose a raw `name` field.

#### Scenario: API response includes structured name
- **WHEN** the authenticated user's profile is loaded via Inertia shared props
- **THEN** the `auth.user` object contains `first_name`, `last_name`, and `full_name` keys

### Requirement: Avatar URL uses full name
The `avatarUrl()` method SHALL use the computed full name to generate the avatar URL.

#### Scenario: Avatar URL reflects name change
- **WHEN** a user updates their first or last name
- **THEN** subsequent calls to `avatarUrl()` return a URL incorporating the new full name
