<?php
/**
 * @link http://www.56hm.com/
 * @copyright Copyright (c) 2014 Repar Software LLC
 * @license http://56hm.com/license/
 */

namespace repkit\form;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;


/**
 * Extends and enhances the Yii ActiveField widget
 *
 * @author Repar <47558328@qq.com>
 * @since 1.0 
 */
class ActiveField extends \yii\widgets\ActiveField {
    
    /**
     * inline layout under the label display css style
     */
	const SR_ONLY = 'sr-only';

    /**
     * @var boolean|null  Whether enable label
     */
	public $enableLabel;

    /**
     * @var boolean|null  Whether enable error
     */
	public $enableError;

    
    /**
     * @var input wrapper options
     */
	public $wrapperOptions = [];

    /**
     * @var string|empty input template
     */
    public $inputTemplate;

    /**
     * @var array addon plugin.
     *   var options: array addon wrapper option configuration
     *   var content: string|array
     *   var asbtn: boolean Whether for button layout type
     *
     * Layout
     *
     * ````
     * addon => [
     *    'options' => [...],
     *    
     *    'before' => [
     *        'content' => '...'
     *    ],
     *
     *    'after' => [
     *       'asbtn' => true,
     *       'content' => [....]
     *    ]
     * 
     * ]
     * `````
     */
    public $addon;

    /**
     * @var array addon options
     */
	public $addonOptions = [];



     /**
     * @inheritdoc
     */
    public function __construct($config = [])
    {
         $layoutConfig = $this->setLayouts($config);
         $config = ArrayHelper::merge($layoutConfig, $config);
         parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function render($content = null){

    	if($content === null){

    		if(!isset($this->parts['beginWrapper'])){
                $options = $this->wrapperOptions;
                $tag = ArrayHelper::remove($options, 'tag', 'div');
                $this->parts['{beginWrapper}'] = Html::beginTag($tag, $options);
                $this->parts['{endWrapper}'] = Html::endTag($tag);
    		}
    		if ($this->enableLabel === false) {
                $this->parts['{label}'] = '';
                $this->parts['{beginLabel}'] = '';
                $this->parts['{labelTitle}'] = '';
                $this->parts['{endLabel}'] = '';
                Html::addCssClass($this->labelOptions, self::SR_ONLY);
            } elseif (!isset($this->parts['{beginLabel}'])) {
                $this->renderLabelParts();
            }
    		if ($this->enableError === false) {
                $this->parts['{error}'] = '';
            }
            if(is_array($this->addon) && !empty($this->addon)){
	           $addon = $this->addon;
	           $before =  static::addonLayout(ArrayHelper::getValue($addon, 'before'), $this->addonOptions);
	           $after = static::addonLayout(ArrayHelper::getValue($addon, 'after'), $this->addonOptions);
	           $input = $before . '{input}' . $after;
	           $addonOptions = ArrayHelper::getValue($addon, 'options', []);
	           Html::addCssClass($addonOptions, 'input-group');
	           $input = Html::tag('div', $input, $addonOptions);
	           $this->template = str_replace('{input}', $input, $this->template);
	        }
	        if ($this->inputTemplate) {
                $input = isset($this->parts['{input}']) ?
                    $this->parts['{input}'] : Html::activeTextInput($this->model, $this->attribute, $this->inputOptions);
                $this->parts['{input}'] = strtr($this->inputTemplate, ['{input}' => $input]);
            }
    	}
        return parent::render($content);
    }

    

    /**
     * @param array $instanceConfig the configuration passed to this instance's constructor
     * @return array the layout specific default configuration for this instance
     */
    public function setLayouts($instanceConfig){

        $config = [
            'hintOptions' => [
                'tag' => 'p',
                'class' => 'help-block',
            ],
            'errorOptions' => [
                'tag' => 'p',
                'class' => 'help-block help-block-error',
            ],
            'inputOptions' => [
                'class' => 'form-control',
            ]
        ];

        $layout = $instanceConfig['form']->layout;
        if($layout === ActiveForm::LAYOUT_HORIZONTAL){
           $classes = $instanceConfig['form']->horizontalLayout;
           $config['template'] = "{label}\n{beginWrapper}\n{input}\n{error}\n{endWrapper}\n{hint}";
            $config['wrapperOptions'] = ['class' => $classes['wrapper']];
            $config['labelOptions'] = ['class' => 'control-label ' . $classes['label']];
            $config['errorOptions'] = ['class' => 'help-block help-block-error ' . $classes['error']];
            $config['hintOptions'] = ['class' => 'help-block ' . $classes['hint']];
        }elseif ($layout === 'inline') {
            $config['enableLabel'] = false;
            $config['enableError'] = false;
        }

        return $config;
    }


    /**
     * @param string|null $label the label or null to use model label
     * @param array $options the tag options
     */
    protected function renderLabelParts($label = null, $options = [])
    {
        $options = array_merge($this->labelOptions, $options);
        if ($label === null) {
            if (isset($options['label'])) {
                $label = $options['label'];
                unset($options['label']);
            } else {
                $attribute = Html::getAttributeName($this->attribute);
                $label = Html::encode($this->model->getAttributeLabel($attribute));
            }
        }
        $this->parts['{beginLabel}'] = Html::beginTag('label', $options);
        $this->parts['{endLabel}'] = Html::endTag('label');
        $this->parts['{labelTitle}'] = $label;
    }




    /**
     * [addonLayout description]
     * @param  [type] $addon   [description]
     * @param  [type] $options [description]
     * @return [type]          [description]
     */
    protected static function addonLayout($addon, $options = []){

    	$content = ArrayHelper::getValue($addon, 'content', '');
        Html::addCssClass($options,(isset($addon['asbtn']) && $addon['asbtn'] === true) ? 'input-group-btn' : 'input-group-addon');
        return Html::tag('div',$content, $options);
    }

}