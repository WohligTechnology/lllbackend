<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Site extends CI_Controller
{
	public function __construct( )
	{
		parent::__construct();

		$this->is_logged_in();
	}
	function is_logged_in( )
	{
		$is_logged_in = $this->session->userdata( 'logged_in' );
		if ( $is_logged_in !== 'true' || !isset( $is_logged_in ) ) {
			redirect( base_url() . 'index.php/login', 'refresh' );
		} //$is_logged_in !== 'true' || !isset( $is_logged_in )
	}
	function checkaccess($access)
	{
		$accesslevel=$this->session->userdata('accesslevel');
		if(!in_array($accesslevel,$access))
			redirect( base_url() . 'index.php/site?alerterror=You do not have access to this page. ', 'refresh' );
	}
	public function index()
	{
		$access = array("1","2");
		$this->checkaccess($access);
		$data[ 'page' ] = 'dashboard';
		$data[ 'title' ] = 'Welcome';
		$this->load->view( 'template', $data );
	}
	public function createuser()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['accesslevel']=$this->user_model->getaccesslevels();
		$data[ 'status' ] =$this->user_model->getstatusdropdown();
		$data[ 'logintype' ] =$this->user_model->getlogintypedropdown();
//        $data['category']=$this->category_model->getcategorydropdown();
		$data[ 'page' ] = 'createuser';
		$data[ 'title' ] = 'Create User';
		$this->load->view( 'template', $data );
	}
	function createusersubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required|max_length[30]');
		$this->form_validation->set_rules('email','Email','trim|required|valid_email|is_unique[user.email]');
		$this->form_validation->set_rules('password','Password','trim|required|min_length[6]|max_length[30]');
		$this->form_validation->set_rules('confirmpassword','Confirm Password','trim|required|matches[password]');
		$this->form_validation->set_rules('accessslevel','Accessslevel','trim');
		$this->form_validation->set_rules('status','status','trim|');
		$this->form_validation->set_rules('socialid','Socialid','trim');
		$this->form_validation->set_rules('logintype','logintype','trim');
		$this->form_validation->set_rules('json','json','trim');
		if($this->form_validation->run() == FALSE)
		{
			$data['alerterror'] = validation_errors();
			$data['accesslevel']=$this->user_model->getaccesslevels();
            $data[ 'status' ] =$this->user_model->getstatusdropdown();
            $data[ 'logintype' ] =$this->user_model->getlogintypedropdown();
            $data[ 'page' ] = 'createuser';
            $data[ 'title' ] = 'Create User';
            $this->load->view( 'template', $data );
		}
		else
		{
            $name=$this->input->post('name');
            $email=$this->input->post('email');
            $password=$this->input->post('password');
            $accesslevel=$this->input->post('accesslevel');
            $status=$this->input->post('status');
            $socialid=$this->input->post('socialid');
            $logintype=$this->input->post('logintype');
            $json=$this->input->post('json');
//            $category=$this->input->post('category');

            $config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload', $config);
			$filename="image";
			$image="";
			if (  $this->upload->do_upload($filename))
			{
				$uploaddata = $this->upload->data();
				$image=$uploaddata['file_name'];

                $config_r['source_image']   = './uploads/' . $uploaddata['file_name'];
                $config_r['maintain_ratio'] = TRUE;
                $config_t['create_thumb'] = FALSE;///add this
                $config_r['width']   = 800;
                $config_r['height'] = 800;
                $config_r['quality']    = 100;
                //end of configs

                $this->load->library('image_lib', $config_r);
                $this->image_lib->initialize($config_r);
                if(!$this->image_lib->resize())
                {
                    echo "Failed." . $this->image_lib->display_errors();
                    //return false;
                }
                else
                {
                    //print_r($this->image_lib->dest_image);
                    //dest_image
                    $image=$this->image_lib->dest_image;
                    //return false;
                }

			}

			if($this->user_model->create($name,$email,$password,$accesslevel,$status,$socialid,$logintype,$image,$json)==0)
			$data['alerterror']="New user could not be created.";
			else
			$data['alertsuccess']="User created Successfully.";
			$data['redirect']="site/viewusers";
			$this->load->view("redirect",$data);
		}
	}
    function viewusers()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['page']='viewusers';
        $data['base_url'] = site_url("site/viewusersjson");

		$data['title']='View Users';
		$this->load->view('template',$data);
	}
    function viewusersjson()
	{
		$access = array("1");
		$this->checkaccess($access);


        $elements=array();
        $elements[0]=new stdClass();
        $elements[0]->field="`user`.`id`";
        $elements[0]->sort="1";
        $elements[0]->header="ID";
        $elements[0]->alias="id";


        $elements[1]=new stdClass();
        $elements[1]->field="`user`.`name`";
        $elements[1]->sort="1";
        $elements[1]->header="Name";
        $elements[1]->alias="name";

        $elements[2]=new stdClass();
        $elements[2]->field="`user`.`email`";
        $elements[2]->sort="1";
        $elements[2]->header="Email";
        $elements[2]->alias="email";

        $elements[3]=new stdClass();
        $elements[3]->field="`user`.`socialid`";
        $elements[3]->sort="1";
        $elements[3]->header="SocialId";
        $elements[3]->alias="socialid";

        $elements[4]=new stdClass();
        $elements[4]->field="`logintype`.`name`";
        $elements[4]->sort="1";
        $elements[4]->header="Logintype";
        $elements[4]->alias="logintype";

        $elements[5]=new stdClass();
        $elements[5]->field="`user`.`json`";
        $elements[5]->sort="1";
        $elements[5]->header="Json";
        $elements[5]->alias="json";

        $elements[6]=new stdClass();
        $elements[6]->field="`accesslevel`.`name`";
        $elements[6]->sort="1";
        $elements[6]->header="Accesslevel";
        $elements[6]->alias="accesslevelname";

        $elements[7]=new stdClass();
        $elements[7]->field="`statuses`.`name`";
        $elements[7]->sort="1";
        $elements[7]->header="Status";
        $elements[7]->alias="status";


        $search=$this->input->get_post("search");
        $pageno=$this->input->get_post("pageno");
        $orderby=$this->input->get_post("orderby");
        $orderorder=$this->input->get_post("orderorder");
        $maxrow=$this->input->get_post("maxrow");
        if($maxrow=="")
        {
            $maxrow=20;
        }

        if($orderby=="")
        {
            $orderby="id";
            $orderorder="ASC";
        }

        $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `user` LEFT OUTER JOIN `logintype` ON `logintype`.`id`=`user`.`logintype` LEFT OUTER JOIN `accesslevel` ON `accesslevel`.`id`=`user`.`accesslevel` LEFT OUTER JOIN `statuses` ON `statuses`.`id`=`user`.`status`");

		$this->load->view("json",$data);
	}


	function edituser()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'status' ] =$this->user_model->getstatusdropdown();
		$data['accesslevel']=$this->user_model->getaccesslevels();
		$data[ 'logintype' ] =$this->user_model->getlogintypedropdown();
		$data['before']=$this->user_model->beforeedit($this->input->get('id'));
		$data['page']='edituser';
		$data['page2']='block/userblock';
		$data['title']='Edit User';
		$this->load->view('templatewith2',$data);
	}
	function editusersubmit()
	{
		$access = array("1");
		$this->checkaccess($access);

		$this->form_validation->set_rules('name','Name','trim|required|max_length[30]');
		$this->form_validation->set_rules('email','Email','trim|required|valid_email');
		$this->form_validation->set_rules('password','Password','trim|min_length[6]|max_length[30]');
		$this->form_validation->set_rules('confirmpassword','Confirm Password','trim|matches[password]');
		$this->form_validation->set_rules('accessslevel','Accessslevel','trim');
		$this->form_validation->set_rules('status','status','trim|');
		$this->form_validation->set_rules('socialid','Socialid','trim');
		$this->form_validation->set_rules('logintype','logintype','trim');
		$this->form_validation->set_rules('json','json','trim');
		if($this->form_validation->run() == FALSE)
		{
			$data['alerterror'] = validation_errors();
			$data[ 'status' ] =$this->user_model->getstatusdropdown();
			$data['accesslevel']=$this->user_model->getaccesslevels();
            $data[ 'logintype' ] =$this->user_model->getlogintypedropdown();
			$data['before']=$this->user_model->beforeedit($this->input->post('id'));
			$data['page']='edituser';
//			$data['page2']='block/userblock';
			$data['title']='Edit User';
			$this->load->view('template',$data);
		}
		else
		{

            $id=$this->input->get_post('id');
            $name=$this->input->get_post('name');
            $email=$this->input->get_post('email');
            $password=$this->input->get_post('password');
            $accesslevel=$this->input->get_post('accesslevel');
            $status=$this->input->get_post('status');
            $socialid=$this->input->get_post('socialid');
            $logintype=$this->input->get_post('logintype');
            $json=$this->input->get_post('json');
//            $category=$this->input->get_post('category');

            $config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload', $config);
			$filename="image";
			$image="";
			if (  $this->upload->do_upload($filename))
			{
				$uploaddata = $this->upload->data();
				$image=$uploaddata['file_name'];

                $config_r['source_image']   = './uploads/' . $uploaddata['file_name'];
                $config_r['maintain_ratio'] = TRUE;
                $config_t['create_thumb'] = FALSE;///add this
                $config_r['width']   = 800;
                $config_r['height'] = 800;
                $config_r['quality']    = 100;
                //end of configs

                $this->load->library('image_lib', $config_r);
                $this->image_lib->initialize($config_r);
                if(!$this->image_lib->resize())
                {
                    echo "Failed." . $this->image_lib->display_errors();
                    //return false;
                }
                else
                {
                    //print_r($this->image_lib->dest_image);
                    //dest_image
                    $image=$this->image_lib->dest_image;
                    //return false;
                }

			}

            if($image=="")
            {
            $image=$this->user_model->getuserimagebyid($id);
               // print_r($image);
                $image=$image->image;
            }

			if($this->user_model->edit($id,$name,$email,$password,$accesslevel,$status,$socialid,$logintype,$image,$json)==0)
			$data['alerterror']="User Editing was unsuccesful";
			else
			$data['alertsuccess']="User edited Successfully.";

			$data['redirect']="site/viewusers";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);

		}
	}

	function deleteuser()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->user_model->deleteuser($this->input->get('id'));
