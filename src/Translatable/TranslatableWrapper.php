<?php namespace TypiCMS\LaravelTranslatableBootForms\Translatable;

use Astrotomic\Translatable\Translatable;

class TranslatableWrapper {

	use Translatable;

	/**
	 * @return array
	 *
	 * @throws \Astrotomic\Translatable\Exception\LocalesNotDefinedException
	 */
	public function getLocales()
	{
		return $this->getLocalesHelper()->all();
	}

}
