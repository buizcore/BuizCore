-- View: view_person_role

-- DROP VIEW view_person_role;

CREATE OR REPLACE VIEW view_person_role AS 
 SELECT 
  core_person.rowid AS core_person_rowid, 
  core_person.salutation AS core_person_salutation, 
  core_person.firstname AS core_person_firstname, 
  core_person.second_firstname AS core_person_second_firstname, 
  core_person.lastname AS core_person_lastname, 
  core_person.academic_title AS core_person_academic_title, 
  buiz_role_user.rowid AS buiz_role_user_rowid,  
  buiz_role_user.name AS buiz_role_user_name,
  
  COALESCE 
  ( 
    buiz_role_user.name, '' 
  ) || 
  COALESCE 
  ( 
    ' &lt;' || core_person.lastname || ', ' || core_person.firstname || '&gt;', 
    ' &lt;' || core_person.lastname || '&gt;', 
    ' &lt;' || core_person.firstname || '&gt;', 
    '' 
  ) as fullname
   FROM 
    buiz_role_user
   JOIN 
    core_person 
      ON core_person.rowid = buiz_role_user.id_person
  WHERE (buiz_role_user.inactive = FALSE OR buiz_role_user.inactive IS NULL );

-- ALTER TABLE view_person_role OWNER TO owner;

    
    
CREATE OR REPLACE VIEW view_employee_person_role as
select
  hr_employee.rowid as empl_rowid,
  hr_employee.empl_number as empl_number,
  core_person.rowid     as person_rowid,
  core_person.salutation as salutation,
  core_person.firstname as firstname,
  core_person.lastname  as lastname,
  buiz_role_user.rowid as role_rowid,
  buiz_role_user.name  as role_name,
  buiz_role_user.email as email
  
from
  buiz_role_user
join 
  core_person
    on  core_person.rowid = buiz_role_user.id_person
join 
  hr_employee
    on  core_person.rowid = hr_employee.id_person;
      
      
-- View: view_person_role

-- DROP VIEW view_person_role;

CREATE OR REPLACE VIEW view_user_role_contact_item AS 
 SELECT 
  core_person.rowid AS core_person_rowid, 
  core_person.salutation AS core_person_salutation, 
  core_person.firstname AS core_person_firstname, 
  core_person.second_firstname AS core_person_second_firstname, 
  core_person.lastname AS core_person_lastname, 
  core_person.academic_title AS core_person_academic_title, 
  buiz_role_user.rowid AS buiz_role_user_rowid, 
  buiz_role_user.name AS buiz_role_user_name,
  buiz_address_item.address_value AS buiz_address_item_address_value, 
  buiz_address_item_type.name AS buiz_address_item_type_name
  FROM 
    buiz_role_user
  JOIN 
    core_person 
      ON core_person.rowid = buiz_role_user.id_person
  JOIN
    buiz_address_item
      ON buiz_role_user.rowid = buiz_address_item.id_user
  JOIN
    buiz_address_item_type
      ON buiz_address_item_type.rowid = buiz_address_item.id_type
  WHERE
    buiz_address_item.use_for_contact = true
      
-- ALTER TABLE view_person_role OWNER TO owner;
    
