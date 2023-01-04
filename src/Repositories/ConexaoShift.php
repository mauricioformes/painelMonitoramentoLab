<?php
namespace Api\Repositories;
use Api\Util\ETipoAcesso;
use PDO;

class ConexaoShift
{
	protected $conn;
	protected $bind;
	private $sql;

	function __construct()
	{
		$this->connection();
		//$this->executeQuery("ALTER SESSION SET NLS_DATE_FORMAT = 'DD/MM/YYYY HH24:MI:SS'");

	}

	function connection(){

		$_username = "root";
		$_password = "";
		
		#teste
		// $_database="(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.10.36)(PORT = 1521))(CONNECT_DATA = (SERVER = DEDICATED)(SERVICE_NAME = teste_ha)))";

		#prod
		$_database="mysql:dbname=painel;host=127.0.0.1";
		
		try {
		    $_conn = new PDO($_database.";charset=utf8",$_username,$_password);

			$this->conn=$_conn;
		} catch(\PDOException $e){
			throw new \Exception("Usuário e/ou senha inválidos.");
    		exit;
		}

	}

	function select($_sql){
		unset($this->bind);
		unset($this->sql);

		$_query='SELECT '.$_sql["fields"].' FROM '.$_sql["tables"];

		if(isset($_sql["where"]) && count($_sql["where"])>0)
		{

			$_query.=$this->where($_sql["where"]);

			if(isset($_sql["econdition"]) && $_sql["econdition"]!="")
			{

				$_query.=' AND '.$_sql["econdition"];

			}


		}
		else
		{

			if(isset($_sql["econdition"]) && $_sql["econdition"]!="")
			{

				$_query.=' WHERE '.$_sql["econdition"];

			}
		}


		if(isset($_sql["order"]) && $_sql["order"]!="")
		{

			$_query.=' ORDER BY '.$_sql["order"][0].' '.$_sql["order"][1];

		}
		$this->sql=$_query;

		//echo $_query;
        if(isset($this->bind))
		    $results= $this->executeQuery($_query,$this->bind);
        else
            $results= $this->executeQuery($_query);

		return $results;

	}

	function where($_where)
	{
		$_queryWhere="";

		$_operators=array(	'=='=>'=',
							'!='=>'<>',
							'IN'=>'IN ( # )',
							'BETWEEN'=> '( #c BETWEEN #v1 AND #v2 )',
							'>'=>'>=');


		foreach ($_where as $_condition) {

			if(trim($_condition[0])=='OR')
			{
				$_increment=' OR ';
			}
			else
			{
				$_increment=' AND ';
			}

			$_findOperator=array_intersect($_condition, array_flip($_operators));

			//print_r($_findOperator);
			//echo count($_findOperator);
			if(count($_findOperator)>0)
			{
				foreach ($_findOperator as $_index => $_value) {
					$_op= $_operators[$_value];
					$_keyOperator=$_index;
					//echo $_value;
					//echo $_index;
				}

				//echo $_op;
				//echo $_keyOperator;

				$_keyCondition=array_search(array_search($_op, $_operators), $_condition);
				//print_r(array_search(array_search($_op, $_operators), $_condition));
				//	print_r($_keyCondition);
				//$_op=array_key_exists(key, search)
				//echo '--->'.strstr('#', $_op);


				if(!strstr('#', $_op))
				{
					//echo 2;

					switch ($_value) {
						case 'IN':
									$_queryWhere.=$_increment.' '.$_condition[$_keyCondition-1].' '.str_replace("#",  ' :'.$this->normalizeBind($_condition[$_keyCondition-1]), $_op);
									$this->parameters($this->normalizeBind($_condition[($_keyCondition-1)]),$_condition[($_keyCondition+1)]);
							break;

						case 'BETWEEN':
									$_arrayReplace=array('#c'=>$_condition[$_keyCondition-1],
														 '#v1'=>':'.$this->normalizeBind($_condition[$_keyCondition-1].'_1'),
														 '#v2'=>':'.$this->normalizeBind($_condition[$_keyCondition-1].'_2'));

									$_queryWhere.=$_increment.strtr($_op, $_arrayReplace);
									$this->parameters($this->normalizeBind($_condition[$_keyCondition-1].'_1'),$_condition[$_keyCondition+1]);
									$this->parameters($this->normalizeBind($_condition[$_keyCondition-1].'_2'),$_condition[$_keyCondition+2]);

									//echo $_queryWhere.=' '.$_condition[$_keyCondition-1].' '.$_op.' :'.$this->normalizeBind($_condition[$_keyCondition+2]).$_increment;
									//$this->parameters($_condition[($_keyCondition-1)],$_condition[($_keyCondition+1)]);
							break;
						default:
								//echo 'default';
								$_queryWhere.=$_increment.$_condition[$_keyCondition-1].' '.$_op.' :'.$this->normalizeBind($_condition[$_keyCondition-1]);
								//echo $_condition[($_keyCondition-1)].'<>'.$_condition[($_keyCondition+1)];
								//echo $this->normalizeBind($_condition[($_keyCondition-1)]).'<>'.$_condition[($_keyCondition+1)];
								$this->parameters($this->normalizeBind($_condition[($_keyCondition-1)]),$_condition[($_keyCondition+1)]);
							break;
					}

					// $_queryWhere.=' '.$_condition[$_keyCondition-1].' '.$_op.' :'.$this->normalizeBind($_condition[$_keyCondition-1]).$_increment;
					// $this->parameters($_condition[($_keyCondition-1)],$_condition[($_keyCondition+1)]);
				}
				else
				{
					// echo  ' '.$_condition[$_keyCondition-1].' '.$_op.' '.$_increment;
					$_queryWhere.=$_increment.str_replace('#', ' :'.$this->normalizeBind($_condition[$_keyCondition-1]).' ', ' '.$_condition[$_keyCondition-1].' '.$_op);
					$this->parameters($this->normalizeBind($_condition[($_keyCondition-1)]),$_condition[($_keyCondition+1)]);

				}

			}
			else
			{
				 $_queryWhere.=$_increment.' '.$_condition[0].' = :'.$this->normalizeBind($_condition[0]);
				$this->parameters($this->normalizeBind($_condition[0]),$_condition[1]);
			}



		}

		return ' WHERE '.substr($_queryWhere,4);

	}

