<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*| --------------------------------------------------------------------------*/
/*| dev : royyan  */
/*| version : V.0.0.2 */
/*| facebook :  */
/*| fanspage :  */
/*| instagram :  */
/*| youtube :  */
/*| --------------------------------------------------------------------------*/
/*| Generate By M-CRUD Generator 30/06/2022 14:36*/
/*| Please DO NOT modify this information*/


class Skripsi extends Backend{

private $title = "Skripsi";


public function __construct()
{
  $config = array(
    'title' => $this->title,
   );
  parent::__construct($config);
  $this->load->model("Skripsi_model","model");
}

function index()
{
  $this->is_allowed('skripsi_list');
  $this->template->set_title($this->title);
  $this->template->view("index");
}

function json()
{
  if ($this->input->is_ajax_request()) {
    if (!is_allowed('skripsi_list')) {
      show_error("Access Permission", 403,'403::Access Not Permission');
      exit();
    }

    $list = $this->model->get_datatables();
    $data = array();
    foreach ($list as $row) {
        $rows = array();
                $rows[] = $row->nim;
                $rows[] = $row->mahasiswa;
                $rows[] = $row->judul;
                $rows[] = $row->pembimbing;
                $rows[] = date("d-m-Y",  strtotime($row->masa_berlaku));
        
        $rows[] = '
                  <div class="btn-group" role="group" aria-label="Basic example">
                      <a href="'.url("skripsi/detail/".enc_url($row->id_skripsi)).'" id="detail" class="btn btn-primary" title="'.cclang("detail").'">
                        <i class="mdi mdi-file"></i>
                      </a>
                      <a href="'.url("skripsi/update/".enc_url($row->id_skripsi)).'" id="update" class="btn btn-warning" title="'.cclang("update").'">
                        <i class="ti-pencil"></i>
                      </a>
                      <a href="'.url("skripsi/delete/".enc_url($row->id_skripsi)).'" id="delete" class="btn btn-danger" title="'.cclang("delete").'">
                        <i class="ti-trash"></i>
                      </a>
                    </div>
                 ';

        $data[] = $rows;
    }

    $output = array(
                    "draw" => $_POST['draw'],
                    "recordsTotal" => $this->model->count_all(),
                    "recordsFiltered" => $this->model->count_filtered(),
                    "data" => $data,
            );
    //output to json format
    return $this->response($output);
  }
}

function filter()
{
  if(!is_allowed('skripsi_filter'))
  {
    echo "access not permission";
  }else{
    $this->template->view("filter",[],false);
  }
}

function detail($id)
{
  $this->is_allowed('skripsi_detail');
    if ($row = $this->model->find(dec_url($id))) {
    $this->template->set_title("Detail ".$this->title);
    $data = array(
          "nim" => $row->nim,
          "mahasiswa" => $row->mahasiswa,
          "judul" => $row->judul,
          "pembimbing" => $row->pembimbing,
          "masa_berlaku" => $row->masa_berlaku,
    );
    $this->template->view("view",$data);
  }else{
    $this->error404();
  }
}

function add()
{
  $this->is_allowed('skripsi_add');
  $this->template->set_title(cclang("add")." ".$this->title);
  $data = array('action' => url("skripsi/add_action"),
                  'nim' => set_value("nim"),
                  'mahasiswa' => set_value("mahasiswa"),
                  'judul' => set_value("judul"),
                  'pembimbing' => set_value("pembimbing"),
                  'masa_berlaku' => set_value("masa_berlaku"),
                  );
  $this->template->view("add",$data);
}

function add_action()
{
  if($this->input->is_ajax_request()){
    if (!is_allowed('skripsi_add')) {
      show_error("Access Permission", 403,'403::Access Not Permission');
      exit();
    }

    $json = array('success' => false);
    $this->form_validation->set_rules("nim","* Nim","trim|xss_clean|required|numeric");
    $this->form_validation->set_rules("mahasiswa","* Mahasiswa","trim|xss_clean|required");
    $this->form_validation->set_rules("judul","* Judul","trim|xss_clean|required");
    $this->form_validation->set_rules("pembimbing","* Pembimbing","trim|xss_clean|required");
    $this->form_validation->set_rules("masa_berlaku","* Masa berlaku","trim|xss_clean|required");
    $this->form_validation->set_error_delimiters('<i class="error text-danger" style="font-size:11px">','</i>');

    if ($this->form_validation->run()) {
      $save_data['nim'] = $this->input->post('nim',true);
      $save_data['mahasiswa'] = $this->input->post('mahasiswa',true);
      $save_data['judul'] = $this->input->post('judul',true);
      $save_data['pembimbing'] = $this->input->post('pembimbing',true);
      $save_data['masa_berlaku'] = date("Y-m-d",  strtotime($this->input->post('masa_berlaku', true)));

      $this->model->insert($save_data);

      set_message("success",cclang("notif_save"));
      $json['redirect'] = url("skripsi");
      $json['success'] = true;
    }else {
      foreach ($_POST as $key => $value) {
        $json['alert'][$key] = form_error($key);
      }
    }

    $this->response($json);
  }
}

function update($id)
{
  $this->is_allowed('skripsi_update');
  if ($row = $this->model->find(dec_url($id))) {
    $this->template->set_title(cclang("update")." ".$this->title);
    $data = array('action' => url("skripsi/update_action/$id"),
                  'nim' => set_value("nim", $row->nim),
                  'mahasiswa' => set_value("mahasiswa", $row->mahasiswa),
                  'judul' => set_value("judul", $row->judul),
                  'pembimbing' => set_value("pembimbing", $row->pembimbing),
                  'masa_berlaku' => $row->masa_berlaku == "" ? "":date("Y-m-d",  strtotime($row->masa_berlaku)),
                  );
    $this->template->view("update",$data);
  }else {
    $this->error404();
  }
}

function update_action($id)
{
  if($this->input->is_ajax_request()){
    if (!is_allowed('skripsi_update')) {
      show_error("Access Permission", 403,'403::Access Not Permission');
      exit();
    }

    $json = array('success' => false);
    $this->form_validation->set_rules("nim","* Nim","trim|xss_clean|required|numeric");
    $this->form_validation->set_rules("mahasiswa","* Mahasiswa","trim|xss_clean|required");
    $this->form_validation->set_rules("judul","* Judul","trim|xss_clean|required");
    $this->form_validation->set_rules("pembimbing","* Pembimbing","trim|xss_clean|required");
    $this->form_validation->set_rules("masa_berlaku","* Masa berlaku","trim|xss_clean|required");
    $this->form_validation->set_error_delimiters('<i class="error text-danger" style="font-size:11px">','</i>');

    if ($this->form_validation->run()) {
      $save_data['nim'] = $this->input->post('nim',true);
      $save_data['mahasiswa'] = $this->input->post('mahasiswa',true);
      $save_data['judul'] = $this->input->post('judul',true);
      $save_data['pembimbing'] = $this->input->post('pembimbing',true);
      $save_data['masa_berlaku'] = date("Y-m-d",  strtotime($this->input->post('masa_berlaku', true)));

      $save = $this->model->change(dec_url($id), $save_data);

      set_message("success",cclang("notif_update"));

      $json['redirect'] = url("skripsi");
      $json['success'] = true;
    }else {
      foreach ($_POST as $key => $value) {
        $json['alert'][$key] = form_error($key);
      }
    }

    $this->response($json);
  }
}

function delete($id)
{
  if ($this->input->is_ajax_request()) {
    if (!is_allowed('skripsi_delete')) {
      return $this->response([
        'type_msg' => "error",
        'msg' => "do not have permission to access"
      ]);
    }

      $this->model->remove(dec_url($id));
      $json['type_msg'] = "success";
      $json['msg'] = cclang("notif_delete");


    return $this->response($json);
  }
}


}

/* End of file Skripsi.php */
/* Location: ./application/modules/skripsi/controllers/backend/Skripsi.php */
