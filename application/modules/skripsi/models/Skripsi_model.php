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


class Skripsi_model extends MY_Model{

  private $table        = "skripsi";
  private $primary_key  = "id_skripsi";
  private $column_order = array('nim', 'mahasiswa', 'judul', 'pembimbing', 'masa_berlaku');
  private $order        = array('skripsi.id_skripsi'=>"DESC");
  private $select       = "skripsi.id_skripsi,skripsi.nim,skripsi.mahasiswa,skripsi.judul,skripsi.pembimbing,skripsi.masa_berlaku";

public function __construct()
	{
		$config = array(
      'table' 	      => $this->table,
			'primary_key' 	=> $this->primary_key,
		 	'select' 	      => $this->select,
      'column_order' 	=> $this->column_order,
      'order' 	      => $this->order,
		 );

		parent::__construct($config);
	}

  private function _get_datatables_query()
    {
      $this->db->select($this->select);
      $this->db->from($this->table);

    if($this->input->post("nim"))
        {
          $this->db->like("skripsi.nim", $this->input->post("nim"));
        }

    if($this->input->post("mahasiswa"))
        {
          $this->db->like("skripsi.mahasiswa", $this->input->post("mahasiswa"));
        }

    if($this->input->post("judul"))
        {
          $this->db->like("skripsi.judul", $this->input->post("judul"));
        }

    if($this->input->post("pembimbing"))
        {
          $this->db->like("skripsi.pembimbing", $this->input->post("pembimbing"));
        }

    if($this->input->post("masa_berlaku"))
        {
          $this->db->like("skripsi.masa_berlaku", date('Y-m-d',strtotime($this->input->post("masa_berlaku"))));
        }

      if(isset($_POST['order'])) // here order processing
       {
           $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
       }
       else if(isset($this->order))
       {
           $order = $this->order;
           $this->db->order_by(key($order), $order[key($order)]);
       }

    }


    public function get_datatables()
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
      $this->db->select($this->select);
      $this->db->from("$this->table");
      return $this->db->count_all_results();
    }



}

/* End of file Skripsi_model.php */
/* Location: ./application/modules/skripsi/models/Skripsi_model.php */
