<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class recommendarticle_model extends CI_Model
{
public function create($article,$recommendarticle)
{
$data=array("article" => $article,"recommendarticle" => $recommendarticle);
$query=$this->db->insert( "lll_recommendarticle", $data );
$id=$this->db->insert_id();
if(!$query)
return  0;
else
return  $id;
}
public function beforeedit($id)
{
$this->db->where("id",$id);
$query=$this->db->get("lll_recommendarticle")->row();
return $query;
}
function getsinglerecommendarticle($id){
$this->db->where("id",$id);
$query=$this->db->get("lll_recommendarticle")->row();
return $query;
}
public function edit($id,$article,$recommendarticle)
{
$data=array("article" => $article,"recommendarticle" => $recommendarticle);
$this->db->where( "id", $id );
$query=$this->db->update( "lll_recommendarticle", $data );
return 1;
}
public function delete($id)
{
$query=$this->db->query("DELETE FROM `lll_recommendarticle` WHERE `id`='$id'");
return $query;
}
public function getarticledropdown()
{
    $query = $this->db->query('SELECT * FROM `lll_article`  ORDER BY `id` ASC')->result();
    foreach ($query as $row) {
        $article[$row->id] = $row->title;
    }

    return $article;
}

public function getrecommendarticledropdown()
{
    $query = $this->db->query('SELECT * FROM `lll_article`  ORDER BY `id` ASC')->result();
    foreach ($query as $row) {
        $article[$row->id] = $row->title;
    }

    return $article;
}
}
?>
