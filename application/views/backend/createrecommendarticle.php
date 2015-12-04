<div class="row">
<div class="col s12">
<h4 class="pad-left-15">Create recommendarticle</h4>
</div>
<form class='col s12' method='post' action='<?php echo site_url("site/createrecommendarticlesubmit");?>' enctype= 'multipart/form-data'>
<div class=" row">
<div class=" input-field col s6">
<?php echo form_dropdown("article",$article,set_value('article'));?>
<label>Article</label>
</div>
</div>
<div class=" row">
<div class=" input-field col s6">
<?php echo form_dropdown("recommendarticle",$recommendarticle,set_value('recommendarticle'));?>
<label>Recommended Article</label>
</div>
</div>
<div class="row">
<div class="col s12 m6">
<button type="submit" class="btn btn-primary waves-effect waves-light blue darken-4">Save</button>
<a href="<?php echo site_url("site/viewrecommendarticle"); ?>" class="btn btn-secondary waves-effect waves-light red">Cancel</a>
</div>
</div>
</form>
</div>
