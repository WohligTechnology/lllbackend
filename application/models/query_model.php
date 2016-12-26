<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class query_model extends CI_Model
{
public function create($question,$answer,$author,$category)
{
$data=array("question" => $question,"answer" => $answer,"author" => $author,"category" => $category);
$query=$this->db->insert( "lll_query", $data );
$id=$this->db->insert_id();
if(!$query)
return  0;
else
return  $id;
}
public function beforeedit($id)
{
$this->db->where("id",$id);
$query=$this->db->get("lll_query")->row();
return $query;
}
function getsinglequery($id){
$this->db->where("id",$id);
$query=$this->db->get("lll_query")->row();
return $query;
}
function querySubmit($question, $category)
{
    $data=array("question" => $question,"category" => $category);
    $query=$this->db->insert( "lll_query", $data );
    $id=$this->db->insert_id();

    $obj = new stdClass();

    if(!$query){
        $obj->value = false;
        $obj->data = "Error";
    }

    else{
        $obj->value = true;
        $obj->data = "Success";
    }
    return $obj;
}
public function edit($id,$question,$answer,$author,$category)
{
$data=array("question" => $question,"answer" => $answer,"author" => $author,"category" => $category);
$this->db->where( "id", $id );
$query=$this->db->update( "lll_query", $data );
return 1;
}
public function delete($id)
{
$query=$this->db->query("DELETE FROM `lll_query` WHERE `id`='$id'");
return $query;
}
}
?>
