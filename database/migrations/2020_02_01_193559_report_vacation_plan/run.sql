create schema report;

CREATE TYPE report.enum_status AS ENUM (
    'saved', 'sent', 'approved', 'rejected'
);

CREATE TYPE report.enum_season AS ENUM (
    'winter', 'spring', 'summer', 'autumn'
);

CREATE TABLE report.vacation_plans (
    learning_stream_id UUID NOT NULL,
    year SMALLINT NOT NULL,
    season report.enum_season NOT NULL,
    status report.enum_status NOT NULL DEFAULT 'saved',
    data JSONB NOT NULL,
    moderated_at common.datetime,
    moderated_by UUID,
    reason TEXT,
    constraint vacation_plans_users_fk foreign key (user_id)
        references core.users(id)
        on delete no action
        on update cascade,
    constraint vacation_plans_users_moderated_by_fk foreign key (moderated_by)
        references core.users(id)
        on delete no action
        on update cascade,
    constraint vacation_plans_organizations_fk foreign key (organization_id)
        references core.organizations(id)
        on delete no action
        on update cascade,
    constraint vacation_plans_learning_streams_fk foreign key (learning_stream_id)
        references core.learning_streams(id)
        on delete no action
        on update cascade
) INHERITS (common.user_objects, common.organization_objects);
