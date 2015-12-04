<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class category_model extends CI_Model
{
public function create($order,$title,$banner,$image,$text)
{
$data=array("order" => $order,"title" => $title,"banner" => $banner,"image" => $image,"text" => $text);
$query=$this->db->insert( "lll_category", $data );
$id=$this->db->insert_id();
if(!$query)
return  0;
else
return  $id;
}
public function beforeedit($id)
{
$this->db->where("id",$id);
$query=$this->db->get("lll_category")->row();
return $query;
}
function getsinglecategory($id){
$this->db->where("id",$id);
$query=$this->db->get("lll_category")->row();
return $query;
}
public function edit($id,$order,$title,$banner,$image,$text)
{
$data=array("order" => $order,"title" => $title,"banner" => $banner,"image" => $image,"text" => $text);
$this->db->where( "id", $id );
$query=$this->db->update( "lll_category", $data );
return 1;
}
public function delete($id)
{
$query=$this->db->query("DELETE FROM `lll_category` WHERE `id`='$id'");
return $query;
}
}
?>
