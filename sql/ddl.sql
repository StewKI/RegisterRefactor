create table mail
(
    id        int auto_increment
        primary key,
    `to`      varchar(255) not null,
    `from`    varchar(255) not null,
    from_name varchar(255) not null,
    subject   varchar(255) not null,
    body      varchar(255) not null,
    status    int          not null
);

create table user
(
    id       int auto_increment
        primary key,
    email    varchar(255) not null,
    password varchar(255) not null
);

create table user_log
(
    id       int auto_increment
        primary key,
    action   varchar(255) not null,
    user_id  int          not null,
    log_time datetime     not null,
    constraint user_log_ibfk_1
        foreign key (user_id) references user (id)
);

create index user_id
    on user_log (user_id);

