DELIMITER ??
DROP PROCEDURE IF EXISTS schema_change??
CREATE PROCEDURE schema_change()
BEGIN
IF NOT EXISTS (SELECT * FROM information_schema.columns WHERE table_schema = DATABASE()  AND table_name = 'zmm_course_order' AND column_name = 'disc_id') THEN
   # ALTER TABLE zmm_course_order ADD COLUMN disc_id INT(10) UNSIGNED DEFAULT 0 COMMENT '优惠券id';
ELSE    
   # ALTER TABLE zmm_course_order MODIFY COLUMN disc_id INT(10) UNSIGNED DEFAULT 0 COMMENT '优惠券id';
END IF; 

IF NOT EXISTS (SELECT * FROM information_schema.columns WHERE table_schema = DATABASE()  AND table_name = 'zmm_course_order' AND column_name = 'disc_price') THEN
	#	ALTER TABLE zmm_course_order ADD COLUMN disc_price INT(10) UNSIGNED DEFAULT 0 COMMENT '优惠价格';
ELSE    
   # ALTER TABLE zmm_course_order MODIFY COLUMN disc_price INT(10) UNSIGNED DEFAULT 0 COMMENT '优惠价格';
END IF; 


END??
DELIMITER ;
CALL schema_change();