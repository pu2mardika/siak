<?php if (!defined('BASEPATH')) exit('No direct script access allowed');  
$row=(isset($skl))?$skl:array(); 
echo '<div class="box borderless">';
echo form_open($action, array('class' => 'contentform form-horizontal', 'id'=>'formcurr'));

//'grade', 'subgrade', 'skl', 'state'

//grade
echo '<div class="form-group input">';
echo "<label for='grade'>". $this->lang->line('curr_grade')."</label>";
//echo form_input('grade',(array_key_exists('grade',$row))?$row['grade']:"",'class="form-control input-sm" required="required" id="grade" title="'.$this->lang->line('curr_subgrade').'"'); 
echo form_dropdown('grade',$grade,'','class="form-control input-sm" required="required" id="state" title="'.$this->lang->line('curr_grade').'"'); 
echo form_error('grade','<span class="error">','</span>');
echo '</div>';
//subgrade
echo '<div class="form-group input">';
echo "<label for='subgrade'>". $this->lang->line('curr_subgrade')."</label>";
//echo form_input('subgrade',(array_key_exists('subgrade',$row))?$row['grade']:"",'class="form-control input-sm" required="required" id="subgrade" title="'.$this->lang->line('curr_subgrade').'"'); 
echo form_dropdown('subgrade',$subgrade,'','class="form-control input-sm" required="required" id="state" title="'.$this->lang->line('curr_subgrade').'"'); 
echo form_error('subgrade','<span class="error">','</span>');
echo '</div>';
//skl
echo '<div class="form-group input">';
echo "<label for='desc'>". $this->lang->line('curr_skl')."</label>";
echo '<textarea id="skl" name="skl" rows="4" class="form-control input-sm editor" required="required"></textarea>';
echo form_error('skl','<span class="error">','</span>');
echo '</div>';
//state
echo '<div class="form-group input">';
echo "<label for='state'>". $this->lang->line('state')."</label>";
echo form_dropdown('state',$options,'','class="form-control input-sm" required="required" id="state" title="'.$this->lang->line('state').'"'); 
echo form_error('state','<span class="error">','</span>');
echo '</div>';
/*submit button
echo '<div class="form-group input">';
echo "<label for='submit'></label>";
echo '<button name="simpan" type="submit" class="btn btn-primary">'.$this->lang->line('save').'</button>';
echo '</div>';

//curr_id*/
echo form_hidden('curr_id',$ids);
echo form_close();
echo '</div>';