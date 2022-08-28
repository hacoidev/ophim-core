<?php

namespace Ophim\Core\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Backpack\Settings\app\Models\Setting;
use Ophim\Core\Contracts\TaxonomyInterface;
use Hacoidev\CachingModel\Contracts\Cacheable;
use Hacoidev\CachingModel\HasCache;
use Illuminate\Database\Eloquent\Model;
use Ophim\Core\Contracts\SeoInterface;
use Ophim\Core\Traits\HasFactory;
use Ophim\Core\Traits\HasTitle;
use Ophim\Core\Traits\HasUniqueName;
use Ophim\Core\Traits\Sluggable;
use Illuminate\Support\Str;
use Artesaos\SEOTools\Facades\JsonLdMulti;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;

class Theme extends Model implements Cacheable
{
    use CrudTrait;
    use HasFactory;
    use HasCache;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'themes';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];
    protected $casts = [
        'options' => 'array',
        'value' => 'array',
    ];

    public static function getActivatedTheme(): ?self
    {
        return Theme::where('active', true)->first() ?: Theme::first();
    }

    public function getVersionAttribute()
    {
        if (!\Composer\InstalledVersions::isInstalled($this->package_name)) {
            return 'Unknown';
        }

        return  \PackageVersions\Versions::getVersion($this->package_name);
    }

    public function editBtn($crud = false)
    {
        return '<a href="' . backpack_url("theme/{$this->id}/edit") . '" class="btn btn-primary">Edit</a>';
    }

    public function activeBtn($crud = false)
    {
        if ($this->active) return '<button class="btn btn-secondary">Activated</button>';

        $template = <<<EOT
        <form action="{actionRoute}" method="post" onsubmit="return confirm('Chắc chắn muốn đặt về mặc định?');" style="display: inline">
            {csrfField}
            <button class="btn {btnType}" type="submit">{name}</button>
        </form>
        EOT;

        $html = str_replace("{actionRoute}", backpack_url("theme/{$this->id}/active"), $template);
        $html = str_replace("{csrfField}", csrf_field(), $html);
        $html = str_replace("{btnType}", 'btn-primary', $html);
        $html = str_replace("{name}", 'Active', $html);

        return $html;
    }

    public function resetBtn($crud = false)
    {
        $template = <<<EOT
        <form action="{actionRoute}" method="post" onsubmit="return confirm('Chắc chắn muốn đặt về mặc định?');" style="display: inline">
            {csrfField}
            <button class="btn {btnType}" type="submit">{name}</button>
        </form>
        EOT;

        $html = str_replace("{actionRoute}", backpack_url("theme/{$this->id}/reset"), $template);
        $html = str_replace("{csrfField}", csrf_field(), $html);
        $html = str_replace("{btnType}", 'btn-warning', $html);
        $html = str_replace("{name}", 'Reset', $html);

        return $html;
    }

    public function active()
    {
        static::where('active', true)->update(['active' => false]);

        return $this->update(['active' => true]);
    }
}
