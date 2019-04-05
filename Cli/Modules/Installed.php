<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Cli\Modules;

/**
 * List installed Magento modules.
 */
class Installed
    extends \Praxigento\Core\App\Cli\Cmd\Base
{
    const OPT_DISPLAY_MAGE_MODS_NAME = 'display-mage-mods';
    const OPT_DISPLAY_MAGE_MODS_SHORTCUT = 'm';

    /** @var \Magento\Framework\Module\ModuleList */
    private $moduleList;

    public function __construct(
        \Magento\Framework\ObjectManagerInterface $manObj,
        \Magento\Framework\Module\ModuleList $moduleList
    ) {
        parent::__construct(
            $manObj,
            'prxgt:app:modules:installed',
            'List installed Magento modules.'
        );
        $this->moduleList = $moduleList;
    }

    protected function configure()
    {
        parent::configure();
        $this->addOption(
            self::OPT_DISPLAY_MAGE_MODS_NAME,
            self::OPT_DISPLAY_MAGE_MODS_SHORTCUT,
            \Symfony\Component\Console\Input\InputOption::VALUE_OPTIONAL,
            'Display Magento modules in listing (skipped by default).',
            false
        );
    }

    protected function execute(
        \Symfony\Component\Console\Input\InputInterface $input,
        \Symfony\Component\Console\Output\OutputInterface $output
    ) {
        $displayMageMods = $input->getOption(self::OPT_DISPLAY_MAGE_MODS_NAME);
        $displayMageMods = ($displayMageMods !== false);
        if ($displayMageMods === false) {
            $msg = "List installed Magento modules (skip Magento modules)";
        } else {
            $msg = "List installed Magento modules.";
        }
        $output->writeln("<info>$msg<info>");
        $allModules = $this->moduleList->getAll();
        ksort($allModules);
        $total = 0;
        foreach ($allModules as $one) {
            $name = $one['name'];
            $version = $one['setup_version'];
            if (
                ($displayMageMods) ||
                (!$displayMageMods && !$this->isMageModule($name))
            ) {
                $total++;
                $output->writeln("<info>$name:$version<info>");
            }
        }
        $output->writeln("\n<info>Total modules: $total.<info>\n");
        $output->writeln('<info>Command \'' . $this->getName() . '\' is completed.<info>');
    }

    /**
     * @param string $name
     * @return bool
     */
    private function isMageModule($name)
    {
        $result = (strpos($name, 'Magento_') === 0);
        return $result;
    }
}