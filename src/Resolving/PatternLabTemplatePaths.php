<?php
declare(strict_types=1);

namespace NamelessCoder\FluidPatternEngine\Resolving;

use TYPO3Fluid\Fluid\View\TemplatePaths;
use PatternLab\Config;

class PatternLabTemplatePaths extends TemplatePaths
{

    const BASE_PREFIX = 'LSG:';

    public function getPartialPathAndFilename($partialName)
    {
        $partialCleanName = (new PartialNamingHelper())->determinePatternCleanName($partialName);
        // remove prefix LSG:
        $partialCleanName = str_replace(self::BASE_PREFIX, '', $partialCleanName);
        // pattern configuration object already contains required shorten name (key=nameDash)
        $partialConfiguration = (new PartialNamingHelper())->getPatternConfiguration($partialCleanName);
        if ($partialConfiguration['pathName'])
            $partialCleanName = $partialConfiguration['pathName'];

        return parent::getPartialPathAndFilename($partialCleanName);
    }

    public function getLayoutPathAndFilename($layoutName = 'default')
    {
        // drop prefix(s) (layouts-page-1col -> page-1col)
        $prefixes = array("layouts-", self::BASE_PREFIX, self::BASE_PREFIX . "layouts-");
        $layoutName = str_replace($prefixes, '', $layoutName);
        return self::getPartialPathAndFilename($layoutName);
    }
}
