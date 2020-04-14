<?php 
namespace app\components;
use yii\base\Widget;
use yii\helpers\Html;
use app\models\Categories;

Class SimpleMenu extends Widget
{
	
	
	
	
	
	public function run()
    {
		$items = Categories::find()->all();
	
	$tre .= "<li>".Html::a( "All", ["../"])."</li>";
			
  foreach ($items as $item) {
       
			
			$tre .= "<li>".Html::a( $item->title, ["../?cat=".$item->alias])."</li>";
    }
	return $tre;}
}	