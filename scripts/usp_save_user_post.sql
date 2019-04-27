CREATE OR REPLACE PROCEDURE public.usp_save_user(IN id bigint DEFAULT 0, IN username character varying, 
        IN lastname character varying, IN firstname character varying, IN email character varying, 
        IN phone character varying, IN password character varying)
LANGUAGE 'plpgsql'
AS 
    IF id >0 THEN
        UPDATE users 
            SET lastname=$3, firstname=$4, email=$5, phone=$6, password=$7
            WHERE users.id = $1;
    ELSE
        INSERT INTO users (username, lastname, firstname, email,phone, password) 
            VALUES (username, lastname, firstname, email,phone, password);
    END IF;
 
    COMMIT;
END;