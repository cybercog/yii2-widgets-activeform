Yii2-Widgets-ActiveForm
=======================
This extension Extends and enhances the [Yii ActiveForm](https://github.com/yiisoft/yii2/blob/master/framework/widgets/ActiveForm.php) widget. Encapsulates the three form layout: default, horizontal, inline. To help developers to quickly create the form. At the same time, we and extends and enhances the [Yii ActiveField](https://github.com/yiisoft/yii2/blob/master/framework/widgets/ActiveField.php) widget. Details please refer to the following instructions and
[Yii2-Toolkit API Documentation](http://reparsoft.github.io/yii2-toolkit-doc).

> NOTE: This extension dependent on the [reparsoft/Yii2-Toolkit-Base](https://github.com/reparsoft/yii2-toolkit-base/tree/master/) extension. Check This  extension the bundled ```composer.json``` requirements and dependencies. At the same time, This extension has been encapsulated in [reparsoft/Yii2-Widgets](https://github.com/reparsoft/yii2-widgets/) extension. Unified call namespace ```repkit\widgets```. If the user choose custom installation other extensions, at use of time,
> ```namespace``` Please refer API Documentation of ```origin namespace``` description.



## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/). Remember to refer to the bundled ```composer.json``` for this extension's requirements and dependencies. 


### Install

Either run

```
$ php composer.phar require reparsoft/yii2-widgets-activeform "*"
```

or add

```
"reparsoft/yii2-widgets-activeform": "*"
```

to the ```require``` section of your `composer.json` file.



##Usage

#### ActiveForm

	use \repkit\form\ActiveForm;
	
	$form = ActiveForm::begin([
      //...settings options

      'layout' => ActiveForm::LAYOUT_HORIZONTAL,
      'fieldConfig' = [
          
      ]
    ]);

      //contents....

    
    $form::end();

#### Settings Options
 
```layout: ``` [string] set form layout. 

- defaultValue: default
- Optional constants:
   * default: [self::LAYOUT_DEFAULT].
   * horizontal: (self::LAYOUT_HORIZONTAL).
   * inline: (self::LAYOUT_INLINE).


```horizontalLayout:``` [array|empty] horizontal layout configuration.

- options: [label, offset, wrapper, error, hint]
  
Example:


	horizontalLayout = [
	  'label' => 'col-sm-5',
	  'offset' => 'col-sm-offset-8',
	  'wrapper' => 'col-sm-3',
	  'error' => '',
	  'hint' => 'col-sm-8',
	]


```fieldConfig``` [array|empty] ActiveField default global configuration. configuration detail Please refer to the [ActiveField README.md](https://github.com/reparsoft/yii2-widgets-activeform/blob/master/README.md) or [API Documentation](https://github.com/reparsoft/yii2-toolkit-doc/components/index.html#activefield).



#### ActiveFiled

	use \repkit\form\ActiveForm;
	
	$form = ActiveForm::begin([
      //...settings options
    ]);

      echo $form->field($model, AttributeName, [
              //ActiveField settings options

              'enableLabel' => true,
              'enableError' => false
           ]);


      echo $form->field($model, AttributeName, [
              //ActiveField settings options
           ])->textInput([
              //ActiveField settings options
           ]);
    
    $form::end();

#### Settings Options
 
```enableLabel: ``` [boolean|empty] Whether enable label.

```enableError: ``` [boolean|empty] Whether enable error.

```wrapperOptions: ``` [array|empty] input wrapper options.

```inputTemplate: ``` [string|empty] input template.

```addon: ``` [array|empty] addon plugin.

- options: [options, before|after]
  * before|after options: [asbtn, content].
  * asbtn: [boolean|empty] Whether the button.
- Example:

		addon => [
		  'options' => [...],
		  'before' => [
		    'content' => '...'
		  ],
		  'after' => [
		    'asbtn' => true,
		    'content' => [....]
		  ]
		]

```addonOptions: ``` [array|empty] addon options.


## Example


use \repkit\form\ActiveForm;
	
	$form = ActiveForm::begin([
      'layout' => ActiveForm::LAYOUT_HORIZONTAL,
	  'horizontalLayout' => [
          'label' => 'col-sm-1',
          'offset' => 'col-sm-offset-6',
          'wrapper' => 'col-sm-6',
          'error' => '',
          'hint' => 'col-sm-5',
      ],
	  'fieldConfig' => [
         'enableLabel' => false,
         'enableError' => true
      ],

    ]);

    echo $form->field($model, 'username',[
      'enableError' => false,
      'enableLabel' => false,
      
      'addon' => [
        'options' => [
           'data-toggle' => 'addon'
        ],

         'before' => [
             'content' => '@'
         ],

         'after' => [
             'asbtn' => true,
             'content' => 
                 '<button type="button" class="btn btn-default" 
                     tabindex="-1">下拉菜单
                  </button>
                  <button type="button" class="btn btn-default 
                     dropdown-toggle" data-toggle="dropdown" tabindex="-1">
                     <span class="caret"></span>
                     <span class="sr-only">切换下拉菜单</span>
                  </button>
                  <ul class="dropdown-menu pull-right">
                     <li><a href="#">功能</a></li>
                     <li><a href="#">另一个功能</a></li>
                     <li><a href="#">其他</a></li>
                     <li class="divider"></li>
                     <li><a href="#">分离的链接</a></li>
                  </ul>'
          ]
       ]
    ])->hint('用户姓名由于[a-zA-Z]组成');
    
    $form::end();



Yii2-Toolkit API Documentation
--------------------------------

- API Documentation github repository: [Yii2-Toolkit-Doc Github Repository](https://github.com/reparsoft/yii2-toolkit-doc/).
- Online API Documentation: [Yii2-Toolkit API Documentation](http://reparsoft.github.io/yii2-toolkit-doc/)



## License

This extension is released under the BSD-3-Clause License. See the bundled `LICENSE.md` for details.