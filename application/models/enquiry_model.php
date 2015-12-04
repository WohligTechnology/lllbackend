<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class enquiry_model extends CI_Model
{
public function create($type,$subject,$query,$timestamp)
{
$data=array("type" => $type,"subject" => $subject,"query" => $query,"timestamp" => $timestamp);
$query=$this->db->insert( "lll_enquiry", $data );
$id=$this->db->insert_id();
if(!$query)
return  0;
else
return  $id;
}
public function beforeedit($id)
{
$this->db->where("id",$id);
$query=$this->db->get("lll_enquiry")->row();
return $query;
}
function getsingleenquiry($id){
$this->db->where("id",$id);
$query=$this->db->get("lll_enquiry")->row();
return $query;
}
public function edit($id,$type,$subject,$query,$timestamp)
{
$data=array("type" => $type,"subject" => $subject,"query" => $query,"timestamp" => $timestamp);
$this->db->where( "id", $id );
$query=$this->db->update( "lll_enquiry", $data );
return 1;
}
public function delete($id)
{
$query=$this->db->query("DELETE FROM `lll_enquiry` WHERE `id`='$id'");
return $query;
}
}
?>