//		$data['table']=$this->user_model->viewusers();
		$data['alertsuccess']="User Deleted Successfully";
		$data['redirect']="site/viewusers";
			//$data['other']="template=$template";
		$this->load->view("redirect",$data);
	}
	function changeuserstatus()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->user_model->changestatus($this->input->get('id'));
		$data['table']=$this->user_model->viewusers();
		$data['alertsuccess']="Status Changed Successfully";
		$data['redirect']="site/viewusers";
        $data['other']="template=$template";
        $this->load->view("redirect",$data);
	}




public function viewcategory()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="viewcategory";
$data["base_url"]=site_url("site/viewcategoryjson");
$data["title"]="View category";
$this->load->view("template",$data);
}
function viewcategoryjson()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`lll_category`.`id`";
$elements[0]->sort="1";
$elements[0]->header="Id";
$elements[0]->alias="id";
$elements[1]=new stdClass();
$elements[1]->field="`lll_category`.`order`";
$elements[1]->sort="1";
$elements[1]->header="Order";
$elements[1]->alias="order";
$elements[2]=new stdClass();
$elements[2]->field="`lll_category`.`title`";
$elements[2]->sort="1";
$elements[2]->header="Title";
$elements[2]->alias="title";
$elements[3]=new stdClass();
$elements[3]->field="`lll_category`.`banner`";
$elements[3]->sort="1";
$elements[3]->header="Banner";
$elements[3]->alias="banner";
$elements[4]=new stdClass();
$elements[4]->field="`lll_category`.`image`";
$elements[4]->sort="1";
$elements[4]->header="Image";
$elements[4]->alias="image";
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
$maxrow=20;
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `lll_category`");
$this->load->view("json",$data);
}

