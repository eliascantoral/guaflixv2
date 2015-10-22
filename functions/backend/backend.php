<?php 
	include_once("general.php");
	
	class backend{
			private function start_connect(){
						$con=mysqli_connect(DB_HOST2,DB_USER2,DB_PASSWORD2,DB_NAME2);						
						if (mysqli_connect_errno())
						  {
						  echo "Failed to connect to MySQL: " . mysqli_connect_error();
						  }
						return $con;				
				}

			private function close_connect($con){
						mysqli_close($con);					
				}
			private function encripter($key){
				return md5($key);
			}
                        private function makequery($query){
                            $status = false;
                            $return = "No se pudo realizar la conexión al server de base de datos.";                            
                            $link = $this->start_connect();
                            if($link){
                                $result = mysqli_query($link, $query);
                                if($result){
                                    $status = true;
                                    $return = $result;                                    
                                }else{
                                    $return = "No se pudor realizar la consulta.";
                                }
                                $this->close_connect($link);
                            }                            
                            return array($status, $return);
                        }
                        
 /********************************************************************************************************/
 /*********************************************************************************************************/
                        function trylogin($user, $pass){
                            $return = array(false, "Error 101");
                            $query = "SELECT `id`,`fname` FROM `user` WHERE `user`='".$user."' AND `password` = '".$this->encripter($pass)."';";
                            //echo $query;
                            $this->makelog($user, "try login", "Usuario '".$user."' intenta ingresar al sistema");
                            $result = $this->makequery($query);
                            if($result[0]){
                                while($row = mysqli_fetch_array($result[1])){
                                    $return = array(true, array($row['id'],$row['fname']));
                                    $this->makelog($user, "login", "Usuario '".$user."' ingreso al sistema");
                                }
                            }else{
                                $return = $result;
                            }
                            return $return;
                        }
                        function tryloginfb($userid){

                        }
/*********************************************************************************************************/                        
                        function get_objectuser($object, $limit = 100){
                            $userlist = array();
                            $query = "SELECT `user`.`id` as userid, 
                                                `user`.`name` as fname, 
                                                `user`.`last` as lname, 
                                                `user`.`mail` as email, 
                                            `user`.`username` as username, 
                                            `user_objeto`.`id` as userobjectid, 
                                            `paymethod`.`name` as paymethod, 
                                            `user_objeto`.`paytime` as paytime, 
                                            `user_objeto`.`timedead` as timedead 

                                        FROM `user_objeto` INNER JOIN `user` ON `user_objeto`.`user` = `user`.`id` INNER JOIN `paymethod` ON  `user_objeto`.`paymethod` = `paymethod`.`id`
                                        WHERE `user_objeto`.`object` = '".$object."' 
                                                AND `user_objeto`.`status`='1' 
                                        GROUP BY `user`.`id`
                                        LIMIT ".$limit;
                           
                            $result = $this->makequery($query);
                            if($result[0]){                                
                                while($row = mysqli_fetch_array($result[1])){
                                    array_push($userlist, $row);
                                }
                                return array(true,$userlist);
                            }
                            return array(false,$userlist);
                        }
                        
                        function get_userobjectlog($user, $object, $limit = 10){
                            $userlog = array();
                            $query = "SELECT * FROM user_object_log WHERE `userid`='".$user."' AND `objectid`='".$object."' ORDER BY `time` DESC LIMIT ".$limit.";";
                            //echo $query;
                            $result = $this->makequery($query);
                            if($result[0]){
                                while($row = mysqli_fetch_array($result[1])){
                                    array_push($userlog, $row);
                                }
                                return array(true, $userlog);
                            }
                            return array(false, $userlog);
                        }
                        function get_userdata($userid){
                            $query = "SELECT `name`,`last`,`username`,`mail` FROM `user` WHERE `id`='".$userid."';";
                            
                            $userdata = array();
                            $result = $this->makequery($query);
                            if($result[0]){                                
                                while($row = mysqli_fetch_array($result[1])){
                                    $userdata = array($row['name'],$row['last'],$row['username'],$row['mail']);                                    
                                }
                                return array(true, $userdata);
                            }
                            return array(false,$userdata);
                        }
                        function unsubscribe_user_object($user, $object){
                            $query = "UPDATE `user_objeto` SET `status` = '0' WHERE `user` = '".$user."' AND `object`='".$object."';";
                            $result = $this->makequery($query);
                            if($result[0]) return true;
                            return false;
                        }
/*********************************************************************************************************/ 
                        
	}
?>
