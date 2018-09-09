<?php

namespace jdombroski\Propel\Behavior\VueMC;

use Propel\Generator\Model\Behavior;
use Propel\Common\Pluralizer\StandardEnglishPluralizer;
use Propel\Common\Pluralizer\PluralizerInterface;

class VueMCBehavior extends Behavior
{
    // default parameters value
    protected $parameters = [
        "path" => null,
        "modelRoutes" => "",        //  yaml_decodeable
        "collectionRoutes" => "",   //  yaml_decodeable
    ];

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

        $directory = "{$this->jsDirectory}/{$this->getParameter("path")}/vuemc";
        $baseDirectory = "{$directory}/base";

        if(!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }

        if(!file_exists($baseDirectory)) {
            mkdir($baseDirectory, 0777, true);
        }

        $data = [
            "phpName" => $this->getTable()->getPhpName(),
            "attributes" => [],
            "phpNamePlural" => $this->getPluralizer()->getPluralForm($this->getTable()->getPhpName()),
            "modelRoutes" => yaml_parse($this->getParameter("modelRoutes")),
            "collectionRoutes" => yaml_parse($this->getParameter("collectionRoutes"))
        ];

        foreach($this->getTable()->getColumns() as $column) {
            $data["attributes"][] = [
                "name" => $column->getPhpName(),
                "defaultValue" => $column->getDefaultValue() ? $column->getDefaultValue() : "'null'"
            ];
        }

        $modelJs = $this->renderTemplate('model_base', $data);
        $collectionJs = $this->renderTemplate('collection_base', $data);

        file_put_contents("{$baseDirectory}/" . strtolower($data["phpName"]) . ".js", $modelJs);
        file_put_contents("{$baseDirectory}/" . strtolower($data["phpNamePlural"]) . ".js", $modelJs);

        if(!file_exists("{$directory}/" . strtolower($data["phpName"]) . ".js")) {
            $modelJs = $this->renderTemplate('model', $data);
            file_put_contents("{$directory}/" . strtolower($data["phpName"]) . ".js", $modelJs);
        }

        if(!file_exists("{$directory}/" . strtolower($data["phpNamePlural"]) . ".js")) {
            $collectionJs = $this->renderTemplate('collection', $data);
            file_put_contents("{$directory}/" . strtolower($data["phpNamePlural"]) . ".js", $collectionJs);
        }
    }
}