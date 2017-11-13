/* Query to create customer table */

create or replace type name_type AS OBJECT(
fname VARCHAR(64), lname VARCHAR(64)
);

create or replace TYPE person_type AS OBJECT (
id NUMBER,
name name_type,
username VARCHAR(64),
password VARCHAR(50)
);

create or replace type purchase_type as OBJECT(
asin VARCHAR(10),
quantity NUMBER(5,2)
);

create or replace type purchase_tab as table of purchase_type;

create or replace type customer_type as OBJECT(
name name_type,
username VARCHAR(64),
password VARCHAR(50)
);

create table customer(
id integer primary key,
customer customer_type,
purchases purchase_tab,
amount number(10,2) not null check(amount>=0.0)
)nested table purchases store as customer_purchases;

create sequence customer_id start with 1 increment by 1 cache 100;

/* query to create game table */
create or replace type developer_tab as table of developer_type;
create or replace type developer_type as OBJECT(
id NUMBER,
name name_type
);

CREATE TABLE "SPANDEY"."GAME" 
   (	"ASIN" VARCHAR2(10 BYTE), 
	"TITLE" VARCHAR2(64 BYTE) NOT NULL ENABLE, 
	"DEVELOPERS" "SPANDEY"."DEVELOPER_TAB" , 
	"PRICE" NUMBER(5,2) NOT NULL ENABLE, 
	 CHECK (price >=0.0) ENABLE, 
	 PRIMARY KEY ("ASIN"))
   )NESTED TABLE "DEVELOPERS" STORE AS "DEVELOPER_GAMES";


/* Query to create developer table */
CREATE TABLE "SPANDEY"."DEVELOPER" OF "SPANDEY"."DEVELOPER_TYPE" 
   ( PRIMARY KEY ("ID") 
   UNIQUE ("NAME"."FNAME")
   )

/*procedure to delete developer */

CREATE TYPE string_table AS TABLE OF varchar2(100);

create or replace procedure deleteDeveloper(ids string_table )
is 
 a GAME.ASIN%type;
CURSOR  GameCursor  IS SELECT  asin  FROM  game;
BEGIN
    delete from developer where id in(select column_value from table(ids));
  OPEN  GameCursor;
  LOOP
    /* Retrieve each row of the result of the above query into PL/SQL variables: */
    FETCH  GameCursor  INTO  a;
    /* If there are no more rows to fetch, exit the loop: */
    EXIT WHEN  GameCursor%NOTFOUND;
    /* Delete the matching developer */
   delete TABLE(select g.developers from game g where g.ASIN=a) d where d.id in (select column_value from table(ids));

  END LOOP;
  /* Free cursor used by the query. */
  CLOSE  GameCursor;

END;


/*PL/SQL to add new developer if the developer doesn't exists on that specific game*/
SET SERVEROUTPUT ON;
DECLARE
  /* Output variables to hold the result of the query: */
  a  DEVELOPER.id%type;
  b  DEVELOPER.name%type;
  counter integer;
  /* Cursor declaration: */
  CURSOR  DeveloperCursor  IS SELECT id,name  FROM  developer p where id in (116,117,118);
BEGIN
 
  OPEN  DeveloperCursor;
  LOOP
    /* Retrieve each row of the result of the above query into PL/SQL variables: */
    FETCH  DeveloperCursor  INTO  a,b;
    /* If there are no more rows to fetch, exit the loop: */
    EXIT WHEN  DeveloperCursor%NOTFOUND;
    /* Delete the matching developer */
    SELECT  count(*) into counter from TABLE(select g.developers from game g where g.ASIN='ASIN-9') d where id=a;
    if counter=0 then
        insert into TABLE(select g.developers from game g where g.ASIN='ASIN-9') values (a,b);
    end if;

  END LOOP;
  /* Free cursor used by the query. */
  CLOSE  DeveloperCursor;
END;

/*Default admin*/
insert into customer values(customer_id.NEXTVAL, customer_type(name_type('sanjaya','pandey'),'admin','admin'),purchase_tab(),0.0 );

/*login check*/
select id from customer c where c.customer.username='admin' and c.customer.password='admin';

/*list customer*/
select id, c.customer.name.fname from customer c ;

select id, c.customer.name.fname, c.customer.name.lname from customer p;

/* purchase functionality */
select p.asin from TABLE(select customer.purchases from customer where customer.id = 6) p where p.asin in ('ASIN-099','ASIN-432');

insert into customer values(customer_id.NEXTVAL, customer_type(name_type('sanjaya','pandey'),'admin','admin'),purchase_tab(),0.0 );

insert into TABLE(select customer.purchases from customer where customer.id = 6) values (purchase_type('ASIN-123', 23));

/* purchase Procedure */
CREATE TYPE string_table AS TABLE OF varchar2(100);

create or replace procedure purchaseGame(customerId integer,  asins string_table, qty integer)
is 
  a GAME.ASIN%type;
  b GAME.PRICE%type;
  counter integer;
  quantity integer;
  /* Cursor declaration: */
  GameCursor sys_refcursor;
BEGIN

  OPEN  GameCursor for select asin, price from game where asin in (select column_value from table(asins));
  LOOP
    /* Retrieve each row of the result of the above query into PL/SQL variables: */
    FETCH  GameCursor  INTO  a, b;
    /* If there are no more rows to fetch, exit the loop: */
    EXIT WHEN  GameCursor%NOTFOUND;
    /* check if that book already purchased or not */
    BEGIN
    SELECT count(*) into counter from TABLE(select customer.purchases from customer where customer.id = customerId) p where p.asin = a;
    EXCEPTION
      WHEN NO_DATA_FOUND THEN
        counter := 0;
    END;
    BEGIN
    SELECT p.quantity into quantity from TABLE(select customer.purchases from customer where customer.id = customerId) p where p.asin = a;
    EXCEPTION
      WHEN NO_DATA_FOUND THEN
        quantity := 0;
    END;
    
    if counter=0 then
        insert into TABLE(select customer.purchases from customer where customer.id = customerId) values (purchase_type(a, qty));
    else
        update TABLE(select customer.purchases from customer where customer.id = customerId) set quantity = quantity + qty where asin =a;
    end if;
    update customer set customer.amount = customer.amount + qty*b where id=customerId;
  END LOOP;
  /* Free cursor used by the query. */
  CLOSE  GameCursor;
END;

SET SERVEROUTPUT ON;
execute purchaseGame(102, string_table('ASIN-123'), 10);
select customer.purchases from customer where customer.id =102;
commit


/* List games developed by specific developer */
select g.asin, g.title from game g, TABLE(g.developers) d where d.id=201;

/*search game */
select g.asin, g.title, (select count(*) from table(g.developers) d where REGEXP_LIKE (d.name.fname, 'san', 'i') or REGEXP_LIKE (d.name.lname, 'ser', 'i')) from game g;

/*procedure to reset the sytem */
create or replace procedure resetSystem is
begin
truncate table developer  purge;
truncate table customer purge;
truncate table game purge;
end;


