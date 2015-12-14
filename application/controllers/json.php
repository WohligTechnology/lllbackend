<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Json extends CI_Controller
{
  function getCategories() {
    $data["message"] = $this->category_model->getAll();
    $this->load->view("json",$data);
  }
  function getCategoryArticles() {
    $id = $this->input->get_post("id");
    $data["message"] = $this->category_model->getOne($id);
    $this->load->view("json",$data);
  }
  function getArticle() {
    $id = $this->input->get_post("id");
    $data["message"] = $this->article_model->getOne($id);
    $this->load->view("json",$data);
  }
  function addSubscriber() {
    $email = $this->input->get_post("email");
    $data["message"] = $this->user_model->addSubscriber($email);
    $this->load->view("json",$data);
  }
}
