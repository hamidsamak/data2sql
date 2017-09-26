<!--
/*
 * Data 2 SQL
 * Hamid Samak
 * https://github.com/hamidsamak/data2sql
 */
-->

<?php

if (isset($_POST['data']) && empty($_POST['data']) === false) {
	print '<pre>';

	$table = $_POST['table'];
	$columns = empty($_POST['columns']) ? [] : explode(',', $_POST['columns']);
	$skip_columns = empty($_POST['skip_columns']) ? [] : explode(',', $_POST['skip_columns']);

	$data = trim($_POST['data']);
	$data = explode("\n", $data);
	$data = array_map('trim', $data);
	$data = array_filter($data);

	foreach ($data as $value) {
		$value = explode("\t", $value);

		foreach ($skip_columns as $key)
			if (isset($value[$key - 1]))
				unset($value[$key - 1]);

		print 'INSERT INTO `' . $table. '` (`' . implode('`, `', $columns) . '`) VALUES (\'' . implode('\', \'', $value) . '\');' . "\n";
	}

	exit;
}

?>

<form method="post">
	<h1>Data 2 SQL</h1>
	<input name="table" type="text" value="" placeholder="Table name&hellip;" style="width: 100%;">
	<br><br>
	<input name="columns" type="text" value="" placeholder="Columns&hellip; (comma-separated, e.g. first_name,last_name)" style="width: 100%;">
	<br><br>
	<input name="skip_columns" type="text" value="" placeholder="Skip Columns&hellip; (comma-separated, e.g. 1,3)" style="width: 100%;">
	<br><br>
	<textarea name="data" style="width: 100%; height: 300px;" placeholder="Data&hellip;"></textarea>
	<br><br>
	<button type="submit" style="width: 100%;">Submit</button>
</form>