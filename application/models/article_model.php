<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class article_model extends CI_Model
{
public function create($category,$title,$image,$author,$timestamp,$desc)
{
$data=array("category" => $category,"title" => $title,"image" => $image,"author" => $author,"timestamp" => $timestamp,"desc" => $desc);
$query=$this->db->insert( "lll_article", $data );
$id=$this->db->insert_id();
if(!$query)
return  0;
else
return  $id;
}
public function beforeedit($id)
{
$this->db->where("id",$id);
$query=$this->db->get("lll_article")->row();
return $query;
}
function getsinglearticle($id){
$this->db->where("id",$id);
$query=$this->db->get("lll_article")->row();
return $query;
}
public function edit($id,$category,$title,$image,$author,$timestamp,$desc)
{
$data=array("category" => $category,"title" => $title,"image" => $image,"author" => $author,"timestamp" => $timestamp,"desc" => $desc);
$this->db->where( "id", $id );
$query=$this->db->update( "lll_article", $data );
return 1;
}
public function delete($id)
{
$query=$this->db->query("DELETE FROM `lll_article` WHERE `id`='$id'");
return $query;
}

public function getcategorydropdown()
{
    $query = $this->db->query('SELECT * FROM `lll_category`  ORDER BY `id` ASC')->result();
    foreach ($query as $row) {
        $category[$row->id] = $row->title;
    }
    return $category;
}
public function getrecommendarticledropdown()
{
    $query = $this->db->query('SELECT * FROM `lll_recommendarticle`  ORDER BY `id` ASC')->result();
    foreach ($query as $row) {
        $recommendarticle[$row->id] = $row->recommendarticle;
    }
    return $recommendarticle;
}
}
?>
