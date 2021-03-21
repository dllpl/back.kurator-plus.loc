# При первой установке
1. Необходимо разместить словари из архива database/migrations/dist
2. Выполнить от суперпользователя PostgreSQL 
```
alter system set search_path = "$user", public, core;
select pg_reload_conf();
```
