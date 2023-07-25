<?php

declare(strict_types=1);

namespace Shopper\Core\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Shopper\Core\Traits\HasSlug;

/**
 * @property-read int $id
 * @property-read string $name
 * @property-read string $slug
 * @property-read string|null $description
 * @property-read string $type
 * @property-read bool $is_enabled
 * @property-read bool $is_searchable
 * @property-read bool $is_filterable
 * @property-read string|null $icon
 */
class Attribute extends Model
{
    use HasFactory;
    use HasSlug;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'type',
        'is_enabled',
        'is_searchable',
        'is_filterable',
        'icon',
    ];

    protected $casts = [
        'is_enabled' => 'boolean',
        'is_searchable' => 'boolean',
        'is_filterable' => 'boolean',
    ];

    protected $appends = [
        'type_formatted',
    ];

    public function getTable(): string
    {
        return shopper_table('attributes');
    }

    public function getTypeFormattedAttribute(): string
    {
        return self::typesFields()[$this->type];
    }

    public static function typesFields(): array
    {
        return [
            'text' => __('shopper::layout.forms.label.text_field', ['type' => '(input)']),
            'number' => __('shopper::layout.forms.label.text_field', ['type' => '(number)']),
            'richtext' => __('shopper::layout.forms.label.richtext'),
            'select' => __('shopper::layout.forms.label.select'),
            'checkbox' => __('shopper::layout.forms.label.checkbox'),
            'radio' => __('shopper::layout.forms.label.radio'),
            'colorpicker' => __('shopper::layout.forms.label.colorpicker'),
            'datepicker' => __('shopper::layout.forms.label.datepicker'),
        ];
    }

    public static function fieldsWithValues(): array
    {
        return [
            'select',
            'checkbox',
            'colorpicker',
            'radio',
        ];
    }

    public static function fieldsWithStringValues(): array
    {
        return [
            'text',
            'number',
            'richtext',
            'datepicker',
        ];
    }

    public function values(): HasMany
    {
        return $this->hasMany(AttributeValue::class);
    }
}
