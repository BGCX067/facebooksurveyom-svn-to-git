<?php
/*******************************************************************
   RETURN VALUES FROM SETTINGS
********************************************************************/
function GetSetting($title, $feature_id = 0){
 $setSQL	= "SELECT * FROM settings WHERE feature_id = '$feature_id' AND title = '$title'";
 $setSET	= mysql_query($setSQL);
 $setROW	= mysql_fetch_assoc($setSET);
 $setValue	= $setROW['value']; 
 
 return $setValue;
 
}


/*******************************************************************
   RETURN ADMIN NAME
********************************************************************/
function GetAdmin($admin_id){
 $adminSQL		= "SELECT * FROM admin WHERE admin_id = '$admin_id'";
 $adminSET		= mysql_query($adminSQL);
 $adminROW		= mysql_fetch_assoc($adminSET);
 $adminValue	= $adminROW['username']; 
 
 return $adminValue;
 
}

?>