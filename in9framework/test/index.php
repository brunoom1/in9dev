<?php
	define("DS", DIRECTORY_SEPARATOR);
	define('PATH', dirname(dirname(__FILE__)));
	require PATH . DS . 'vendor' . DS . 'autoload.php';

	use \In9\Validator\EasyValidator as ev;

	if($_POST){

		$errors = ev::validator($_POST, [], [
			'nome' => function(){
				return [
					['notEmpty' => "O campo nome, não pode ser vasio"]
				];
			}
		]);

		print_r($errors);
	}


?>

<p>
	<br >
</p>

<form action="" method="post">
	<label for="">
		Nome: <input name="nome" value="" />
	</label>

	<input type="submit" value="enviar" />
</form>
