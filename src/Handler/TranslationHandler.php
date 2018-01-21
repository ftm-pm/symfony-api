<?php

namespace App\Handler;

use Doctrine\Bundle\DoctrineBundle\Registry;

/**
 * Class TranslationHandler
 * @package AppBundle\Handler
 */
class TranslationHandler
{
    /**
     * @var Registry
     */
    private $doctrine;

    /**
     * @var array
     */
    private $languages;

    /**
     * @var string
     */
    private $locale;

    /**
     * TranslationHandler constructor.
     * @param Registry $doctrine
     * @param string $locale
     * @param array $languages
     */
    public function __construct(Registry $doctrine, string $locale, array $languages)
    {
        $this->doctrine = $doctrine;
        $this->locale = $locale;
        $this->languages = $languages;
    }

    /**
     * @param $entity
     * @param array $translations
     * @param bool $check
     */
    public function setTranslations($entity, $translations = [], $check = true)
    {
        $em = $this->doctrine->getManager();
        $repository = $em->getRepository('Gedmo\Translatable\Entity\Translation');

        foreach ($translations as $lang => $translation) {
            if (!$check || ($check && $lang != $this->locale && in_array($lang, $this->languages))) {
                foreach ($translation as $field => $value) {
                    $repository->translate($entity, $field, $lang, $value);
                }
            }
        }
    }

    /**
     * @param $entity
     * @param array $fields
     * @return array
     */
    public function getTranslations($entity, $fields = [])
    {
        $repository = $this->doctrine->getRepository('Gedmo\Translatable\Entity\Translation');
        $translations = $repository->findTranslations($entity);

        if(!$translations) {
            $translations = [];
        }

        foreach ($translations as $lang => $translation) {
            $translations[$lang] = array_intersect_key($translation, $fields);
        }

        return $translations;
    }
}