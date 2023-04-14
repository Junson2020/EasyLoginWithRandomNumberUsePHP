

CREATE DATABASE IF NOT EXISTS `junson_user` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `junson_user`;

CREATE TABLE `randpswd` (
  `licensenumber` varchar(128) NOT NULL,
  `pswd` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `userinfo` (
  `u_account` varchar(30) NOT NULL,
  `u_pswd` varchar(30) DEFAULT NULL,
  `u_name` varchar(100) DEFAULT NULL,
  `u_cell` varchar(30) DEFAULT NULL,
  `u_group` varchar(30) DEFAULT NULL,
  `u_email` varchar(50) DEFAULT NULL,
  `stopyn` varchar(1) DEFAULT NULL,
  `u_fixtime` varchar(30) DEFAULT NULL,
  `u_lastfix` varchar(30) DEFAULT NULL,
  `u_language` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `userlicenseall` (
  `ulid` bigint(20) NOT NULL,
  `u_account` varchar(30) DEFAULT NULL,
  `u_name` varchar(50) DEFAULT NULL,
  `licensenumber` varchar(100) DEFAULT NULL,
  `endtime` varchar(30) DEFAULT NULL,
  `u_group` varchar(255) DEFAULT NULL,
  `u_language` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `logdata` (
  `logid` bigint(20) NOT NULL,
  `logtext` text NOT NULL,
  `logtime` varchar(20) NOT NULL,
  `logfrom` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `userinfo`
  ADD PRIMARY KEY (`u_account`);

ALTER TABLE `userlicenseall`
  ADD PRIMARY KEY (`ulid`);
ALTER TABLE `userlicenseall`
  MODIFY `ulid` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10000;

ALTER TABLE `logdata`
  ADD PRIMARY KEY (`logid`);
ALTER TABLE `logdata`
  MODIFY `logid` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;
  
COMMIT;      