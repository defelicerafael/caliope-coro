<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Authorization,Content-Type,Accept,Origin,User-Agent,DNT,Cache-Control,X-Mx-ReqToken,Keep-Alive,X-Requested-With,If-Modified-Since");
header("Content-Type:application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=Reporte_Stock.xls");  //File name extension was wrong
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);
$tabla = filter_input(INPUT_GET, 'tabla', FILTER_SANITIZE_SPECIAL_CHARS);
include_once 'class_sql.php';
//echo "netre php";
$sql = new Sql;
$select = $sql->excel($tabla);  

$null = is_null($select);
if($null==true){
    echo "[]";
}else{
if (count($select) > 0): ?>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>    
    <table>
        <thead>
            <tr>
                <th><?php echo implode('</th><th>', array_keys(current($select))); ?></th>
            </tr>
        </thead>
      <tbody>
    <?php foreach ($select as $row): array_map('htmlentities', $row); ?>
            <tr>
              <td><?php echo implode('</td><td>', $row); ?></td>
            </tr>
    <?php endforeach; ?>
      </tbody>
    </table>
<?php endif; 

}

