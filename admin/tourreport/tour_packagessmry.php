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
if (!isset($tour_packages_summary))
	$tour_packages_summary = new tour_packages_summary();
if (isset($Page))
	$OldPage = $Page;
$Page = &$tour_packages_summary;

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
			<div id="ew-center" class="<?php echo $tour_packages_summary->CenterContentClass ?>">
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
								<div id="gmp_tour_packages" class="<?php if (IsResponsiveLayout()) {
																		echo "table-responsive ";
																	} ?>ew-grid-middle-panel">
									<table class="<?php echo $Page->ReportTableClass ?>">
										<thead>
											<!-- Table header -->
											<tr class="ew-table-header">
												<?php if ($Page->PackageName->Visible) {
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
												<center><h2><u>Package Reports</u></h2></center>
												
												';  ?>
													<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
														<td data-field="PackageName">
															<div class="tour_packages_PackageName"><span class="ew-table-header-caption"><?php echo $Page->PackageName->caption() ?></span></div>
														</td>
													<?php } else { ?>
														<td data-field="PackageName">
															<?php if ($Page->sortUrl($Page->PackageName) == "") { ?>
																<div class="ew-table-header-btn tour_packages_PackageName">
																	<span class="ew-table-header-caption"><?php echo $Page->PackageName->caption() ?></span>
																</div>
															<?php } else { ?>
																<div class="ew-table-header-btn ew-pointer tour_packages_PackageName" onclick="ew.sort(event,'<?php echo $Page->sortUrl($Page->PackageName) ?>',0);">
																	<span class="ew-table-header-caption"><?php echo $Page->PackageName->caption() ?></span>
																	<span class="ew-table-header-sort"><?php if ($Page->PackageName->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($Page->PackageName->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span>
																</div>
															<?php } ?>
														</td>
													<?php } ?>
												<?php } ?>
												<?php if ($Page->PackageType->Visible) { ?>
													<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
														<td data-field="PackageType">
															<div class="tour_packages_PackageType"><span class="ew-table-header-caption"><?php echo $Page->PackageType->caption() ?></span></div>
														</td>
													<?php } else { ?>
														<td data-field="PackageType">
															<?php if ($Page->sortUrl($Page->PackageType) == "") { ?>
																<div class="ew-table-header-btn tour_packages_PackageType">
																	<span class="ew-table-header-caption"><?php echo $Page->PackageType->caption() ?></span>
																</div>
															<?php } else { ?>
																<div class="ew-table-header-btn ew-pointer tour_packages_PackageType" onclick="ew.sort(event,'<?php echo $Page->sortUrl($Page->PackageType) ?>',0);">
																	<span class="ew-table-header-caption"><?php echo $Page->PackageType->caption() ?></span>
																	<span class="ew-table-header-sort"><?php if ($Page->PackageType->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($Page->PackageType->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span>
																</div>
															<?php } ?>
														</td>
													<?php } ?>
												<?php } ?>
												<?php if ($Page->PackageLocation->Visible) { ?>
													<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
														<td data-field="PackageLocation">
															<div class="tour_packages_PackageLocation"><span class="ew-table-header-caption"><?php echo $Page->PackageLocation->caption() ?></span></div>
														</td>
													<?php } else { ?>
														<td data-field="PackageLocation">
															<?php if ($Page->sortUrl($Page->PackageLocation) == "") { ?>
																<div class="ew-table-header-btn tour_packages_PackageLocation">
																	<span class="ew-table-header-caption"><?php echo $Page->PackageLocation->caption() ?></span>
																</div>
															<?php } else { ?>
																<div class="ew-table-header-btn ew-pointer tour_packages_PackageLocation" onclick="ew.sort(event,'<?php echo $Page->sortUrl($Page->PackageLocation) ?>',0);">
																	<span class="ew-table-header-caption"><?php echo $Page->PackageLocation->caption() ?></span>
																	<span class="ew-table-header-sort"><?php if ($Page->PackageLocation->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($Page->PackageLocation->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span>
																</div>
															<?php } ?>
														</td>
													<?php } ?>
												<?php } ?>
												<?php if ($Page->PackagePrice->Visible) { ?>
													<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
														<td data-field="PackagePrice">
															<div class="tour_packages_PackagePrice"><span class="ew-table-header-caption"><?php echo $Page->PackagePrice->caption() ?></span></div>
														</td>
													<?php } else { ?>
														<td data-field="PackagePrice">
															<?php if ($Page->sortUrl($Page->PackagePrice) == "") { ?>
																<div class="ew-table-header-btn tour_packages_PackagePrice">
																	<span class="ew-table-header-caption"><?php echo $Page->PackagePrice->caption() ?></span>
																</div>
															<?php } else { ?>
																<div class="ew-table-header-btn ew-pointer tour_packages_PackagePrice" onclick="ew.sort(event,'<?php echo $Page->sortUrl($Page->PackagePrice) ?>',0);">
																	<span class="ew-table-header-caption"><?php echo $Page->PackagePrice->caption() ?></span>
																	<span class="ew-table-header-sort"><?php if ($Page->PackagePrice->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($Page->PackagePrice->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span>
																</div>
															<?php } ?>
														</td>
													<?php } ?>
												<?php } ?>
												<?php if ($Page->PackageFetures->Visible) { ?>
													<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
														<td data-field="PackageFetures">
															<div class="tour_packages_PackageFetures"><span class="ew-table-header-caption"><?php echo $Page->PackageFetures->caption() ?></span></div>
														</td>
													<?php } else { ?>
														<td data-field="PackageFetures">
															<?php if ($Page->sortUrl($Page->PackageFetures) == "") { ?>
																<div class="ew-table-header-btn tour_packages_PackageFetures">
																	<span class="ew-table-header-caption"><?php echo $Page->PackageFetures->caption() ?></span>
																</div>
															<?php } else { ?>
																<div class="ew-table-header-btn ew-pointer tour_packages_PackageFetures" onclick="ew.sort(event,'<?php echo $Page->sortUrl($Page->PackageFetures) ?>',0);">
																	<span class="ew-table-header-caption"><?php echo $Page->PackageFetures->caption() ?></span>
																	<span class="ew-table-header-sort"><?php if ($Page->PackageFetures->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($Page->PackageFetures->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span>
																</div>
															<?php } ?>
														</td>
													<?php } ?>
												<?php } ?>
												<?php if ($Page->noofday->Visible) { ?>
													<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
														<td data-field="noofday">
															<div class="tour_packages_noofday"><span class="ew-table-header-caption"><?php echo $Page->noofday->caption() ?></span></div>
														</td>
													<?php } else { ?>
														<td data-field="noofday">
															<?php if ($Page->sortUrl($Page->noofday) == "") { ?>
																<div class="ew-table-header-btn tour_packages_noofday">
																	<span class="ew-table-header-caption"><?php echo $Page->noofday->caption() ?></span>
																</div>
															<?php } else { ?>
																<div class="ew-table-header-btn ew-pointer tour_packages_noofday" onclick="ew.sort(event,'<?php echo $Page->sortUrl($Page->noofday) ?>',0);">
																	<span class="ew-table-header-caption"><?php echo $Page->noofday->caption() ?></span>
																	<span class="ew-table-header-sort"><?php if ($Page->noofday->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($Page->noofday->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span>
																</div>
															<?php } ?>
														</td>
													<?php } ?>
												<?php } ?>
												<?php if ($Page->fdate->Visible) { ?>
													<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
														<td data-field="fdate">
															<div class="tour_packages_fdate"><span class="ew-table-header-caption"><?php echo $Page->fdate->caption() ?></span></div>
														</td>
													<?php } else { ?>
														<td data-field="fdate">
															<?php if ($Page->sortUrl($Page->fdate) == "") { ?>
																<div class="ew-table-header-btn tour_packages_fdate">
																	<span class="ew-table-header-caption"><?php echo $Page->fdate->caption() ?></span>
																</div>
															<?php } else { ?>
																<div class="ew-table-header-btn ew-pointer tour_packages_fdate" onclick="ew.sort(event,'<?php echo $Page->sortUrl($Page->fdate) ?>',0);">
																	<span class="ew-table-header-caption"><?php echo $Page->fdate->caption() ?></span>
																	<span class="ew-table-header-sort"><?php if ($Page->fdate->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($Page->fdate->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span>
																</div>
															<?php } ?>
														</td>
													<?php } ?>
												<?php } ?>
												<?php if ($Page->tdate->Visible) { ?>
													<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
														<td data-field="tdate">
															<div class="tour_packages_tdate"><span class="ew-table-header-caption"><?php echo $Page->tdate->caption() ?></span></div>
														</td>
													<?php } else { ?>
														<td data-field="tdate">
															<?php if ($Page->sortUrl($Page->tdate) == "") { ?>
																<div class="ew-table-header-btn tour_packages_tdate">
																	<span class="ew-table-header-caption"><?php echo $Page->tdate->caption() ?></span>
																</div>
															<?php } else { ?>
																<div class="ew-table-header-btn ew-pointer tour_packages_tdate" onclick="ew.sort(event,'<?php echo $Page->sortUrl($Page->tdate) ?>',0);">
																	<span class="ew-table-header-caption"><?php echo $Page->tdate->caption() ?></span>
																	<span class="ew-table-header-sort"><?php if ($Page->tdate->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($Page->tdate->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span>
																</div>
															<?php } ?>
														</td>
													<?php } ?>
												<?php } ?>
												<?php if ($Page->PackageDetails->Visible) { ?>
													<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
														<td data-field="PackageDetails">
															<div class="tour_packages_PackageDetails"><span class="ew-table-header-caption"><?php echo $Page->PackageDetails->caption() ?></span></div>
														</td>
													<?php } else { ?>
														<td data-field="PackageDetails">
															<?php if ($Page->sortUrl($Page->PackageDetails) == "") { ?>
																<div class="ew-table-header-btn tour_packages_PackageDetails">
																	<span class="ew-table-header-caption"><?php echo $Page->PackageDetails->caption() ?></span>
																</div>
															<?php } else { ?>
																<div class="ew-table-header-btn ew-pointer tour_packages_PackageDetails" onclick="ew.sort(event,'<?php echo $Page->sortUrl($Page->PackageDetails) ?>',0);">
																	<span class="ew-table-header-caption"><?php echo $Page->PackageDetails->caption() ?></span>
																	<span class="ew-table-header-sort"><?php if ($Page->PackageDetails->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($Page->PackageDetails->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span>
																</div>
															<?php } ?>
														</td>
													<?php } ?>
												<?php } ?>
												<?php if ($Page->HotelDetails->Visible) { ?>
													<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
														<td data-field="HotelDetails">
															<div class="tour_packages_HotelDetails"><span class="ew-table-header-caption"><?php echo $Page->HotelDetails->caption() ?></span></div>
														</td>
													<?php } else { ?>
														<td data-field="HotelDetails">
															<?php if ($Page->sortUrl($Page->HotelDetails) == "") { ?>
																<div class="ew-table-header-btn tour_packages_HotelDetails">
																	<span class="ew-table-header-caption"><?php echo $Page->HotelDetails->caption() ?></span>
																</div>
															<?php } else { ?>
																<div class="ew-table-header-btn ew-pointer tour_packages_HotelDetails" onclick="ew.sort(event,'<?php echo $Page->sortUrl($Page->HotelDetails) ?>',0);">
																	<span class="ew-table-header-caption"><?php echo $Page->HotelDetails->caption() ?></span>
																	<span class="ew-table-header-sort"><?php if ($Page->HotelDetails->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($Page->HotelDetails->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span>
																</div>
															<?php } ?>
														</td>
													<?php } ?>
												<?php } ?>
												<?php if ($Page->Vehicle->Visible) { ?>
													<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
														<td data-field="Vehicle">
															<div class="tour_packages_Vehicle"><span class="ew-table-header-caption"><?php echo $Page->Vehicle->caption() ?></span></div>
														</td>
													<?php } else { ?>
														<td data-field="Vehicle">
															<?php if ($Page->sortUrl($Page->Vehicle) == "") { ?>
																<div class="ew-table-header-btn tour_packages_Vehicle">
																	<span class="ew-table-header-caption"><?php echo $Page->Vehicle->caption() ?></span>
																</div>
															<?php } else { ?>
																<div class="ew-table-header-btn ew-pointer tour_packages_Vehicle" onclick="ew.sort(event,'<?php echo $Page->sortUrl($Page->Vehicle) ?>',0);">
																	<span class="ew-table-header-caption"><?php echo $Page->Vehicle->caption() ?></span>
																	<span class="ew-table-header-sort"><?php if ($Page->Vehicle->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($Page->Vehicle->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span>
																</div>
															<?php } ?>
														</td>
													<?php } ?>
												<?php } ?>
												<?php if ($Page->Offer->Visible) { ?>
													<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
														<td data-field="Offer">
															<div class="tour_packages_Offer"><span class="ew-table-header-caption"><?php echo $Page->Offer->caption() ?></span></div>
														</td>
													<?php } else { ?>
														<td data-field="Offer">
															<?php if ($Page->sortUrl($Page->Offer) == "") { ?>
																<div class="ew-table-header-btn tour_packages_Offer">
																	<span class="ew-table-header-caption"><?php echo $Page->Offer->caption() ?></span>
																</div>
															<?php } else { ?>
																<div class="ew-table-header-btn ew-pointer tour_packages_Offer" onclick="ew.sort(event,'<?php echo $Page->sortUrl($Page->Offer) ?>',0);">
																	<span class="ew-table-header-caption"><?php echo $Page->Offer->caption() ?></span>
																	<span class="ew-table-header-sort"><?php if ($Page->Offer->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($Page->Offer->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span>
																</div>
															<?php } ?>
														</td>
													<?php } ?>
												<?php } ?>
												<?php if ($Page->offer_edate->Visible) { ?>
													<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
														<td data-field="offer_edate">
															<div class="tour_packages_offer_edate"><span class="ew-table-header-caption"><?php echo $Page->offer_edate->caption() ?></span></div>
														</td>
													<?php } else { ?>
														<td data-field="offer_edate">
															<?php if ($Page->sortUrl($Page->offer_edate) == "") { ?>
																<div class="ew-table-header-btn tour_packages_offer_edate">
																	<span class="ew-table-header-caption"><?php echo $Page->offer_edate->caption() ?></span>
																</div>
															<?php } else { ?>
																<div class="ew-table-header-btn ew-pointer tour_packages_offer_edate" onclick="ew.sort(event,'<?php echo $Page->sortUrl($Page->offer_edate) ?>',0);">
																	<span class="ew-table-header-caption"><?php echo $Page->offer_edate->caption() ?></span>
																	<span class="ew-table-header-sort"><?php if ($Page->offer_edate->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($Page->offer_edate->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span>
																</div>
															<?php } ?>
														</td>
													<?php } ?>
												<?php } ?>
												<?php if ($Page->Creationdate->Visible) { ?>
													<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
														<td data-field="Creationdate">
															<div class="tour_packages_Creationdate"><span class="ew-table-header-caption"><?php echo $Page->Creationdate->caption() ?></span></div>
														</td>
													<?php } else { ?>
														<td data-field="Creationdate">
															<?php if ($Page->sortUrl($Page->Creationdate) == "") { ?>
																<div class="ew-table-header-btn tour_packages_Creationdate">
																	<span class="ew-table-header-caption"><?php echo $Page->Creationdate->caption() ?></span>
																</div>
															<?php } else { ?>
																<div class="ew-table-header-btn ew-pointer tour_packages_Creationdate" onclick="ew.sort(event,'<?php echo $Page->sortUrl($Page->Creationdate) ?>',0);">
																	<span class="ew-table-header-caption"><?php echo $Page->Creationdate->caption() ?></span>
																	<span class="ew-table-header-sort"><?php if ($Page->Creationdate->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($Page->Creationdate->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span>
																</div>
															<?php } ?>
														</td>
													<?php } ?>
												<?php } ?>
												<?php if ($Page->UpdationDate->Visible) { ?>
													<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
														<td data-field="UpdationDate">
															<div class="tour_packages_UpdationDate"><span class="ew-table-header-caption"><?php echo $Page->UpdationDate->caption() ?></span></div>
														</td>
													<?php } else { ?>
														<td data-field="UpdationDate">
															<?php if ($Page->sortUrl($Page->UpdationDate) == "") { ?>
																<div class="ew-table-header-btn tour_packages_UpdationDate">
																	<span class="ew-table-header-caption"><?php echo $Page->UpdationDate->caption() ?></span>
																</div>
															<?php } else { ?>
																<div class="ew-table-header-btn ew-pointer tour_packages_UpdationDate" onclick="ew.sort(event,'<?php echo $Page->sortUrl($Page->UpdationDate) ?>',0);">
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
											<?php if ($Page->PackageName->Visible) { ?>
												<td data-field="PackageName" <?php echo $Page->PackageName->cellAttributes() ?>>
													<span<?php echo $Page->PackageName->viewAttributes() ?>><?php echo $Page->PackageName->getViewValue() ?></span>
												</td>
											<?php } ?>
											<?php if ($Page->PackageType->Visible) { ?>
												<td data-field="PackageType" <?php echo $Page->PackageType->cellAttributes() ?>>
													<span<?php echo $Page->PackageType->viewAttributes() ?>><?php echo $Page->PackageType->getViewValue() ?></span>
												</td>
											<?php } ?>
											<?php if ($Page->PackageLocation->Visible) { ?>
												<td data-field="PackageLocation" <?php echo $Page->PackageLocation->cellAttributes() ?>>
													<span<?php echo $Page->PackageLocation->viewAttributes() ?>><?php echo $Page->PackageLocation->getViewValue() ?></span>
												</td>
											<?php } ?>
											<?php if ($Page->PackagePrice->Visible) { ?>
												<td data-field="PackagePrice" <?php echo $Page->PackagePrice->cellAttributes() ?>>
													<span<?php echo $Page->PackagePrice->viewAttributes() ?>><?php echo $Page->PackagePrice->getViewValue() ?></span>
												</td>
											<?php } ?>
											<?php if ($Page->PackageFetures->Visible) { ?>
												<td data-field="PackageFetures" <?php echo $Page->PackageFetures->cellAttributes() ?>>
													<span<?php echo $Page->PackageFetures->viewAttributes() ?>><?php echo $Page->PackageFetures->getViewValue() ?></span>
												</td>
											<?php } ?>
											<?php if ($Page->noofday->Visible) { ?>
												<td data-field="noofday" <?php echo $Page->noofday->cellAttributes() ?>>
													<span<?php echo $Page->noofday->viewAttributes() ?>><?php echo $Page->noofday->getViewValue() ?></span>
												</td>
											<?php } ?>
											<?php if ($Page->fdate->Visible) { ?>
												<td data-field="fdate" <?php echo $Page->fdate->cellAttributes() ?>>
													<span<?php echo $Page->fdate->viewAttributes() ?>><?php echo $Page->fdate->getViewValue() ?></span>
												</td>
											<?php } ?>
											<?php if ($Page->tdate->Visible) { ?>
												<td data-field="tdate" <?php echo $Page->tdate->cellAttributes() ?>>
													<span<?php echo $Page->tdate->viewAttributes() ?>><?php echo $Page->tdate->getViewValue() ?></span>
												</td>
											<?php } ?>
											<?php if ($Page->PackageDetails->Visible) { ?>
												<td data-field="PackageDetails" <?php echo $Page->PackageDetails->cellAttributes() ?>>
													<span<?php echo $Page->PackageDetails->viewAttributes() ?>><?php echo $Page->PackageDetails->getViewValue() ?></span>
												</td>
											<?php } ?>
											<?php if ($Page->HotelDetails->Visible) { ?>
												<td data-field="HotelDetails" <?php echo $Page->HotelDetails->cellAttributes() ?>>
													<span<?php echo $Page->HotelDetails->viewAttributes() ?>><?php echo $Page->HotelDetails->getViewValue() ?></span>
												</td>
											<?php } ?>
											<?php if ($Page->Vehicle->Visible) { ?>
												<td data-field="Vehicle" <?php echo $Page->Vehicle->cellAttributes() ?>>
													<span<?php echo $Page->Vehicle->viewAttributes() ?>><?php echo $Page->Vehicle->getViewValue() ?></span>
												</td>
											<?php } ?>
											<?php if ($Page->Offer->Visible) { ?>
												<td data-field="Offer" <?php echo $Page->Offer->cellAttributes() ?>>
													<span<?php echo $Page->Offer->viewAttributes() ?>><?php echo $Page->Offer->getViewValue() ?></span>
												</td>
											<?php } ?>
											<?php if ($Page->offer_edate->Visible) { ?>
												<td data-field="offer_edate" <?php echo $Page->offer_edate->cellAttributes() ?>>
													<span<?php echo $Page->offer_edate->viewAttributes() ?>><?php echo $Page->offer_edate->getViewValue() ?></span>
												</td>
											<?php } ?>
											<?php if ($Page->Creationdate->Visible) { ?>
												<td data-field="Creationdate" <?php echo $Page->Creationdate->cellAttributes() ?>>
													<span<?php echo $Page->Creationdate->viewAttributes() ?>><?php echo $Page->Creationdate->getViewValue() ?></span>
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
												<div id="gmp_tour_packages" class="<?php if (IsResponsiveLayout()) {
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
														<?php include "tour_packages_pager.php" ?>
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