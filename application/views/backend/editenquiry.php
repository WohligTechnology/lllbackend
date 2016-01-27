<div class="row">
<div class="col s12">
<h4 class="pad-left-15">Edit enquiry</h4>
</div>
</div>
<div class="row">
<form class='col s12' method='post' action='<?php echo site_url("site/editenquirysubmit");?>' enctype= 'multipart/form-data'>
<input type="hidden" id="normal-field" class="form-control" name="id" value="<?php echo set_value('id',$before->id);?>" style="display:none;">
<div class="row">
<div class="input-field col s6">
<label for="Type">Type</label>
<input type="text" id="Type" name="type" value='<?php echo set_value('type',$before->type);?>'>
</div>
</div>
<div class="row">
<div class="input-field col s6">
<label for="Subject">Subject</label>
<input type="text" id="Subject" name="subject" value='<?php echo set_value('subject',$before->subject);?>'>
</div>
</div>
<div class="row">
<div class="input-field col s6">
<label for="Query">Query</label>
<input type="text" id="Query" name="query" value='<?php echo set_value('query',$before->query);?>'>
</div>
</div>
<div class="row">
<div class="input-field col s6">
<label for="Timestamp">Timestamp</label>
<input type="text" id="Timestamp" name="timestamp" value='<?php echo set_value('timestamp',$before->timestamp);?>'>
</div>
</div>
<div class="row">
<div class="col s6">
<button type="submit" class="btn btn-primary waves-effect waves-light  blue darken-4">Save</button>
<a href='<?php echo site_url("site/viewenquiry"); ?>' class='btn btn-secondary waves-effect waves-light red'>Cancel</a>
</div>
</div>
</form>
</div>
