<?php
/**
 * Tiny Translator Class
 *
 * this is a tiny class to grab the translation from the intl translation maps
 **/
class Translator {
    /**
     * bundle of translated strings generated by genrb command
     * @var ResourceBundle|null resulting resource bundle
     **/
    private $resourceBundle = null;

    /**
     * Translator constructor
     *
     * @param ResourceBundle $newResourceBundle bundle of translations
     **/
    public function __construct(\ResourceBundle $newResourceBundle) {
        $this->resourceBundle = $newResourceBundle;
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
}