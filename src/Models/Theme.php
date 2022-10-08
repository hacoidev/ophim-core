<?php

namespace Ophim\Core\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Hacoidev\CachingModel\Contracts\Cacheable;
use Hacoidev\CachingModel\HasCache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;
use Ophim\Core\Traits\HasFactory;

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

    public function getOptionsAttribute()
    {
        $allThemes = config('themes', []);

        if (!isset($allThemes[strtolower($this->name)]['options'])) {
            return [];
        }

        return $allThemes[strtolower($this->name)]['options'];
    }

    public function editBtn($crud = false)
    {
        return '<a href="' . backpack_url("theme/{$this->id}/edit") . '" class="btn btn-primary">Edit</a>';
    }

    public function activeBtn($crud = false)
    {
        $template = <<<EOT
        <form action="{actionRoute}" method="post" onsubmit="return confirm('Chắc chắn muốn kích hoạt giao diện {display_name}?');" style="display: inline">
            {csrfField}
            <button class="btn {btnType}" type="submit">{name}</button>
        </form>
        EOT;

        $html = str_replace("{actionRoute}", backpack_url("theme/{$this->id}/active"), $template);
        $html = str_replace("{csrfField}", csrf_field(), $html);
        $html = str_replace("{display_name}", $this->display_name, $html);

        if ($this->active) {
            $html = str_replace("{name}", 'Re-Activate', $html);
            $html = str_replace("{btnType}", 'btn-secondary', $html);
        } else {
            $html = str_replace("{name}", 'Activate', $html);
            $html = str_replace("{btnType}", 'btn-primary', $html);
        }


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

        $publishTags = config('themes', [])[$this->name]['publishes'] ?? [];

        foreach ($publishTags as $tag) {
            Artisan::call('vendor:publish', [
                '--tag' => $tag,
                '--force' => true
            ]);
        }

        return $this->update(['active' => true]);
    }
}
