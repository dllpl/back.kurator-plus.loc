insert into core.social_providers (id, slug, name, driver, class) values
(1, 'google', 'Google', 'google', 'google-plus'),
(2, 'facebook', 'Facebook', 'facebook', 'facebook'),
(3, 'vk', 'VK', 'vkontakte', 'vk');

insert into core.organization_types(id, slug, name) values
(1, 'gov', 'Контролирующая организация'),
(2, 'edu', 'Учебная организация');

insert into core.relationships (id, slug, name, description) values
(1, 'director', 'Директор', 'Директор организации'),
(2, 'secretary', 'Секретарь', 'Секретарь организации'),
(3, 'head_teacher', 'Завуч', 'Заведующий учебной частью школы'),
(4, 'stream_leader', 'Классный руководитель', 'Классный руководитель'),
(5, 'teacher', 'Учитель', 'Учитель школы'),
(6, 'psychologist', 'Психолог', 'Психолог школы'),
(7, 'student', 'Ученик', 'Ученик школы'),
(8, 'parent', 'Родитель', 'Родитель несовершеннолетнего');

insert into core.organization_type_relationship(organization_type_id, relationship_id)
select t.id, r.id from core.relationships r
join core.organization_types t on t.slug = 'gov'
where r.slug in ('director', 'secretary');

insert into core.organization_type_relationship(organization_type_id, relationship_id)
select t.id, r.id from core.relationships r
join core.organization_types t on t.slug = 'edu';
