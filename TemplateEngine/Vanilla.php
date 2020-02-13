<?php

namespace UKMNorge\TemplateEngine;

use UKMNorge\Design\Image;
use UKMNorge\Design\TemplateEngine\Filters;
use UKMNorge\Design\TemplateEngine\Functions;
use UKMNorge\Design\UKMDesign;
use UKMNorge\TemplateEngine\Proxy\Twig;

class Vanilla extends TemplateEngine
{
    public static function init($dir = null)
    {
        parent::init(rtrim($dir, '/') . '/');
        static::_initUKMDesign();
        static::_initTwig();
    }

    public static function _initUKMDesign()
    {
        UKMDesign::init();

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
