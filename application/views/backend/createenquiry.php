<div class="row">
<div class="col s12">
<h4 class="pad-left-15">Create Enquiry</h4>
</div>
<form class='col s12' method='post' action='<?php echo site_url("site/createenquirysubmit");?>' enctype= 'multipart/form-data'>
<div class="row">
<div class="input-field col s6">
<label for="Type">Type</label>
<input type="text" id="Type" name="type" value='<?php echo set_value('type');?>'>
</div>
</div>
<div class="row">
<div class="input-field col s6">
<label for="Subject">Subject</label>
<input type="text" id="Subject" name="subject" value='<?php echo set_value('subject');?>'>
</div>
</div>
<div class="row">
<div class="input-field col s6">
<label for="Query">Query</label>
<input type="text" id="Query" name="query" value='<?php echo set_value('query');?>'>
</div>
</div>
<div class="row">
<div class="col s12 m6">
<button type="submit" class="btn btn-primary waves-effect waves-light blue darken-4">Save</button>
<a href="<?php echo site_url("site/viewenquiry"); ?>" class="btn btn-secondary waves-effect waves-light red">Cancel</a>
</div>
</div>
</form>
</div>
