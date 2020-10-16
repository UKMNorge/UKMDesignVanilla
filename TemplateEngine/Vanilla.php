<?php

namespace UKMNorge\TemplateEngine;

use Exception;
use UKMNorge\Design\Image;
use UKMNorge\Design\TemplateEngine\Filters;
use UKMNorge\Design\TemplateEngine\Functions;
use UKMNorge\Design\UKMDesign;
use UKMNorge\Design\YamlLoader;
use UKMNorge\TemplateEngine\Proxy\Twig;

class Vanilla extends TemplateEngine
{

    static $cacheDir = null;

    public static function setCacheDir( String $cacheDir ) {
        static::$cacheDir = $cacheDir;
    }

    public static function init($dir)
    {
        if( is_null(static::$cacheDir) ) {
            throw new Exception(
                'Vanilla::init krever at setCacheDir kjøres først'
            );
        }
        parent::init($dir);
        static::_initTwig();

        // Opprett cache-mappe om den ikke finnes
        static::$cacheDir .= 'ukmdesignbundle/';
        if( !file_exists( static::$cacheDir ) ) {
            mkdir( static::$cacheDir, 0777, true );
        }

        $yamlLoader = new YamlLoader(
            static::getPath(),
            str_replace(
                'designvanilla/TemplateEngine',
                'design', 
                __DIR__ .'/Resources/config/'
            )
        );
        static::_initUKMDesign( $yamlLoader );
    }

    public static function _initUKMDesign( YamlLoader $yamlLoader)
    {
        UKMDesign::init( $yamlLoader );

        UKMDesign::getHeader()::getSeo()
            ->setImage(
                new Image(
                    UKMDesign::getConfig('SEOdefaults.image.url'),
                    intval(UKMDesign::getConfig('SEOdefaults.image.width')),
                    intval(UKMDesign::getConfig('SEOdefaults.image.height')),
                    UKMDesign::getConfig('SEOdefaults.image.type')
                )
            )
            ->setSiteName(UKMDesign::getConfig('SEOdefaults.site_name'))
            ->setType('website')
            ->setTitle(UKMDesign::getConfig('SEOdefaults.title'))
            ->setDescription(UKMDesign::getConfig('slogan'))
            ->setAuthor(UKMDesign::getConfig('SEOdefaults.author'))
            ->setFBAdmins(UKMDesign::getConfig('facebook.admins'))
            ->setFBAppId(UKMDesign::getConfig('facebook.app_id'))
            ->setGoogleSiteVerification(UKMDesign::getConfig('google.site_verification'));
    }

    /**
     * Sett opp twig som TemplateRenderer
     *
     * @return void
     */
    private static function _initTwig()
    {
        // Add template and default paths
        Twig::standardInit();
        Twig::enableDebugMode();
        Twig::addPath(static::getViewPath());
        Twig::addPath(UKMDesign::getViewPath());
        Twig::addFiltersFromClass(new Filters());
        Twig::addFiltersFromClass(new TwigFilters());
        Twig::addFunctionsFromClass(new Functions());

        static::setTemplateRenderer(new Twig());
        static::_initViewData();
    }

    /**
     * Sett standard view-data for wordpress
     *
     * @return void
     */
    private static function _initViewData()
    {
        static::addViewData(
            [
                'UKMDesign' => new UKMDesign()
            ]
        );
    }
}
