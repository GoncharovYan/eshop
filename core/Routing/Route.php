<?php

namespace Core\Routing;

class Route
{
	public string $method;

	public string $uri;

	public \Closure $action;

	private array $variables = [];

	public function __construct(
		string $method,
		string $uri,
		\Closure $action
	)
	{
		$this->method = $method;
		$this->uri = $uri;
		$this->action = $action;
	}

	public function match(string $uri): bool
	{
		$regexpVar = '([A-Za-z0-9_-]+)';
		$regexp = '#^' . preg_replace('(:[A-Za-z]+)', $regexpVar, $this->uri) . '$#';

		$result = preg_match($regexp, $uri, $matches);
		if ($result)
		{
			array_shift($matches);
			$this->variables = $matches;
		}

		return $result;
	}

	/**
	 * @return array
	 */
	public function getVariables(): array
	{
		return $this->variables;
	}
}