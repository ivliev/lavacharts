<?php

namespace Hypoid\Lavacharts\Symfony\Bundle\Twig;

use Hypoid\Lavacharts\Lavacharts;
use Hypoid\Lavacharts\Charts\ChartFactory;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class LavachartsExtension extends AbstractExtension
{
    /**
     * The Lavacharts object passed in from the service container.
     *
     * @var \Hypoid\Lavacharts\Lavacharts
     */
    private $lava;

    /**
     * LavachartsExtension constructor.
     *
     * @param \Hypoid\Lavacharts\Lavacharts $lava
     */
    public function __construct(Lavacharts $lava)
    {
        $this->lava = $lava;
    }

    /**
     * Add Twig functions to utilize Lavacharts from the container.
     *
     * To render, just use the lowercase name of the chart:
     * and pass through the raw filter.
     *
     * Example:
     *  {{ linechart('Stocks")|raw }}
     *
     *
     * @return array Array of twig functions
     */
    public function getFunctions()
    {
        $renderableTypes = array_merge(['dashboard'], ChartFactory::$CHART_TYPES);

        $renderFunctions = [];

        foreach ($renderableTypes as $type) {
            $renderFunctions[] = new TwigFunction(strtolower($type),
                function($label) use ($type) {
                    try {
                        $elementId = func_get_arg(1);

                        return $this->lava->render($type, $label, $elementId);
                    } catch (\Exception $e) {
                        return $this->lava->render($type, $label);
                    }
                }
            );
        }

        $renderFunctions[] = new TwigFunction('renderAll', function() {
            return $this->lava->renderAll();
        });

        return $renderFunctions;
    }

    /**
     * Returns the name of the Lavacharts Twig Extension
     *
     * @return string
     */
    public function getName()
    {
        return 'lavacharts_twig_extension';
    }
}
