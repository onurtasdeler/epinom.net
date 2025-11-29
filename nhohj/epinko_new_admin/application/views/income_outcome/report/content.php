<form id="guncelleForm" onsubmit="return false" enctype="multipart/form-data">
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="row" style="row-gap:10px;">
                    <div class="col-lg-12">
                        <div class="card card-custom">
                            <div class="card-header align-items-center">
                                <div class="card-title">
                                <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/General/Clipboard.svg--><svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                                            viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24"/>
                                                <path d="M8,3 L8,3.5 C8,4.32842712 8.67157288,5 9.5,5 L14.5,5 C15.3284271,5 16,4.32842712 16,3.5 L16,3 L18,3 C19.1045695,3 20,3.8954305 20,5 L20,21 C20,22.1045695 19.1045695,23 18,23 L6,23 C4.8954305,23 4,22.1045695 4,21 L4,5 C4,3.8954305 4.8954305,3 6,3 L8,3 Z"
                                                      fill="#000000" opacity="0.3"/>
                                                <path d="M11,2 C11,1.44771525 11.4477153,1 12,1 C12.5522847,1 13,1.44771525 13,2 L14.5,2 C14.7761424,2 15,2.22385763 15,2.5 L15,3.5 C15,3.77614237 14.7761424,4 14.5,4 L9.5,4 C9.22385763,4 9,3.77614237 9,3.5 L9,2.5 C9,2.22385763 9.22385763,2 9.5,2 L11,2 Z"
                                                      fill="#000000"/>
                                                <rect fill="#000000" opacity="0.3" x="7" y="10" width="5" height="2"
                                                      rx="1"/>
                                                <rect fill="#000000" opacity="0.3" x="7" y="14" width="9" height="2"
                                                      rx="1"/>
                                            </g>
                                        </svg><!--end::Svg Icon--></span> &nbsp;
                                    <h3 class="card-label">Gelir Gider Raporu</h3>
                                </div>
                                <input type="text" class="form-control ml-auto w-auto" id="dateRange" value="<?= date("01.01.Y") ?> - <?= date("31.12.Y"); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="d-flex flex-wrap justify-content-center" style="gap:5px">
                            <button class="btn btn-sm btn-primary" onclick="$('#dateRange').data('daterangepicker').setStartDate('<?= date('01.01.Y') ?>');$('#dateRange').data('daterangepicker').setEndDate('<?= date('d.01.Y',strtotime('last day of this month',strtotime('2024-01-01'))) ?>');triggerReport()">Ocak</button>
                            <button class="btn btn-sm btn-primary" onclick="$('#dateRange').data('daterangepicker').setStartDate('<?= date('01.02.Y') ?>');$('#dateRange').data('daterangepicker').setEndDate('<?= date('d.02.Y',strtotime('last day of this month',strtotime('2024-02-01'))) ?>');triggerReport()">Şubat</button>
                            <button class="btn btn-sm btn-primary" onclick="$('#dateRange').data('daterangepicker').setStartDate('<?= date('01.03.Y') ?>');$('#dateRange').data('daterangepicker').setEndDate('<?= date('d.03.Y',strtotime('last day of this month',strtotime('2024-03-01'))) ?>');triggerReport()">Mart</button>
                            <button class="btn btn-sm btn-primary" onclick="$('#dateRange').data('daterangepicker').setStartDate('<?= date('01.04.Y') ?>');$('#dateRange').data('daterangepicker').setEndDate('<?= date('d.04.Y',strtotime('last day of this month',strtotime('2024-04-01'))) ?>');triggerReport()">Nisan</button>
                            <button class="btn btn-sm btn-primary" onclick="$('#dateRange').data('daterangepicker').setStartDate('<?= date('01.05.Y') ?>');$('#dateRange').data('daterangepicker').setEndDate('<?= date('d.05.Y',strtotime('last day of this month',strtotime('2024-05-01'))) ?>');triggerReport()">Mayıs</button>
                            <button class="btn btn-sm btn-primary" onclick="$('#dateRange').data('daterangepicker').setStartDate('<?= date('01.06.Y') ?>');$('#dateRange').data('daterangepicker').setEndDate('<?= date('d.06.Y',strtotime('last day of this month',strtotime('2024-06-01'))) ?>');triggerReport()">Haziran</button>
                            <button class="btn btn-sm btn-primary" onclick="$('#dateRange').data('daterangepicker').setStartDate('<?= date('01.07.Y') ?>');$('#dateRange').data('daterangepicker').setEndDate('<?= date('d.07.Y',strtotime('last day of this month',strtotime('2024-07-01'))) ?>');triggerReport()">Temmuz</button>
                            <button class="btn btn-sm btn-primary" onclick="$('#dateRange').data('daterangepicker').setStartDate('<?= date('01.08.Y') ?>');$('#dateRange').data('daterangepicker').setEndDate('<?= date('d.08.Y',strtotime('last day of this month',strtotime('2024-08-01'))) ?>');triggerReport()">Ağustos</button>
                            <button class="btn btn-sm btn-primary" onclick="$('#dateRange').data('daterangepicker').setStartDate('<?= date('01.09.Y') ?>');$('#dateRange').data('daterangepicker').setEndDate('<?= date('d.09.Y',strtotime('last day of this month',strtotime('2024-09-01'))) ?>');triggerReport()">Eylül</button>
                            <button class="btn btn-sm btn-primary" onclick="$('#dateRange').data('daterangepicker').setStartDate('<?= date('01.10.Y') ?>');$('#dateRange').data('daterangepicker').setEndDate('<?= date('d.10.Y',strtotime('last day of this month',strtotime('2024-10-01'))) ?>');triggerReport()">Ekim</button>
                            <button class="btn btn-sm btn-primary" onclick="$('#dateRange').data('daterangepicker').setStartDate('<?= date('01.11.Y') ?>');$('#dateRange').data('daterangepicker').setEndDate('<?= date('d.11.Y',strtotime('last day of this month',strtotime('2024-11-01'))) ?>');triggerReport()">Kasım</button>
                            <button class="btn btn-sm btn-primary" onclick="$('#dateRange').data('daterangepicker').setStartDate('<?= date('01.12.Y') ?>');$('#dateRange').data('daterangepicker').setEndDate('<?= date('d.12.Y',strtotime('last day of this month',strtotime('2024-12-01'))) ?>');triggerReport()">Aralık</button>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="card card-custom">
                            <div class="card-header">
                                <div class="card-title">
                                    Manuel Gider
                                </div>
                            </div>
                            <div class="card-body">
                                <h2 id="manuelOutcome">0.00 <?= getcur(); ?></h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="card card-custom">
                            <div class="card-header">
                                <div class="card-title">
                                    Manuel Gelir
                                </div>
                            </div>
                            <div class="card-body">
                                <h2 id="manuelIncome">0.00 <?= getcur(); ?></h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="card card-custom">
                            <div class="card-header">
                                <div class="card-title">
                                    Manuel Kazanç
                                </div>
                            </div>
                            <div class="card-body">
                                <h2 id="manuelEarning">0.00 <?= getcur(); ?></h2>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12 col-md-4">
                        <div class="card card-custom">
                            <div class="card-header">
                                <div class="card-title">
                                    Epin Gider
                                </div>
                            </div>
                            <div class="card-body">
                                <h2 id="epinOutcome">0.00 <?= getcur(); ?></h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="card card-custom">
                            <div class="card-header">
                                <div class="card-title">
                                    Epin Gelir
                                </div>
                            </div>
                            <div class="card-body">
                                <h2 id="epinIncome">0.00 <?= getcur(); ?></h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="card card-custom">
                            <div class="card-header">
                                <div class="card-title">
                                    Epin Kazanç
                                </div>
                            </div>
                            <div class="card-body">
                                <h2 id="epinEarning">0.00 <?= getcur(); ?></h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="card card-custom">
                            <div class="card-header">
                                <div class="card-title">
                                    İlan Komisyon Gider
                                </div>
                            </div>
                            <div class="card-body">
                                <h2 id="advertOutcome">0.00 <?= getcur(); ?></h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="card card-custom">
                            <div class="card-header">
                                <div class="card-title">
                                    İlan Komisyon Gelir
                                </div>
                            </div>
                            <div class="card-body">
                                <h2 id="advertIncome">0.00 <?= getcur(); ?></h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="card card-custom">
                            <div class="card-header">
                                <div class="card-title">
                                    İlan Komisyon Kazanç
                                </div>
                            </div>
                            <div class="card-body">
                                <h2 id="advertEarning">0.00 <?= getcur(); ?></h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="card card-custom">
                            <div class="card-header">
                                <div class="card-title">
                                    Bayi Komisyon Gider
                                </div>
                            </div>
                            <div class="card-body">
                                <h2 id="bayiOutcome">0.00 <?= getcur(); ?></h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="card card-custom">
                            <div class="card-header">
                                <div class="card-title">
                                    Bayi Komisyon Gelir
                                </div>
                            </div>
                            <div class="card-body">
                                <h2 id="bayiIncome">0.00 <?= getcur(); ?></h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="card card-custom">
                            <div class="card-header">
                                <div class="card-title">
                                    Bayi Komisyon Kazanç
                                </div>
                            </div>
                            <div class="card-body">
                                <h2 id="bayiEarning">0.00 <?= getcur(); ?></h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card card-custom">
                            <div class="card-header">
                                <div class="card-title">
                                    Toplam Kazanç
                                </div>
                            </div>
                            <div class="card-body">
                                <h2 id="totalEarning">0.00 <?= getcur(); ?></h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
    </div>
</form>