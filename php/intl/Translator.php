<?php
/**
 * Tiny Translator Class
 *
 * this is a tiny class to grab the translation from the intl translation maps
 **/
class Translator {
    /**
     * locales accepted for this site
     * @var array ACCEPTED_LOCALES
     **/
    public const ACCEPTED_LOCALES = ["en", "es"];

    /**
     * bundle of translated strings generated by genrb command
     * @var ResourceBundle|null $resourceBundle
     **/
    private $resourceBundle = null;

    /**
     * Translator constructor
     *
     * @param string $locale language bundle to load
     **/
    public function __construct(string $locale) {
        if (in_array($locale, self::ACCEPTED_LOCALES) === true) {
            $this->resourceBundle = new \ResourceBundle($locale, __DIR__);
        }
    }

    /**
     * accessor method for translated strings
     *
     * @param string $key key in the translation dictionary
     * @return string translated string from dictionary
     **/
    public function getTranslatedString(string $key): string  {
        return $this->resourceBundle->get($key);
    }

    /**
     * static method to determine the best locale to use
     *
     * @return string locale automagically determined
     */
    public static function getLocale() {
        // try session or cookies first
        $sessionLocale = $_SESSION["locale"] ?? $_COOKIE["locale"];
        if (in_array($sessionLocale, self::ACCEPTED_LOCALES) === true) {
            return $sessionLocale;
        }

        // try HTTP headers instead
        $defaultLocale = "es_MX";
        $httpLocale = \Locale::acceptFromHttp($_SERVER["HTTP_ACCEPT_LANGUAGE"]) ?? $defaultLocale;
        $locale = \Locale::getPrimaryLanguage($httpLocale);
        if (in_array($locale, self::ACCEPTED_LOCALES) === false) {
            // default fallback
            $locale = \Locale::getPrimaryLanguage($defaultLocale);
        }
        return $locale;
    }
}
