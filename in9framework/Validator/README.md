# In9 Easy Validator

Simplifica validação dos campos de um formulário. Uma das maiores vantagens é a reutilização da validação para diversos formulários, alocando tudo em uma classe especifica.

## Dependencias ##

Esta classe depende do pacote de validação https://github.com/Respect/Validation

## Instalação ##

Para instalar esta classe você poderá usar o composer ou fazer o donwload direto do github.

## O pacote ##

O pacote de classes está organizado da seguinte forma:

```
In9\
	Validator\
		EasyValidator
```

## Utilização ##

```php
<?php
	/* configurações de autoloader psr-4 */
	use \In9\Validator\EasyValidator;

	class MyClassValidator extends EasyValidator{
		public function __construct(){
			$this->add('name', function(){
				return [
					['notEmpty' => 'Este campo não pode ser vasio'],
					['alpha','notEmpty:false' => 'Este campo só deve conter caracteres alfabéticos ']
				];
			});
		}
	}
?>
```
No arquivo de onde os dados do formulário são pegos faremos algo do tipo. Lembrando que os dados vindos do formulário devem estar no formato:

['key' => 'value', 'key' => 'value']

Ex: form.php

<?php
	
?>
