SHOW DATABASES;

USE Prueba;

CREATE TABLE CSVImport (id INT);

ALTER TABLE CSVImport ADD COLUMN Hum VARCHAR(256);

LOAD DATA INFILE "/var/www/html/order.csv" INTO TABLE CSVImport COLUMNS TERMINATED BY ',' LINES TERMINATED BY '\n'(Title,Temp,Hum,DATE,FECHA);

SELECT * FROM CSVImport;

DESCRIBE CSVImport;

ALTER TABLE CSVImport MODIFY COLUMN id INT(11) AUTO_INCREMENT,ADD PRIMARY KEY(id);

DELETE FROM CSVImport WHERE condition;

ALTER TABLE tablename AUTO_INCREMENT = 1;

SELECT * from CSVImport where Title="Test1";

CREATE TABLE IF NOT EXISTS contactos (
id_contacto INT(11) NOT NULL AUTO_INCREMENT,
nombre VARCHAR(20) NOT NULL,
apellido1 VARCHAR(30) DEFAULT NULL,
apellido2 VARCHAR(30) DEFAULT NULL,
tel_mov INT(15) DEFAULT NULL,
tel_fijo INT(15) DEFAULT NULL,
email VARCHAR(100) DEFAULT NULL,
PRIMARY KEY (id_contacto)
);

DROP TABLE table_name;

SELECT DISTINCT Country FROM Customers;

SELECT column1, column2 FROM table_name WHERE condition; (= 	Equal
<> 	Not equal. Note: In some versions of SQL this operator may be written as !=
> 	Greater than
< 	Less than
>= 	Greater than or equal
<= 	Less than or equal
BETWEEN 	Between an inclusive range
LIKE 	Search for a pattern
IN 	To specify multiple possible values for a column)

SELECT column1, column2 FROM table_name WHERE condition1 AND condition2;
SELECT column1, column2 FROM table_name WHERE condition1 OR condition2;
SELECT column1, column2 FROM table_name WHERE NOT condition;

SELECT * FROM Customers ORDER BY Country ASC, CustomerName DESC;

INSERT INTO table_name (column1, column2, column3) VALUES (value1, value2, value3);


SELECT column_names FROM table_name WHERE column_name IS NULL;

UPDATE table_name SET column1 = value1, column2 = value2 WHERE condition;


select cast(t.DataDate as date) as dia, avg(t.Temp) as Promedio from Oficina_1 t group by cast(t.DataDate as date) order by cast(t.DataDate as date) asc;

SELECT id, sum(corriente) AS Total FROM (SELECT* FROM(SELECT id,corriente FROM Corriente_1 UNION ALL SELECT id,corriente FROM Corriente_2 UNION ALL SELECT id,corriente FROM Corriente_3) AS Tabla_union) AS Ranking GROUP BY id ORDER BY Total;


select energia from Gonzalo WHERE DAY(DataDate)=(select DATE(NOW()) as dia);

select * from Gonzalo  where (DataDate between  DATE_FORMAT(NOW() ,'%Y-%m-02') AND NOW() );

select SUM(energia) as suma from Gonzalo WHERE id BETWEEN 1 AND ( select MAX(id) from Gonzalo where DAY(DataDate)=13);

select SUM(energia) from Gonzalo  where (DataDate between  DATE_FORMAT(NOW() ,'2017-06-01') AND DATE_FORMAT(NOW(),'2017-06-%d' ));



INSERT INTO Ranking (Individuo, Variacion_Porcentual) VALUES('$tabla',


(select (SELECT Promedio from (             SELECT* FROM(select id as id,Oficina as Oficina,DATE_FORMAT(cast(t.DataDate as date),'%m') as dia, avg(t.Corriente) as Promedio from $tabla t group by DATE_FORMAT(cast(t.DataDate as date),'%m') order by DATE_FORMAT(cast(t.DataDate as date),'%m') desc)AS Tabla               ) as hola where id=(SELECT MAX( id )FROM (             SELECT* FROM(select id as id,Oficina as Oficina,DATE_FORMAT(cast(t.DataDate as date),'%m') as dia, avg(t.Corriente) as Promedio from $tabla t group by DATE_FORMAT(cast(t.DataDate as date),'%m') order by DATE_FORMAT(cast(t.DataDate as date),'%m') desc)AS Tabla               ) as hola)) 

/

 (SELECT Promedio from (             SELECT* FROM(select id as id,Oficina as Oficina,DATE_FORMAT(cast(t.DataDate as date),'%m') as dia, avg(t.Corriente) as Promedio from $tabla t group by DATE_FORMAT(cast(t.DataDate as date),'%m') order by DATE_FORMAT(cast(t.DataDate as date),'%m') desc)AS Tabla               ) as hola where id=(SELECT MIN( id )FROM (             SELECT* FROM(select id as id,Oficina as Oficina,DATE_FORMAT(cast(t.DataDate as date),'%m') as dia, avg(t.Corriente) as Promedio from $tabla t group by DATE_FORMAT(cast(t.DataDate as date),'%m') order by DATE_FORMAT(cast(t.DataDate as date),'%m') desc)AS Tabla               ) as hola))  


as Relacion) )

ON DUPLICATE KEY UPDATE Variacion_Porcentual=


(select (SELECT Promedio from (             SELECT* FROM(select id as id,Oficina as Oficina,DATE_FORMAT(cast(t.DataDate as date),'%m') as dia, avg(t.Corriente) as Promedio from $tabla t group by DATE_FORMAT(cast(t.DataDate as date),'%m') order by DATE_FORMAT(cast(t.DataDate as date),'%m') desc)AS Tabla               ) as hola where id=(SELECT MAX( id )FROM (             SELECT* FROM(select id as id,Oficina as Oficina,DATE_FORMAT(cast(t.DataDate as date),'%m') as dia, avg(t.Corriente) as Promedio from $tabla t group by DATE_FORMAT(cast(t.DataDate as date),'%m') order by DATE_FORMAT(cast(t.DataDate as date),'%m') desc)AS Tabla               ) as hola))


/

 (SELECT Promedio from (             SELECT* FROM(select id as id,Oficina as Oficina,DATE_FORMAT(cast(t.DataDate as date),'%m') as dia, avg(t.Corriente) as Promedio from $tabla t group by DATE_FORMAT(cast(t.DataDate as date),'%m') order by DATE_FORMAT(cast(t.DataDate as date),'%m') desc)AS Tabla               ) as hola where id=(SELECT MIN( id )FROM (             SELECT* FROM(select id as id,Oficina as Oficina,DATE_FORMAT(cast(t.DataDate as date),'%m') as dia, avg(t.Corriente) as Promedio from $tabla t group by DATE_FORMAT(cast(t.DataDate as date),'%m') order by DATE_FORMAT(cast(t.DataDate as date),'%m') desc)AS Tabla               ) as hola)) 

 as Relacion);
