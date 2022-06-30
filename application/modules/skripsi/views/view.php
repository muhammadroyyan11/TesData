<div class="row">
  <div class="col-md-12 col-xl-10 mx-auto animated fadeIn delay-2s">
    <div class="card-header bg-primary text-white">
      <?=ucwords($title_module)?>
    </div>
    <div class="card">
      <div class="card-body">
        <table class="table table-bordered table-striped">
        <tr>
          <td>Nim</td>
          <td><?=$nim?></td>
        </tr>
        <tr>
          <td>Mahasiswa</td>
          <td><?=$mahasiswa?></td>
        </tr>
        <tr>
          <td>Judul</td>
          <td><?=$judul?></td>
        </tr>
        <tr>
          <td>Pembimbing</td>
          <td><?=$pembimbing?></td>
        </tr>
      <tr>
        <td>Masa berlaku</td>
        <td><?=$masa_berlaku != "" ? date('d-m-Y',strtotime($masa_berlaku)):""?></td>
      </tr>
        </table>

        <a href="<?=url($this->uri->segment(2))?>" class="btn btn-sm btn-danger mt-3"><?=cclang("back")?></a>
      </div>
    </div>
  </div>
</div>
