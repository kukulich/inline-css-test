<?php declare(strict_types = 1);

require __DIR__ . '/vendor/autoload.php';

function run(string $library, callable $callback) {
	$htmlWithCss = file_get_contents(__DIR__ . '/input/html-with-css.html');

	echo $library . ': ';
	$start = microtime(true);
	for ($i = 0; $i < 50; $i++) {
		$converted = $callback($htmlWithCss);
		if ($i === 0) {
			$converted = \Jyxo\Html::removeTags($converted, ['style']);
			file_put_contents(__DIR__ . '/output/' . $library . '.html', $converted);
		}
		echo '.';
	}
	printf("\n%.2f seconds\n", microtime(true) - $start);
}

run('TijsVerkoyen', [new \TijsVerkoyen\CssToInlineStyles\CssToInlineStyles(), 'convert']);
run('Jyxo', [\Jyxo\Css::class, 'convertStyleToInline']);
