CREATE DATABASE car_dealer;

CREATE TABLE car_dealer.engines (
  engine_code VARCHAR(45) NOT NULL PRIMARY KEY,
  horse_power SMALLINT(4) NULL,
  torque VARCHAR(45) NULL,
  engine_plant VARCHAR(45) NULL,
  num_cylinders TINYINT(1) NULL,
  block_type VARCHAR(45) NULL,
  block_material VARCHAR(45) NULL,
  displacement VARCHAR(45) NULL,
  fuel_type VARCHAR(45) NULL
);

CREATE TABLE car_dealer.drive_trains (
	trans_code VARCHAR(45) NOT NULL PRIMARY KEY,   
    trans_type VARCHAR(20) NULL,   
    torque_rating VARCHAR(20) NULL,  
    num_gears SMALLINT(4) NULL,    
    manufacturers VARCHAR(40) NULL
);

CREATE TABLE car_dealer.makes (
	id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    name VARCHAR (255),
    INDEX ix_makes_name (name)
);

CREATE TABLE car_dealer.models (
	id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    make_id INT,
    name VARCHAR (255) NOT NULL,
    CONSTRAINT fk_models_make_id 
		FOREIGN KEY (make_id) 
		REFERENCES car_dealer.makes (id)
		ON DELETE CASCADE,
    INDEX ix_model_name (name),
    INDEX ix_model_make_id (make_id, name)
);

CREATE TABLE car_dealer.performance_specs (
	model_id INT NOT NULL,
	engine_id VARCHAR(45) NOT NULL,
	drive_train_id VARCHAR(45) NOT NULL,
	accel_to_sixty_mph VARCHAR(10) NULL,
	mpg SMALLINT(3) NULL,
	breaking_distance SMALLINT(3) NULL,
	year SMALLINT(4)NOT NULL,
	INDEX engine_id_idx (engine_id ASC),
	INDEX drive_train_idx (drive_train_id ASC),
	CONSTRAINT fk_ps_model_id 
		FOREIGN KEY (model_id) 
		REFERENCES car_dealer.models (id),
	CONSTRAINT fk_ps_engines 
		FOREIGN KEY (engine_id)
		REFERENCES car_dealer.engines (engine_code),
	CONSTRAINT fk_ps_drive_train 
		FOREIGN KEY (drive_train_id)
		REFERENCES car_dealer.drive_trains (trans_code),
	PRIMARY KEY(model_id, engine_id, drive_train_id, year)
);

CREATE TABLE car_dealer.cars (
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
  CONSTRAINT fk_cars_model_id 
	FOREIGN KEY (model_id) 
	REFERENCES car_dealer.models (id) 
	ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_cars_engines 
	FOREIGN KEY (engine_id)
	REFERENCES car_dealer.engines (engine_code) 
	ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_cars_drive_train 
	FOREIGN KEY (drive_train_id)
	REFERENCES car_dealer.drive_trains (trans_code)
    ON DELETE CASCADE ON UPDATE CASCADE  
);   