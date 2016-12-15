<?php header('Content-Type: text/html; charset=utf-8'); ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>OLX CATCHER</title>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/slate/bootstrap.min.css">
</head>

<body>
	<?php
		$url = file_get_contents('http://sp.olx.com.br/regiao-de-sorocaba');
		preg_match_all('/<h3 class="OLXad-list-title mb5px">([^<]++)/', $url, $col_itens);
		preg_match_all('/<p class="text detail-category">([^<]++)/', $url, $col_cats);
		preg_match_all('/<p class="OLXad-list-price">([^<]++)/', $url, $col_vals);
		$i=0; ?>
		<table>
			<?php while($i<=50){
				$valor_st = str_replace('<p class="OLXad-list-price">','',$col_vals[0][$i]);
				$valor_st = str_replace('R$','',$valor_st);
				$valor_st = str_replace('.','',$valor_st);
				$valor = (float)$valor_st;
				if($valor <= 500){?>
			<tr>
				<td><?php echo utf8_encode($col_itens[0][$i]) ;?></td>
				<td>
					<?php echo var_dump($col_cats[0][$i]);
					//utf8_encode(
						//str_replace('<h3 class="OLXad-list-title mb5px">','',$col_cats[0][$i])); ?>
				</td>
				<td><?php echo $valor; ?></td>
			</tr>
			<?php	} $i++; } ?>
		</table>
</body>
</html>
