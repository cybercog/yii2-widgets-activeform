<?php
/**
 * @link http://www.56hm.com/
 * @copyright Copyright (c) 2014 Repar Software LLC
 * @license http://56hm.com/license/
 */

namespace repkit\form;

use yii\base\InvalidConfigException;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;


/**
 * Extends and enhances the Yii ActiveForm widget
 *
 * @author Repar <47558328@qq.com>
 * @since 1.0 
 */
class ActiveForm extends \yii\widgets\ActiveForm {

	/**
     * The form layouts options
     */
    const LAYOUT_DEFAULT = 'default';
	const LAYOUT_HORIZONTAL = 'horizontal';
	const LAYOUT_INLINE = 'inline';


    /**
     * @var string  the default field class name when calling [[field()]] to create a new field
     */
	public $fieldClass = '\repkit\form\ActiveField';

    /**
     * @var array  HTML attributes for the form tag. Default is `['role' => 'form']`.
     */
	public $options = ['role' => 'form'];

	/**
     * @var array horizontal layout configuration
     *
     * `````
     * horizontalLayout = [
     *    'label' => 'col-sm-5',
     *    'offset' => 'col-sm-offset-8',
     *    'wrapper' => 'col-sm-3',
     *    'error' => '',
     *    'hint' => 'col-sm-8',
     * ]
     * `````
     */
	public $horizontalLayout;

    /**
     * @var string  set form  layout.   
     * @see layout options see : [self::LAYOUT_...]
     * By choosing a layout, an appropriate default field configuration is applied. This will
     * render the form fields with slightly different markup for each layout. You can
     * override these defaults through [[fieldConfig]].
     * @see \repkit\form\ActiveField for details on Bootstrap 3 field configuration
     * 
     */
	public $layout = 'default';


	/**
     * @inheritdoc
     */
    public function __construct($config = [])
    {
         $layoutConfig = $this->setLayouts($config);
         $config = ArrayHelper::merge($layoutConfig, $config);
         parent::__construct($config);
    }

    


	public function init(){

        if ($this->layout !== 'default') {
            Html::addCssClass($this->options, 'form-' . $this->layout);
        }

        parent::init();

	}

    /**
     * Sets form default configuration
     */
	protected function setLayouts($instanceConfig){
         
        $config = [];
        //get or set default layout
        $layout = ArrayHelper::getValue($instanceConfig, 'layout', self::LAYOUT_DEFAULT);
        $layouts = [self::LAYOUT_DEFAULT, self::LAYOUT_HORIZONTAL, self::LAYOUT_INLINE];
        if(!in_array($layout, $layouts)){
        	throw new InvalidConfigException('Invalid layout type: "' . $this->layout. '", layout options Can only include: [' . implode(',', $layouts) . ']');
        }
        if($layout === ActiveForm::LAYOUT_HORIZONTAL){
		   $classes = [
		        'label' => 'col-sm-1',
		        'offset' => 'col-sm-offset-1',
		        'wrapper' => 'col-sm-3',
		        'hint' => 'col-sm-8',
		        'error' => ''
		    ];
		    if (isset($instanceConfig['horizontalLayout'])) {
		        $classes = ArrayHelper::merge($classes, $instanceConfig['horizontalLayout']);
		    }
		    $config['horizontalLayout'] = $classes;
		}

		$config['layout'] = $layout;
        return $config;
	}

}