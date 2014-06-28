
<form method="post">
	<input name="a"/><br />
	<input name="b"/>
	<input type="submit" value="go" />
	<input type="button" value="i dont do anything" />
</form>

<br />
<br />

<?php

class z {
	var $hi;
	var $bi;

	function __construct($a, $b) {
		$this->hi = $a;
		$this->bi = $b;
	}

	function boomerang($hello, $goodbye) {
		echo "fudgiemuffins" . $hello . $this->bi . $this->hi;
	}
}

$f = new z(10, 15);
// z { hi = 10, bi = 15 }

echo $f->bi;
echo $f->boomerang("unified", "boom");


$password = "cool";
echo $_GET['a'];
echo $_GET['b'];
echo $_POST['a'];
?>