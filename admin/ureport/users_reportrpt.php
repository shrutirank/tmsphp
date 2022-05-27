<?php

namespace PHPReportMaker12\project3;

// Session
if (session_status() !== PHP_SESSION_ACTIVE)
	session_start(); // Init session data

// Output buffering
ob_start();

// Autoload
include_once "rautoload.php";
?>
<?php

// Create page object
if (!isset($users_report_rpt))
	$users_report_rpt = new users_report_rpt();
if (isset($Page))
	$OldPage = $Page;
$Page = &$users_report_rpt;

// Run the page
$Page->run();

// Setup login status
SetClientVar("login", LoginStatus());
if (!$DashboardReport)
	WriteHeader(FALSE);

// Global Page Rendering event (in rusrfn*.php)
Page_Rendering();

// Page Rendering event
$Page->Page_Render();
?>
<?php if (!$DashboardReport) { ?>
	<?php include_once "rheader.php" ?>
<?php } ?>
<?php if ($Page->Export == "" || $Page->Export == "print") { ?>
	<script>
		currentPageID = ew.PAGE_ID = "rpt"; // Page ID
	</script>
<?php } ?>
<?php if ($Page->Export == "" && !$Page->DrillDown && !$DashboardReport) { ?>
<?php } ?>
<?php if ($Page->Export == "" && !$Page->DrillDown && !$DashboardReport) { ?>
	<script>
		// Write your client script here, no need to add script tags.
	</script>
<?php } ?>
<a id="top"></a>
<?php if ($Page->Export == "" && !$DashboardReport) { ?>
	<!-- Content Container -->
	<div id="ew-container" class="container-fluid ew-container">
	<?php } ?>
	<?php if (ReportParam("showfilter") === TRUE) { ?>
		<?php $Page->showFilterList(TRUE) ?>
	<?php } ?>
	<div class="btn-toolbar ew-toolbar">
		<?php
		if (!$Page->DrillDownInPanel) {
			$Page->ExportOptions->render("body");
			$Page->SearchOptions->render("body");
			$Page->FilterOptions->render("body");
			$Page->GenerateOptions->render("body");
		}
		?>
	</div>
	<?php $Page->showPageHeader(); ?>
	<?php $Page->showMessage(); ?>
	<?php if ($Page->Export == "" && !$DashboardReport) { ?>
		<div class="row">
		<?php } ?>
		<?php if ($Page->Export == "" && !$DashboardReport) { ?>
			<!-- Center Container - Report -->
			<div id="ew-center" class="<?php echo $users_report_rpt->CenterContentClass ?>">
			<?php } ?>
			<!-- Summary Report begins -->
			<div id="report_summary">
				<?php

				// Set the last group to display if not export all
				if ($Page->ExportAll && $Page->Export <> "") {
					$Page->StopGroup = $Page->TotalGroups;
				} else {
					$Page->StopGroup = $Page->StartGroup + $Page->DisplayGroups - 1;
				}

				// Stop group <= total number of groups
				if (intval($Page->StopGroup) > intval($Page->TotalGroups))
					$Page->StopGroup = $Page->TotalGroups;
				$Page->RecordCount = 0;
				$Page->RecordIndex = 0;

				// Get first row
				if ($Page->TotalGroups > 0) {
					$Page->loadRowValues(TRUE);
					$Page->GroupCount = 1;
				}
				$Page->GroupIndexes = InitArray(2, -1);
				$Page->GroupIndexes[0] = -1;
				$Page->GroupIndexes[1] = $Page->StopGroup - $Page->StartGroup + 1;
				while ($Page->Recordset && !$Page->Recordset->EOF && $Page->GroupCount <= $Page->DisplayGroups || $Page->ShowHeader) {

					// Show dummy header for custom template
					// Show header

					if ($Page->ShowHeader) {
				?>
						<?php if ($Page->Export == "word" || $Page->Export == "excel") { ?>
							<div class="ew-grid" <?php echo $Page->ReportTableStyle ?>>
							<?php } else { ?>
								<div class="card ew-card ew-grid" <?php echo $Page->ReportTableStyle ?>>
								<?php } ?>
								<!-- Report grid (begin) -->
								<div id="gmp_users_report" class="<?php if (IsResponsiveLayout()) {
																		echo "table-responsive ";
																	} ?>ew-grid-middle-panel">
									<table class="<?php echo $Page->ReportTableClass ?>">
										<thead>
											<!-- Table header -->
											<tr class="ew-table-header">
												<?php if ($Page->FullName->Visible) {
													echo '
													<div style="margin-top:-2rem;"></div>
													<img src="logo.ico" alt="Shyaam" style="height: 100px;width: 115px;margin-bottom: -7rem;margin-left: 3rem;margin-top: 3rem;">
													<div style="margin-left: 15rem;">
													<p>
													<h2>Shyaam Holiday</h2>
													
													D2069, Central Bazar, Varachha, Surat, Gujarat. <br>
													Email: shyaamholiday@gmail.com | Mo: +91 97266 26668
													</p>
													<p style="margin-left: 40rem;margin-right: 5px;margin-top: -2rem;">Date: ' . date('d-m-Y') . '</p>
													</div>
													<hr class="bg-dark">
													<center><h2><u>User Reports</u></h2></center>
													
													';  ?>
													<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
														<td data-field="FullName">
															<div class="users_report_FullName"><span class="ew-table-header-caption"><?php echo $Page->FullName->caption() ?></span></div>
														</td>
													<?php } else { ?>
														<td data-field="FullName">
															<?php if ($Page->sortUrl($Page->FullName) == "") { ?>
																<div class="ew-table-header-btn users_report_FullName">
																	<span class="ew-table-header-caption"><?php echo $Page->FullName->caption() ?></span>
																</div>
															<?php } else { ?>
																<div class="ew-table-header-btn ew-pointer users_report_FullName" onclick="ew.sort(event,'<?php echo $Page->sortUrl($Page->FullName) ?>',0);">
																	<span class="ew-table-header-caption"><?php echo $Page->FullName->caption() ?></span>
																	<span class="ew-table-header-sort"><?php if ($Page->FullName->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($Page->FullName->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span>
																</div>
															<?php } ?>
														</td>
													<?php } ?>
												<?php } ?>
												<?php if ($Page->MobileNumber->Visible) { ?>
													<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
														<td data-field="MobileNumber">
															<div class="users_report_MobileNumber"><span class="ew-table-header-caption"><?php echo $Page->MobileNumber->caption() ?></span></div>
														</td>
													<?php } else { ?>
														<td data-field="MobileNumber">
															<?php if ($Page->sortUrl($Page->MobileNumber) == "") { ?>
																<div class="ew-table-header-btn users_report_MobileNumber">
																	<span class="ew-table-header-caption"><?php echo $Page->MobileNumber->caption() ?></span>
																</div>
															<?php } else { ?>
																<div class="ew-table-header-btn ew-pointer users_report_MobileNumber" onclick="ew.sort(event,'<?php echo $Page->sortUrl($Page->MobileNumber) ?>',0);">
																	<span class="ew-table-header-caption"><?php echo $Page->MobileNumber->caption() ?></span>
																	<span class="ew-table-header-sort"><?php if ($Page->MobileNumber->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($Page->MobileNumber->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span>
																</div>
															<?php } ?>
														</td>
													<?php } ?>
												<?php } ?>
												<?php if ($Page->EmailId->Visible) { ?>
													<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
														<td data-field="EmailId">
															<div class="users_report_EmailId"><span class="ew-table-header-caption"><?php echo $Page->EmailId->caption() ?></span></div>
														</td>
													<?php } else { ?>
														<td data-field="EmailId">
															<?php if ($Page->sortUrl($Page->EmailId) == "") { ?>
																<div class="ew-table-header-btn users_report_EmailId">
																	<span class="ew-table-header-caption"><?php echo $Page->EmailId->caption() ?></span>
																</div>
															<?php } else { ?>
																<div class="ew-table-header-btn ew-pointer users_report_EmailId" onclick="ew.sort(event,'<?php echo $Page->sortUrl($Page->EmailId) ?>',0);">
																	<span class="ew-table-header-caption"><?php echo $Page->EmailId->caption() ?></span>
																	<span class="ew-table-header-sort"><?php if ($Page->EmailId->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($Page->EmailId->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span>
																</div>
															<?php } ?>
														</td>
													<?php } ?>
												<?php } ?>
												<?php if ($Page->RegDate->Visible) { ?>
													<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
														<td data-field="RegDate">
															<div class="users_report_RegDate"><span class="ew-table-header-caption"><?php echo $Page->RegDate->caption() ?></span></div>
														</td>
													<?php } else { ?>
														<td data-field="RegDate">
															<?php if ($Page->sortUrl($Page->RegDate) == "") { ?>
																<div class="ew-table-header-btn users_report_RegDate">
																	<span class="ew-table-header-caption"><?php echo $Page->RegDate->caption() ?></span>
																</div>
															<?php } else { ?>
																<div class="ew-table-header-btn ew-pointer users_report_RegDate" onclick="ew.sort(event,'<?php echo $Page->sortUrl($Page->RegDate) ?>',0);">
																	<span class="ew-table-header-caption"><?php echo $Page->RegDate->caption() ?></span>
																	<span class="ew-table-header-sort"><?php if ($Page->RegDate->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($Page->RegDate->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span>
																</div>
															<?php } ?>
														</td>
													<?php } ?>
												<?php } ?>
												<?php if ($Page->UpdationDate->Visible) { ?>
													<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
														<td data-field="UpdationDate">
															<div class="users_report_UpdationDate"><span class="ew-table-header-caption"><?php echo $Page->UpdationDate->caption() ?></span></div>
														</td>
													<?php } else { ?>
														<td data-field="UpdationDate">
															<?php if ($Page->sortUrl($Page->UpdationDate) == "") { ?>
																<div class="ew-table-header-btn users_report_UpdationDate">
																	<span class="ew-table-header-caption"><?php echo $Page->UpdationDate->caption() ?></span>
																</div>
															<?php } else { ?>
																<div class="ew-table-header-btn ew-pointer users_report_UpdationDate" onclick="ew.sort(event,'<?php echo $Page->sortUrl($Page->UpdationDate) ?>',0);">
																	<span class="ew-table-header-caption"><?php echo $Page->UpdationDate->caption() ?></span>
																	<span class="ew-table-header-sort"><?php if ($Page->UpdationDate->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($Page->UpdationDate->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span>
																</div>
															<?php } ?>
														</td>
													<?php } ?>
												<?php } ?>
											</tr>
										</thead>
										<tbody>
										<?php
										if ($Page->TotalGroups == 0) break; // Show header only
										$Page->ShowHeader = FALSE;
									}
									$Page->RecordCount++;
									$Page->RecordIndex++;
										?>
										<?php

										// Render detail row
										$Page->resetAttributes();
										$Page->RowType = ROWTYPE_DETAIL;
										$Page->renderRow();
										?>
										<tr<?php echo $Page->rowAttributes(); ?>>
											<?php if ($Page->FullName->Visible) { ?>
												<td data-field="FullName" <?php echo $Page->FullName->cellAttributes() ?>>
													<span<?php echo $Page->FullName->viewAttributes() ?>><?php echo $Page->FullName->getViewValue() ?></span>
												</td>
											<?php } ?>
											<?php if ($Page->MobileNumber->Visible) { ?>
												<td data-field="MobileNumber" <?php echo $Page->MobileNumber->cellAttributes() ?>>
													<span<?php echo $Page->MobileNumber->viewAttributes() ?>><?php echo $Page->MobileNumber->getViewValue() ?></span>
												</td>
											<?php } ?>
											<?php if ($Page->EmailId->Visible) { ?>
												<td data-field="EmailId" <?php echo $Page->EmailId->cellAttributes() ?>>
													<span<?php echo $Page->EmailId->viewAttributes() ?>><?php echo $Page->EmailId->getViewValue() ?></span>
												</td>
											<?php } ?>
											<?php if ($Page->RegDate->Visible) { ?>
												<td data-field="RegDate" <?php echo $Page->RegDate->cellAttributes() ?>>
													<span<?php echo $Page->RegDate->viewAttributes() ?>><?php echo $Page->RegDate->getViewValue() ?></span>
												</td>
											<?php } ?>
											<?php if ($Page->UpdationDate->Visible) { ?>
												<td data-field="UpdationDate" <?php echo $Page->UpdationDate->cellAttributes() ?>>
													<span<?php echo $Page->UpdationDate->viewAttributes() ?>><?php echo $Page->UpdationDate->getViewValue() ?></span>
												</td>
											<?php } ?>
											</tr>
										<?php

										// Accumulate page summary
										$Page->accumulateSummary();

										// Get next record
										$Page->loadRowValues();
										$Page->GroupCount++;
									} // End while
										?>
										<?php if ($Page->TotalGroups > 0) { ?>
										</tbody>
										<tfoot>
										</tfoot>
									<?php } elseif (!$Page->ShowHeader && FALSE) { // No header displayed 
									?>
										<?php if ($Page->Export == "word" || $Page->Export == "excel") { ?>
											<div class="ew-grid" <?php echo $Page->ReportTableStyle ?>>
											<?php } else { ?>
												<div class="card ew-card ew-grid" <?php echo $Page->ReportTableStyle ?>>
												<?php } ?>
												<!-- Report grid (begin) -->
												<div id="gmp_users_report" class="<?php if (IsResponsiveLayout()) {
																						echo "table-responsive ";
																					} ?>ew-grid-middle-panel">
													<table class="<?php echo $Page->ReportTableClass ?>">
													<?php } ?>
													<?php if ($Page->TotalGroups > 0 || FALSE) { // Show footer 
													?>
													</table>
												</div>
												<?php if ($Page->Export == "" && !($Page->DrillDown && $Page->TotalGroups > 0)) { ?>
													<div class="card-footer ew-grid-lower-panel">
														<?php include "users_report_pager.php" ?>
														<div class="clearfix"></div>
													</div>
												<?php } ?>
												</div>
											<?php } ?>
											</div>
											<!-- Summary Report Ends -->
											<?php if ($Page->Export == "" && !$DashboardReport) { ?>
								</div>
								<!-- /#ew-center -->
							<?php } ?>
							<?php if ($Page->Export == "" && !$DashboardReport) { ?>
								</div>
								<!-- /.row -->
							<?php } ?>
							<?php if ($Page->Export == "" && !$DashboardReport) { ?>
							</div>
							<!-- /.ew-container -->
						<?php } ?>
						<?php
						$Page->showPageFooter();
						if (DEBUG_ENABLED)
							echo GetDebugMessage();
						?>
						<?php

						// Close recordsets
						if ($Page->GroupRecordset)
							$Page->GroupRecordset->Close();
						if ($Page->Recordset)
							$Page->Recordset->Close();
						?>
						<?php if ($Page->Export == "" && !$Page->DrillDown && !$DashboardReport) { ?>
							<script>
								// Write your table-specific startup script here
								// console.log("page loaded");
							</script>
						<?php } ?>
						<?php if (!$DashboardReport) { ?>
							<?php include_once "rfooter.php" ?>
						<?php } ?>
						<?php
						$Page->terminate();
						if (isset($OldPage))
							$Page = $OldPage;
						?>