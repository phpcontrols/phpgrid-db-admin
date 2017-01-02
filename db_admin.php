<?php
use phpGrid\C_DataGrid;

require_once("phpGridx/conf.php");   

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>DB Admin</title>
</head>
<body>

<style type='text/css'>
.wrapper{
   width: 100%;
   margin: 0 auto;
}
.header{
   float: left;
   width: 100%;
   text-align: center;
}
.wrapright{
   float: left;
   width: 100%;
}
.right{
   margin-left: 310px;
   height: 200px;
}
.left{
   float: left;
   width: 300px;
   margin-left: -100%;
   height: 200px;
}
body {
   padding: 15px;
   margin: 15px;
}
</style>

<div class="wrapper">
    <div class="header">
        <h1>Database Table Data CRUD Admin Console</h1>
    </div> 
    <div class="wrapright">       
        <div class="right">
            <?php
            $schemaName = (isset($_GET['TABLE_SCHEMA']) && isset($_GET['TABLE_SCHEMA']) !== '') ? $_GET['TABLE_SCHEMA'] : 'sampledb';
            $tableName = (isset($_GET['TABLE_NAME']) && isset($_GET['TABLE_NAME']) !== '') ? $_GET['TABLE_NAME'] : 'orders';

            //$dg = new C_DataGrid("SELECT * FROM $schemaName.$tableName");
            
            $dg = new C_DataGrid("SELECT * FROM $tableName",'orderNumber', "$tableName",
                        array("hostname"=>"localhost",
                            "username"=>"root",
                            "password"=>"",
                            "dbname"=>$schemaName, 
                            "dbtype"=>"mysql", 
                            "dbcharset"=>"utf8"));
            $dg->set_caption(strtoupper("$schemaName.$tableName"));
            
            $dg->enable_autowidth(true);
            $dg->enable_edit();
            $dg->set_scroll(true);
            $dg->enable_global_search(true);

            // uncomment to set width to parent DIV instead
            $dg->before_script_end .= 'setTimeout(function(){$(window).bind("resize", function() {
                    phpGrid_'. $tableName .'.setGridWidth($(".right").width());
                }).trigger("resize");}, 0)';
            
            $dg -> display();
            ?>
        </div>
    </div>    
    <div class="left">
        <?php
        // schema list
        $dbs = new C_DataGrid("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA", "SCHEMA_NAME", "INFORMATION_SCHEMA.SCHEMATA");
        $dbs->set_dimension('300px');
        $dbs->set_pagesize(999)->set_scroll(true);

        // table list
        $tbl = new C_DataGrid("SELECT TABLE_NAME, TABLE_SCHEMA, TABLE_ROWS FROM INFORMATION_SCHEMA.TABLES", "TABLE_NAME", "INFORMATION_SCHEMA.TABLES");
        $tbl->set_col_hidden('TABLE_SCHEMA');
        $tbl->set_pagesize(999)->set_scroll(true);
        $tbl -> set_col_dynalink("TABLE_NAME", "db_admin.php", array("TABLE_NAME", "TABLE_SCHEMA"), '', "_top");
        //$tbl->set_col_title('TABLE_NAME', 'Name')->set_col_title('TABLE_ROWS', 'Count');

        $dbs->set_subgrid($tbl, 'TABLE_SCHEMA', 'SCHEMA_NAME');
        $dbs->display();
        ?>
    </div>  
</div>

TODO: add form only mode


</body>
</html>