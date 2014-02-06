<? echo $javascript_entidad?>
<style>
table {
-webkit-border-bottom-left-radius: 20px;
border-bottom-left-radius: 20px;
-webkit-border-top-left-radius: 20px;
border-top-left-radius: 20px;
-moz-border-radius-bottomleft: 20px;
-moz-border-radius-topleft: 20px;
-webkit-border-bottom-right-radius: 20px;
border-bottom-right-radius: 20px;
-webkit-border-top-right-radius: 20px;
border-top-right-radius: 20px;
-moz-border-radius-bottomright: 20px;
-moz-border-radius-topright: 20px;
text-align: justify;
font-size: 13px;
color: #3D1211;}
</style>
<table width="100%" align="center" cellpadding="0" cellspacing="0" bgcolor="#E7D8B1">
  <tr>
    <td ><table width="100%"  border="0" cellpadding="0" cellspacing="5" >
      <tr>
        <td>
					<table width="100%"  border="0" cellpadding="0" cellspacing="0" >
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table>
          <table width="100%"  cellpadding="4" cellspacing="1" >
          <tr >
                <td align="left">
									<!--<span class="style2">--><h2>EVALUACIÓN DEL GRUPO: </h2><!--</span>-->
								</td>
            </tr>
<? if(isset($frm["mensajeDeError"]) && $frm["mensajeDeError"]!=""){?>
          <tr >
	          <td align="left">
							<span><?=$frm["mensajeDeError"]?></span>
						</td>
          </tr>
<?}?>
        </table>
					<!--<form name="entryform" action="<?=$ME?>?mercado=<?=$CFG->mercado?>" method="POST" enctype="multipart/form-data" onSubmit="return revisar()">-->
                    <form name="entryform" action="index.php?modo=curadores&mode=listar_grupos&a=1" method="POST" enctype="multipart/form-data" onSubmit="return revisar()">
					<?
						$pk=$entidad->getAttributeByName($entidad->get("primaryKey"));
					?>
						<input type="hidden" name="modo" value="curadores" />
                        <input type="hidden" name="module" value="<?=$entidad->get("name");?>">
						<input type="hidden" name="mode" value="<?=$entidad->get("newMode");?>">
						<input type="hidden" name="<?=$entidad->get("primaryKey")?>" value="<?=$pk->get("value");?>">
						<br>        
            <table width="100%"  border="0" cellpadding="2" cellspacing="1"   style="width:100%px">
<!--	********************************************	-->
<? echo $string_entidad;?>
<!--	********************************************	-->


						</table>
<!--	********************************************	-->
<?
if($entidad->get("newMode")!="insert"){
for($i=0;$i<sizeof($entidad->relationships);$i++){
	$relation=$entidad->getRelationshipByIndex($i);
?>
<!--	********************************************	-->
        <br>
        <table width="100%"   cellpadding="4" cellspacing="1" >
          <tr >
                <td align="left"><span class="style2"><?=$relation->get("label");?>:</span></td>
          </tr>
        </table>
        <br>
        <table width="300"  border="0" cellpadding="0" cellspacing="1" >
              <tr > 
                <td >
									<iframe src="relation.php?name=<?=$relation->get("name")?>&masterTable=<?=$entidad->get("name")?>&masterFieldValue=<?=$relation->get("masterFieldValue")?>" frameborder="1" width="100%" height="200" scrolling="auto" name="postit_iframe"></iframe>
								</td>
              </tr>
				</table>
<!--	********************************************	-->
<?
}
}
?>
<!--	********************************************	-->

            <table width="100%"  border="0" cellpadding="0" cellspacing="0" >
              <tr> 
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr> 
                <td colspan="2">
									<table width="100%" border="0" cellspacing="0" cellpadding="3">
                    <tr>
                      <td>
												<input type="Submit" style="font-size:14px; background-color:#3D1211; color:#FFF; cursor:pointer" value="Enviar">
												<!--<input type="button" style="font-size:8pt" value="Cancelar" onClick="window.location.href='<?=$ME?>?mercado=<?=$CFG->mercado ?>&modo=curadores&mode=listar_grupos';">-->
                                               <!-- <input type="button" style="font-size:14px; cursor:pointer" value="Cancelar" onClick="window.location.href='index.php?modo=curadores&mode=listar_grupos&a=1'">-->
											</td>
                    </tr>
                  </table>
								</td>
              </tr>
            </table>
					</form>
				</td>
      </tr>
    </table></td>
  </tr>
</table>
