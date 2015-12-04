<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");
class Json extends CI_Controller 
{function getallcategory()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`lll_category`.`id`";
$elements[0]->sort="1";
$elements[0]->header="Id";
$elements[0]->alias="id";

$elements=array();
$elements[1]=new stdClass();
$elements[1]->field="`lll_category`.`order`";
$elements[1]->sort="1";
$elements[1]->header="Order";
$elements[1]->alias="order";

$elements=array();
$elements[2]=new stdClass();
$elements[2]->field="`lll_category`.`title`";
$elements[2]->sort="1";
$elements[2]->header="Title";
$elements[2]->alias="title";

$elements=array();
$elements[3]=new stdClass();
$elements[3]->field="`lll_category`.`banner`";
$elements[3]->sort="1";
$elements[3]->header="Banner";
$elements[3]->alias="banner";

$elements=array();
$elements[4]=new stdClass();
$elements[4]->field="`lll_category`.`image`";
$elements[4]->sort="1";
$elements[4]->header="Image";
$elements[4]->alias="image";

$elements=array();
$elements[5]=new stdClass();
$elements[5]->field="`lll_category`.`text`";
$elements[5]->sort="1";
$elements[5]->header="Text";
$elements[5]->alias="text";

$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `lll_category`");
$this->load->view("json",$data);
}
public function getsinglecategory()
{
$id=$this->input->get_post("id");
$data["message"]=$this->category_model->getsinglecategory($id);
$this->load->view("json",$data);
}
function getallarticle()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`lll_article`.`id`";
$elements[0]->sort="1";
$elements[0]->header="Id";
$elements[0]->alias="id";

$elements=array();
$elements[1]=new stdClass();
$elements[1]->field="`lll_article`.`category`";
$elements[1]->sort="1";
$elements[1]->header="Category";
$elements[1]->alias="category";

$elements=array();
$elements[2]=new stdClass();
$elements[2]->field="`lll_article`.`title`";
$elements[2]->sort="1";
$elements[2]->header="Title";
$elements[2]->alias="title";

$elements=array();
$elements[3]=new stdClass();
$elements[3]->field="`lll_article`.`image`";
$elements[3]->sort="1";
$elements[3]->header="Image";
$elements[3]->alias="image";

$elements=array();
$elements[4]=new stdClass();
$elements[4]->field="`lll_article`.`author`";
$elements[4]->sort="1";
$elements[4]->header="Author";
$elements[4]->alias="author";

$elements=array();
$elements[5]=new stdClass();
$elements[5]->field="`lll_article`.`timestamp`";
$elements[5]->sort="1";
$elements[5]->header="Timestamp";
$elements[5]->alias="timestamp";

$elements=array();
$elements[6]=new stdClass();
$elements[6]->field="`lll_article`.`desc`";
$elements[6]->sort="1";
$elements[6]->header="Description";
$elements[6]->alias="desc";

$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `lll_article`");
$this->load->view("json",$data);
}
public function getsinglearticle()
{
$id=$this->input->get_post("id");
$data["message"]=$this->article_model->getsinglearticle($id);
$this->load->view("json",$data);
}
function getallrecommendarticle()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`lll_recommendarticle`.`id`";
$elements[0]->sort="1";
$elements[0]->header="Id";
$elements[0]->alias="id";

$elements=array();
$elements[1]=new stdClass();
$elements[1]->field="`lll_recommendarticle`.`article`";
$elements[1]->sort="1";
$elements[1]->header="Article";
$elements[1]->alias="article";

$elements=array();
$elements[2]=new stdClass();
$elements[2]->field="`lll_recommendarticle`.`recommendarticle`";
$elements[2]->sort="1";
$elements[2]->header="Recommended Article";
$elements[2]->alias="recommendarticle";

$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `lll_recommendarticle`");
$this->load->view("json",$data);
}
public function getsinglerecommendarticle()
{
$id=$this->input->get_post("id");
$data["message"]=$this->recommendarticle_model->getsinglerecommendarticle($id);
$this->load->view("json",$data);
}
function getallenquiry()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`lll_enquiry`.`id`";
$elements[0]->sort="1";
$elements[0]->header="Id";
$elements[0]->alias="id";

$elements=array();
$elements[1]=new stdClass();
$elements[1]->field="`lll_enquiry`.`type`";
$elements[1]->sort="1";
$elements[1]->header="Type";
$elements[1]->alias="type";

$elements=array();
$elements[2]=new stdClass();
$elements[2]->field="`lll_enquiry`.`subject`";
$elements[2]->sort="1";
$elements[2]->header="Subject";
$elements[2]->alias="subject";

$elements=array();
$elements[3]=new stdClass();
$elements[3]->field="`lll_enquiry`.`query`";
$elements[3]->sort="1";
$elements[3]->header="Query";
$elements[3]->alias="query";

$elements=array();
$elements[4]=new stdClass();
$elements[4]->field="`lll_enquiry`.`timestamp`";
$elements[4]->sort="1";
$elements[4]->header="Timestamp";
$elements[4]->alias="timestamp";

$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `lll_enquiry`");
$this->load->view("json",$data);
}
public function getsingleenquiry()
{
$id=$this->input->get_post("id");
$data["message"]=$this->enquiry_model->getsingleenquiry($id);
$this->load->view("json",$data);
}
} ?>