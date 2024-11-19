create database test;

create table categories (
    id int primary key ,
    name varchar(255) not null,
    alias varchar(255) not null,
    parent_id int default null,
    foreign key (parent_id) references categories(id) on delete cascade
);