public function createcategory()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="createcategory";
$data["title"]="Create category";
$this->load->view("template",$data);
}
public function createcategorysubmit()
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("order","Order","trim");
$this->form_validation->set_rules("title","Title","trim");
$this->form_validation->set_rules("banner","Banner","trim");
$this->form_validation->set_rules("image","Image","trim");
$this->form_validation->set_rules("text","Text","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="createcategory";
$data["title"]="Create category";
$this->load->view("template",$data);
}
else
{
$order=$this->input->get_post("order");
$title=$this->input->get_post("title");
// $banner=$this->input->get_post("banner");
// $image=$this->input->get_post("image");

$text=$this->input->get_post("text");
$config['upload_path'] = './uploads/';
$config['allowed_types'] = 'gif|jpg|png';
$this->load->library('upload', $config);
$filename="banner";
$banner="";
if (  $this->upload->do_upload($filename))
{
$uploaddata = $this->upload->data();
$banner=$uploaddata['file_name'];
}
$filename="image";
$image="";
if (  $this->upload->do_upload($filename))
{
$uploaddata = $this->upload->data();
$image=$uploaddata['file_name'];
}


if($this->category_model->create($order,$title,$banner,$image,$text)==0)
$data["alerterror"]="New category could not be created.";
else
$data["alertsuccess"]="category created Successfully.";
$data["redirect"]="site/viewcategory";
$this->load->view("redirect",$data);
}
}
public function editcategory()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="editcategory";
$data["title"]="Edit category";
$data["before"]=$this->category_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
public function editcategorysubmit()
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("id","Id","trim");
$this->form_validation->set_rules("order","Order","trim");
$this->form_validation->set_rules("title","Title","trim");
$this->form_validation->set_rules("banner","Banner","trim");
$this->form_validation->set_rules("image","Image","trim");
$this->form_validation->set_rules("text","Text","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="editcategory";
$data["title"]="Edit category";
$data["before"]=$this->category_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$order=$this->input->get_post("order");
$title=$this->input->get_post("title");
$text=$this->input->get_post("text");

$config['upload_path'] = './uploads/';
		 $config['allowed_types'] = 'gif|jpg|png';
		 $this->load->library('upload', $config);
		 $filename="image";
		 $image="";
		 if (  $this->upload->do_upload($filename))
		 {
			 $uploaddata = $this->upload->data();
			 $image=$uploaddata['file_name'];
		 }
		 $filename="banner";
		 $banner="";
		 if (  $this->upload->do_upload($filename))
		 {
			 $uploaddata = $this->upload->data();
			 $banner=$uploaddata['file_name'];
		 }

		 
if($this->category_model->edit($id,$order,$title,$banner,$image,$text)==0)
$data["alerterror"]="New category could not be Updated.";
else
$data["alertsuccess"]="category Updated Successfully.";
$data["redirect"]="site/viewcategory";
$this->load->view("redirect",$data);
}
}
public function deletecategory()
{
$access=array("1");
$this->checkaccess($access);
$this->category_model->delete($this->input->get("id"));
$data["redirect"]="site/viewcategory";
$this->load->view("redirect",$data);
}
public function viewarticle()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="viewarticle";
$data["base_url"]=site_url("site/viewarticlejson");
$data["title"]="View article";
$this->load->view("template",$data);
}
function viewarticlejson()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`lll_article`.`id`";
$elements[0]->sort="1";
$elements[0]->header="Id";
$elements[0]->alias="id";
$elements[1]=new stdClass();
$elements[1]->field="`lll_article`.`category`";
$elements[1]->sort="1";
$elements[1]->header="Category";
$elements[1]->alias="category";
$elements[2]=new stdClass();
$elements[2]->field="`lll_article`.`title`";
$elements[2]->sort="1";
$elements[2]->header="Title";
$elements[2]->alias="title";
$elements[3]=new stdClass();
$elements[3]->field="`lll_article`.`image`";
$elements[3]->sort="1";
$elements[3]->header="Image";
$elements[3]->alias="image";
$elements[4]=new stdClass();
$elements[4]->field="`lll_article`.`author`";
$elements[4]->sort="1";
$elements[4]->header="Author";
$elements[4]->alias="author";
$elements[5]=new stdClass();
$elements[5]->field="`lll_article`.`timestamp`";
$elements[5]->sort="1";
$elements[5]->header="Timestamp";
$elements[5]->alias="timestamp";
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
$maxrow=20;
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `lll_article`");
$this->load->view("json",$data);
}

