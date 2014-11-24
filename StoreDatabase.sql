USE test3;
SELECT DATABASE();
SHOW TABLES;

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
SELECT * FROM item;

CREATE TABLE lead_singer(
upc char(30) not null, 
Name char(30) not null,
PRIMARY KEY(upc, name));
ALTER TABLE lead_singer
ADD FOREIGN KEY(upc) REFERENCES item(upc);
INSERT INTO lead_singer VALUE
(1, "MC Doge");
SELECT * FROM lead_singer;

CREATE TABLE has_song(
upc char(30) not null,
Title char(30) not null, 
PRIMARY KEY(upc, title));
ALTER TABLE has_song
ADD FOREIGN KEY(upc) REFERENCES item(upc);
INSERT INTO has_song VALUE
(1, "Campfire Song");
SELECT * FROM has_song;

CREATE TABLE orders(
ReceiptId char(30) not null,
Date date not null,
CId char(30) not null,
CardNo char(30) not null,
ExpiryDate date not null,
ExpectedDate date not null,
DeliveredDate date not null,
PRIMARY KEY(ReceiptId));
ALTER TABLE orders 
ADD FOREIGN KEY(cid) REFERENCES customer(cid);
INSERT INTO orders VALUE
(1, '2012-12-10', 1, 8374793, '2014-2-3', '2012-12-14', '2012-12-15');
INSERT INTO orders VALUE
(2, '2013-1-3', 2, 12312312, '2015-2-7', '2013-1-5', '2013-1-5');
SELECT * FROM orders;

CREATE TABLE purchase_item(
ReceiptId char(30) not null,
upc char(30) not null,
Quantity char(30) not null, 
PRIMARY KEY (ReceiptId, upc));
ALTER TABLE purchase_item
ADD FOREIGN KEY(ReceiptId) REFERENCES Orders(ReceiptId);
ALTER TABLE purchase_item
ADD FOREIGN KEY(upc) REFERENCES item(upc);
INSERT INTO purchase_item VALUE
(1, 1, 1);
INSERT INTO purchase_item VALUE
(2, 2, 1);
SELECT * FROM purchase_item;

CREATE TABLE customer(
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

CREATE TABLE returns(
RetId char(30) not null,
Date date not null,
ReceiptId char(30) not null,
PRIMARY KEY(RetId));
ALTER TABLE returns
ADD FOREIGN KEY(receiptid) REFERENCES orders(receiptid);
INSERT INTO returns VALUE
(1, '2012-12-31', 1);
SELECT * FROM returns;

CREATE TABLE returnitem(
RetId char(30) not null,
upc char(30) not null,
Quantity char(30) not null,
PRIMARY KEY(RetId, upc));
ALTER TABLE returnitem
ADD FOREIGN KEY(retid) REFERENCES returns(retid);
ALTER TABLE returnitem
ADD FOREIGN KEY(upc) REFERENCES item(upc);
SELECT * FROM returnitem;