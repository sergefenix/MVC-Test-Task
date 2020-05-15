
create table `users` (
    `id` int(10) unsigned not null auto_increment,
    `email` varchar(255) not null,
    `name`  varchar(255) not null,
    `password`  varchar(255) not null,
    `is_admin`   varchar(255) not null,,
    primary key (id)
)

auto_increment = 1
character set utf8
collate utf8_general_ci;