public function createarticle()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="createarticle";
$data["title"]="Create article";
$data[ 'category' ] =$this->article_model->getcategorydropdown();
$this->load->view("template",$data);
}
public function createarticlesubmit()
{
$access=array("1");
$this->checkaccess($access);
// $this->form_validation->set_rules("category","Category","trim");
$data[ 'category' ] =$this->article_model->getcategorydropdown();
$this->form_validation->set_rules("title","Title","trim");
$this->form_validation->set_rules("image","Image","trim");
$this->form_validation->set_rules("author","Author","trim");
$this->form_validation->set_rules("timestamp","Timestamp","trim");
$this->form_validation->set_rules("desc","Description","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="createarticle";
$data["title"]="Create article";
$data[ 'category' ] =$this->article_model->getcategorydropdown();
$this->load->view("template",$data);
}
else
{
$category=$this->input->get_post("category");
$title=$this->input->get_post("title");
// $image=$this->input->get_post("image");
$author=$this->input->get_post("author");
$timestamp=$this->input->get_post("timestamp");
$desc=$this->input->get_post("desc");
$config['upload_path'] = './uploads/';
					$config['allowed_types'] = 'gif|jpg|png|jpeg';
					$this->load->library('upload', $config);
					$filename = 'image';
					$image = '';
					if ($this->upload->do_upload($filename)) {
							$uploaddata = $this->upload->data();
							$image = $uploaddata['file_name'];
							$config_r['source_image'] = './uploads/'.$uploaddata['file_name'];
							$config_r['maintain_ratio'] = true;
							$config_t['create_thumb'] = false; ///add this
							$config_r['width'] = 800;
							$config_r['height'] = 800;
							$config_r['quality'] = 100;

							// end of configs

							$this->load->library('image_lib', $config_r);
							$this->image_lib->initialize($config_r);
							if (!$this->image_lib->resize()) {
									$data['alerterror'] = 'Failed.'.$this->image_lib->display_errors();

									// return false;
							} else {

									// print_r($this->image_lib->dest_image);
									// dest_image

									$image = $this->image_lib->dest_image;

									// return false;
							}
if($this->article_model->create($category,$title,$image,$author,$timestamp,$desc)==0)
$data["alerterror"]="New article could not be created.";
else
$data["alertsuccess"]="article created Successfully.";
$data["redirect"]="site/viewarticle";
$this->load->view("redirect",$data);
}
}
}
public function editarticle()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="editarticle";
$data["title"]="Edit article";
$data[ 'category' ] =$this->article_model->getcategorydropdown();
$data["before"]=$this->article_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
public function editarticlesubmit()
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("id","Id","trim");
// $this->form_validation->set_rules("category","Category","trim");
$data[ 'category' ] =$this->article_model->getcategorydropdown();
$this->form_validation->set_rules("title","Title","trim");
$this->form_validation->set_rules("image","Image","trim");
$this->form_validation->set_rules("author","Author","trim");
$this->form_validation->set_rules("timestamp","Timestamp","trim");
$this->form_validation->set_rules("desc","Description","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="editarticle";
$data["title"]="Edit article";
$data["before"]=$this->article_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$category=$this->input->get_post("category");
$title=$this->input->get_post("title");
$image=$this->input->get_post("image");
$author=$this->input->get_post("author");
$timestamp=$this->input->get_post("timestamp");
$desc=$this->input->get_post("desc");
if($this->article_model->edit($id,$category,$title,$image,$author,$timestamp,$desc)==0)
$data["alerterror"]="New article could not be Updated.";
else
$data["alertsuccess"]="article Updated Successfully.";
$data["redirect"]="site/viewarticle";
$this->load->view("redirect",$data);
}
}
public function deletearticle()
{
$access=array("1");
$this->checkaccess($access);
$this->article_model->delete($this->input->get("id"));
$data["redirect"]="site/viewarticle";
$this->load->view("redirect",$data);
}
public function viewrecommendarticle()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="viewrecommendarticle";
$data["base_url"]=site_url("site/viewrecommendarticlejson");
$data["title"]="View recommendarticle";
$this->load->view("template",$data);
}
function viewrecommendarticlejson()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`lll_recommendarticle`.`id`";
$elements[0]->sort="1";
$elements[0]->header="Id";
$elements[0]->alias="id";
$elements[1]=new stdClass();
$elements[1]->field="`lll_recommendarticle`.`article`";
$elements[1]->sort="1";
$elements[1]->header="Article";
$elements[1]->alias="article";
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
$maxrow=20;
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `lll_recommendarticle`");
$this->load->view("json",$data);
}

