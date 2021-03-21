create schema if not exists core;

create table core.password_resets (
    created_at common.datetime,
    token text not null primary key,
    email text not null
);

create index password_resets_email_idx on core.password_resets
    using btree (email);

create table core.users (
    name text not null,
    surname text not null,
    patronymic text,
    inn text,
    email text unique,
    email_verified_at common.datetime,
    phone text,
    password text,
    remember_token text,
    locale_id integer,
    superuser boolean,
    constraint users_pkey primary key(id)
) inherits (common.objects);

create table core.social_providers (
    driver text not null,
    class text,
    constraint social_providers_pkey primary key(id)
) inherits (common.enum_objects);

create table core.social_accounts (
    provider_id integer not null,
    provider_user text not null,
    name text not null,
    email text,
    avatar text,
    constraint social_accounts_pkey primary key(id),
    constraint social_accounts_users_fk foreign key (user_id)
        references core.users(id)
        on delete cascade
        on update cascade,
    constraint social_accounts_social_providers_fk foreign key (provider_id)
        references core.social_providers(id)
        on delete no action
        on update cascade
) inherits (common.user_objects);

create unique index social_accounts_provider_id_provider_user_idx on core.social_accounts
    using btree (provider_id, provider_user) where deleted_at is null;

create table core.family_ties (
    parent_id uuid not null,
    constraint family_ties_pkey primary key(id),
    constraint family_ties_users_fk foreign key (user_id)
        references core.users(id)
        on delete cascade
        on update cascade,
    constraint family_ties_users_parent_id_fk foreign key (parent_id)
        references core.users(id)
        on delete cascade
        on update cascade
) inherits (common.user_objects);

create table core.organization_types (
    constraint organization_types_pkey primary key(id),
    constraint organization_types_key unique(slug)
) inherits (common.enum_objects);

create table core.organizations (
    organization_type_id int not null,
    short_name text,
    parent_id uuid,
    address text,
    phone text,
    inn text,
    ogrn text,
    deleted_due text,
    constraint organizations_pkey primary key(id),
    constraint organizations_key unique(slug),
    constraint organizations_organizations_fk foreign key (parent_id)
        references core.organizations(id)
        on delete no action
        on update no action,
    constraint organizations_organization_type_fk foreign key (organization_type_id)
        references core.organization_types(id)
        on delete no action
        on update no action
) inherits (common.descripted_objects);

create sequence core.version_seq;

create table core.organization_changes (
    version integer not null default nextval('core.version_seq'),
    name text not null,

    short_name text,
    parent_id uuid,
    address text,
    phone text,
    inn text,
    ogrn text,
    deleted_due text,
    constraint organization_changes_pkey primary key(id),
    constraint organization_changes_organizations_fk foreign key (organization_id)
        references core.organizations(id)
        on delete no action
        on update no action,
    constraint organization_changes_organization_changes_fk foreign key (parent_id)
        references core.organization_changes(id)
        on delete no action
        on update no action
) inherits (common.organization_objects);

create table core.learning_streams (
    name text not null,
    year smallint not null,
    years smallint,
    started_at date,
    ended_at date,
    constraint learning_streams_pkey primary key(id),
    constraint learning_streams_organizations_fk foreign key (organization_id)
        references core.organizations(id)
        on delete cascade
        on update cascade
) inherits (common.organization_objects);

create unique index learning_streams_name_year_idx on core.learning_streams
    using btree (name, year) where deleted_at is null;

create table core.relationships (
    constraint relationships_pkey primary key(id),
    constraint relationships_key unique(slug)
) inherits (common.enum_objects);

create table core.organization_type_relationship(
    organization_type_id int not null,
    relationship_id int not null,
    constraint organization_type_relationship_pkey primary key(id),
    constraint organization_type_relationship_key unique(organization_type_id, relationship_id),
    constraint organization_type_relationship_organization_types_fk foreign key (organization_type_id)
        references core.organization_types(id)
        on delete no action
        on update no action,
    constraint organization_type_relationship_relationships_fk foreign key (relationship_id)
        references core.relationships(id)
        on delete no action
        on update no action
) inherits (common.objects);

create table core.relations (
    constraint relations_pkey primary key(id),
    constraint relations_users_fk foreign key (user_id)
        references core.users(id)
        on delete cascade
        on update cascade,
    constraint relations_organizations_fk foreign key (organization_id)
        references core.organizations(id)
        on delete cascade
        on update cascade,
    constraint relations_relationships_fk foreign key (relationship_id)
        references core.relationships(id)
        on delete no action
        on update cascade
) inherits (common.relation_objects, common.organization_objects);

create unique index relations_organization_id_relationship_id_user_id_idx on core.relations
    using btree (organization_id, relationship_id, user_id) where acting is not true and deleted_at is null;

create unique index relations_organization_id_relationship_id_user_id_acting_idx on core.relations
    using btree (organization_id, relationship_id, user_id) where acting and deleted_at is null;

create table core.stream_relations (
    learning_stream_id uuid not null,
    constraint stream_relations_pkey primary key(id),
    constraint stream_relations_users_fk foreign key (user_id)
        references core.users(id)
        on delete cascade
        on update cascade,
    constraint stream_relations_learning_streams_fk foreign key (learning_stream_id)
        references core.learning_streams(id)
        on delete cascade
        on update cascade
) inherits (common.relation_objects);

create unique index stream_relations_learning_stream_id_user_id_idx on core.stream_relations
    using btree (learning_stream_id, user_id) where acting is not true and deleted_at is null;

create unique index stream_relations_learning_stream_id_user_id_acting_idx on core.stream_relations
    using btree (learning_stream_id, user_id) where acting and deleted_at is null;

create function core.organization_changed (
)
returns trigger as
$body$
declare
    o core.organization_changes;
    n core.organization_changes;
begin
    n = jsonb_populate_record(n, to_jsonb(new));
    if TG_OP = 'UPDATE' then
        o = jsonb_populate_record(o, to_jsonb(old));
    end if;
    if n is distinct from o then
        n.organization_id = n.id;
        n.id = gen_random_uuid();
        n.version = nextval('version_seq');
        select id into n.parent_id from core.organization_changes where organization_id = n.parent_id order by version desc limit 1;
        insert into core.organization_changes select n.*;
    end if;
    return null;
end;
$body$
language plpgsql
volatile;

create trigger organizations_tr after insert or update on core.organizations
for each row execute procedure core.organization_changed();
