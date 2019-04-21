DELIMITER $$
CREATE PROCEDURE `usp_save_user_j`(p_id INT, p_username VARCHAR(255),
	p_email VARCHAR(255), p_lastname VARCHAR(255),p_firstname VARCHAR(255),
        p_password1 VARCHAR(255), p_password2 VARCHAR(255)
)
main: BEGIN
	DECLARE cnt INT;
	DECLARE errCt INT;
	DECLARE id INT;
	DECLARE msg VARCHAR(4000);
	SET msg='{';
	SET errCt=0;

        if (p_id=0 AND (length(p_username)<4 OR EXISTS(SELECT 1 FROM users WHERE username=p_username))) THEN
            SET msg = concat(msg, 'username:"username exists or is invalid ",');
            SET errCt=errCt+1;
        END IF;

        IF p_password1 <> p_password2 OR (length(p_password1)<8 AND p_id<1) THEN
		SET msg = concat(msg, 'password1:"passwords do not or invalid ",');
		SET errCt=errCt+1;
        END IF;

	if p_email NOT LIKE '%@%.%' THEN
		SET msg = concat(msg, 'email1:"Email: ',p_email,' incorrect format! Use xx@xx.xx",');
		SET errCt=errCt+1;
	end if;

        if length(p_lastname)<2 OR length(p_lastname)>100 THEN
		SET msg = concat(msg, 'lastname:"Last Name ',p_lastname,' incorrect incorrect length",');
		SET errCt=errCt+1;
        end if;
        if length(p_firstname)<2 OR length(p_firstname)>100 THEN
		SET msg = concat(msg, 'firstname:"Last Name ',p_firstname,' incorrect incorrect length",');
		SET errCt=errCt+1;
        end if;
	if errCt>0 then
                SET msg = concat(msg, 'errorMsg:"Please correct these issues and resubmit"}');
		SELECT errCt*-1 as retcode, msg as retval;
		leave main;
	end if;
	IF errCt=0 THEN
            IF p_id = 0 THEN
                SET errCt=3;
		INSERT INTO users (username, email, lastname, firstname,password) 
                    VALUES (p_username, p_email, p_lastname, p_firstname, p_password1);
		SET id = last_insert_id();
		SELECT id AS retcode, 'Profile Created' as retval;
            ELSE
                IF (p_password1='') THEN
                    REPLACE INTO users (username, email, lastname, firstname,password) 
                        VALUES (p_username, p_email, p_lastname, p_firstname, p_password1);
                ELSEIF (LENGTH(TRIM(p_password1))>7) THEN
                    REPLACE INTO users (username, email, lastname, firstname,password) 
                        VALUES (p_username, p_email, p_lastname, p_firstname, p_password1);
                ELSE 
                    SET msg='password:"Password is invalid",';
                    SET msg = concat(msg, 'errorMsg:"Please correct these issues and resubmit"}');
                    SELECT -1 as retcode, msg as retval;
                    leave main;
                END IF;
                SELECT p_id as retcode, 'listing updated' as retval;
            END IF;
            LEAVE main;
	END IF;
	SELECT errCt as retcode, '<li>User not saved</li>' as retval, msg As errors;
END$$
DELIMITER ;