public function createrecommendarticle()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="createrecommendarticle";
$data["title"]="Create recommendarticle";
$data[ 'article' ] =$this->recommendarticle_model->getarticledropdown();
$data[ 'recommendarticle' ] =$this->recommendarticle_model->getrecommendarticledropdown();
$this->load->view("template",$data);
}
public function createrecommendarticlesubmit()
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("article","Article","trim");
// $this->form_validation->set_rules("recommendarticle","Recommended Article","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="createrecommendarticle";
$data["title"]="Create recommendarticle";
$data[ 'article' ] =$this->recommendarticle_model->getarticledropdown();
$data[ 'recommendarticle' ] =$this->recommendarticle_model->getrecommendarticledropdown();
$this->load->view("template",$data);
}
else
{
$article=$this->input->get_post("article");
$recommendarticle=$this->input->get_post("recommendarticle");
if($this->recommendarticle_model->create($article,$recommendarticle)==0)
$data["alerterror"]="New recommendarticle could not be created.";
else
$data["alertsuccess"]="recommendarticle created Successfully.";
$data["redirect"]="site/viewrecommendarticle";
$this->load->view("redirect",$data);
}
}
public function editrecommendarticle()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="editrecommendarticle";
$data["title"]="Edit recommendarticle";
$data["before"]=$this->recommendarticle_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
public function editrecommendarticlesubmit()
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("id","Id","trim");
$this->form_validation->set_rules("article","Article","trim");
$this->form_validation->set_rules("recommendarticle","Recommended Article","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="editrecommendarticle";
$data["title"]="Edit recommendarticle";
$data["before"]=$this->recommendarticle_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$article=$this->input->get_post("article");
$recommendarticle=$this->input->get_post("recommendarticle");
if($this->recommendarticle_model->edit($id,$article,$recommendarticle)==0)
$data["alerterror"]="New recommendarticle could not be Updated.";
else
$data["alertsuccess"]="recommendarticle Updated Successfully.";
$data["redirect"]="site/viewrecommendarticle";
$this->load->view("redirect",$data);
}
}
public function deleterecommendarticle()
{
$access=array("1");
$this->checkaccess($access);
$this->recommendarticle_model->delete($this->input->get("id"));
$data["redirect"]="site/viewrecommendarticle";
$this->load->view("redirect",$data);
}
public function viewenquiry()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="viewenquiry";
$data["base_url"]=site_url("site/viewenquiryjson");
$data["title"]="View enquiry";
$this->load->view("template",$data);
}
function viewenquiryjson()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`lll_enquiry`.`id`";
$elements[0]->sort="1";
$elements[0]->header="Id";
$elements[0]->alias="id";
$elements[1]=new stdClass();
$elements[1]->field="`lll_enquiry`.`type`";
$elements[1]->sort="1";
$elements[1]->header="Type";
$elements[1]->alias="type";
$elements[2]=new stdClass();
$elements[2]->field="`lll_enquiry`.`subject`";
$elements[2]->sort="1";
$elements[2]->header="Subject";
$elements[2]->alias="subject";
$elements[3]=new stdClass();
$elements[3]->field="`lll_enquiry`.`query`";
$elements[3]->sort="1";
$elements[3]->header="Query";
$elements[3]->alias="query";
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
$maxrow=20;
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `lll_enquiry`");
$this->load->view("json",$data);
}

