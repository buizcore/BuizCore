
-- index auf buiz_group_users
CREATE INDEX assign_user_area_vid_idx 
  ON buiz_group_users 
  (
    id_group,
    id_user,
    id_area,
    partial,
    vid
  );
  
CREATE INDEX acl_load_dataset_permission_idx 
  ON buiz_group_users 
  (
    id_group,
    id_area,
    vid
  );

CREATE INDEX search_buiz_security_access_access_level_idx 
  ON buiz_security_access 
  (
    access_level
  );
  
CREATE INDEX search_buiz_security_area_access_key_idx 
  ON buiz_security_area 
  (
    access_key
  );