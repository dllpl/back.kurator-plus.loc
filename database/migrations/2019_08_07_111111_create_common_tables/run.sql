-- alter system set search_path = "$user", public, common, core;
-- select pg_reload_conf();

create extension pgcrypto;

create schema if not exists common;

create domain common.objectid uuid not null default gen_random_uuid();

create domain common.datetime timestamptz(0);

create table common.objects (
    created_at common.datetime not null default now(),
    updated_at common.datetime not null default now(),
    deleted_at common.datetime,
    id common.objectid
);

create table common.user_objects (
    user_id uuid not null
) inherits (common.objects);

create table common.organization_objects (
    organization_id uuid not null
) inherits (common.objects);

create table common.named_objects (
    slug text not null,
    name text not null
) inherits (common.objects);

create table common.descripted_objects (
    description text
) inherits (common.named_objects);

create table common.relation_objects (
    relationship_id int not null,
    acting boolean,
    started_at date not null,
    ended_at date
) inherits (common.user_objects);

create table common.enum_objects (
    created_at common.datetime not null default now(),
    updated_at common.datetime not null default now(),
    deleted_at common.datetime,
    id integer,
    slug text not null,
    name text not null,
    description text
);

create function common.bcrypt_override (
    hash text,
    version text = 'a'
)
returns text as
$body$
select case when version ~ '^[abxy]$' then regexp_replace(hash, '^\$2[abxy](?=\$)', '$2' || version) else hash end
$body$
language sql
immutable;

create function common.hash_make (
    password text,
    iter_count integer = 10
)
returns text as
$body$
select common.bcrypt_override(crypt(password, gen_salt('bf', iter_count)), 'y')
$body$
language sql
immutable;

create function common.hash_check (
    password text,
    hash text
)
returns boolean as
$body$
select crypt(password, common.bcrypt_override(hash, 'a')) = common.bcrypt_override(hash, 'a')
$body$
language sql
immutable;

create function common.gen_random_text(
    length integer = 10
)
returns text as
$body$
select substr(translate(encode(gen_random_bytes(length), 'base64'), '/+=', ''), 1, length)
$body$
language sql
volatile;

-- create function common.to_uuid (
--     integer
-- )
-- returns uuid as
-- $body$
-- select ('676c6172-7573-474c-4152-5553' || lpad(to_hex($1), 8, '0'))::uuid
-- $body$
-- language sql
-- immutable strict
-- parallel safe;