public function createenquiry()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="createenquiry";
$data["title"]="Create enquiry";
$this->load->view("template",$data);
}
public function createenquirysubmit()
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("type","Type","trim");
$this->form_validation->set_rules("subject","Subject","trim");
$this->form_validation->set_rules("query","Query","trim");
$this->form_validation->set_rules("timestamp","Timestamp","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="createenquiry";
$data["title"]="Create enquiry";
$this->load->view("template",$data);
}
else
{
$type=$this->input->get_post("type");
$subject=$this->input->get_post("subject");
$query=$this->input->get_post("query");
$timestamp=$this->input->get_post("timestamp");
if($this->enquiry_model->create($type,$subject,$query,$timestamp)==0)
$data["alerterror"]="New enquiry could not be created.";
else
$data["alertsuccess"]="enquiry created Successfully.";
$data["redirect"]="site/viewenquiry";
$this->load->view("redirect",$data);
}
}
public function editenquiry()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="editenquiry";
$data["title"]="Edit enquiry";
$data["before"]=$this->enquiry_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
public function editenquirysubmit()
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("id","Id","trim");
$this->form_validation->set_rules("type","Type","trim");
$this->form_validation->set_rules("subject","Subject","trim");
$this->form_validation->set_rules("query","Query","trim");
$this->form_validation->set_rules("timestamp","Timestamp","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="editenquiry";
$data["title"]="Edit enquiry";
$data["before"]=$this->enquiry_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$type=$this->input->get_post("type");
$subject=$this->input->get_post("subject");
$query=$this->input->get_post("query");
$timestamp=$this->input->get_post("timestamp");
if($this->enquiry_model->edit($id,$type,$subject,$query,$timestamp)==0)
$data["alerterror"]="New enquiry could not be Updated.";
else
$data["alertsuccess"]="enquiry Updated Successfully.";
$data["redirect"]="site/viewenquiry";
$this->load->view("redirect",$data);
}
}
public function deleteenquiry()
{
$access=array("1");
$this->checkaccess($access);
$this->enquiry_model->delete($this->input->get("id"));
$data["redirect"]="site/viewenquiry";
$this->load->view("redirect",$data);
}

}
?>
