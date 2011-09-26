<?php if (!defined('APPLICATION')) exit();
// Loop the currently loaded locale definitions looking for matches
$Locale = Gdn::Locale();
$Definitions = $Locale->GetDefinitions();
$CountDefinitions = count($Definitions);
$CountMatches = count($this->Matches);
echo $this->Form->Open();
?>
<style type="text/css">
textarea.TextBox { height: 22px; min-height: 22px; }
#Form_Go { margin: 0 20px !important; }
</style>
<script type="text/javascript" language="javascript">
jQuery(document).ready(function($) {
	if ($.autogrow)
      $('textarea.TextBox').autogrow();
});
</script>
<h1>Customize Text</h1>
<div class="Info">
   <?php
		echo 'Editable text definitions: '.Wrap($CountDefinitions, 'strong');
      echo $this->Form->Errors();
      echo '<p>Search for the text you want to customize. Partial searches work. For example: "disc" will return "discussion" and "all discussions", etc.</p>';
		echo '<p>'.Anchor('Find Editable Text', '/settings/customizetext/rebuild', 'SmallButton').'</p>';
		echo '<br />';
      echo $this->Form->TextBox('Keywords');
      echo $this->Form->Button(T('Go'));
   ?>
</div>
<?php
if ($this->Form->GetValue('Keywords', '') != '') {
	echo '<h3>';
	printf(T('%s matches found.'), $CountMatches);
	echo '</h3>';
	echo '<ul>';
	$Loop = 0;
	foreach ($this->Matches as $Key => $Definition) {
		echo '<li>';
		echo Wrap(Gdn_Format::Text($Key), 'label', array('for' => 'Form_def_'.$Loop));
		echo $this->Form->Hidden('code_'.$Loop, array('value' => $Key));
		$OldCode = $this->Form->GetValue('code_'.$Loop);
		$NewDef = $this->Form->GetValue('def_'.$Loop);
		if ($OldCode == $Key && $NewDef !== FALSE && $NewDef != $Definition)
			echo $this->Form->TextBox('def_'.$Loop, array('multiline' => TRUE));
		else
			echo $this->Form->TextBox('def_'.$Loop, array('value' => $Definition, 'multiline' => TRUE));
			
		echo '</li>';
		$Loop++;
	}
	echo '</ul>';
	echo $this->Form->Button('Save All');
}
echo $this->Form->Close();