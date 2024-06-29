<?php

declare(strict_types=1);

namespace CReifenscheid\DummyExtension\Event\Listener;

use TYPO3\CMS\Core\Configuration\Event\SiteConfigurationLoadedEvent;
use TYPO3\CMS\Core\Configuration\Loader\YamlFileLoader;
use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

use function array_key_exists;
use function is_array;

/**
 * Event to modify the site configuration array before loading the configuration
 */
class SiteConfigurationLoadedEventListener
{
    /**
     * @var string
     */
    private const YAML_FILE = 'EXT:dummy_extension/Configuration/Yaml/RouteEnhancers.yaml';

    public function modify(SiteConfigurationLoadedEvent $event): void
    {
        $fileLoader = GeneralUtility::makeInstance(YamlFileLoader::class);

        $siteConfiguration = $event->getConfiguration();
        $siteEnhancers = $siteConfiguration['routeEnhancers'] ?? null;

        $extensionConfiguration = $fileLoader->load(self::YAML_FILE);
        $extensionEnhancers = $extensionConfiguration['routeEnhancers'] ?? null;

        // no route enhancers found
        if ($siteEnhancers === null && $extensionEnhancers === null) {
            return;
        }

        // no route enhancers are configured in site configuration - just use the enhancers provided by the extension
        if ($siteEnhancers === null && $extensionEnhancers !== null) {
            $siteConfiguration['routeEnhancers'] = $extensionEnhancers;
            $event->setConfiguration($siteConfiguration);

            return;
        }

        /**
         * We need to add the route enhancers provided by the extension to the site configuration,
         * so we need to loop through them and check if a corresponding enhancer exists in the site configuration,
         * which can then be merged.
         * When merging, the enhancer from the site configuration has a higher priority
         * than the enhancer provided by the extension.
         * This ensures that the enhancer provided by the extension can be overwritten by the enhancer of the site configuration.
         */
        foreach ($extensionEnhancers as $enhancerKey => $enhancerConfiguration) {
            // check if a route enhancer with the same key exists - merge the two enhancers
            if ($this->isEnhancerKeyExistingInSiteConfiguration($enhancerKey, $siteEnhancers)) {
                $siteEnhancers[$enhancerKey] = $this->mergeEnhancerConfigurations($enhancerConfiguration, $siteEnhancers[$enhancerKey]);
                continue;
            }

            // check if a route enhancer with the same extension:plugin combination exists - merge the two enhancers and keep the enhancer key from the site configuration
            if (($siteEnhancer = $this->getExistingEnhancer($enhancerConfiguration, $siteEnhancers)) && is_array($siteEnhancer)) {
                $siteEnhancers[$siteEnhancer['key']] = $this->mergeEnhancerConfigurations($enhancerConfiguration, $siteEnhancer['configuration']);
                continue;
            }

            // the route enhancer does not exist - add it
            $siteEnhancers[$enhancerKey] = $enhancerConfiguration;
        }

        $siteConfiguration['routeEnhancers'] = $siteEnhancers;

        $event->setConfiguration($siteConfiguration);
    }

    protected function isEnhancerKeyExistingInSiteConfiguration(string $enhancerKey, array $siteEnhancers): bool
    {
        return array_key_exists($enhancerKey, $siteEnhancers);
    }

    protected function getExistingEnhancer(array $enhancerConfiguration, array $siteEnhancers): ?array
    {
        if (!array_key_exists('extension', $enhancerConfiguration)) {
            return null;
        }

        if (!array_key_exists('plugin', $enhancerConfiguration)) {
            return null;
        }

        foreach ($siteEnhancers as $siteEnhancerKey => $siteEnhancerConfiguration) {
        
            if (!array_key_exists('extension', $siteEnhancerConfiguration)) {
                continue;
            }

            if (!array_key_exists('plugin', $siteEnhancerConfiguration)) {
                continue;
            }
        
            if (
            $siteEnhancerConfiguration['extension'] === $enhancerConfiguration['extension'] &&  
            $siteEnhancerConfiguration['plugin'] === $enhancerConfiguration['plugin']) {
                return [
                    'key' => $siteEnhancerKey,
                    'configuration' => $siteEnhancerConfiguration,
                ];
            }
        }

        return null;
    }

    /**
     * Method to return an existing route by comparing the configured controller:action combination
     */
    protected function getExistingRoute(array $route, array $lookUp): ?array
    {
        if (!array_key_exists('_controller', $route)) {
            return null;
        }
    
        foreach ($lookUp as $key => $compare) {
            if (!array_key_exists('_controller', $compare)) {
                continue;
            }
            
            if ($route['_controller'] === $compare['_controller']) {
                return [
                    'key' => $key,
                    'configuration' => $compare,
                ];
            }
        }

        return null;
    }

    /**
     * Method to merge two enhancer configurations by respecting possible differing routes
     *
     * Note:
     * The enhancer provided by the extension is always overwritten by the corresponding enhancer of the site configuration.
     * This enables the integrator to overwrite (parts of) the route enhancer provided by the extension.
     */
    protected function mergeEnhancerConfigurations(array $extensionEnhancer, array $siteEnhancer): array
    {
        // to prevent a loss of routes, the routes configuration has to be treated manually
        $siteEnhancerRoutes = $siteEnhancer['routes'] ?? null;
        $extensionEnhancerRoutes = $extensionEnhancer['routes'] ?? null;

        // if there are no routes configured either in the site nor the extension configuration
        if ($siteEnhancerRoutes === null || $extensionEnhancerRoutes === null) {
            // override the extension enhancer with the enhancer configured in the site configuration
            ArrayUtility::mergeRecursiveWithOverrule($extensionEnhancer, $siteEnhancer);

            return $extensionEnhancer;
        }

        // loop through every route configured in the site configuration
        foreach ($siteEnhancerRoutes as $siteEnhancerRoute) {
            // get the existing route from the enhancers provided by the extension
            $extensionEnhancerRoute = $this->getExistingRoute($siteEnhancerRoute, $extensionEnhancerRoutes);

            if (is_array($extensionEnhancerRoute)) {
                // the route of the site configuration is existing in the routes configured in the extension, so merge the two configurations
                ArrayUtility::mergeRecursiveWithOverrule($extensionEnhancerRoute['configuration'], $siteEnhancerRoute);
                $extensionEnhancerRoutes[$extensionEnhancerRoute['key']] = $extensionEnhancerRoute['configuration'];
            } else {
                // the route of the site configuration is not existing in the routes configured in the extension, so add the site route to the extension enhancer routes
                $extensionEnhancerRoutes[] = $siteEnhancerRoute;
            }
        }

        // overwrite the routes of the site configuration with the updated routes of the extension
        $siteEnhancer['routes'] = $extensionEnhancerRoutes;

        // overwrite extension enhancer with site enhancer
        ArrayUtility::mergeRecursiveWithOverrule($extensionEnhancer, $siteEnhancer);

        return $extensionEnhancer;
    }
}
