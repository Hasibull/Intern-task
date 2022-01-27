CREATE DATABASE cake_world;

USE cake_world;

CREATE TABLE owner(
    username varchar(100) NOT NULL,
    password varchar(100) NOT NULL,
    PRIMARY KEY(username)
    );

CREATE TABLE cakes(
    cake_id int(10) NOT NULL AUTO_INCREMENT,
    fname varchar(100) NOT NULL,
    PRIMARY KEY(cake_id)
    );

CREATE TABLE inventory_cost (
    cake_id int,
    material_cost double(10,5) NOT NULL,
    transportation_cost double(10, 5) NOT NULL,
    utility_cost double(10, 5) AS ((material_cost + transportation_cost) * (3 / 100)),
    space_cost double(10, 5) NOT NULL,
    staff_cost double(10, 5) NOT NULL,
    total_cost double(10, 5) AS (material_cost + transportation_cost + utility_cost + space_cost + space_cost + staff_cost),
    FOREIGN KEY(cake_id) REFERENCES cakes(cake_id)
    );

CREATE TABLE sells(
    cake_id int,
    actual_price double(10, 5) NOT NULL,
    discount double(10, 5) NOT NULL,
    discount_price double(10, 5) AS (actual_price - (actual_price * (discount/100))),
    amount double(10, 5) NOT NULL,
    fprice double(10, 5) AS (discount_price * amount),
    FOREIGN KEY(cake_id) REFERENCES cakes(cake_id)
    );