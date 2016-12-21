
	<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

		class FileUtils
    {
        public static function get_contents_utf8($fn)
        {
            if (!is_null($fn) && is_string($fn) && strlen($fn) > 0) {
                $content = file_get_contents($fn);
                return mb_convert_encoding($content, 'UTF-8',
                      mb_detect_encoding($content, 'UTF-8, ISO-8859-1', true));
            }
            throw new Exception('Incorrect parameter $fn for file_get_contents_utf8, string expetecded.');
        }
    }
?>
