<div class="row">
<div class="col s12">
<h4 class="pad-left-15">Edit Query</h4>
</div>
</div>
<div class="row">
<form class='col s12' method='post' action='<?php echo site_url("site/editquerysubmit");?>' enctype= 'multipart/form-data'>
<input type="hidden" id="normal-field" class="form-control" name="id" value="<?php echo set_value('id',$before->id);?>" style="display:none;">
<div class=" row">
<div class=" input-field col s6">
<?php echo form_dropdown("category",$category,set_value('category',$before->category));?>
<label>Category</label>
</div>
</div>
<div class="row">
<div class="col s12 m6">
<label>Question</label>
<textarea id="some-textarea" name="question" placeholder="Enter text ..."><?php echo set_value( 'question',$before->question);?></textarea>
</div>
</div>
<div class="row">
<div class="col s12 m6">
<label>Answer</label>
<textarea id="some-textarea" name="answer" placeholder="Enter text ..."><?php echo set_value( 'answer',$before->answer);?></textarea>
</div>
</div>
<div class="row">
<div class="input-field col s6">
<label for="author">Author</label>
<input type="text" id="author" name="author" value='<?php echo set_value('author',$before->author);?>'>
</div>
</div>
<div class="row">
<div class="col s6">
<button type="submit" class="btn btn-primary waves-effect waves-light  blue darken-4">Save</button>
<a href='<?php echo site_url("site/viewquery"); ?>' class='btn btn-secondary waves-effect waves-light red'>Cancel</a>
</div>
</div>
</form>
</div>
