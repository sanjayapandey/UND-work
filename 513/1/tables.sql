CREATE TABLE `books` (
  `title` char(128) DEFAULT NULL,
  `ISBN` char(20) NOT NULL,
  `price` double DEFAULT NULL,
  PRIMARY KEY (`ISBN`)
) 

CREATE TABLE `customer` (
  `customer_id` int(11) NOT NULL AUTO_INCREMENT,
  `password` char(128) DEFAULT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `middle_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `user_name` varchar(100) DEFAULT NULL,
  `phone_number` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`customer_id`)
)

CREATE TABLE `purchase` (
  `purchase_id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `ISBN` varchar(20) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  PRIMARY KEY (`purchase_id`),
  KEY `ISBN` (`ISBN`),
  KEY `customer_id` (`customer_id`),
  CONSTRAINT `purchase_ibfk_1` FOREIGN KEY (`ISBN`) REFERENCES `books` (`ISBN`),
  CONSTRAINT `purchase_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`)
)


select g.ASIN, g.title, g.price , d.id, value(d).name.fname from game g, TABLE(select g.developers from game g where g.ASIN='ISBN-123') d;
 select g.ASIN, d.id from game g, TABLE(g.developers) d;
delete from game where id = any (select d.id from game g,table(developers) d where d.id=1);
declare
a 

///////////////////////////////////////////////////////////////
INSERT INTO TABLE(SELECT h.people FROM hr_info h
   WHERE h.department_id = 280)
   VALUES ('Smith', 280, 1750);

DELETE TABLE(SELECT h.people FROM hr_info h
   WHERE h.department_id = 280) p
   WHERE p.salary > 1700;
///////////////////////////////////////////
insert into TABLE(select g.developers from game g where g.ASIN='ASIN-1234') values (1,name_type('sanjaya','pandey'))
>>Combine both using plsql, 
delete TABLE(select g.developers from game g where g.ASIN='ASIN-1234') d where d.id=1;
delete TABLE(select g.developers from game g ) d where d.id=1;

update  game set price=12 where ASIN='ASIN-9'
