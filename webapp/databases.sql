SET time_zone = "+03:00";

CREATE DATABASE `benchmark_ffmpeg`;

USE `benchmark_ffmpeg`;

CREATE TABLE IF NOT EXISTS `cpuBench` (
	`id` INT AUTO_INCREMENT NOT NULL,
    `bench` VARCHAR(3),
	`resolution` VARCHAR(15),
    `os` VARCHAR(20),
    `iterations` INT,
    `cpu` VARCHAR(50),
	`arch` VARCHAR(20),
	`frequency` VARCHAR(20),
	`memory` VARCHAR(25),
    `encoder` VARCHAR(10),
    `preset` VARCHAR(15),
    `crf` INT,
    `total` VARCHAR(30),
    `average` VARCHAR(30),
    `fps` VARCHAR(30),
    `fastest` VARCHAR(30),
	`fastest_seconds` FLOAT,
	`created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS `gpuBench` (
	`id` INT AUTO_INCREMENT NOT NULL,
    `bench` VARCHAR(3),
	`resolution` VARCHAR(15),
    `os` VARCHAR(20),
    `iterations` INT,
    `gpu` VARCHAR(100),
    `encoder` VARCHAR(10),
    `preset` VARCHAR(15),
    `tune` VARCHAR(15),
    `level` VARCHAR(10),
    `total` VARCHAR(30),
    `average` VARCHAR(30),
    `fps` VARCHAR(30),
    `fastest` VARCHAR(30),
	`fastest_seconds` FLOAT,
	`created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
);
