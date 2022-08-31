<?php

namespace Hschottm\SurveyBundle\Controller\ContentElement;

use Contao\ContentModel;
use Contao\CoreBundle\ServiceAnnotation\ContentElement;
use Contao\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @ContentElement(category="includes")
 */
class SurveyResultElementController extends \Contao\CoreBundle\Controller\ContentElement\AbstractContentElementController
{

    protected function getResponse(Template $template, ContentModel $model, Request $request): ?Response
    {
        // TODO: Implement getResponse() method.
    }
}