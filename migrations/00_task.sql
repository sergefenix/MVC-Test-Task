
-- Таблица товаров --
create table `tasks` (
    `id` int(10) unsigned not null auto_increment,
    `email` varchar(255) not null,
    `name`  varchar(255)  null default null,
    `text`  varchar(255)  null default null,
    `img`   varchar(50)  null default null,
    primary key (id)
)

auto_increment = 1
character set utf8
collate utf8_general_ci;


