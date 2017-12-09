<?php

/*
 * Data 2 SQL
 * Hamid Samak
 * https://github.com/hamidsamak/data2sql
 */

define('DATA2SQL_CHARSET', 'utf8');

if (isset($_POST['data']) && empty($_POST['data']) === false) {
	$table = $_POST['table'];
	$columns = empty($_POST['columns']) ? [] : explode(',', $_POST['columns']);
	$skip_columns = empty($_POST['skip_columns']) ? [] : explode(',', $_POST['skip_columns']);

	$data = trim($_POST['data']);
	$data = explode("\n", $data);
	$data = array_map('trim', $data);
	$data = array_filter($data);

	$separator = $_POST['separator'];
	$query = $_POST['query'];
	$trim = empty($_POST['trim']);
	$output = $_POST['output'];

	if ($separator == 'comma')
		$separator = ',';
	else
		$separator = "\t";

	if ($output == 'open') {
		print '<meta charset="' . DATA2SQL_CHARSET . '">';
		print '<pre>';
	} else if ($output == 'save') {
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream; charset=utf-8');
		header('Content-Disposition: attachment; filename=data2sql_' . $table . '_' . date('YmdHis') . '.sql');
		header('Content-Transfer-Encoding: binary');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Expires: 0');
	}

	foreach ($data as $value) {
		$value = explode($separator, $value);

		if ($trim === true)
			$value = array_map('trim', $value);

		foreach ($skip_columns as $key) {
			if (isset($columns[$key - 1]))
				unset($columns[$key - 1]);

			if (isset($value[$key - 1]))
				unset($value[$key - 1]);
		}

		if ($query == 'insert')
			print 'INSERT INTO `' . $table. '` (`' . implode('`, `', $columns) . '`) VALUES (\'' . implode('\', \'', $value) . '\');' . "\n";
		else if ($query == 'update') {
			print 'UPDATE `' . $table. '` SET ';

			for ($i = 0; $i < count($columns) - 1; $i += 1) {
				print '`' . $columns[$i] . '` = \'' . $value[$i] . '\'';

				if ($i + 2 !== count($columns))
					print ', ';
			}

			print ' WHERE `' . end($columns) . '` = \'' . end($value) . '\';' . "\n";
		}
	}

	exit;
}

?>

<meta charset="<?=DATA2SQL_CHARSET?>">

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
	Data separator: <label><input name="separator" type="radio" value="tab" checked> Tab (\t)</label> <label><input name="separator" type="radio" value="comma"> Comma (,)</label>
	<br><br>
	Query: <label><input name="query" type="radio" value="insert" checked> INSERT</label> <label><input name="query" type="radio" value="update"> UPDATE</label>
	<br><br>
	Trim values: <label><input name="trim" type="radio" value="1"> Yes</label> <label><input name="trim" type="radio" value="0" checked> No</label>
	<br><br>
	Output: <label><input name="output" type="radio" value="open" checked> Open</label> <label><input name="output" type="radio" value="save"> Save</label>
	<br><br>
	<button type="submit" style="width: 100%;">Submit</button>
</form>

<div style="font-size: 75%; text-align: center;">
	<a href="https://github.com/hamidsamak/data2sql" target="_blank">Data2SQL</a> by <a href="https://github.com/hamidsamak" target="_blank">Hamid Samak</a>
</div>