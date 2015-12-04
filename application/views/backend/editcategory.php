<div class="row">
<div class="col s12">
<h4 class="pad-left-15">Edit category</h4>
</div>
</div>
<div class="row">
<form class='col s12' method='post' action='<?php echo site_url("site/editcategorysubmit");?>' enctype= 'multipart/form-data'>
<input type="hidden" id="normal-field" class="form-control" name="id" value="<?php echo set_value('id',$before->id);?>" style="display:none;">
<div class="row">
<div class="input-field col s6">
<label for="Order">Order</label>
<input type="text" id="Order" name="order" value='<?php echo set_value('order',$before->order);?>'>
</div>
</div>
<div class="row">
<div class="input-field col s6">
<label for="Title">Title</label>
<input type="text" id="Title" name="title" value='<?php echo set_value('title',$before->title);?>'>
</div>
</div>

<div class="row">
  <div class="file-field input-field col m6 s12">
    <span class="img-center big image">
                    <?php
if ($before->image == '') {
} else {
?><img src="<?php
echo base_url('uploads') . '/' . $before->image;
?>">
        <?php
}
?></span>
    <div class="btn blue darken-4">
      <span>Image</span>
      <input name="image" type="file" multiple>
    </div>
    <div class="file-path-wrapper">
      <input class="file-path validate image" type="text" placeholder="Upload one or more files" value="<?php
echo set_value('image', $before->image);
?>">
    </div>
  </div>
</div>

<div class="row">
  <div class="file-field input-field col m6 s12">
    <span class="img-center big image">
                    <?php
if ($before->banner == '') {
} else {
?><img src="<?php
echo base_url('uploads') . '/' . $before->banner;
?>">
        <?php
}
?></span>
    <div class="btn blue darken-4">
      <span>Banner</span>
      <input name="banner" type="file" multiple>
    </div>
    <div class="file-path-wrapper">
      <input class="file-path validate image" type="text" placeholder="Upload one or more files" value="<?php
echo set_value('banner', $before->banner);
?>">
    </div>
  </div>
</div>

<div class="row">
<div class="input-field col s6">
<label for="Text">Text</label>
<input type="text" id="Text" name="text" value='<?php echo set_value('text',$before->text);?>'>
</div>
</div>
<div class="row">
<div class="col s6">
<button type="submit" class="btn btn-primary waves-effect waves-light  blue darken-4">Save</button>
<a href='<?php echo site_url("site/viewcategory"); ?>' class='btn btn-secondary waves-effect waves-light red'>Cancel</a>
</div>
</div>
</form>
</div>
