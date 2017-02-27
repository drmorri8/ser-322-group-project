CREATE DATABASE car_dealer;

CREATE TABLE car_dealer.engine (
    engine_code VARCHAR(45) NOT NULL PRIMARY KEY,
    horse_power DOUBLE NULL,
    torque DOUBLE NULL,
    engine_plant VARCHAR(45) NULL,
    num_cylinders TINYINT(1) NULL,
    block_type VARCHAR(45) NULL,
    block_material VARCHAR(45) NULL,
    displacement VARCHAR(45) NULL,
    fuel_type VARCHAR(45) NULL
);

CREATE TABLE car_dealer.drive_train (
    trans_code VARCHAR(45) NOT NULL PRIMARY KEY,   
    trans_type VARCHAR(20) NULL,   
    torque_rating VARCHAR(20) NULL,  
    num_gears SMALLINT(4) NULL,    
    manufacturers VARCHAR(40) NULL
);

CREATE TABLE car_dealer.make (
    id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    name VARCHAR (255),
    INDEX ix_make_name (name)
);

CREATE TABLE car_dealer.model (
    id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    make_id INT,
    name VARCHAR (255) NOT NULL,
    CONSTRAINT fk_model_make_id 
    FOREIGN KEY (make_id) 
    REFERENCES car_dealer.make (id)
    ON DELETE CASCADE,
    INDEX ix_model_name (name),
    INDEX ix_model_make_id (make_id, name)
);

CREATE TABLE car_dealer.performance_spec (
    model_id INT NOT NULL,
    engine_id VARCHAR(45) NOT NULL,
    drive_train_id VARCHAR(45) NOT NULL,
    accel_to_sixty_mph DOUBLE NULL,
    mpg SMALLINT(3) NULL,
    breaking_distance double NULL,
    year SMALLINT(4) NOT NULL,
    INDEX engine_id_idx (engine_id ASC),
    INDEX drive_train_idx (drive_train_id ASC),
    CONSTRAINT fk_ps_model_id 
        FOREIGN KEY (model_id) 
        REFERENCES car_dealer.model (id),
    CONSTRAINT fk_ps_engine 
        FOREIGN KEY (engine_id)
        REFERENCES car_dealer.engine (engine_code),
    CONSTRAINT fk_ps_drive_train 
        FOREIGN KEY (drive_train_id)
        REFERENCES car_dealer.drive_train (trans_code),
    PRIMARY KEY(model_id, engine_id, drive_train_id, year)
);

CREATE TABLE car_dealer.car (
    vin VARCHAR(17) NOT NULL,
    trans_serial_number VARCHAR(45) NULL,
    model_id INT NOT NULL,
    year SMALLINT(4) NOT NULL,
    engine_serial_number VARCHAR(45) NULL,
    engine_id VARCHAR(45) NOT NULL,
    drive_train_id VARCHAR(45) NOT NULL,
    PRIMARY KEY (vin),
    INDEX ix_engine_id (engine_id ASC),  
    INDEX ix_drive_train (drive_train_id ASC),
    CONSTRAINT fk_car_model_id 
        FOREIGN KEY (model_id) 
        REFERENCES car_dealer.model (id) 
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_car_engine 
        FOREIGN KEY (engine_id)
        REFERENCES car_dealer.engine (engine_code) 
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_car_drive_train 
        FOREIGN KEY (drive_train_id)
        REFERENCES car_dealer.drive_train (trans_code)
        ON DELETE CASCADE ON UPDATE CASCADE  
);

insert into car_dealer.make (
    name
)
values
    ('Ford'),
    ('Nissan'),
    ('Honda'),
    ('Hyundai'),
    ('Lamborghini'),
    ('Mazda'),
    ('Lexus');
    
insert into car_dealer.model (
    make_id,
    name
)
values
    (1, 'GT'),
    (1, 'Fiesta'),
    (1, 'Focus'),
    (2, 'Sentra'),
    (2, 'Altima'),
    (2, '370z'),
    (3, 'Civic'),
    (3, 'Accord'),
    (4, 'Elantra'),
    (4, 'Azera'),
    (5, 'Aventador'),
    (5, 'Huracan'),
    (6, '3'),
    (6, 'MX-5 Miata'),
    (7, 'RX 350');
    

insert into car_dealer.engine (
    engine_code,
    horse_power,
    torque,
    engine_plant,
    num_cylinders,
    block_type,
    block_material,
    displacement,
    fuel_type
)
values (
    '2GR-FE',
    275,
    257,
    null,
    6,
    null,
    null,
    3457,
    'premium unleaded'
);

insert into car_dealer.drive_train
(
    trans_code,
    trans_type,
    torque_rating,
    num_gears,
    manufacturers
)
values (
    '6A',
    'automatic',
    null,
    6,
    null
);

insert into car_dealer.performance_spec (
    model_id,
    engine_id,
    drive_train_id,
    accel_to_sixty_mph,
    mpg,
    breaking_distance,
    year
)
values (
    15,
    '2GR-FE',
    '6A',
    null,
    20,
    null,
    2013
);

insert into car_dealer.performance_spec (
    model_id,
    engine_id,
    drive_train_id,
    accel_to_sixty_mph,
    mpg,
    breaking_distance,
    year
)
values (
    1,
    '2GR-FE',
    '6A',
    10.0,
    32,
    5.0,
    2015
);

insert into car_dealer.car (
    vin,
    trans_serial_number,
    model_id,
    year,
    engine_serial_number,
    engine_id,
    drive_train_id
)
values (
   '12345678901234567',
    'transnumber',
    15,
    2013,
    'engineerialnumber',
    '2GR-FE',
    '6A'    
);

insert into car_dealer.car (
    vin,
    trans_serial_number,
    model_id,
    year,
    engine_serial_number,
    engine_id,
    drive_train_id
)
values (
   '12345678901234568',
    'mehtrans',
    1,
    2015,
    'mehengine',
    '2GR-FE',
    '6A'    
);