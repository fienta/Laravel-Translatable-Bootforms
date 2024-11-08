<?php namespace TypiCMS\LaravelTranslatableBootForms\Tests\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Model extends Eloquent
{

    use Translatable;

    protected $table = 'models';

    public $timestamps = false;

    protected $fillable = ['id', 'default', 'input'];

    public $translationModel = ModelTranslation::class;

    public $translatedAttributes = ['input'];
}