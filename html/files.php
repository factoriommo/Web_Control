<?php $currentpage = 'files';
require 'header.php';
if (isset($_REQUEST['s'])) {
	if ($_REQUEST['s'] == 'managepgm') {
		$server_select = '';
	}else {
		$server_select = $_REQUEST['s'].'/';
	}
	if (isset($_REQUEST['f'])) {
		$file_name = $_REQUEST['f'];
		$ext = pathinfo($_REQUEST['f'], PATHINFO_EXTENSION);
		if ($ext == '0' || $ext == 'log') {
			if ($_REQUEST['l'] == 'true') {
				$logs = 'logs/';
			}else {
				$logs = '';
			}
			$paste = $directory.'tmp/'.$file_name;
			$file = $base_dir . $server_select . $logs . $file_name;
			shell_exec("cp $file $paste");
			if (file_exists('./tmp/'.$file_name)){
				echo "Downloading". $file_name;
				header('Content-Description: File Transfer');
				header('Content-Type: application/octet-stream');
				header('Content-Disposition: attachment; filename='.basename('./tmp/'.$file_name));
				header('Expires: 0');
				header('Cache-Control: must-revalidate');
				header('Pragma: public');
				header('Content-Length: ' . filesize('./tmp/'.$file_name));
				ob_clean();
				flush();
				readfile('./tmp/'.$file_name);
				shell_exec("rm $paste");
				exit;
			} else {
				echo "File doesn't exist";
			}
		}else {
			echo "File not correct";
		}
	}else {
		echo "Filename not set";
	}
}else {
	echo "Server not set";
}
?>
