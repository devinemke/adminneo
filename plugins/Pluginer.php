<?php

namespace AdminNeo;

/**
 * Admin/Editor customization allowing usage of plugins.
 *
 * @author Jakub Vrana, https://www.vrana.cz/
 * @author Peter Knut
 *
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
 */
class Pluginer extends Admin
{
	/** @var array|null */
	private $plugins;

	/**
	 * @param array $plugins List of plugin instances.
	 */
	public function __construct(array $plugins, array $config = [])
	{
		parent::__construct($config);

		$this->plugins = $plugins;

		//! it is possible to use ReflectionObject to find out which plugins defines which methods at once
	}

	// appendPlugin

	public function editRowPrint($table, $fields, $row, $update)
	{
		return $this->appendPlugin(__FUNCTION__, func_get_args());
	}

	public function editFunctions($field)
	{
		return $this->appendPlugin(__FUNCTION__, func_get_args());
	}

	// applyPlugin

	public function name()
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function getCredentials(): array
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function authenticate(string $username, string $password)
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function connectSsl()
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function permanentLogin(bool $create = false)
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function bruteForceKey()
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function getServerName(string $server): string
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function database()
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function schemas(): array
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function databases($flush = true): array
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function collations(array $keepValues = []): array
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function queryTimeout()
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function headers()
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function getCspHeader(): array
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function head()
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function loginForm()
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function composeLoginFormRow(string $fieldName, string $label, string $field): string
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function getTableName(array $tableStatus): string
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function getFieldName(array $field, int $order = 0): string
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function formatComment(?string $comment): string
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function selectLinks($tableStatus, $set = "")
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function getForeignKeys(string $table): array
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function backwardKeys($table, $tableName)
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function backwardKeysPrint($backwardKeys, $row)
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function formatSelectQuery(string $query, float $start, bool $failed = false): string
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function formatMessageQuery(string $query, string $time, bool $failed = false): string
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function formatSqlCommandQuery(string $query): string
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function rowDescription($table)
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function rowDescriptions($rows, $foreignKeys)
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function selectLink($val, $field)
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	function selectVal($val, $link, $field, $original)
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function formatFieldValue($value, array $field): ?string
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function printTableStructure(array $fields): void
	{
		$this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function tablePartitionsPrint($partition_info)
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function tableIndexesPrint($indexes)
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function selectColumnsPrint(array $select, array $columns)
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function selectSearchPrint(array $where, array $columns, array $indexes)
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function selectOrderPrint(array $order, array $columns, array $indexes)
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function selectLimitPrint(?int $limit): void
	{
		$this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function selectLengthPrint($text_length)
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function selectActionPrint($indexes)
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function selectCommandPrint()
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function selectImportPrint()
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function selectEmailPrint($emailFields, $columns)
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function selectColumnsProcess($columns, $indexes)
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function selectSearchProcess($fields, $indexes)
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function selectOrderProcess($fields, $indexes)
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function selectLimitProcess(): ?int
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function selectLengthProcess()
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function selectEmailProcess($where, $foreignKeys)
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function editInput($table, $field, $attrs, $value, $function)
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function getEditHint(string $table, array $field, ?string $value): string
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function processInput(?array $field, $value, $function = "")
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function getDumpOutputs(): array
	{
		return $this->appendPlugin(__FUNCTION__, func_get_args());
	}

	public function getDumpFormats(): array
	{
		return $this->appendPlugin(__FUNCTION__, func_get_args());
	}

	public function sendDumpHeaders(string $identifier, bool $multiTable = false): string
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function dumpDatabase(string $database): void
	{
		$this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function dumpTable(string $table, string $style, int $viewType = 0): void
	{
		$this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function dumpData(string $table, string $style, string $query): void
	{
		$this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function importServerPath()
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function homepage()
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function navigation($missing)
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function databasesPrint($missing)
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function printTablesFilter(): void
	{
		$this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function tablesPrint(array $tables)
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function foreignColumn($foreignKeys, $column): ?array
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function callParent(string $function, array $args = [])
	{
		return call_user_func_array([parent::class, $function], $args);
	}

	private function appendPlugin(string $function, array $args)
	{
		$return = $this->callParent($function, $args);

		foreach ($this->plugins as $plugin) {
			if (!method_exists($plugin, $function)) {
				continue;
			}

			$value = call_user_func_array([$plugin, $function], $args);
			if ($value) {
				$return += $value;
			}
		}

		return $return;
	}

	private function applyPlugin(string $function, array $args)
	{
		if (count($args) > 6) {
			trigger_error('Too many parameters.', E_USER_WARNING);
		}

		foreach ($this->plugins as $plugin) {
			if (!method_exists($plugin, $function)) {
				continue;
			}

			// Method call_user_func_array() doesn't work well with references.
			switch (count($args)) {
				case 0:
					$return = $plugin->$function();
					break;
				case 1:
					$return = $plugin->$function($args[0]);
					break;
				case 2:
					$return = $plugin->$function($args[0], $args[1]);
					break;
				case 3:
					$return = $plugin->$function($args[0], $args[1], $args[2]);
					break;
				case 4:
					$return = $plugin->$function($args[0], $args[1], $args[2], $args[3]);
					break;
				case 5:
					$return = $plugin->$function($args[0], $args[1], $args[2], $args[3], $args[4]);
					break;
				case 6:
					$return = $plugin->$function($args[0], $args[1], $args[2], $args[3], $args[4], $args[5]);
					break;
				default:
					$return = null;
					break;
			}

			if ($return !== null) {
				return $return;
			}
		}

		return $this->callParent($function, $args);
	}
}
