<?php
/* Usage:
 * php replace_voc.php "quoted" <path-to-vocabulary> <path-to-file> [<path-to-result>]
 * 
 * Example Usage:
C:\Windows\System32>php "D:\Users\User\Documents\PHPworkspace\Replace_from_vocabu
lary_file\replace_voc.php" "unquoted" "D:\Users\User\Documents\Impoting items\Vocabulary\voc
abulary_utf_8.csv" "D:\Users\User\Documents\Impoting items\Vocabulary\CM_noteboo
ks_with_prices.csv" "D:\Users\User\Documents\Impoting items\Vocabulary\CM_notebo
oks_with_prices_result.csv"

php "D:\Users\User\Documents\PHPworkspace\Replace_from_vocabulary_file\replace_voc.php" "quoted" "D:\Users\User\Documents\Impoting items\Vocabulary\Categories\categories_map.csv" "D:\Users\User\Documents\Impoting items\Vocabulary\Categories\NB_categories.csv" "D:\Users\User\Documents\Impoting items\Vocabulary\Categories\NB_categories_result.csv"
*/
class Replace_voc{
	var $vocabularyStr;
	var $string;	
	
	function __construct($_vocabularyStr,$_string) {
		if (isset($_vocabularyStr) && $_vocabularyStr != false)	$this->vocabularyStr = $_vocabularyStr;
		if (isset($_string) && $_string != false) $this->string = $_string;
	}
	
	/*
	* $unquoted_mode - 0 - quoted, 1 - unquoted
	*/
	function replace_voc($unquoted_mode,$outFilename) {
		if (isset($this->vocabularyStr)){
			$searchStrings = array();
			$replaceStrings = array();
			foreach(preg_split("/((\r?\n)|(\r\n?))/", $this->vocabularyStr) as $vocLine){
				$vocWords = array();
				preg_match_all ('/"([^"]+?)"/', $vocLine, $vocWords, PREG_PATTERN_ORDER);
				if (isset($vocWords[$unquoted_mode][0])){
					$searchStrings[] = $vocWords[$unquoted_mode][0];
					if (isset($vocWords[$unquoted_mode][1])){
						$replaceStrings[] = $vocWords[$unquoted_mode][1];
					}else{
						$replaceStrings[] = '';
					}
				}
				unset($vocWords);
			}
			
			file_put_contents($outFilename,
				str_replace ($searchStrings, $replaceStrings, $this->string));
		}
	}	
}

if (isset($argv[1]) && isset($argv[2]) && isset($argv[3])){	
	$RV = new Replace_voc(file_get_contents($argv[2]),file_get_contents($argv[3]));
	$RV -> replace_voc($argv[1] === "quoted" ? 0 : 1,isset($argv[4]) ? $argv[4] : $argv[3] );
}
?>