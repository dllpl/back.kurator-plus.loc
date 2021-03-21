insert into oauth.clients (id, name, secret, redirect, personal_access_client, password_client, revoked) values
('{$client_id}', 'Frontend', common.gen_random_text(40), 'https://my.{$prefix}kuratorplus.ru/#/oauth/callback?', true, false, false);

insert into oauth.personal_access_clients (client_id) select id from oauth.clients;
