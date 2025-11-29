<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
  <div class="d-flex flex-column-fluid" style="margin-top: 15px">
    <div class="container">
      <div class="card card-custom">
        <?php $this->load->view("includes/page_inner_header_card") ?>
        <div class="card-body">
          <table
            class="table table-bordered table-hover table-checkable"
            id="kt_datatable"
            style="margin-top: 13px !important"
          >
            <thead>
              <tr>
                <th style="width: 3%">No</th>
                <th>Üye</th>
                <th>Ödeme Methodu</th>
                <th>Ödenen Tutar</th>
                <th>Açıklama</th>
                <th>Durum</th>
                <th>Tarih</th>
                <th></th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
