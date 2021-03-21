ALTER TABLE core.users
    DROP COLUMN gender;

DROP TYPE IF EXISTS core.gender_enum;
