<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class category_model extends CI_Model
{
    public function create($order, $title, $banner, $image, $text)
    {
        $data = array('order' => $order,'title' => $title,'banner' => $banner,'image' => $image,'text' => $text);
        $query = $this->db->insert('lll_category', $data);
        $id = $this->db->insert_id();
        if (!$query) {
            return  0;
        } else {
            return  $id;
        }
    }
    public function beforeedit($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('lll_category')->row();

        return $query;
    }
    public function getsinglecategory($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('lll_category')->row();

        return $query;
    }
    public function edit($id, $order, $title, $banner, $image, $text)
    {
        $data = array('order' => $order,'title' => $title,'text' => $text);
        if($banner != "")
          $data['banner']=$banner;
        if($image != "")
          $data['image']=$image;
        $this->db->where('id', $id);
        $query = $this->db->update('lll_category', $data);

        return 1;
    }
    public function delete($id)
    {
        $query = $this->db->query("DELETE FROM `lll_category` WHERE `id`='$id'");

        return $query;
    }
    public function getAll()
    {
        $query = $this->db->query("SELECT * FROM `lll_category`" )->result();

        return $query;
    }
    public function getOne($id)
    {
        $query = new stdClass();
        $query->category = $this->db->query("SELECT * FROM `lll_category` WHERE `id` = '$id' " )->row();
        $query->article = $this->db->query("SELECT * FROM `lll_article` WHERE `category` = '$id' ORDER BY `lll_article`.`timestamp` DESC " )->result();
        $query->mostViewed = $this->db->query("SELECT * FROM `lll_article` WHERE `category` = '$id' ORDER BY `lll_article`.`views` DESC  " )->result();
        return $query;
    }
}
