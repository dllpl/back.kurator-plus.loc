insert into core.users (name, surname, email, email_verified_at, password, remember_token) values
('Наиль', 'Админов', 'root@example.net', now(), common.hash_make('password'), common.gen_random_text(10)),
('Сергей', 'Иванов', 'director@example.net', now(), common.hash_make('password'), common.gen_random_text(10)),
('Екатерина', 'Иванова', 'head@example.net', now(), common.hash_make('password'), common.gen_random_text(10)),
('Василий', 'Пупкин', 'vasiliy@example.net', now(), common.hash_make('password'), common.gen_random_text(10)),
('Василиса', 'Пупкина', 'vasilisa@example.net', now(), common.hash_make('password'), common.gen_random_text(10));

update core.users set superuser = true where email = 'root@example.net';

insert into core.organizations (organization_type_id, slug, name, short_name)
select id, 'minedu', 'Министерство образования и науки РФ', 'МОиН РФ'
from core.organization_types
where slug = 'gov';

insert into core.organizations (organization_type_id, slug, name, parent_id)
select t.id, 'das', 'Школа анализа данных', o.id
from core.organization_types t
join core.organizations o on o.slug = 'minedu'
where t.slug = 'edu';

insert into core.relations(organization_id, user_id, relationship_id, started_at)
select o.id, u.id, r.id, now() from core.organizations o
join core.users u on u.email = 'director@example.net'
join core.relationships r on r.slug = 'director'
where o.slug = 'das';

insert into core.relations(organization_id, user_id, relationship_id, started_at)
select o.id, u.id, r.id, now() from core.organizations o
join core.users u on u.email = 'head@example.net'
join core.relationships r on r.slug = 'head_teacher'
where o.slug = 'das';

insert into core.relations(organization_id, user_id, relationship_id, started_at)
select o.id, u.id, r.id, now() from core.organizations o
join core.users u on u.email = 'vasiliy@example.net'
join core.relationships r on r.slug = 'student'
where o.slug = 'das';

insert into core.relations(organization_id, user_id, relationship_id, started_at)
select o.id, u.id, r.id, now() from core.organizations o
join core.users u on u.email = 'vasilisa@example.net'
join core.relationships r on r.slug = 'parent'
where o.slug = 'das';

insert into core.family_ties(parent_id, user_id)
select p.id, c.id from core.users c
join core.users p on p.email = 'vasilisa@example.net'
where c.email = 'vasiliy@example.net';

update core.organizations set name = 'Минобр', updated_at = clock_timestamp() + '1 sec' where slug = 'minedu';
update core.organizations set name = 'ШАД', updated_at = clock_timestamp() + '2 sec' where slug = 'das';

insert into core.learning_streams(organization_id, name, year, years, started_at)
select id, 'А', extract(year from now()), 12, date_trunc('year', now()) + interval '8 mons'
from core.organizations
where slug = 'das';

insert into core.stream_relations(learning_stream_id, user_id, relationship_id, started_at)
select s.id, u.id, r.id, date_trunc('year', now()) + interval '8 mons'
from core.learning_streams s
join core.users u on u.email = 'head@example.net'
join core.relationships r on r.slug = 'stream_leader';

insert into core.stream_relations(learning_stream_id, user_id, relationship_id, started_at)
select s.id, u.id, r.id, date_trunc('year', now()) + interval '8 mons'
from core.learning_streams s
join core.users u on u.email = 'vasiliy@example.net'
join core.relationships r on r.slug = 'student';
