<?php
Class load_utility extends PDO{
    protected $_fetchMode        = PDO::FETCH_ASSOC;
    protected $_transactionCount = 0;

    public function  __construct($dsn, $user = '', $passwd = '', $options = NULL){
        $driver_options = array(
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
        );
        if(!empty($options)){
            $driver_options = array_merge($driver_options, $options);
        }
        parent::__construct($dsn, $user, $passwd, $driver_options);
    }

    private function _prepare($sql, $bind = array()){

        $stmt = $this->prepare($sql);
        if(!$stmt){
            $errorInfo = $this->errorInfo();
            throw new PDOException("Database error [{$errorInfo[0]}]: {$errorInfo[2]}, driver error code is $errorInfo[1]");
        }
        if(!is_array($bind)){
            $bind = empty($bind) ? array() : array($bind);
        }
        if(!$stmt->execute($bind) || $stmt->errorCode() != '00000'){
            $errorInfo = $stmt->errorInfo();
            throw new PDOException("Database error [{$errorInfo[0]}]: {$errorInfo[2]}, driver error code is $errorInfo[1]");
        }
		
		//echo $stmt->queryString;
        return $stmt;
    }

    public function run($sql, $bind = array()){
        $stmt = $this->_prepare($sql, $bind);
        return $stmt->rowCount();
    }

    public function setFetchMode($fetchMode){
        $this->_fetchMode = $fetchMode;
        return $this;
    }

    public function where($where, $andOr = 'AND'){
        if(is_array($where)){
            $tmp = array();
            foreach($where as $k => $v){
                $tmp[] = $k . '=' . $this->quote($v);
            }
            return '(' . implode(" $andOr ", $tmp) . ')';
        }
        return $where;
    }

    public function select($table, $fields = "*", $where = "", $bind = array(), $order = NULL, $limit = NULL){
       
	    $sql = "SELECT " . $fields . " FROM " . $table;
        if(!empty($where)){
            $where = $this->where($where);
            $sql .= " WHERE " . $where;
        }
        if(!empty($order)){
            $sql .= " ORDER BY " . $order;
        }
        if(!empty($limit)){
            $sql .= " LIMIT " . $limit;
        }
		//echo $sql; exit;

        $stmt = $this->_prepare($sql, $bind);
        return $stmt->fetchAll($this->_fetchMode);
    }
	
	
	
	   public function join_query($table_join, $fields = "*", $where = "", $bind = array(), $order = NULL, $limit = NULL){
       
	    $sql = "SELECT " . $fields . " FROM " . $table_join;
        if(!empty($where)){
            $where = $this->where($where);
            $sql .= " WHERE " . $where;
        }
        if(!empty($order)){
            $sql .= " ORDER BY " . $order;
        }
        if(!empty($limit)){
            $sql .= " LIMIT " . $limit;
        }
		//echo $sql; //exit;
        $stmt = $this->_prepare($sql, $bind);
		//echo $stmt->queryString; 
		//echo ">>>".$stmt->debugDumpParams();
        return $stmt->fetchAll($this->_fetchMode);
    }
	
	
	

    public function insert($table, $data){
        $fieldNames = array_keys($data);
        $sql = "INSERT INTO `$table` (" . implode($fieldNames, ", ") . ") VALUES (:" . implode($fieldNames, ", :") . ");";
        $bind = array();
        foreach($fieldNames as $field){
            $bind[":$field"] = $data[$field];
        }
		//echo $sql;die;
		//print  strtr($sql, $bind); die;
        return $this->run($sql, $bind);
    }

    public function bulkInsert($table, $fieldNames, $data, $replace = false){
       
	    if(empty($table) || empty($fieldNames) || empty($data)){
            return 0;
        }
		
        $fieldCount = count($fieldNames);
        $valueList = '';
        foreach ($data as $values){
            $dataCount = count($values);
            if($dataCount != $fieldCount){
                if($dataCount > $fieldCount){
                    $values = array_slice($values, 0, $fieldCount);
                }
                else{
                    throw new PDOException("Number of columns and values not match!");
                }
            }
            foreach ($values as &$val){
                if (is_null($val)){
                    $val = 'NULL';
                }
                elseif(is_string($val)){
                    $val = $this->quote($val);
                }
                elseif(is_object($val) || is_array($val)){
                    $val = $this->quote(json_encode($val));
                }
            }
            $valueList .= '(' . implode(',', $values) . '),';
        }
        $valueList = rtrim($valueList, ',');
        $insert = $replace ? 'REPLACE' : 'INSERT';
        $sql = "$insert INTO `$table` (" . implode(', ', $fieldNames) . ") VALUES " . $valueList . ";";
        return $this->run($sql);
    }

    public function update($table, $data, $where = "", $bind = array()){
        $sql = "UPDATE `$table` SET ";

        $comma = '';
        if(!is_array($bind)){
            $bind = empty($bind) ? array() : array($bind);
			
        }
        foreach($data as $k => $v){
            $sql .= $comma . $k . " = :upd_" . $k;
            $comma = ', ';
            $bind[":upd_" . $k] = $v;
        }
        if(!empty($where)){
            $where = $this->where($where);
            $sql .= " WHERE " . $where;
        }

		///echo strtr($sql); die;
        return $this->run($sql, $bind);
    }

    public function delete($table, $where, $bind = array()){
        $sql = "DELETE FROM `$table`";
        if(!empty($where)){
            $where = $this->where($where);
            $sql .= " WHERE " . $where;
        }
		//echo $sql;die;
        return $this->run($sql, $bind);
    }

    public function inquery($sql){

        return $this->run($sql);
    }

    public function truncate($table){
        $sql = "TRUNCATE TABLE `$table`";
        return $this->run($sql);
    }

    public function save($table, $data, $where = "", $bind = array()){
        $count = 0;
        if(!empty($where)){
            $where = $this->where($where);
            $count = $this->fetchOne("SELECT COUNT(1) FROM $table WHERE $where", $bind);
        }
        if($count == 0){
            return $this->insert($table, $data);
        }
        else{
            return $this->update($table, $data, $where, $bind);
        }
    }

    public function fetchOne($sql, $bind = array()){
        $stmt = $this->_prepare($sql, $bind);
        return $stmt->fetchColumn(0);
    }

    public function fetchRow($sql, $bind = array()){
		$stmt = $this->_prepare($sql, $bind);
		return $stmt->fetch($this->_fetchMode);
    }

    public function fetchAll($sql, $bind = array()){
        $stmt = $this->_prepare($sql, $bind);
		//print  strtr($sql, $bind); die;
		//echo 'query'.$sql;die;
        return $stmt->fetchAll($this->_fetchMode);
    }

    public function fetchAssoc($sql, $bind = array()){
        $stmt = $this->_prepare($sql, $bind);
        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $result = array();
        if(!empty($records)){
            $k0 = key($records[0]);
            foreach($records as $rec){
                $result[$rec[$k0]] = $rec;
            }
        }
        return $result;
    }

    public function fetchAssocArr($sql, $bind = array()){
        $stmt = $this->_prepare($sql, $bind);
        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $result = array();
        if(!empty($records)){
            $k0 = key($records[0]);
            foreach($records as $rec){
                $result[$rec[$k0]][] = $rec;
            }
        }
        return $result;
    }

    public function fetchPairs($sql, $bind = array()){
        $stmt = $this->_prepare($sql, $bind);
        return $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
    }

    public function fetchCol($sql, $bind = array()){
        $stmt = $this->_prepare($sql, $bind);
        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $result = array();
        if(!empty($records)){
            $k0 = key($records[0]);
            foreach($records as $rec){
                $result[] = $rec[$k0];
            }
        }
        return $result;
    }

    public function createTable($table, $fieldNames, $fieldTypes, $defaultValues, $fieldComments, $primaryKey = '', $indexes = array(), $dbEngine = 'InnoDB', $charset='utf8'){
        $sql = "CREATE TABLE IF NOT EXISTS `$table` (";
        foreach($fieldNames as $i => $fieldName){
            $sql .= "`$fieldName` " . $fieldTypes[$i];
            if(!empty($defaultValues[$i])){
                $sql .= " DEFAULT " . $defaultValues[$i];
            }
            if(!empty($fieldComments[$i])){
                $sql .= " COMMENT '" . $fieldComments[$i] . "'";
            }
            $sql .= ", ";
        }
        if(empty($primaryKey)){
            $primaryKey = $fieldNames[0];
        }
        $sql .= " PRIMARY KEY $primaryKey";
        foreach($indexes as $i => $index){
            $sql .= ",INDEX index_{$i} $index";
        }
        $sql .= ") ENGINE={$dbEngine} DEFAULT CHARSET={$charset};";
        return $this->run($sql);
    }

    public function dropTable($table){
        $sql = "DROP TABLE IF EXISTS `$table`;";
        return $this->run($sql);
    }

    public function beginTransaction(){
        if (!$this->_transactionCount++){
            return parent::beginTransaction();
        }
        $this->exec('SAVEPOINT trans'.$this->_transactionCount);
        return $this->_transactionCount >= 0;
    }

    public function commit(){
        if (!--$this->_transactionCount){
            return parent::commit();
        }
        return $this->_transactionCount >= 0;
    }

    public function rollback(){
        if (--$this->_transactionCount){
            $this->exec('ROLLBACK TO trans'.($this->_transactionCount + 1));
            return true;
        }
        return parent::rollback();
    }

    public function hasTransaction(){
       return $this->_transactionCount > 0;
    }

    public function validateUserInput($array){
        if($array){
            foreach($array as $key=> $val){
                 $array[$key]    = strip_tags(addslashes(trim($val)));
            }
        }
       return $array;
    }

    function short_name($str, $limit){
        if($limit < 3){
          $limit = 3;
        }
        if(strlen($str) > $limit){
          $str 	= substr($str, 0, $limit - 3) . '...';
          $str	= stripslashes(strip_tags($str));
          return $str;
        }
        else{
          return $str;
        }
     }

     function youtube_id_from_url($url){
         $pattern =
                 '%^# Match any youtube URL
                 (?:https?://)?  # Optional scheme. Either http or https
                 (?:www\.)?      # Optional www subdomain
                 (?:             # Group host alternatives
                   youtu\.be/    # Either youtu.be,
                 | youtube\.com  # or youtube.com
                   (?:           # Group path alternatives
                     /embed/     # Either /embed/
                   | /v/         # or /v/
                   | /watch\?v=  # or /watch\?v=
                   )             # End path alternatives.
                 )               # End host alternatives.
                 ([\w-]{10,12})  # Allow 10-12 for 11 char youtube id.
                 $%x';
         $result = preg_match($pattern, $url, $matches);
         if($result){
             return $matches[1];
         }
         return false;
     }

     function mail_attachment($filename, $path, $mailto, $from_mail, $from_name, $replyto, $subject, $message){
         $file = $path.$filename;
         $file_size = filesize($file);
         $handle = fopen($file, "r");
         $content = fread($handle, $file_size);
         fclose($handle);
         $content = chunk_split(base64_encode($content));
         $uid = md5(uniqid(time()));
         $name = basename($file);
         $header = "From: ".$from_name." <".$from_mail.">\r\n";
         $header .= "Reply-To: ".$replyto."\r\n";
         $header .= "MIME-Version: 1.0\r\n";
         $header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";
         $header .= "This is a multi-part message in MIME format.\r\n";
         $header .= "--".$uid."\r\n";
         $header .= "Content-type:text/html; charset=iso-8859-1\r\n";
         $header .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
         $header .= $message."\r\n\r\n";
         $header .= "--".$uid."\r\n";
         $header .= "Content-Type: application/octet-stream; name=\"".$filename."\"\r\n"; // use different content types here
         $header .= "Content-Transfer-Encoding: base64\r\n";
         $header .= "Content-Disposition: attachment; filename=\"".$filename."\"\r\n\r\n";
         $header .= $content."\r\n\r\n";
         $header .= "--".$uid."--";
         if(mail($mailto, $subject, "", $header)){
             return 1;
         }
         else{
             return 0;
         }
     }

     function prepare_url($string){
         $string = strtolower(stripslashes(trim($string)));
         $string = preg_replace("/[^a-z0-9_\s\/\-]/", "", $string);
         $string = preg_replace("/[\s-]+/", " ", $string);
         $string = preg_replace("/[\s_\/]/", "-", $string);
         $string = preg_replace("/[\s-]+/", "-", $string);
         return $string;
     }

     public function get_extension($filename){
         $x = explode('.', $filename);
         return '.'.end($x);
     }

     function resizeImage($temppath, $resizepath, $width, $height, $extension){
         list($w_orig, $h_orig) = getimagesize($temppath);
         $scale_ratio = $w_orig / $h_orig;

         if(($width / $height) > $scale_ratio){
             $width = $height * $scale_ratio;
         }
         else{
             $height = $width / $scale_ratio;
         }
         $img = "";
         $ext = strtolower($extension);

         if($ext == "gif"){
             $img = imagecreatefromgif($temppath);
         }
         elseif($ext =="png"){
             $img = imagecreatefrompng($temppath);
         }
         elseif($ext == "bmp"){
             $img = imagecreatefromwbmp($temppath);
         }
         else{
             $img = imagecreatefromjpeg($temppath);
         }

         $tci = imagecreatetruecolor($width, $height);

         imagecopyresampled($tci, $img, 0, 0, 0, 0, $width, $height, $w_orig, $h_orig);
         imagejpeg($tci, $resizepath, 80);
     }

     public function validateUserString($string){
        return $string;
     }

     function getToken($length = 6){
         return substr(md5(rand().rand()), 0, $length);
     }

     function stringPad($data,$pad_length,$pad_element,$prefix){
         $token = str_pad($data,$pad_length,$pad_element,STR_PAD_LEFT);
         $token = $prefix.$token;
         return $token;
     }

     function finddate($currentdate,$interval,$addorminus,$IntervalType){
         $date = $currentdate;
         if(strtoupper($IntervalType)=="DAY"){
             $IntervalType="day";
         }
         if(strtoupper($IntervalType)=="MONTH"){
             $IntervalType="month";
         }
         if(strtoupper($IntervalType)=="YEAR"){
             $IntervalType="year";
         }
         if(strtoupper($addorminus)=="ADD"){
             $newdate = strtotime ( "+".$interval." ".$IntervalType  , strtotime ( $date ) ) ;
         }
         if(strtoupper($addorminus)=="MINUS"){
             $newdate = strtotime ( "-".$interval." ".$IntervalType  , strtotime ( $date ) ) ;
         }
         $newdate = date ( 'Y-m-j' , $newdate );
         return $newdate;
     }

     private function clearArray($array){
         if(!is_array($array) || count($array)==0){
            die("<span style='color:red;font-size:12px;font-weight:bold;'>Database Field error :  -Please Contact your Software Support</span>");
         }
         $this->fields        = $this->optimiseFields();
         foreach($array as $key => $val){
             if(!array_key_exists($key, $this->fields)){
                 unset($array[$key]);
             }
             else{
                 $val = mysqli_real_escape_string($val);
             }
         }
         return $array;
     }

     function getPageLink($pgNo, $totPage, $url, $count = "5"){
 		$intPre 	= $pgNo - 1;
 		$intNex 	= $pgNo + 1;
 		$intFirst 	= $pgNo - 5;
 		$intLast 	= $pgNo + 5;
 		$strReturn  ="";

 		if($intFirst <= 0){
 			$intFirst	= 1;
 		}

 		if($intLast >= $totPage){
 			$intLast	= $totPage;
 		}

 		if($intPre <= 0){
 			$intPre		= 1;
 		}
 		else{
 			$strReturn	= str_replace("{pgNo}", "$intPre", $url);
 			$strReturn	= str_replace("{pgTxt}", "<div class='pagelinkBorder pagination pagination-sm no-margin pull-right' style='width=50px;'>&nbsp;Previous&nbsp;</div>", $strReturn);
 		}

 		for($i = $intFirst; $i <= $intLast; $i++){
 			if ($i != $pgNo) {
 				$strTemp	= str_replace("{pgNo}", "$i", $url);
 				$strReturn	.= str_replace("{pgTxt}", "<div class='pagelinkBorder pagination pagination-sm no-margin pull-right' style='width:18px;'>&nbsp;$i&nbsp;</div>", $strTemp);
 			}
            else{
 				$strReturn	.= "<td align='center' valign='middle' class='ashtxt pagination pagination-sm no-margin pull-right' ><div class='currentpagelinkBorder' style='width:18px;'>&nbsp;$i&nbsp;</div></td>";
 			}
 		}
 		if($intNex > $totPage){
 			$intNex		= $totPage;
 		}
 		else{
 			$strTemp	= str_replace("{pgNo}", "$intNex", $url);
 			$strReturn .= str_replace("{pgTxt}", "<div class='pagelinkBorder' style='width=50px;'>&nbsp;Next&nbsp;</div>", $strTemp);
 		}
 		return $strReturn;
 	}

    function CalculateAge($BirthDate){
        list($Year, $Month, $Day) = explode("/", $BirthDate);
        $YearDiff = date("Y") - $Year;
        if(date("m") < $Month || (date("m") == $Month && date("d") < $DayDiff)){
            $YearDiff--;
        }
        return $YearDiff;
   }

   function nicetime($date){
       if(empty($date)){
           return "No date provided";
       }
       $periods   = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
       $lengths   = array("60","60","24","7","4.35","12","10");
       $now       = time();
       $unix_date = strtotime($date);

       if(empty($unix_date)){
           return "Bad date";
       }

       if($now > $unix_date){
           $difference = $now - $unix_date;
           $tense      = "ago";

       }
       else{
           $difference = $unix_date - $now;
           $tense      = "from now";
       }

       for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++){
           $difference /= $lengths[$j];
       }

       $difference = round($difference);

       if($difference != 1) {
           $periods[$j].= "s";
       }
       return "$difference $periods[$j] {$tense}";
    }

    function alter(&$val, $key){
        $val = "$key = '$val'";
    }

    function validateUsername($username){
        $username = trim($username);
        if(isset($username)){
             if(!eregi('/^[a-zA-Z0-9_]{3,10}$/', $username)){
                return false;
            }
            else{
                return true;
            }
        }
        else{
            return false;
        }
    }

    function validatePasswords($password1,$password2){
        if(isset($password1) && isset($password2)){
            $password1 = trim($password1);
            $password2 = trim($password2);
            if($password1 <> $password2){
                return false;
            }
            else{
                return true;
            }
        }
        else{
            return false;
        }
    }

    function validateEmail($email){
        $email = trim($email);
        if(isset($email)){
            if (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)){
                return false;
            }
            else{
                return true;
            }
        }
        else{
             return false;
        }
    }

    function checkNull($field){
        $field = trim($field);
        if($field == ""){
            return false;
        }
        else{
            return true;
        }
    }

	function imageupload($imagename,$path,$tmp_name,$last_id,$table,$fieldname,$Idname)
	{


	$check=substr($image,-3);
	$extnsn=trim($check);
	if(($extnsn!="jpeg")&&($extnsn!="JPEG")&&($extnsn!="jpg")&&($extnsn!="JPG")&&($extnsn!="gif")&&($extnsn!="GIF")&&($extnsn!="png")&&($extnsn!="PNG"))
		{
			return false;
		}

	$setdir_images = $path;
	$orgname	   = $imagename;
	$rndId 		   =  rand(5,500);
	$f_ext		   = explode(".",strtolower($orgname));
	$path1		   = $setdir_images."big".$rndId.".".$f_ext[1];
	$newname	   = date("YmdHis")."-pdf-".$rndId.".".$f_ext[1];
	$path_th1	   = $setdir_images.$newname;
	move_uploaded_file($tmp_name, $path_th1);

	if($newname!='' && !empty($imagename))
				{


					 $UpdateArray = array(
							$fieldname		=> $imagename

					 );

					 $where = array(
							$Idname          => $last_id
					);


					if($objCareers->update($table, $UpdateArray, "$Idname = :".$Idname,  $where)){
						return true;
					}else{
						return false;
					}
				}


	}

    function getCategoryTitle($categoryid){
        if(intval($categoryid) > 0){
            $sql  = "SELECT title FROM tbl_categories WHERE id = :id";
            $bind = array(":id" => $categoryid);
            $data = $this->fetchRow($sql, $bind);
            return $data['title'];
        }
        else{
            return NULL;
        }
    }
	
	
	 function getParentCatId($categoryid){
        if(intval($categoryid) > 0){
            $sql  = "SELECT parent_category_id FROM tbl_categories WHERE id = :id";
            $bind = array(":id" => $categoryid);
            $data = $this->fetchRow($sql, $bind);
            return $data['parent_category_id'];
        }
        else{
            return NULL;
        }
    }
	
	
	
}
