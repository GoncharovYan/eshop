<?php

namespace Controller;

abstract class BaseController
{
	public function render(string $templateName, array $variables)
	{
		$template = __DIR__ . '/../View/' . $templateName;
		if (!file_exists($template))
		{
			http_response_code(404);
			echo 'Page not found';
			return;
		}

		extract($variables);

		ob_start();
		require $template;
		return ob_get_clean();
	}
}