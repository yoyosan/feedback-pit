## ADDED Requirements

### Requirement: Name field is displayed in account settings
The Account Settings page SHALL display the user's current name in a text input field, sourced from the shared `auth.user.name` value.

#### Scenario: Name input is pre-populated
- **WHEN** a user navigates to Account Settings
- **THEN** the name input shows their current name

### Requirement: User can update their name
The system SHALL allow users to update their name from the Account Settings page. The name SHALL be validated as required, string, and max 255 characters.

#### Scenario: Successful name update
- **WHEN** a user enters a valid name and submits the profile form
- **THEN** the name is persisted and the displayed name updates accordingly

#### Scenario: Empty name is rejected
- **WHEN** a user submits the profile form with an empty name
- **THEN** the system rejects the submission with an inline validation error on the name field

### Requirement: Name and email are submitted together
The profile form SHALL submit name and email in a single request to the existing profile update endpoint.

#### Scenario: Updating both name and email
- **WHEN** a user changes both name and email and submits the form
- **THEN** both fields are persisted in a single update
