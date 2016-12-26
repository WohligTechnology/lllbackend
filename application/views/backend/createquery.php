<div class="row">
<div class="col s12">
<h4 class="pad-left-15">Create Query</h4>
</div>
<form class='col s12' method='post' action='<?php echo site_url("site/createquerysubmit");?>' enctype= 'multipart/form-data'>
<div class=" row">
<div class=" input-field col s6">
<?php echo form_dropdown("category",$category,set_value('category'));?>
<label>Category</label>
</div>
</div>
<div class="row">
<div class="col s12 m6">
<label>Question</label>
<textarea id="some-textarea" name="question" placeholder="Enter text ..."><?php echo set_value( 'question');?></textarea>
</div>
</div>
<div class="row">
<div class="col s12 m6">
<label>Answer</label>
<textarea id="some-textarea" name="answer" placeholder="Enter text ..."><?php echo set_value( 'answer');?></textarea>
</div>
</div>
<div class="row">
<div class="input-field col s6">
<label for="author">Author</label>
<input type="text" id="author" name="author" value='<?php echo set_value('author');?>'>
</div>
</div>
<div class="row">
<div class="col s12 m6">
<button type="submit" class="btn btn-primary waves-effect waves-light blue darken-4">Save</button>
<a href="<?php echo site_url("site/viewquery"); ?>" class="btn btn-secondary waves-effect waves-light red">Cancel</a>
</div>
</div>
</form>
</div>
