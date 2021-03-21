CREATE TYPE core.gender_enum AS ENUM (
    'male', 'female'
);

ALTER TABLE core.users
    ADD COLUMN gender core.gender_enum;
