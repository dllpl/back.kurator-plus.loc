create schema if not exists oauth;

create domain oauth.token as
    text not null;

alter domain oauth.token
    add constraint token_chk check (length(value) <= 100);

create table oauth.clients (
    created_at common.datetime not null default now(),
    updated_at common.datetime not null default now(),
    id common.objectid not null primary key,
    user_id uuid,
    name text not null,
    secret oauth.token not null,
    redirect text not null,
    personal_access_client boolean not null,
    password_client boolean not null,
    revoked boolean not null,
    constraint clients_users_fk foreign key (user_id)
        references core.users(id)
        on delete cascade
        on update cascade
        not deferrable
);

create table oauth.access_tokens (
    created_at common.datetime not null default now(),
    updated_at common.datetime not null default now(),
    expires_at common.datetime,
    id oauth.token not null primary key,
    user_id uuid,
    client_id uuid not null,
    name text,
    scopes text,
    revoked boolean not null,
    constraint access_tokens_users_fk foreign key (user_id)
        references core.users(id)
        on delete cascade
        on update cascade
        not deferrable,
    constraint access_tokens_clients_fk foreign key (client_id)
        references oauth.clients(id)
        on delete cascade
        on update cascade
        not deferrable
);

create table oauth.auth_codes (
    id oauth.token not null primary key,
    user_id uuid not null,
    client_id uuid not null,
    scopes text,
    revoked boolean not null,
    expires_at common.datetime,
    constraint auth_codes_users_fk foreign key (user_id)
        references core.users(id)
        on delete cascade
        on update cascade
        not deferrable,
    constraint auth_codes_clients_fk foreign key (client_id)
        references oauth.clients(id)
        on delete cascade
        on update cascade
        not deferrable
);

create table oauth.personal_access_clients (
    created_at common.datetime not null default now(),
    updated_at common.datetime not null default now(),
    id common.objectid not null primary key,
    client_id uuid not null,
    constraint personal_access_clients_clients_fk foreign key (client_id)
        references oauth.clients(id)
        on delete cascade
        on update cascade
        not deferrable
);

create table oauth.refresh_tokens (
    id oauth.token not null primary key,
    access_token_id oauth.token not null,
    revoked boolean not null,
    expires_at common.datetime,
    constraint refresh_tokens_access_tokens_fk foreign key (access_token_id)
        references oauth.access_tokens(id)
        on delete cascade
        on update cascade
        not deferrable
);

create index access_tokens_user_id_idx on oauth.access_tokens using btree (user_id);

create index refresh_tokens_access_token_id_idx on oauth.refresh_tokens using btree (access_token_id);

create index clients_user_id_idx on oauth.clients using btree (user_id);

create index personal_access_clients_client_id_idx on oauth.personal_access_clients using btree (client_id);
