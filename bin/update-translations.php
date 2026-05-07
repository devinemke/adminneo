<?php

use function AdminNeo\find_available_languages;

include __DIR__ . "/../admin/include/debug.inc.php";
include __DIR__ . "/../admin/include/available.inc.php";
include __DIR__ . "/../admin/include/polyfill.inc.php";

$languages = find_available_languages();
$to_end = $clean = false;
$language = null;
$template = "_template";

array_shift($argv);
foreach ($argv as $key => $option) {
	if ($option == "-h" || $option == "--help") {
		echo "Usage:\n";
		echo "  php bin/update-translations.php [-h] [--keep-order] [--clean] [language]\n";
		echo "\n";
		echo "Updates admin/translations/*.inc.php from the source code messages.\n";
		echo "\n";
		echo "OPTIONS:\n";
		echo "  --to-end    - Group untranslated texts at the end of the list.\n";
		echo "  --clean     - Delete untranslated texts.\n";
		echo "  -h, --help  - Print help.\n";
		echo "\n";
		echo "PARAMETERS:\n";
		echo "  language     - Language code.\n";
		exit;
	}

	if ($option == "--to-end") {
		$to_end = true;
		unset($argv[$key]);
	} elseif ($option == "--clean") {
		$clean = true;
		unset($argv[$key]);
	} else {
		$language = $option;
	}
}

if ($language && $language != $template && !isset($languages[$language])) {
	echo "⚠️ Unknown language: $language\n";
	exit(1);
}

if (isset($argv[2])) {
	echo "⚠️ Unknown argument: $argv[2]\n";
	echo "Run `php bin/update-translations.php -h` for help.\n";
	exit(1);
}

if ($language) {
	$languages = [
		$language => true,
	];
}

// Always update the template at first.
$languages = [$template => true] + $languages;

// Get all texts from the source code.
$file_paths = array_merge(
	glob(__DIR__ . "/../admin/*.php"),
	glob(__DIR__ . "/../admin/core/*.php"),
	glob(__DIR__ . "/../admin/include/*.php"),
	glob(__DIR__ . "/../admin/drivers/*.php"),
	glob(__DIR__ . "/../editor/*.php"),
	glob(__DIR__ . "/../editor/core/*.php"),
	glob(__DIR__ . "/../editor/include/*.php"),
	glob(__DIR__ . "/../plugins/*.php")
);

$all_texts = [];
foreach ($file_paths as $file_path) {
	$source_code = file_get_contents($file_path);

	// lang() always uses apostrophes.
	if (preg_match_all("~lang\\('([^\\\\']+|\\\\.)*'([),])~", $source_code, $matches)) {
		$all_texts += array_combine($matches[1], $matches[2]);
	}
}

// Generate language files.
foreach ($languages as $language => $dummy) {
	$file_path = __DIR__ . "/../admin/translations/$language.inc.php";
	$filename = basename($file_path);
	$period = ($language == "bn" || $language == 'hi' ? '।' : (preg_match('~^(ja|zh)~', $language) ? '。' : ($language == 'he' ? '' : '\.')));

	$texts = $all_texts;
	$translations = require $file_path;
	$content = file_get_contents(__DIR__ . "/../admin/translations/$template.inc.php");

	foreach ($translations as $en => $translation) {
		// Skip/remove the translation of nonexistent text.
		if (!isset($texts[$en])) {
			if ($language == $template) {
				delete_translation($content, $en);
			}
			continue;
		}

		// Keep current translated texts.
		if ($translation !== null || (!$to_end && !$clean)) {
			write_translation($content, $en, $translation, $language == $template);
			unset($texts[$en]);

			// Do not check untranslated texts and thousands separator.
			if ($translation === null || $en == ",") {
				continue;
			}

			$term = "'$en' => " . format_translation($translation, true);
			$variants = is_string($translation) ? [$translation] : $translation;

			foreach ($variants as $variant) {
				$endWithPeriod = substr($en, -1, 1) == ".";

				// Ignore periods in DB abbreviation.
				if (!$endWithPeriod) {
					$variant = preg_replace('~Β.Δ.$~', "ΒΔ", $variant);
				}

				// Check forbidden periods.
				if (!$period && preg_match("~\.$~", $variant)) {
					print_warning($filename, $term, "Period is forbidden");
				}

				// Check mismatched periods. Period is optional in 'ja' and can mismatch in date/time formatting.
				if ($period &&
					$language != "ja" &&
					!preg_match('~^[0-9.$YMD\-]+$~', $en) &&
					($endWithPeriod xor preg_match("~$period$~", $variant)))
				{
					print_warning($filename, $term, "Not matching period");
				}

				// Check mismatched placeholders.
				if (preg_match('~%~', $en) xor preg_match('~%~', $variant)) {
					print_warning($filename, $term, "Not matching placeholder");
				}
			}
		}
	}

	// Process untranslated texts.
	$first = true;
	foreach ($texts as $en => $ending) {
		if ($to_end || $clean) {
			delete_translation($content, $en);
		} elseif ($language != $template) {
			write_translation($content, $en, null, false);
			continue;
		}

		if (!$clean && ($language != "en" || str_contains($en, "%d"))) {
			add_translation($content, $en, $first);
			$first = false;
		}
	}

	// Cleanup en file.
	if ($language == "en") {
		$content = preg_replace('~\t//.*~', "", $content);
		$content = preg_replace('~\n{2,}([\t\]])~', "\n$1", $content);
	}

	$old_content = str_replace("\r", "", file_get_contents($file_path));
	if ($content != $old_content) {
		file_put_contents($file_path, $content);

		echo "✳️ $filename updated\n";
	} elseif ($language != $template || count($languages) == 1) {
		echo "✔︎ $filename\n";
	}
}

/**
 * @param string|array|null $translation
 */
function write_translation(string &$content, string $en, $translation, bool $single_line): void
{
	$content = preg_replace(
		'~(\t\'' . preg_quote($en) . '\' => ).+,\n~',
		"$1" . format_translation($translation, $single_line, true) . ",\n",
		$content
	);
}

function delete_translation(string &$content, string $en): void
{
	$content = preg_replace(
		'~\t+\'' . preg_quote($en) . '\' => .+,\n~',
		"",
		$content
	);
}

function add_translation(string &$content, string $en, bool $first = false): void
{
	if ($first) {
		$content = preg_replace(
			'~];~',
			"\n\t// TODO New texts\n];",
			$content
		);
	}

	$content = preg_replace(
		'~];~',
		"\t'$en' => null,\n];",
		$content
	);
}

/**
 * @param string|array|null $translation
 */
function format_translation($translation, bool $single_line = false, bool $escape_dollars = false): string
{
	$result = $translation === null ? "null" : var_export($translation, true);

	if (is_array($translation)) {
		$result = preg_replace('~\n\s+\d+ => ~', "\n\t\t", $result);
		$result = preg_replace('~^array \(~', "[", $result);
		$result = preg_replace('~,?\n\)$~', ",\n\t]", $result);

		if ($single_line) {
			$result = preg_replace('~,\n\s*~', ", ", $result);
			$result = preg_replace('~\n\s*~', "", $result);
			$result = str_replace(", ]", "]", $result);
		}
	}

	if ($escape_dollars) {
		$result = str_replace('$', '\$', $result);
	}

	return $result;
}

function print_warning(string $filename, string $term, string $message): void
{
	echo "⚠️ $filename | $message: $term\n";
}
