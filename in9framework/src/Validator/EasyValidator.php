<?php
namespace In9\Validator;

/**
 * @uses Respect\Validation\Validator
 */

use Respect\Validation\Validator as v;

/**
 * Classe criada para facilitar a validação de dados vindos de formulários.
 */

class EasyValidator{

	private $funcs = [];

	public function add($key, $function){
		$this->funcs[$key] = $function;
		return $this;
	}

	public function exists($key){
		if($this->funcs[$key]){
			return true;
		}
		return false;
	}

	public function call($key, $val=""){
		if($this->exists($key)){
			return $this->funcs[$key]($val);
		}

	}

	public function v($valid_regras, $valor){
		$messages = [];
		$pass = true;

		if($valid_regras)
			foreach($valid_regras as $item){

				$message_error = $item[key($item)];
				$array_regras =  explode(",", trim(key($item)));

				$obj = null;
				$boolean_expected = false;

				foreach($array_regras as $regra){
					$func_name = lcfirst(str_replace(" ",'',ucwords(str_replace('-', ' ', $regra))));


					if(strstr($func_name, ":") !== false){

						$booleanOperator = strtolower(end(explode(':', $func_name)));
						$func_name = end(array_reverse(explode(':', $func_name)));

						if($booleanOperator == "true")
							$boolean_expected = true;
					}

					if($obj == null)
						$obj = v::$func_name();
					else
						$obj -> $func_name();

				}

				if($obj -> validate($valor) === $boolean_expected)
					$messages[] = $message_error;
			}

		return $messages;
	}

	public static function validator($data, $except=[], $funcs = []){
		$errors = [];
		$validator = new EasyValidator();

		if($data){
			foreach($data as $key => $value){
				if(array_search($key, $except) !== FALSE)	continue;

				if($funcs)
					foreach($funcs as $key2 => $func){
						$validator -> add($key2, $func);
					}

				if($validator->exists($key)){
					$error = $validator -> v($validator -> call($key), $value);

					if($error)
						$errors[$key] = $error;
				}
				else throw new \Exception('Não existe validação para o campo "<b>'.$key.'</b>",
				por favor, crie um metodo de validação para o objeto \App\Helper\Validator.
				<br /><br /> <b>Exemplo</b>:
				<pre>
				public function '.$key.'(){
					return $this->v([
						["string, not-empty" => "Este campo não pode ser vasio"],
					]);
				}
					</pre>');
			}
		}
		return $errors;
	}


}
