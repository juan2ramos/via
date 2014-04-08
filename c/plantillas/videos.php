<?
$qVideos=$db->sql_query("
	SELECT id,url,etiqueta,'archivos_grupos_$tipo' as tabla
	FROM archivos_grupos_$tipo 
	WHERE id_grupos_$tipo='".$id."' AND tipo=3 AND url IS NOT NULL 
	UNION 
	SELECT ao.id,ao.url,ao.etiqueta,'archivos_grupos_$tipo' as tabla
	FROM archivos_obras_$tipo ao LEFT JOIN obras_$tipo o ON ao.id_obras_$tipo = o.id
	WHERE o.id_grupos_$tipo='".$id."' AND ao.tipo=3 AND ao.url IS NOT NULL
");
	
	
	echo "<script>\n	var url=new Array();\n
	var nombre=new Array();\n"; 
	$i=0;
while($video = $db->sql_fetchrow($qVideos)){
	//echo "<h2>$video[etiqueta]</h2>";
	echo "url[".$i."]='".$video["url"]."';\n";
	echo "nombre[".$i."]='".$video["etiqueta"]."';\n";
	$i++;
	//echo $video["url"] . " <br/><br/>";
}
echo "</script>";
 ?>
 
 <script>
function getUrlVars(i) {
	var url2=url[i];
    var vars = {};
    var parts = url2.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
        vars[key] = value;
    });
    return vars;
}
for(i=0;i<url.length;i++){
var first = getUrlVars(i)["v"];
if(first!=undefined){
document.write('<h2>'+nombre[i]+'</h2>');
document.write('<object type="application/x-shockwave-flash" style="width:440px; height:366px;" data="http://www.youtube.com/v/'+first+'?version=3"><param name="movie" value="http://www.youtube.com/v/'+first+'?version=3" /><param name="allowFullScreen" value="true" /><param name="allowscriptaccess" value="always" /></object>');
}else{
	document.write('<h2>'+nombre[i]+'</h2>');
	document.write(url[i]);
	}
}
</script>
 


