<?php


namespace App\Traits;


use App\Exceptions\AttributeIsNotTranslatableException;
use Illuminate\Support\Str;

trait Transatable
{
    protected $translationLocale;

    // protected $translatable = [];

    public static function usingLocale(string $locale): self
    {
        return (new self())->setLocale($locale);
    }

    /**
     * @throws AttributeIsNotTranslatableException
     */
    public function getAttributeValue($key)
    {
        if (! $this->isTranslatableAttribute($key)) {
            return parent::getAttributeValue($key);
        }

        return $this->getTranslation($key, $this->getLocale());
    }

    /**
     * @throws AttributeIsNotTranslatableException
     */public function setAttribute($key, $value)
    {
        if (is_array($value) && $this->isTranslatableAttribute($key)) {
            return $this->setTranslations($key, $value);
        }

        // Pass arrays and untranslatable attributes to the parent method.
        if (is_array($value) ||  ! $this->isTranslatableAttribute($key) ) {
            return parent::setAttribute($key, $value);
        }

        // If the attribute is translatable and not already translated, set a
        // translation for the current app locale.
        return $this->setTranslation($key, $this->getLocale(), $value);
    }

    /**
     * @throws AttributeIsNotTranslatableException
     */
    public function translate(string $key, string $locale = '', bool $useFallbackLocale = true)
    {
        return $this->getTranslation($key, $locale, $useFallbackLocale);
    }

    /**
     * @throws AttributeIsNotTranslatableException
     */public function getTranslation(string $key, string $locale, bool $useFallbackLocale = true)
    {
        $locale = $this->normalizeLocale($key, $locale, $useFallbackLocale);

        $translations = $this->getTranslations($key);

        $translation = $translations[$locale] ?? '';

        if ($this->hasGetMutator($key)) {
            return $this->mutateAttribute($key, $translation);
        }

        return $translation;
    }

    /**
     * @throws AttributeIsNotTranslatableException
     */public function getTranslationWithFallback(string $key, string $locale)
    {
        return $this->getTranslation($key, $locale);
    }

    /**
     * @throws AttributeIsNotTranslatableException
     */public function getTranslationWithoutFallback(string $key, string $locale)
    {
        return $this->getTranslation($key, $locale, false);
    }

    /**
     * @throws AttributeIsNotTranslatableException
     */
    public function getTranslations(string $key = null, array $allowedLocales = null): array
    {
        if ($key !== null) {
            $this->guardAgainstNonTranslatableAttribute($key);

            try {
                return array_filter(
                    json_decode($this->getAttributes()[$key] ?? '' ?: '{}', true, 512, JSON_THROW_ON_ERROR) ?: [],
                    function ($value, $locale) use ($allowedLocales) {
                        return $this->filterTranslations($value, $locale, $allowedLocales);
                    },
                    ARRAY_FILTER_USE_BOTH
                );
            } catch (\JsonException $e) {
                abort(500,$e->getMessage());
            }
        }

        return array_reduce($this->getTranslatableAttributes(), function ($result, $item) use ($allowedLocales) {
            $result[$item] = $this->getTranslations($item, $allowedLocales);

            return $result;
        });
    }

    /**
     * @throws AttributeIsNotTranslatableException
     */public function setTranslation(string $key, string $locale, $value): self
    {
        $this->guardAgainstNonTranslatableAttribute($key);

        $translations = $this->getTranslations($key);

        //$oldValue = $translations[$locale] ?? '';

        if ($this->hasSetMutator($key)) {
            $method = 'set'.Str::studly($key).'Attribute';

            $this->{$method}($value, $locale);

            $value = $this->attributes[$key];
        }

        $translations[$locale] = $value;

        $this->attributes[$key] = $this->asJson($translations);


        return $this;
    }

    /**
     * @throws AttributeIsNotTranslatableException
     */
    public function setTranslations(string $key, array $translations): self
    {
        $this->guardAgainstNonTranslatableAttribute($key);

        foreach ($translations as $locale => $translation) {
            $this->setTranslation($key, $locale, $translation);
        }

        return $this;
    }

    /**
     * @throws AttributeIsNotTranslatableException
     */
    public function forgetTranslation(string $key, string $locale): self
    {
        $translations = $this->getTranslations($key);

        unset(
            $translations[$locale],
            $this->$key
        );

        $this->setTranslations($key, $translations);

        return $this;
    }


    /**
     * @throws AttributeIsNotTranslatableException
     */
    public function forgetAllTranslations(string $locale): self
    {
        collect($this->getTranslatableAttributes())->each(function (string $attribute) use ($locale) {
            $this->forgetTranslation($attribute, $locale);
        });

        return $this;
    }

    /**
     * @throws AttributeIsNotTranslatableException
     */
    public function getTranslatedLocales(string $key): array
    {
        return array_keys($this->getTranslations($key));
    }

    public function isTranslatableAttribute(string $key): bool
    {
        return in_array($key, $this->getTranslatableAttributes(), true);
    }

    /**
     * @throws AttributeIsNotTranslatableException
     */
    public function hasTranslation(string $key, string $locale = null): bool
    {
        $locale = $locale ?: $this->getLocale();

        return isset($this->getTranslations($key)[$locale]);
    }

    /**
     * @throws AttributeIsNotTranslatableException
     */
    public function replaceTranslations(string $key, array $translations): self
    {
        foreach ($this->getTranslatedLocales($key) as $locale) {
            $this->forgetTranslation($key, $locale);
        }

        $this->setTranslations($key, $translations);

        return $this;
    }

    /**
     * @throws AttributeIsNotTranslatableException
     */
    protected function guardAgainstNonTranslatableAttribute(string $key): void
    {
        if (! $this->isTranslatableAttribute($key)) {
            throw AttributeIsNotTranslatableException::make($key, $this);
        }
    }

    /**
     * @throws AttributeIsNotTranslatableException
     */
    protected function normalizeLocale(string $key, string $locale, bool $useFallbackLocale): string
    {
        $translatedLocales = $this->getTranslatedLocales($key);

        if (in_array($locale, $translatedLocales, true)) {
            return $locale;
        }

        if (! $useFallbackLocale) {
            return $locale;
        }

        $fallbackLocale = config('app.locale') ?? config('app.fallback_locale');
        if (! is_null($fallbackLocale) && in_array($fallbackLocale, $translatedLocales, true)) {
            return $fallbackLocale;
        }

        if (! empty($translatedLocales) && config('app.fallback_locale')) {
            return $translatedLocales[0];
        }

        return $locale;
    }

    protected function filterTranslations($value = null, string $locale = null, array $allowedLocales = null): bool
    {
        if ($value === null) {
            return false;
        }

        if ($value === '') {
            return false;
        }

        if ($allowedLocales === null) {
            return true;
        }

        if (!in_array($locale, $allowedLocales, true)) {
            return false;
        }

        return true;
    }

    public function setLocale(string $locale): self
    {
        $this->translationLocale = $locale;

        return $this;
    }

    public function getLocale(): string
    {
        return $this->translationLocale ?: config('app.locale');
    }

    public function getTranslatableAttributes(): array
    {
        return is_array($this->translatable)
            ? $this->translatable
            : [];
    }

    /**
     * @throws AttributeIsNotTranslatableException
     */
    public function getTranslationsAttribute(): array
    {
        return collect($this->getTranslatableAttributes())
            ->mapWithKeys(function (string $key) {
                return [$key => $this->getTranslations($key)];
            })
            ->toArray();
    }

    public function getCasts(): array
    {
        return array_merge(
            parent::getCasts(),
            array_fill_keys($this->getTranslatableAttributes(), 'array')
        );
    }
}
