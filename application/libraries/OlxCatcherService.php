<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include("application/libraries/FileUtils.php");


class OlxCatcherService
{
  protected $CI;

  const REGEX_LINES = "/[\r\n]*/";

	const REGEX_GROUP_ITENS = "/class=\"section_OLXad-list.*?<\/ul><\/div>/";

	const REGEX_ITEM = "/<li class=\"item.*?li>/";

	const REGEX_ITEM_PRICE = "/\"OLXad-list-price\">[^\d]+([\d\.]+)</";

	const REGEX_ITEM_TITLE = "/<h3 class=\"OLXad-list-title mb5px\">(.*?)<\/h3>/";

	const REGEX_ITEM_CATEGORY = "/<p class=\"text detail-category\">(.*?)</";

	const REGEX_ITEM_LINK = "/href=\"(http:\/\/.*?)\"/";

	public $Url;

	public $ItensInPage;

	public function __construct($url){

    $this->CI =& get_instance();

    $this->CI->load->model('Category');
    $this->CI->load->model('Product');
    $this->CI->load->library('FileUtils');

	  if (is_null($url) || !is_string($url) || strlen($url) <= 0) {
			$url = 'http://sp.olx.com.br/regiao-de-sorocaba';
		}

		$this->Url = $url;
  }


	public function get_itens()
	{
		$input_lines = FileUtils::get_contents_utf8($this->Url);
		$input_lines = preg_replace(self::REGEX_LINES, "", $input_lines);
		preg_match_all(self::REGEX_GROUP_ITENS, $input_lines, $group);
		preg_match_all(self::REGEX_ITEM, $group[0][0], $itens);
		$this->ItensInPage =count($itens[0]);

		for ($i=0; $i < $this->ItensInPage; $i++) {
        $item = $itens[0][$i];
				preg_match(self::REGEX_ITEM_PRICE, $item, $output_price);

				if (count($output_price) > 1) {
					$price_st = $output_price[1];

					$price_st = str_replace('.', '', $price_st);
					$price = (float)$price_st;

          $product = $this->CI->Product;
          $product->Price = $price;

          preg_match(self::REGEX_ITEM_TITLE, $item, $output_array);
          $product->Description = trim($output_array[1]);

          preg_match(self::REGEX_ITEM_CATEGORY, $item, $output_array);
          $category = $this->CI->Category;



          $category->byDescription(trim($output_array[1]));


          $product->Category = $category;

          preg_match(self::REGEX_ITEM_LINK, $item, $output_array);
          $product->Link = $output_array[1];

          $product->Save();
				}

		}
	}

	public static function build_url($state, $region)
	{
		$format = 'http://%s.olx.com.br/%s';
		return printf($format,$state,$region);
	}
}
?>
