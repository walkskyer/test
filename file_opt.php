<?php
/*
 * 用来创建文件和文件夹 并实现批量删除
 */
$op = isset($_GET['op']) ? $_GET['op'] : '';
$path = './';
if(empty($op) || $op == 'create') {
	$filearray = array(
					array(
						't'=>'d',
							'n'=>'test1',
							'f'=>array(
									array(
										't'=>'f',
											'n'=>'test1.txt',
											'c'=>'hello test1'),
										array(
											't'=>'f',
												'n'=>'test2.txt',
												'c'=>'hello test2'),
										array(
											't'=>'f',
												'n'=>'test3.txt',
												'c'=>'hello test3'),
										array(
											't'=>'f',
												'n'=>'test4.txt',
												'c'=>'hello test4'),
										array(
											't'=>'d',
												'n'=>'test1_1',
												'f'=>array(
														array(
															't'=>'f',
																'n'=>'test1.txt',
																'c'=>'hello test1'),
															array(
																't'=>'f',
																	'n'=>'test2.txt',
																	'c'=>'hello test2'),
															array(
																't'=>'f',
																	'n'=>'test3.txt',
																	'c'=>'hello test3'))))));
	create($filearray, $path);
	echo 'hello<br />';
	echo '<a href="/file_opt.php?op=del">Delete the dir test1?</a>';
}elseif($op == 'del') {
	del('test1', $path);
	echo 'The dir test1 has been removed!';
}

/**
 * 根据格式化的数组批量创建在指定的目录下文件及文件夹
 *
 * @param array $file_array
 *        	格式化的数组
 * @param string $path
 *        	指定目录
 */
function create($file_array,$path){
	if(!isset($file_array['t'])) {
		foreach($file_array as $file) {
			create($file, $path);
		}
	}elseif($file_array['t'] == 'd') { // 创建文件夹
		$dir = $path . $file_array['n'];
		if(!is_dir($dir)) { // 确保文件夹存在
			mkdir($dir);
		}
		create($file_array['f'], $dir . '/');
	}elseif($file_array['t'] == 'f') { // 创建文件
		if(is_dir($path)) { // 确保文件夹存在
			file_put_contents($path . $file_array['n'], $file_array['c']);
		}
	}
}

/**
 * 删除文件，若file为文件夹，则先删除file下的所有文件和子文件夹。
 * 
 * @param string $file  文件或文件夹名     	
 * @param string $path  file所在目录      	
 */
function del($file,$path){
	$path_file = $path . $file;
	if(is_dir($path_file)) { // 文件夹
		$file_array = scandir($path_file);
		foreach($file_array as $file) {
			if($file!='..'&& $file!='.'){
				del($file, $path_file . '/');
			}
		}
		rmdir($path_file);
	}elseif(is_file($path_file)) { // 文件
		unlink($path_file);
	}
}
?>