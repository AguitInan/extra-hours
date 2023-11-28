<?php

class HlpForm
{	
	public static function Start($option=array())
	{
		if(!empty($option['url']) && (!empty($option['action']))){
			echo'<form  class="form-horizontal" action="'.$option['url'].'" method="'.$option['action'].'">
			<fieldset><legend>'.$option['titre'].'</legend>
			<div class="bottom-space25"></div>
			';
						
		}
	}		
	public static function Input($param)
	{	
		echo
		'<div class="clearfix"> 
		<label  class="control-label" for="'.$param.'"> '.$param.' :</label>
			<div class="controls">
				<input class="xxlarge" type="text" name="'.$param.'" id="'.$param.'">
			</div>
		</div>';
	}		
	public static function InputPwd($param)
	{
		echo'
		<div class="clearfix"> 
		<label  class="control-label" for="'.$param.'"> '.$param.' :</label>
			<div class="controls">
				<input type="password" class="xxlarge" placeholder="Password" name="'.$param.'" id="'.$param.'">
			</div>
		</div>';
  	
	}
	public static function MultiInput($values=array())
	{
		foreach($values as $v){
		echo'<div class="clearfix">
		<label class="control-label" for="'.$v.'"> '.$v.' :</label>
		<div class="controls">
		<input class="xlarge"  type="text" name="'.$v.'" id="'.$v.'">
		</div>
		</div>';	
		}		
	}
	
	// MultiInput2, version du MultiInput avec différenciation de l'intitulé du label (utilisation de la variable $k) et qui permet également d'afficher par défaut la valeur $v (value="$v" de la balise <input>)
	public static function MultiInput2($values=array())
	{
		foreach($values as $k => $v){
		echo'<div class="clearfix">
		<label class="control-label" for="'.$k.'"> '.$k.' :</label>
		<div class="controls">
		<input class="xlarge"  type="text" name="'.$k.'" id="'.$k.'" value="'.$v.'">
		</div>
		</div>';	
		}		
	}
	

	public static function Select($options=array(),$label)
	{
		echo'<div class="clearfix">
				<label class="control-label" for="normalSelect">'.$label.' :</label>
				<div class="controls">
				<select name="normalSelect" id="normalSelect">';
                foreach($options as $k => $v){
					echo' <option value="'.$k.'">'.$v.'</option>';
				}
		echo'
				</select>
				</div>
				</div>';
	}
	
	// Select2, version du Select avec $name en paramètre lorsqu'on a besoin de plusieurs formulaires Select
	public static function Select2($options=array(),$label,$name)
	{
		echo'<div class="clearfix">
				<label class="control-label" for="normalSelect">'.$label.' :</label>
				<div class="controls">
				<select name="'.$name.'" id="'.$name.'">';
                foreach($options as $k => $v){
					echo' <option value="'.$k.'">'.$v.'</option>';
				}
		echo'
				</select>
				</div>
				</div>';
	}

	// Select3, version du Select avec $name en paramètre lorsqu'on a besoin de plusieurs formulaires Select et qui permet d'afficher la valeur $value en "selected" par défaut
	public static function Select3($options=array(),$label,$name,$value)
	{
		echo'<div class="clearfix">
				<label class="control-label" for="normalSelect">'.$label.' :</label>
				<div class="controls">
				<select name="'.$name.'" id="'.$name.'" >';
                foreach($options as $k => $v){
				if ( $k == $value )
				{	echo' <option value="'.$k.'" selected="selected">'.$v.'</option>';
				}else{
					echo' <option value="'.$k.'">'.$v.'</option>';
				}}
		echo'
				</select>
				</div>
				</div>';
				
	}
	
	public static function CheckedList ($lists=array(),$label)
	{
		echo'

		<div class="control-group">
            <label class="control-label" for="optionsCheckbox">'.$label.' :</label>';

              foreach($lists as $k => $v )
				{echo'
					<div class="controls">
					<label class="checkbox">
					<input type="checkbox" id="optionsCheckbox'.$k.'"value="'.$k.'">'.$v.'
					</label>
					</div>';
				}
                echo'</div>';		
	}
	public static function RadioList ($lists=array(),$label)
	{
		echo'
		<div class="control-group">
		    <label class="control-label">'.$label.' :</label>
            <div class="controls">';
				foreach($lists as $k => $v )
				{
					echo'
						<label class="radio">
						<input type="radio"  name="radiobutton" id="optionsRadios'.$k.'" value="'.$k.'" />
						<span>'.$v.'</span>
						</label>';				
				}
		echo'
		</div>
		</div>';		
	}
	public static function Submit()
	{
		echo'
		<div class="bottom-space25"></div>
		<div class="form-horizontal">
            <input type="submit" class="btn btn-primary" value="Envoyer">&nbsp;<button type="reset" class="btn">Vider</button>
          </div>
        </fieldset>
      </form>';	
	}

}	
?>



