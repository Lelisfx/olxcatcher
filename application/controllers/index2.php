<?php header('Content-Type: text/html; charset=utf-8');

include("FileUtils.class.php");

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>OLX CATCHER</title>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/slate/bootstrap.min.css">
</head>

<body>
	<?php


        $input_lines = FileUtils::get_contents_utf8('http://sp.olx.com.br/regiao-de-sorocaba');
        $input_lines = preg_replace("/[\r\n]*/", "", $input_lines);

        preg_match_all("/class=\"section_OLXad-list.*?<\/ul><\/div>/", $input_lines, $group);
      preg_match_all("/<li class=\"item.*?li>/", $group[0][0], $itens);
        //preg_match_all('/<li class="item">.*?li>/', $url, $itens);


    //	preg_match_all('/<p class="text detail-category">([^<]++)/', $url, $col_cats);
    //	preg_match_all('/<p class="OLXad-list-price">([^<]++)/', $url, $col_vals);
//		preg_match_all('/<a class="OLXad-list-link"([^<]++)/', $url, $col_links);
        $i=0; ?>
		<table>
			<?php

echo count($itens[0]);

while ($i<count($itens[0])) {
    $item = $itens[0][$i];
    preg_match_all("/OLXad-list-price.*?([\d\.]+).*?<\/p>/", $item, $output_price);

        //		$valor = (float)$valor_st;
        //		if($valor <= 500)
?>
			<tr>
				<td><?php

//$itens[0][$i]
            if (count($output_price) > 1) {
                if (count($output_price[1]) > 0) {
                    $valor_st = $output_price[1][0];
                    $valor_st = str_replace('.', '', $valor_st);
                    $valor = (float)$valor_st; ?>

</td>
				<td>
					<?php
            preg_match("/<h3 class=\"OLXad-list-title mb5px\">(.*?)<\/h3>/", $item, $output_array);
                    echo $output_array[1]
?>
				</td>
				<td>

<?php

echo $valor; ?>

</td>
				<td>

<?php

                    preg_match("/<p class=\"text detail-category\">(.*?)<\/p>/", $item, $output_array);
                    echo $output_array[1]
//						preg_match('/href="([^<]++)/',$col_links[0][$i],$col_links2);
    //					echo var_dump($col_links2);
                    ?>
				</td>

				<td>

			<?php

                    preg_match("/href=\"(http:\/\/.*?)\"/", $item, $output_array);
                    echo $output_array[1]
            //						preg_match('/href="([^<]++)/',$col_links[0][$i],$col_links2);
            //					echo var_dump($col_links2);
                    ?>
				</td>
			</tr>
			<?php

                }
            }
    $i++;
} ?>
		</table>
</body>
</html>
