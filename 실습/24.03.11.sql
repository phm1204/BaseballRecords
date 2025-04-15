create database info;
USE info;

create table mytable(
	id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(20) not null,
    model_num VARCHAR(10) not null,
    model_type VARCHAR(20) not null,
    primary key(id)
);
show tables;
insert into mytable values(1, 'i7','13700k','Raptor L');
insert into mytable(name, model_num, model_type) values('i5','14400F', 'Raptor L');
insert into mytable(name, model_num, model_type) values('R7-5','7800X3D', 'Raphael');
insert into mytable(name, model_num, model_type) values('R5-4','5600', 'Vermeer');
insert into mytable(name, model_num, model_type) values('i7','14700KF', 'Rapter R');

select * from mytable;
select name, model_num from mytable;

select name AS cpu_name, model_num AS cpu_num from mytable;		
select * from mytable where id < 2;
select * from mytable where id = 1;
select * from mytable where id > 1;
select * from mytable where name like 'i%';

select * from mytable limit 2;			#select * from mytable limit n;      처음부터 n개 출력
select * from mytable limit 3, 2;		#select * from mytable limit n, m;   n+1부터 m개 출력

select * from mytable order by id DESC;			#내림차순 정렬
select * from mytable order by id asc;			#오름차순 정렬

select id, name from mytable
where id < 4 and name like 'i%'
order by name asc
limit 1, 4;

select * from mytable where model_num like '13%'; 				#문제 1
select * from mytable where name = 'i7';						#문제 2
select * from mytable where model_type = 'Raptor L' limit 1;	#문제 3

update mytable set name = 'i5', model_num = '5500' where id = 2; 	#id가 2이면 name이 i5이고 model_num가 5500
DElete from mytable where id = 3;									#id가 3인 데이터 삭제

select * from mytable;


desc mytable;
drop table mytable;

