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
if (!isset($Bookings_Report_summary))
	$Bookings_Report_summary = new Bookings_Report_summary();
if (isset($Page))
	$OldPage = $Page;
$Page = &$Bookings_Report_summary;

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
		currentPageID = ew.PAGE_ID = "summary"; // Page ID
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
			<div id="ew-center" class="<?php echo $Bookings_Report_summary->CenterContentClass ?>">
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
								<div id="gmp_Bookings_Report" class="<?php if (IsResponsiveLayout()) {
																			echo "table-responsive ";
																		} ?>ew-grid-middle-panel">
									<table class="<?php echo $Page->ReportTableClass ?>">
										<thead>
											<!-- Table header -->
											<tr class="ew-table-header">
												<?php if ($Page->PackageId->Visible) {
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
													<center><h2><u>Booking Reports</u></h2></center>
													
													'; ?>
													<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
														<td data-field="PackageId">
															<div class="Bookings_Report_PackageId"><span class="ew-table-header-caption"><?php echo $Page->PackageId->caption() ?></span></div>
														</td>
													<?php } else { ?>
														<td data-field="PackageId">
															<?php if ($Page->sortUrl($Page->PackageId) == "") { ?>
																<div class="ew-table-header-btn Bookings_Report_PackageId">
																	<span class="ew-table-header-caption"><?php echo $Page->PackageId->caption() ?></span>
																</div>
															<?php } else { ?>
																<div class="ew-table-header-btn ew-pointer Bookings_Report_PackageId" onclick="ew.sort(event,'<?php echo $Page->sortUrl($Page->PackageId) ?>',0);">
																	<span class="ew-table-header-caption"><?php echo $Page->PackageId->caption() ?></span>
																	<span class="ew-table-header-sort"><?php if ($Page->PackageId->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($Page->PackageId->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span>
																</div>
															<?php } ?>
														</td>
													<?php } ?>
												<?php } ?>
												<?php if ($Page->PackageName->Visible) { ?>
													<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
														<td data-field="PackageName">
															<div class="Bookings_Report_PackageName"><span class="ew-table-header-caption"><?php echo $Page->PackageName->caption() ?></span></div>
														</td>
													<?php } else { ?>
														<td data-field="PackageName">
															<?php if ($Page->sortUrl($Page->PackageName) == "") { ?>
																<div class="ew-table-header-btn Bookings_Report_PackageName">
																	<span class="ew-table-header-caption"><?php echo $Page->PackageName->caption() ?></span>
																</div>
															<?php } else { ?>
																<div class="ew-table-header-btn ew-pointer Bookings_Report_PackageName" onclick="ew.sort(event,'<?php echo $Page->sortUrl($Page->PackageName) ?>',0);">
																	<span class="ew-table-header-caption"><?php echo $Page->PackageName->caption() ?></span>
																	<span class="ew-table-header-sort"><?php if ($Page->PackageName->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($Page->PackageName->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span>
																</div>
															<?php } ?>
														</td>
													<?php } ?>
												<?php } ?>
												<?php if ($Page->PackageId1->Visible) { ?>
													<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
														<td data-field="PackageId1">
															<div class="Bookings_Report_PackageId1"><span class="ew-table-header-caption"><?php echo $Page->PackageId1->caption() ?></span></div>
														</td>
													<?php } else { ?>
														<td data-field="PackageId1">
															<?php if ($Page->sortUrl($Page->PackageId1) == "") { ?>
																<div class="ew-table-header-btn Bookings_Report_PackageId1">
																	<span class="ew-table-header-caption"><?php echo $Page->PackageId1->caption() ?></span>
																</div>
															<?php } else { ?>
																<div class="ew-table-header-btn ew-pointer Bookings_Report_PackageId1" onclick="ew.sort(event,'<?php echo $Page->sortUrl($Page->PackageId1) ?>',0);">
																	<span class="ew-table-header-caption"><?php echo $Page->PackageId1->caption() ?></span>
																	<span class="ew-table-header-sort"><?php if ($Page->PackageId1->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($Page->PackageId1->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span>
																</div>
															<?php } ?>
														</td>
													<?php } ?>
												<?php } ?>
												<?php if ($Page->UserEmail->Visible) { ?>
													<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
														<td data-field="UserEmail">
															<div class="Bookings_Report_UserEmail"><span class="ew-table-header-caption"><?php echo $Page->UserEmail->caption() ?></span></div>
														</td>
													<?php } else { ?>
														<td data-field="UserEmail">
															<?php if ($Page->sortUrl($Page->UserEmail) == "") { ?>
																<div class="ew-table-header-btn Bookings_Report_UserEmail">
																	<span class="ew-table-header-caption"><?php echo $Page->UserEmail->caption() ?></span>
																</div>
															<?php } else { ?>
																<div class="ew-table-header-btn ew-pointer Bookings_Report_UserEmail" onclick="ew.sort(event,'<?php echo $Page->sortUrl($Page->UserEmail) ?>',0);">
																	<span class="ew-table-header-caption"><?php echo $Page->UserEmail->caption() ?></span>
																	<span class="ew-table-header-sort"><?php if ($Page->UserEmail->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($Page->UserEmail->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span>
																</div>
															<?php } ?>
														</td>
													<?php } ?>
												<?php } ?>
												<?php if ($Page->FromDate->Visible) { ?>
													<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
														<td data-field="FromDate">
															<div class="Bookings_Report_FromDate"><span class="ew-table-header-caption"><?php echo $Page->FromDate->caption() ?></span></div>
														</td>
													<?php } else { ?>
														<td data-field="FromDate">
															<?php if ($Page->sortUrl($Page->FromDate) == "") { ?>
																<div class="ew-table-header-btn Bookings_Report_FromDate">
																	<span class="ew-table-header-caption"><?php echo $Page->FromDate->caption() ?></span>
																</div>
															<?php } else { ?>
																<div class="ew-table-header-btn ew-pointer Bookings_Report_FromDate" onclick="ew.sort(event,'<?php echo $Page->sortUrl($Page->FromDate) ?>',0);">
																	<span class="ew-table-header-caption"><?php echo $Page->FromDate->caption() ?></span>
																	<span class="ew-table-header-sort"><?php if ($Page->FromDate->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($Page->FromDate->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span>
																</div>
															<?php } ?>
														</td>
													<?php } ?>
												<?php } ?>
												<?php if ($Page->ToDate->Visible) { ?>
													<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
														<td data-field="ToDate">
															<div class="Bookings_Report_ToDate"><span class="ew-table-header-caption"><?php echo $Page->ToDate->caption() ?></span></div>
														</td>
													<?php } else { ?>
														<td data-field="ToDate">
															<?php if ($Page->sortUrl($Page->ToDate) == "") { ?>
																<div class="ew-table-header-btn Bookings_Report_ToDate">
																	<span class="ew-table-header-caption"><?php echo $Page->ToDate->caption() ?></span>
																</div>
															<?php } else { ?>
																<div class="ew-table-header-btn ew-pointer Bookings_Report_ToDate" onclick="ew.sort(event,'<?php echo $Page->sortUrl($Page->ToDate) ?>',0);">
																	<span class="ew-table-header-caption"><?php echo $Page->ToDate->caption() ?></span>
																	<span class="ew-table-header-sort"><?php if ($Page->ToDate->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($Page->ToDate->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span>
																</div>
															<?php } ?>
														</td>
													<?php } ?>
												<?php } ?>
												<?php if ($Page->pay->Visible) { ?>
													<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
														<td data-field="pay">
															<div class="Bookings_Report_pay"><span class="ew-table-header-caption"><?php echo $Page->pay->caption() ?></span></div>
														</td>
													<?php } else { ?>
														<td data-field="pay">
															<?php if ($Page->sortUrl($Page->pay) == "") { ?>
																<div class="ew-table-header-btn Bookings_Report_pay">
																	<span class="ew-table-header-caption"><?php echo $Page->pay->caption() ?></span>
																</div>
															<?php } else { ?>
																<div class="ew-table-header-btn ew-pointer Bookings_Report_pay" onclick="ew.sort(event,'<?php echo $Page->sortUrl($Page->pay) ?>',0);">
																	<span class="ew-table-header-caption"><?php echo $Page->pay->caption() ?></span>
																	<span class="ew-table-header-sort"><?php if ($Page->pay->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($Page->pay->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span>
																</div>
															<?php } ?>
														</td>
													<?php } ?>
												<?php } ?>
												<?php if ($Page->subject->Visible) { ?>
													<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
														<td data-field="subject">
															<div class="Bookings_Report_subject"><span class="ew-table-header-caption"><?php echo $Page->subject->caption() ?></span></div>
														</td>
													<?php } else { ?>
														<td data-field="subject">
															<?php if ($Page->sortUrl($Page->subject) == "") { ?>
																<div class="ew-table-header-btn Bookings_Report_subject">
																	<span class="ew-table-header-caption"><?php echo $Page->subject->caption() ?></span>
																</div>
															<?php } else { ?>
																<div class="ew-table-header-btn ew-pointer Bookings_Report_subject" onclick="ew.sort(event,'<?php echo $Page->sortUrl($Page->subject) ?>',0);">
																	<span class="ew-table-header-caption"><?php echo $Page->subject->caption() ?></span>
																	<span class="ew-table-header-sort"><?php if ($Page->subject->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($Page->subject->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span>
																</div>
															<?php } ?>
														</td>
													<?php } ?>
												<?php } ?>
												<?php if ($Page->chil->Visible) { ?>
													<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
														<td data-field="chil">
															<div class="Bookings_Report_chil"><span class="ew-table-header-caption"><?php echo $Page->chil->caption() ?></span></div>
														</td>
													<?php } else { ?>
														<td data-field="chil">
															<?php if ($Page->sortUrl($Page->chil) == "") { ?>
																<div class="ew-table-header-btn Bookings_Report_chil">
																	<span class="ew-table-header-caption"><?php echo $Page->chil->caption() ?></span>
																</div>
															<?php } else { ?>
																<div class="ew-table-header-btn ew-pointer Bookings_Report_chil" onclick="ew.sort(event,'<?php echo $Page->sortUrl($Page->chil) ?>',0);">
																	<span class="ew-table-header-caption"><?php echo $Page->chil->caption() ?></span>
																	<span class="ew-table-header-sort"><?php if ($Page->chil->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($Page->chil->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span>
																</div>
															<?php } ?>
														</td>
													<?php } ?>
												<?php } ?>
												<?php if ($Page->RegDate->Visible) { ?>
													<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
														<td data-field="RegDate">
															<div class="Bookings_Report_RegDate"><span class="ew-table-header-caption"><?php echo $Page->RegDate->caption() ?></span></div>
														</td>
													<?php } else { ?>
														<td data-field="RegDate">
															<?php if ($Page->sortUrl($Page->RegDate) == "") { ?>
																<div class="ew-table-header-btn Bookings_Report_RegDate">
																	<span class="ew-table-header-caption"><?php echo $Page->RegDate->caption() ?></span>
																</div>
															<?php } else { ?>
																<div class="ew-table-header-btn ew-pointer Bookings_Report_RegDate" onclick="ew.sort(event,'<?php echo $Page->sortUrl($Page->RegDate) ?>',0);">
																	<span class="ew-table-header-caption"><?php echo $Page->RegDate->caption() ?></span>
																	<span class="ew-table-header-sort"><?php if ($Page->RegDate->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($Page->RegDate->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span>
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
											<?php if ($Page->PackageId->Visible) { ?>
												<td data-field="PackageId" <?php echo $Page->PackageId->cellAttributes() ?>>
													<span<?php echo $Page->PackageId->viewAttributes() ?>><?php echo $Page->PackageId->getViewValue() ?></span>
												</td>
											<?php } ?>
											<?php if ($Page->PackageName->Visible) { ?>
												<td data-field="PackageName" <?php echo $Page->PackageName->cellAttributes() ?>>
													<span<?php echo $Page->PackageName->viewAttributes() ?>><?php echo $Page->PackageName->getViewValue() ?></span>
												</td>
											<?php } ?>
											<?php if ($Page->PackageId1->Visible) { ?>
												<td data-field="PackageId1" <?php echo $Page->PackageId1->cellAttributes() ?>>
													<span<?php echo $Page->PackageId1->viewAttributes() ?>><?php echo $Page->PackageId1->getViewValue() ?></span>
												</td>
											<?php } ?>
											<?php if ($Page->UserEmail->Visible) { ?>
												<td data-field="UserEmail" <?php echo $Page->UserEmail->cellAttributes() ?>>
													<span<?php echo $Page->UserEmail->viewAttributes() ?>><?php echo $Page->UserEmail->getViewValue() ?></span>
												</td>
											<?php } ?>
											<?php if ($Page->FromDate->Visible) { ?>
												<td data-field="FromDate" <?php echo $Page->FromDate->cellAttributes() ?>>
													<span<?php echo $Page->FromDate->viewAttributes() ?>><?php echo $Page->FromDate->getViewValue() ?></span>
												</td>
											<?php } ?>
											<?php if ($Page->ToDate->Visible) { ?>
												<td data-field="ToDate" <?php echo $Page->ToDate->cellAttributes() ?>>
													<span<?php echo $Page->ToDate->viewAttributes() ?>><?php echo $Page->ToDate->getViewValue() ?></span>
												</td>
											<?php } ?>
											<?php if ($Page->pay->Visible) { ?>
												<td data-field="pay" <?php echo $Page->pay->cellAttributes() ?>>
													<span<?php echo $Page->pay->viewAttributes() ?>><?php echo $Page->pay->getViewValue() ?></span>
												</td>
											<?php } ?>
											<?php if ($Page->subject->Visible) { ?>
												<td data-field="subject" <?php echo $Page->subject->cellAttributes() ?>>
													<span<?php echo $Page->subject->viewAttributes() ?>><?php echo $Page->subject->getViewValue() ?></span>
												</td>
											<?php } ?>
											<?php if ($Page->chil->Visible) { ?>
												<td data-field="chil" <?php echo $Page->chil->cellAttributes() ?>>
													<span<?php echo $Page->chil->viewAttributes() ?>><?php echo $Page->chil->getViewValue() ?></span>
												</td>
											<?php } ?>
											<?php if ($Page->RegDate->Visible) { ?>
												<td data-field="RegDate" <?php echo $Page->RegDate->cellAttributes() ?>>
													<span<?php echo $Page->RegDate->viewAttributes() ?>><?php echo $Page->RegDate->getViewValue() ?></span>
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
											<?php
											$Page->resetAttributes();
											$Page->RowType = ROWTYPE_TOTAL;
											$Page->RowTotalType = ROWTOTAL_GRAND;
											$Page->RowTotalSubType = ROWTOTAL_FOOTER;
											$Page->RowAttrs["class"] = "ew-rpt-grand-summary";
											$Page->renderRow();
											?>
											<?php if ($Page->ShowCompactSummaryFooter) { ?>
												<tr<?php echo $Page->rowAttributes() ?>>
													<td colspan="<?php echo ($Page->GroupColumnCount + $Page->DetailColumnCount) ?>"><?php echo $ReportLanguage->Phrase("RptGrandSummary") ?> <span class="ew-summary-count">(<span class="ew-aggregate-caption"><?php echo $ReportLanguage->phrase("RptCnt") ?></span><?php echo $ReportLanguage->phrase("AggregateEqual") ?><span class="ew-aggregate-value"><?php echo FormatNumber($Page->TotalCount, 0, -2, -2, -2) ?></span>)</span></td>
													</tr>
												<?php } else { ?>
													<tr<?php echo $Page->rowAttributes() ?>>
														<td colspan="<?php echo ($Page->GroupColumnCount + $Page->DetailColumnCount) ?>"><?php echo $ReportLanguage->Phrase("RptGrandSummary") ?> <span class="ew-summary-count">(<?php echo FormatNumber($Page->TotalCount, 0, -2, -2, -2); ?><?php echo $ReportLanguage->Phrase("RptDtlRec") ?>)</span></td>
														</tr>
													<?php } ?>
										</tfoot>
									<?php } elseif (!$Page->ShowHeader && FALSE) { // No header displayed 
									?>
										<?php if ($Page->Export == "word" || $Page->Export == "excel") { ?>
											<div class="ew-grid" <?php echo $Page->ReportTableStyle ?>>
											<?php } else { ?>
												<div class="card ew-card ew-grid" <?php echo $Page->ReportTableStyle ?>>
												<?php } ?>
												<!-- Report grid (begin) -->
												<div id="gmp_Bookings_Report" class="<?php if (IsResponsiveLayout()) {
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
														<?php include "Bookings_Report_pager.php" ?>
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