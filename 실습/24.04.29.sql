

create database DB;
use DB;
/*
CREATE TABLE 고객 (
	고객아이디 VARCHAR(20) NOT NULL,
	고객이름 VARCHAR(10) NOT NULL,
	나이	INT,
	등급	VARCHAR(10)	 NOT NULL,
	직업	VARCHAR(20),
	적립금 INT DEFAULT 0,
	PRIMARY KEY(고객아이디)
);

CREATE TABLE 제품 (
	제품번호 CHAR(3) NOT NULL,
	제품명 VARCHAR(20),
	재고량 INT,
	단가 INT,
	제조업체 VARCHAR(20),
	PRIMARY KEY(제품번호),
	CHECK (재고량 >= 0 AND 재고량 <=10000)
);

create table 주문(
	주문번호 char(3) not null,
    주문고객 varchar(20),
    주문제품 char(3),
    수량 int,
    배송지 varchar(30),
    주문일자 date,
    primary key(주문번호),
    foreign key(주문고객) references 고객(고객아이디),
	foreign key(주문제품) references 제품(제품번호)
);
create table 배송업체(
	업체번호 char(3) not null,
    업체명 varchar(20),
    주소 varchar(100),
    전화번호 varchar(20),
    primary key(업체번호)
);

alter table 고객 add constraint chk_age check(나이 >= 20);		#제약조건 추가
alter table 고객 drop constraint chk_age;						#제약조건 삭제

drop table 배송업체;
*/

/*
INSERT INTO 고객 VALUES ('apple', '정소화', 20, 'gold', '학생', 1000);
INSERT INTO 고객 VALUES ('banana', '김선우', 25, 'vip', '간호사', 2500);
INSERT INTO 고객 VALUES ('carrot', '고명석', 28, 'gold', '교사', 4500);
INSERT INTO 고객 VALUES ('orange', '김용욱', 22, 'silver', '학생', 0);
INSERT INTO 고객 VALUES ('melon', '성원용', 35, 'gold', '회사원', 5000);
INSERT INTO 고객 VALUES ('peach', '오형준', NULL, 'silver', '의사', 300);
INSERT INTO 고객 VALUES ('pear', '채광주', 31, 'silver', '회사원', 500);


INSERT INTO 제품 VALUES ('p01', '그냥만두', 5000, 4500, '대한식품');
INSERT INTO 제품 VALUES ('p02', '매운쫄면', 2500, 5500, '민국푸드');
INSERT INTO 제품 VALUES ('p03', '쿵떡파이', 3600, 2600, '한빛제과');
INSERT INTO 제품 VALUES ('p04', '맛난초콜릿', 1250, 2500, '한빛제과');
INSERT INTO 제품 VALUES ('p05', '얼큰라면', 2200, 1200, '대한식품');
INSERT INTO 제품 VALUES ('p06', '통통우동', 1000, 1550, '민국푸드');
INSERT INTO 제품 VALUES ('p07', '달콤비스킷', 1650, 1500, '한빛제과');


INSERT INTO 주문 VALUES ('o01', 'apple', 'p03', 10, '서울시 마포구', '22/01/01');
INSERT INTO 주문 VALUES ('o02', 'melon', 'p01', 5, '인천시 계양구', '22/01/10');
INSERT INTO 주문 VALUES ('o03', 'banana', 'p06', 45, '경기도 부천시', '22/01/11');
INSERT INTO 주문 VALUES ('o04', 'carrot', 'p02', 8, '부산시 금정구', '22/02/01');
INSERT INTO 주문 VALUES ('o05', 'melon', 'p06', 36, '경기도 용인시', '22/02/20');
INSERT INTO 주문 VALUES ('o06', 'banana', 'p01', 19, '충청북도 보은군', '22/03/02');
INSERT INTO 주문 VALUES ('o07', 'apple', 'p03', 22, '서울시 영등포구', '22/03/15');
INSERT INTO 주문 VALUES ('o08', 'pear', 'p02', 50, '강원도 춘천시', '22/04/10');
INSERT INTO 주문 VALUES ('o09', 'banana', 'p04', 15, '전라남도 목포시', '22/04/11');
INSERT INTO 주문 VALUES ('o10', 'carrot', 'p03', 20, '경기도 안양시', '22/05/22');
*/
show tables;
select * from 고객;
select * from 제품;
select * from 주문;

select 고객아이디, 고객이름, 등급 from 고객;
select 제조업체 from 제품;
select all 제조업체 from 제품;
select distinct 제조업체 from 제품;

select 제품명, 단가 as 가격 from 제품;
select 제품명, 단가 * 1/4 as "조정 단가" from 제품;

select 제품명, 재고량, 단가 from 제품 where 제조업체 = '한빛제과';
select 제품명, 재고량, 단가 from 제품 where 제조업체 = '대한식품';
select 제품명, 재고량, 단가 from 제품 where 제조업체 = '민국푸드';

select 주문제품, 수량, 주문일자 from 주문 where 주문고객 = 'apple' and 수량 >= 15;
select 주문제품, 수량, 주문일자, 주문고객 from 주문 where 주문고객 = 'apple' or 수량 >= 15;




select 고객아이디, 나이, 등급, 적립금 from 고객 where 고객아이디 like '_____';		#like '' 따옴표 안에 '_'개수로 길이 검색
select 고객이름, 나이 from 고객 where 나이 is null;				# 나이가 null값인 경우 검색
select 고객이름, 나이 from 고객 where 나이 is not null;			# 나이가 null값이 아닌 경우 검색

select 고객이름, 등급, 나이 from 고객 order by 나이 desc;			# 나이 역순으로 정렬
select 주문고객, 주문제품, 수량, 주문일자 from 주문 where 수량
								  order by 주문제품 asc, 수량 desc;		# 주문제춤 번호 순서대로, 수량이 많은대로 정렬

select avg(단가) from 제품;											# AVG() : 평균 함수
select sum(재고량) as 재고량합계 from 제품 where 제조업체 = '민국푸드' ;		# SUM() : 모두 더하는 함수
select count(고객아이디) as 고객수 from 고객;								# COUNT() : 개수 구하는 함수
select count(distinct 제조업체) as 제조업체수 from 제품; 					# DISTINCT : 중복 제거

select 주문제품, sum(수량) as 총주문수량 from 주문 group by 주문제품;
select 제조업체, count(*) as 제품수, max(단가) as 최고가 from 제품 group by 제조업체;

select 제조업체, count(*) as 제품수, max(단가) as 최고가 from 제품 group by 제조업체 having count(*) >= 3;
select 등급, count(*) as 고객수, avg(적립금) as 평균적립금 from 고객 group by 등급 having avg(적립금) >= 1000;
select 주문제품, 주문고객, sum(수량) as 총주문수량 from 주문 group by 주문제품, 주문고객;

select 제품.제품명 from 제품, 주문 where 주문.주문고객 = 'banana' and 제품.제품번호 = 주문.주문제품;
select 주문.주문제품, 주문.주문일자 from 고객, 주문 where 고객.나이 >= 30 and 고객.고객아이디 = 주문.주문고객;
select 제품명, 단가 from 제품 where 제조업체 = (select 제조업체 from 제품 where 제품명 = '달콤비스킷');

create view 우수고객(고객아이디, 고객이름, 나이, 등급) 
as select 	고객아이디, 고객이름, 나이, 등급
	from 	고객 
	where 	등급 = 'vip' with check option;

select * from 우수고객;
drop view 우수고객;





