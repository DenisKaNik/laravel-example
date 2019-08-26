<?php

namespace App;

use Collective\Html\FormFacade as Form;
use Zofe\Rapyd\DataForm\Field\Field;
use Zofe\Rapyd\Rapyd;

class CKEditor extends Field
{
	public $type = "text";

	public function build()
	{
		$output = "";

		if (parent::build() === false) {
			return;
		}

		switch ($this->status) {
			case "disabled":
			case "show":
				if ($this->type == 'hidden' || $this->value == "") {
					$output = "";
				} elseif ((!isset($this->value))) {
					$output = $this->layout['null_label'];
				} else {
					$output = nl2br(htmlspecialchars($this->value));
				}

				$output = "<div class='help-block'>" . $output . "&nbsp;</div>";
				break;

			case "create":
			case "modify":
				$output = '<script src="//cdn.ckeditor.com/4.5.9/full/ckeditor.js"></script>' .
					Form::textarea($this->name, $this->value, $this->attributes);

				Rapyd::script("
					if (typeof CKEDITOR != 'undefined') {
						CKEDITOR.config.stylesSet = 'laravel:/js/admin/ckeditor.styles.js';
						CKEDITOR.config.contentsCss = '/css/app.css';
						CKEDITOR.config.height = 400;
						CKEDITOR.config.bodyClass = 'formatting';
						CKEDITOR.replace( '{$this->name}' );
					}
				");

				break;

			case "hidden":
				$output = Form::hidden($this->name, $this->value);
				break;

			default:
				;
		}

		$this->output = "\n" . $output . "\n" . $this->extra_output . "\n";
	}
}
