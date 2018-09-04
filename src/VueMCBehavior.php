<?php

namespace jdombroski\Propel\Behavior\VueMC;

use Propel\Generator\Model\Behavior;
use Propel\Common\Pluralizer\StandardEnglishPluralizer;
use Propel\Common\Pluralizer\PluralizerInterface;

class VueMCBehavior extends Behavior
{
    // default parameters value
    protected $parameters = [];

    private $jsDirectory = 'K:\Workspace\leasingio\resources\assets\js';
    

    /** @var  PluralizerInterface */
    protected $pluralizer;
    private static $tablesProcessed = 0;

    /**
     * @return PluralizerInterface
     */
    public function getPluralizer() {
        if ($this->pluralizer === null) {
            $this->pluralizer = new StandardEnglishPluralizer();
        }
        
        return $this->pluralizer;
    }

    public function modifyTable()
    {
        self::execute();
    }
    
    public function execute()
    {
        $this->getTable()->getNamespace();

        $directory = "{$this->jsDirectory}/{$this->getTable()->getNamespace()}";

        if(!file_exists($jsDirectory)) {
            mkdir($jsDirectory);
        }

        $data = [
            "phpName" => $this->getTable()->getPhpName(),
            "attributes" => [],
            "phpNamePlural" => $this->getPluralizer()->getPluralForm($this->getTable()->getName()),
            "collectionRoutes" => []
        ];

        foreach($this->getTable()->getColumns() as $column) {
            $data["attributes"][] = [
                "name" => $column->getPhpName(),
                "defaultValue" => $column->getDefaultValue()
            ];
        }

        $js = $this->renderTemplate('vuemc', $data);
        file_put_contents("{$directory}/{$this->getTable()->getPhpName()}.js", $js);
        
    }
}