	function parameters($_index,$_value)
	{
		//echo $_index.'<->'.$_value;
		$this->bind[':'.$_index]=$_value;
		//array_push($this->bind, [':'.$_index=>$_value]);
	}

	function normalizeBind($_string)
	{
		return str_replace(".", "_", $_string);
	}

	function executeQuery($_query,$_bind=null,$_retorno=false)
	{

		$this->bind = $_bind;

		$this->sql=$_query;
		try {


			$_sql=$this->conn->prepare($_query);

			if(isset($_bind) && $_bind!=NULL){
				foreach ($_bind as $key => &$value ) {

					$_sql->bindParam($key,$value);
					
				}
			}


			$this->conn->beginTransaction();
		 	$_sql->execute();

			$_tipoQuery=strtoupper(substr(trim($_query),0,6));

			if($_tipoQuery=='SELECT' )
			{
				$_resultado=array();
				while($_row=$_sql->fetch(\PDO::FETCH_ASSOC)) {
					  $_resultado[]=$_row;
			    }


			    $this->conn->commit();
			    return $_resultado;
			}
			elseif($_tipoQuery=='INSERT'){
				$this->conn->commit();
				return true;
			}
			elseif($_tipoQuery=='DELETE'){
				$this->conn->commit();
				return true;

			}
			elseif($_tipoQuery=='UPDATE'){
				$this->conn->commit();
				return true;

			}
			else{
				$this->conn->commit();
				return true;
			}


		} catch(\PDOException $e) {
		    echo 'ERROR TRY: ' . $e->getMessage();
		    echo '<br/>';
		    echo 'Query:'.$_query;
		    echo '<br/>';
		    echo 'Bind:';
		    print_r($_bind);
		    echo '<pre>';
		    //print_r($e);
		    echo $this->showQuery();
		    echo '</pre>';
		    
		}

	}

	function update($_sql)
	{
		unset($this->bind);
		$_query='UPDATE '.$_sql["tables"].' SET ';
		$_set="";
		$key="";
		foreach ($_sql["set"] as $key => $value) {
			//$this->parameters('1',1);
			$_set.=''.$key.'= :'.$key.'_ , ';
			//echo $this->normalizeBind($key.'_').'->'.$value;
			$this->parameters( $this->normalizeBind($key.'_'),  $value);
		}

		$_query.=substr($_set,0,-2);

		if(isset($_sql["where"]) && count($_sql["where"])>0)
		{

			$_query.=$this->where($_sql["where"]);

			if(isset($_sql["econdition"]) && $_sql["econdition"]!="")
			{

				$_query.=' AND '.$_sql["econdition"];

			}
		}
		else
		{

			if(isset($_sql["econdition"]) && $_sql["econdition"]!="")
			{

				$_query.=' WHERE '.$_sql["econdition"];

			}
		}

		return $this->executeQuery($_query,$this->bind);
	}


	function insert($_sql)
	{
		unset($this->bind);
		$_query='INSERT INTO '.$_sql["tables"].' ';

		$_into="";
		$_value="";

		foreach ($_sql["values"] as $key => $value) {
			//$this->parameters('1',1);
			$_into.=$key.' , ';
			$_value.=':'.$key.' , ';
			//echo $this->normalizeBind($key.'_').'->'.$value;
			$this->parameters( $this->normalizeBind($key),  $value);
		}

		$_query.='('.substr($_into,0,-2).') VALUES ('.substr($_value,0,-2).')';

		return $this->executeQuery($_query,$this->bind);

	}

	function delete($_sql)
	{
		unset($this->bind);
		$_query='DELETE FROM '.$_sql["tables"].' ';

		if($_sql["where"] && count($_sql["where"])>0)
		{

			$_query.=$this->where($_sql["where"]);
		}
		else
		{

			if(isset($_sql["econdition"]) && $_sql["econdition"]!="")
			{

				$_query.=' WHERE '.$_sql["econdition"];

			}
		}

		//return $_query;
		return $this->executeQuery($_query,$this->bind);


	}

	public function showQuery(){
		$query=$this->sql;

	    foreach($this->bind AS $key => $value){
	        $query=str_replace($key,"'".$value."'",$query);
	    }

	 	return $query;
	}
}
