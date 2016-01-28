<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class article_model extends CI_Model
{
    public function create($category, $title, $image, $author, $timestamp, $desc)
    {
        $data = array('category' => $category,'title' => $title,'image' => $image,'author' => $author,'timestamp' => $timestamp,'desc' => $desc);
        $query = $this->db->insert('lll_article', $data);
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
        $query = $this->db->get('lll_article')->row();

        return $query;
    }
    public function getsinglearticle($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('lll_article')->row();

        return $query;
    }
    public function edit($id, $category, $title,$image, $author, $timestamp, $desc)
    {

        $data = array('category' => $category,'title' => $title,'author' => $author,'timestamp' => $timestamp,'desc' => $desc);
        if($image != "")
          $data['image']=$image;
        $this->db->where('id', $id);
        $query = $this->db->update('lll_article', $data);

        return 1;
    }
    public function delete($id)
    {
        $query = $this->db->query("DELETE FROM `lll_article` WHERE `id`='$id'");

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
    public function getarticledropdown()
    {
        $query = $this->db->query('SELECT * FROM `lll_article`  ORDER BY `id` ASC')->result();
        $return = array(
  '' => 'Select',
  );
        foreach ($query as $row) {
            $return[$row->id] = $row->title;
        }

        return $return;
    }

    public function getOne($id)
    {
        $query = new stdClass();
        $this->db->query("UPDATE `lll_article` SET `views`= `views`+1 WHERE `id` = '$id'");
        $query->category = $this->db->query("SELECT * FROM `lll_article` INNER JOIN `lll_category` ON `lll_category`.`id` =  `lll_article`.`category` WHERE `lll_article`.`id` = '$id'")->row();
        $query->article = $this->db->query("SELECT * FROM `lll_article` WHERE `id` = '$id'" )->row();
        $query->recommended = $this->db->query("SELECT * FROM `lll_recommendarticle` INNER JOIN `lll_article` ON `lll_recommendarticle`.`recommendarticle` = `lll_article`.`id`  WHERE `lll_recommendarticle`.`article` = '$id' ORDER BY `lll_article`.`views` DESC  " )->result();

        $catid = $query->category->id;

        $next = $this->db->query("SELECT `id` FROM `lll_article` WHERE `id` > '$id' AND `category` = '$catid' ORDER BY `id` ASC LIMIT 0,1");
        if($next->num_rows() > 0)
        {
          $query->next = $next->row();
          $query->next = $query->next->id;
        }

        $prev= $this->db->query("SELECT `id` FROM `lll_article` WHERE `id` < '$id' AND `category` = '$catid' ORDER BY `id` DESC LIMIT 0,1");
        if($prev->num_rows() > 0)
        {
          $query->prev = $prev->row();
          $query->prev = $query->prev->id;
        }

        return $query;
    }
}
