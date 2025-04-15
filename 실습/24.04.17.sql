create database test;
use test;

create table test (
	id int unsigned not null auto_increment,
    name varchar(20) not null,
    model_num varchar(10) not null,
    model_type varchar(30) not null,
	lowest_price int unsigned,
	primary key(id)
);

insert into test(name, model_num, model_type, lowest_price)values("i5", "13400F", "랩터레이크", 234860);
insert into test(name, model_num, model_type, lowest_price)values("i5", "12400F", "엘더레이크", 164190);
insert into test(name, model_num, model_type, lowest_price)values("i7", "14700KF", "엘더레이크 리스페시", 542180);
insert into test(name, model_num, model_type, lowest_price)values("i5", "12400", "엘더레이크", 180490);
insert into test(name, model_num, model_type, lowest_price)values("i5", "14500", "엘더레이크 리프레시", 326960);

#문제 1
select * from test;

#문제 2
select model_num, lowest_price from test;

#문제 3
select name as cpu_num from test;

update test set model_type = "Leptor L" where model_type = "랩터레이크" ;

select * from test where name = "i5";
select name, model_num from test where lowest_price <= 300000;
select * from test where lowest_price >= 400000;


