CREATE DATABASE test;
USE test;

CREATE TABLE item(
upc char(30) not null,
Title char(30) not null,
Type enum("CD" , "DVD") not null,
Category enum("Rock", "Pop", "Rap", "Country", "Classical", "New age", "Instrumental") not null,
Company char(30) not null, 
Year year not null,
Price char(30) not null, 
Stock char(30) not null,
PRIMARY KEY(upc));
INSERT INTO item VALUE
(1, "Ming's first CD", "CD", "CLASSICAL", "Doge Entertainment", 2014, 9.99, 10);
INSERT INTO item VALUE
(2, "Ming's first DVD", "dVD", "pop", "Doge Entertainment", 2012, 19.99, 5);
INSERT INTO item VALUE
(3, "Wesley's first CD", "CD", "CLASSICAL", "Doge Entertainment", 2014, 9.99, 20);
INSERT INTO item VALUE
(4, "Wesley's first DVD", "dVD", "pop", "Doge Entertainment", 2012, 19.99, 10);
INSERT INTO item VALUE
(5, "Alvin's first CD", "CD", "CLASSICAL", "Doge Entertainment", 2014, 9.99, 30);
INSERT INTO item VALUE
(6, "Alvin's first DVD", "dVD", "pop", "Doge Entertainment", 2012, 19.99, 15);
INSERT INTO item VALUE
(7, "Roger's first CD", "CD", "CLASSICAL", "Doge Entertainment", 2014, 9.99, 40);
INSERT INTO item VALUE
(8, "Roger's first DVD", "dVD", "pop", "Doge Entertainment", 2012, 19.99, 20);
SELECT * FROM item;

CREATE TABLE Lead_Singer(
upc char(30) not null, 
Name char(30) not null,
PRIMARY KEY(upc, name));
INSERT INTO lead_singer VALUE
(1, "Ming");
INSERT INTO lead_singer VALUE
(3, "Wesley");
INSERT INTO lead_singer VALUE
(5, "Alvin");
INSERT INTO lead_singer VALUE
(7, "Roger");
SELECT * FROM lead_singer;

CREATE TABLE Has_Song(
upc char(30) not null,
Title char(30) not null, 
PRIMARY KEY(upc, title));
INSERT INTO has_song VALUE
(1, "Campfire Song");
SELECT * FROM has_song;

CREATE TABLE Orders(
ReceiptId char(30) not null,
Date date not null,
CId char(30) not null,
CardNo char(30) not null,
ExpiryDate date not null,
ExpectedDate date not null,
DeliveredDate date not null,
PRIMARY KEY(ReceiptId));
INSERT INTO orders VALUE
(1, '2012-12-10', 1, 8374793, '2014-2-3', '2012-12-14', '2012-12-15');
INSERT INTO orders VALUE
(2, '2012-12-10', 2, 12312312, '2015-2-7', '2013-1-5', '2013-1-5');
INSERT INTO orders VALUE
(3, '2013-1-3', 2, 12312312, '2015-2-7', '2013-1-5', '2013-1-5');
INSERT INTO orders VALUE
(4, '2013-1-3', 2, 12312312, '2015-2-7', '2013-1-5', '2013-1-5');
INSERT INTO orders VALUE
(5, '2013-1-3', 2, 12312312, '2015-2-7', '2013-1-5', '2013-1-5');
INSERT INTO orders VALUE
(6, '2013-1-3', 2, 12312312, '2015-2-7', '2013-1-5', '2013-1-5');
INSERT INTO orders VALUE
(7, '2013-1-3', 2, 12312312, '2015-2-7', '2013-1-5', '2013-1-5');
INSERT INTO orders VALUE
(8, '2013-1-3', 2, 12312312, '2015-2-7', '2013-1-5', '2013-1-5');
SELECT * FROM orders;

CREATE TABLE Purchase_Item(
ReceiptId char(30) not null,
upc char(30) not null,
Quantity char(30) not null, 
PRIMARY KEY (ReceiptId, upc));
INSERT INTO purchase_item VALUE
(1, 1, 1);
INSERT INTO purchase_item VALUE
(2, 2, 1);
INSERT INTO purchase_item VALUE
(2, 1, 1);
INSERT INTO purchase_item VALUE
(3, 3, 1);
INSERT INTO purchase_item VALUE
(3, 1, 1);
INSERT INTO purchase_item VALUE
(4, 4, 1);
INSERT INTO purchase_item VALUE
(5, 5, 5);
INSERT INTO purchase_item VALUE
(6, 6, 4);
INSERT INTO purchase_item VALUE
(7, 7, 4);
INSERT INTO purchase_item VALUE
(8, 8, 3);
SELECT * FROM purchase_item;

CREATE TABLE Customer(
CId char(30) not null,
Password char(30) not null,
Name char(30) not null,
Address char(30) not null,
PhoneNo char(30) not null,
PRIMARY KEY(cid));
INSERT INTO customer VALUE
(1, '123abc', 'Ming-Hung Lee', 'Somewhere Surrey', 7781234567);
INSERT INTO customer VALUE
(2, 'password', 'Wesley Lee', 'Somewhere Surrey', 1234567890);
INSERT INTO customer VALUE
(3, 'password', 'Alvin Chan', 'Near Evans House', 0987654321);
SELECT * FROM customer;

CREATE TABLE Returns(
RetId char(30) not null,
Date date not null,
ReceiptId char(30) not null,
PRIMARY KEY(RetId));
INSERT INTO returns VALUE
(1, '2012-12-31', 1);
SELECT * FROM returns;

CREATE TABLE ReturnItem(
RetId char(30) not null,
upc char(30) not null,
Quantity char(30) not null,
PRIMARY KEY(RetId, upc));
SELECT * FROM returnitem;


ALTER TABLE lead_singer
ADD FOREIGN KEY(upc) REFERENCES item(upc);

ALTER TABLE has_song
ADD FOREIGN KEY(upc) REFERENCES item(upc);

ALTER TABLE orders 
ADD FOREIGN KEY(cid) REFERENCES customer(cid);

ALTER TABLE Purchase_Item
ADD FOREIGN KEY(ReceiptId) REFERENCES Orders(ReceiptId);
ALTER TABLE Purchase_Item
ADD FOREIGN KEY(upc) REFERENCES item(upc);

ALTER TABLE returns
ADD FOREIGN KEY(receiptid) REFERENCES orders(receiptid);

ALTER TABLE returnitem
ADD FOREIGN KEY(retid) REFERENCES returns(retid);
ALTER TABLE returnitem
ADD FOREIGN KEY(upc) REFERENCES item(upc);
