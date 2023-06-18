<?php
include_once("includes/functions.php");
verifyAdmin();
include_once("includes/header.php");
include_once("includes/navbar.php");

?>

<style>
.pagination {
    list-style-type: none;
    padding: 10px 0;
    display: inline-flex;
    justify-content: space-between;
    box-sizing: border-box;
}
.pagination li {
    box-sizing: border-box;
    padding-right: 10px;
}
.pagination li a {
    box-sizing: border-box;
    background-color: #e2e6e6;
    padding: 8px;
    text-decoration: none;
    font-size: 12px;
    font-weight: bold;
    color: #616872;
    border-radius: 4px;
}
.pagination li a:hover {
    background-color: #d4dada;
}
.pagination .next a, .pagination .prev a {
    text-transform: uppercase;
    font-size: 12px;
}
.pagination .currentpage a {
    background-color: #518acb;
    color: #fff;
}
.pagination .currentpage a:hover {
    background-color: #518acb;
}

td {
  vertical-align: middle;
}
</style>

<div class="content-body">
    <div class="row match-height">
        <div class="col-xl-12 col-lg-12">
            <div class="card bg-white">
                <div class="card-content">
                    <div class="card-body">
                        <h4 class="card-title">All Quotes.
                        <a href="invoice-create.php?IQ=Q"><span class="la la-plus" data-toggle="tooltip" data-placement="top" title="Create New"></span></a>
                        </h4>
                        <?php
						$total_pages = $mysqli->query('SELECT * FROM invoices WHERE invoice_type = "Quote"')->num_rows;
						$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
						// Number of results to show on each page.
						$num_results_on_page = 10;

						if ($stmt = $mysqli->prepare('SELECT * 
														FROM invoices i
														JOIN customer c
														ON c.invoice_no = i.invoice_no
														WHERE i.invoice_no = c.invoice_no
														AND i.invoice_type = "Quote"
														ORDER BY i.invoice_no DESC LIMIT ?,?')) {
							// Calculate the page to get the results we need from our table.
							$calc_page = ($page - 1) * $num_results_on_page;
							$stmt->bind_param('ii', $calc_page, $num_results_on_page);
							$stmt->execute(); 
							// Get the results...
							$result = $stmt->get_result();?>
									<table class="table table-hover table-bordered" id="data-table" cellspacing="0"><thead><tr>
									<th>Quote</th>
									<th>Customer</th>
									<th>Reference</th>
									<th>Issue Date</th>
									<th>Valid Till</th>
									<th>Amount Due</th>
									<th>Status</th>
									<th>Actions</th>
									</tr></thead><tbody>

									<?php while($row = $result->fetch_assoc()) {

									// Generate encryption key
									include_once("includes/config.php");
									$encryption_key = generateRandomString();
									$pw = openssl_encrypt('DeleteIt', $cipher, $encryption_key, $options, $encryption_iv);
									date_default_timezone_set(TIMEZONE);
									$now = time();
									$expDate = DateTime::createFromFormat('d/m/Y', $row["invoice_due_date"])->format('d-m-Y');
									$date = strtotime($expDate);
									$stat  = $row['status'];
									$status = explode("-", $stat);?>

									<tr>
										<td><?echo $row["invoice_no"]?></td>
										<td><?echo $row["company"]?></td>
										<td><?echo $row["invoice_reference"]?></td>
										<td><?echo $row["invoice_date"]?></td>
										<?if($date < $now & $status[0] != "Converted"){
											print '<td class="text text-danger">' . $row['invoice_due_date'] . '</td>';
										} else {
											print '<td class="text text-success">' . $row['invoice_due_date'] . '</td>';
										}?>
										<td><?echo CURRENCY . $row["total"]?></td>
										

										<?if($row['status'] == "Open" || $row['status'] == "Draft" || $row['status'] == "Sent"){	?>
										<?if($row['status'] == "Sent"){
											print '<td><b><span class="text text-info">' . $row['status'] . '</span></b></td>';
										} else {
											print '<td><b><span class="text text-warning">' . $row['status'] . '</span></b></td>';
										}?>

										<td>
										<a href="invoice-edit.php?inv=<? echo $row["invoice_no"]?>&pre=<? echo $row["invoice_pre"]?>&t=cti" class="btn btn-success btn-sm py-0" style="font-size: 0.8em;">
											<span class="la la-check" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Convert To Invoice"></span></a>

										<a href="invoice-edit.php?inv=<? echo $row["invoice_no"]?>&pre=<? echo $row["invoice_pre"]?>" class="btn btn-primary btn-sm py-0" style="font-size: 0.8em;">
											<span class="la la-edit" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Edit Quote"></span></a> 

										<a href="includes/functions.php?action=sendinqt&pre=<? echo $row["invoice_pre"]?>&no=<? echo $row["invoice_no"]?>&e1=<? echo $row["custom_email"]?>&e2=<? echo $row["custom_email_1"]?>
										&bal=<? echo $row["total"]?>&dd=<? echo $row["invoice_due_date"]?>&ir=<? echo $row["invoice_reference"]?>&co=<? echo $row["company"]?>&p=2"
										class="btn btn-warning btn-sm py-0" style="font-size: 0.8em; email-invoice">
											<span class="la la-envelope" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Email Quote"></span></a> 

										<a href="qtinvdcs/Quote-<? echo $row["invoice_pre"].$row["invoice_no"]?>.pdf" class="btn btn-info btn-sm py-0" style="font-size: 0.8em;" target="_blank">
											<span class="la la-download" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Download Quote"></span></a> 

										<a href="includes/functions.php?action=deliq&p=1&pre=<? echo $row["invoice_pre"]?>&iq=<? echo $encryption_key?>&no=<? echo $row["invoice_no"]?>&en=<?echo $pw?>"
										class="btn btn-danger btn-sm py-0" style="font-size: 0.8em; delete-Quote">
											<span class="la la-trash" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Delete Quote"></span></a></td>
									</tr>
								
									<?	} elseif ($status[0] == "Converted"){?>
										<td><span class="text text-success"><? echo $status[0]?></span></td>

											<td>
												Converted To Invoice <? echo $status[1]?>
											</td>
									</tr>
									<?	} else {

										echo "<p>There are no invoices to display.</p>";

										}

									}

									print '</tr></tbody></table>';?>
								
									<?php if (ceil($total_pages / $num_results_on_page) > 0): ?>
									<ul class="pagination">
										<?php if ($page > 1): ?>
										<li class="prev"><a href="quote-view.php?page=<?php echo $page-1 ?>">Prev</a></li>
										<?php endif; ?>

										<?php if ($page > 3): ?>
										<li class="start"><a href="quote-view.php?page=1">1</a></li>
										<li class="dots">...</li>
										<?php endif; ?>

										<?php if ($page-2 > 0): ?><li class="page"><a href="quote-view.php?page=<?php echo $page-2 ?>"><?php echo $page-2 ?></a></li><?php endif; ?>
										<?php if ($page-1 > 0): ?><li class="page"><a href="quote-view.php?page=<?php echo $page-1 ?>"><?php echo $page-1 ?></a></li><?php endif; ?>

										<li class="currentpage"><a href="quote-view.php?page=<?php echo $page ?>"><?php echo $page ?></a></li>

										<?php if ($page+1 < ceil($total_pages / $num_results_on_page)+1): ?><li class="page">
											<a href="quote-view.php?page=<?php echo $page+1 ?>"><?php echo $page+1 ?></a></li><?php endif; ?>
										<?php if ($page+2 < ceil($total_pages / $num_results_on_page)+1): ?><li class="page">
											<a href="quote-view.php?page=<?php echo $page+2 ?>"><?php echo $page+2 ?></a></li><?php endif; ?>

										<?php if ($page < ceil($total_pages / $num_results_on_page)-2): ?>
										<li class="dots">...</li>
										<li class="end"><a href="quote-view.php?page=<?php echo ceil($total_pages / $num_results_on_page) ?>">
										<?php echo ceil($total_pages / $num_results_on_page) ?></a></li>
										<?php endif; ?>

										<?php if ($page < ceil($total_pages / $num_results_on_page)): ?>
										<li class="next"><a href="quote-view.php?page=<?php echo $page+1 ?>">Next</a></li>
										<?php endif; ?>
									</ul>
									<?php endif; ?>
							<?php $stmt->close();
						} ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/ Statistics -->
<!-- ////////////////////////////////////////////////////////////////////////////-->

<? include ('includes/footer.php')?>