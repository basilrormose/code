<?php

/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */

// Include Zend Escaper for HTML Output Encoding
require_once(realpath(__DIR__ . '/Component_ZendEscaper/Escaper.php'));
$escaper = new Zend\Escaper\Escaper('utf-8');

require_once(realpath(__DIR__ . '/assets.php'));

/****************************
 * FUNCTION: VIEW TOP TABLE *
 ****************************/
function view_top_table($id, $calculated_risk, $subject, $status, $show_details = false)
{
	global $lang;
	global $escaper;
	
	echo "<table width=\"100%\" cellpadding=\"10\" cellspacing=\"0\" style=\"border:none;\">\n";
        echo "<tr>\n";
        echo "<td width=\"100\" valign=\"middle\" halign=\"center\">\n";

        echo "<table width=\"100\" height=\"100\" border=\"10\" class=" . $escaper->escapeHtml(get_risk_color($calculated_risk)) . ">\n";
        echo "<tr>\n";
        echo "<td valign=\"middle\" halign=\"center\">\n";
        echo "<center>\n";
	echo "<font size=\"72\">" . $escaper->escapeHtml($calculated_risk) . "</font><br />\n";
        echo "(". $escaper->escapeHtml(get_risk_level_name($calculated_risk)) . ")\n";
        echo "</center>\n";
        echo "</td>\n";
        echo "</tr>\n";
        echo "</table>\n";

        echo "</td>\n";
        echo "<td valign=\"left\" halign=\"center\">\n";

	echo "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" style=\"border:none;\">\n";
        echo "<tr>\n";
        echo "<td width=\"100\"><h4>". $escaper->escapeHtml($lang['RiskId']) .":</h4></td>\n";
	echo "<td><h4>" . $escaper->escapeHtml($id) . "</h4></td>\n";
	echo "</tr>\n";
        echo "<tr>\n";
        echo "<td width=\"100\"><h4>". $escaper->escapeHtml($lang['Subject']) .":</h4></td>\n";
	echo "<td><h4>" . $escaper->escapeHtml($subject) . "</h4></td>\n";
        echo "</tr>\n";
        echo "<tr>\n";
        echo "<td width=\"100\"><h4>". $escaper->escapeHtml($lang['Status']) .":</h4></td>\n";
	echo "<td><h4>" . $escaper->escapeHtml($status) . "</h4></td>\n";
	echo "</tr>\n";
	echo "</table>\n";

        echo "</td>\n";
        echo "<td valign=\"top\">\n";
        echo "<div class=\"btn-group pull-right\">\n";
        echo "<a class=\"btn dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\">". $escaper->escapeHtml($lang['RiskActions']) ."<span class=\"caret\"></span></a>\n";
        echo "<ul class=\"dropdown-menu\">\n";

        // If the risk is closed, offer to reopen
        if ($status == "Closed")
        {
        	echo "<li><a href=\"reopen.php?id=".$escaper->escapeHtml($id)."\">". $escaper->escapeHtml($lang['ReopenRisk']) ."</a></li>\n";
        }
        // Otherwise, offer to close
        else
        {
        	// If the user has permission to close risks
                if (isset($_SESSION["close_risks"]) && $_SESSION["close_risks"] == 1)
                {
                	echo "<li><a href=\"close.php?id=".$escaper->escapeHtml($id)."\">". $escaper->escapeHtml($lang['CloseRisk']) ."</a></li>\n";
                }
        }

	echo "<li><a href=\"view.php?id=" . $escaper->escapeHtml($id) . "\">". $escaper->escapeHtml($lang['EditRisk']) ."</a></li>\n";
        echo "<li><a href=\"mitigate.php?id=" . $escaper->escapeHtml($id) . "\">". $escaper->escapeHtml($lang['PlanAMitigation']) ."</a></li>\n";
        echo "<li><a href=\"mgmt_review.php?id=" . $escaper->escapeHtml($id) . "\">". $escaper->escapeHtml($lang['PerformAReview']) ."</a></li>\n";
        echo "<li><a href=\"comment.php?id=" . $escaper->escapeHtml($id) . "\">". $escaper->escapeHtml($lang['AddAComment']) ."</a></li>\n";
	echo "<li><a href=\"print_view.php?id=" . $escaper->escapeHtml($id) . "\" target=\"_blank\">". $escaper->escapeHtml($lang['PrintableView']) ."</a></li>\n";
        echo "</ul>\n";
        echo "</div>\n";
        echo "</td>\n";
        echo "</tr>\n";

	// If we want to show the details
	if ($show_details)
	{
		echo "<tr>\n";
		echo "<td colspan=\"3\">\n";
		echo "<a href=\"#\" id=\"show\" onclick=\"javascript: showScoreDetails();\">". $escaper->escapeHtml($lang['ShowRiskScoringDetails']) ."</a>\n";
        	echo "<a href=\"#\" id=\"hide\" style=\"display: none;\" onclick=\"javascript: hideScoreDetails();\">". $escaper->escapeHtml($lang['HideRiskScoringDetails']) ."</a>\n";
		echo "</td>\n";
		echo "</tr>\n";
	}

        echo "</table>\n";
}

/**********************************
 * FUNCTION: VIEW PRINT TOP TABLE *
 **********************************/
function view_print_top_table($id, $calculated_risk, $subject, $status)
{
        global $lang;
        global $escaper;

        echo "<table width=\"100%\" cellpadding=\"10\" cellspacing=\"0\" style=\"border:none;\">\n";
        echo "<tr>\n";
        echo "<td width=\"100\" valign=\"middle\" halign=\"center\">\n";

        echo "<table width=\"100\" height=\"100\" border=\"10\" class=" . $escaper->escapeHtml(get_risk_color($calculated_risk)) . ">\n";
        echo "<tr>\n";
        echo "<td valign=\"middle\" halign=\"center\">\n";
        echo "<center>\n";
        echo "<font size=\"72\">" . $escaper->escapeHtml($calculated_risk) . "</font><br />\n";
        echo "(". $escaper->escapeHtml(get_risk_level_name($calculated_risk)) . ")\n";
        echo "</center>\n";
        echo "</td>\n";
        echo "</tr>\n";
        echo "</table>\n";

        echo "</td>\n";
        echo "<td valign=\"left\" halign=\"center\">\n";

        echo "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" style=\"border:none;\">\n";
        echo "<tr>\n";
        echo "<td width=\"100\"><h4>". $escaper->escapeHtml($lang['RiskId']) .":</h4></td>\n";
        echo "<td><h4>" . $escaper->escapeHtml($id) . "</h4></td>\n";
        echo "</tr>\n";
        echo "<tr>\n";
        echo "<td width=\"100\"><h4>". $escaper->escapeHtml($lang['Subject']) .":</h4></td>\n";
        echo "<td><h4>" . $escaper->escapeHtml($subject) . "</h4></td>\n";
        echo "</tr>\n";
        echo "<tr>\n";
        echo "<td width=\"100\"><h4>". $escaper->escapeHtml($lang['Status']) .":</h4></td>\n";
        echo "<td><h4>" . $escaper->escapeHtml($status) . "</h4></td>\n";
        echo "</tr>\n";
        echo "</table>\n";

        echo "</td>\n";
	echo "</table>\n";
}

/*******************************
 * FUNCTION: VIEW RISK DETAILS *
 *******************************/
function view_risk_details($id, $submission_date, $subject, $reference_id, $regulation, $control_number, $location, $category, $team, $technology, $owner, $manager, $assessment, $notes)
{
	global $lang;
	global $escaper;
	
	echo "<h4>". $escaper->escapeHtml($lang['Details']) ."</h4>\n";
        echo $escaper->escapeHtml($lang['SubmissionDate']) .": \n";
        echo "<br />\n";
        echo "<input style=\"cursor: default;\" type=\"text\" name=\"submission_date\" id=\"submission_date\" size=\"50\" value=\"" . $escaper->escapeHtml($submission_date) . "\" title=\"" . $escaper->escapeHtml($submission_date) . "\" disabled=\"disabled\" />\n";
        echo "<br />\n";
        echo $escaper->escapeHtml($lang['Subject']) .": \n";
        echo "<br />\n";
        echo "<input style=\"cursor: default;\" type=\"text\" name=\"subject\" id=\"subject\" size=\"50\" value=\"" . $escaper->escapeHtml($subject) . "\" title=\"" . $escaper->escapeHtml($subject) . "\" disabled=\"disabled\" />\n";
        echo "<br />\n";
        echo $escaper->escapeHtml($lang['ExternalReferenceId']) .": \n";
        echo "<br />\n";
        echo " <input style=\"cursor: default;\" type=\"text\" name=\"reference_id\" id=\"reference_id\" size=\"20\" value=\"" . $escaper->escapeHtml($reference_id) . "\" title=\"" . $escaper->escapeHtml($reference_id) . "\" disabled=\"disabled\" />\n";
        echo "<br />\n";
        echo $escaper->escapeHtml($lang['ControlRegulation']) .": \n";
        echo "<br />\n";
        echo "<input style=\"cursor: default;\" type=\"text\" name=\"regulation\" id=\"regulation\" size=\"50\" value=\"" . $escaper->escapeHtml(get_name_by_value("regulation", $regulation)) . "\" title=\"" . $escaper->escapeHtml(get_name_by_value("regulation", $regulation)) . "\" disabled=\"disabled\" />\n";
        echo "<br />\n";
        echo $escaper->escapeHtml($lang['ControlNumber']) .": \n";
        echo "<br />\n";
        echo " <input style=\"cursor: default;\" type=\"text\" name=\"control_number\" id=\"control_number\" size=\"20\" value=\"" . $escaper->escapeHtml($control_number) . "\" title=\"" . $escaper->escapeHtml($control_number) . "\" disabled=\"disabled\" />\n";
        echo "<br />\n";
        echo $escaper->escapeHtml($lang['SiteLocation']) .": \n";
        echo "<br />\n";
        echo "<input style=\"cursor: default;\" type=\"text\" name=\"location\" id=\"location\" size=\"50\" value=\"" . $escaper->escapeHtml(get_name_by_value("location", $location)) . "\" title=\"" . $escaper->escapeHtml(get_name_by_value("location", $location)) . "\" disabled=\"disabled\" />\n";
        echo "<br />\n";
        echo $escaper->escapeHtml($lang['Category']) .": \n";
        echo "<br />\n";
        echo "<input style=\"cursor: default;\" type=\"text\" name=\"category\" id=\"category\" size=\"50\" value=\"" . $escaper->escapeHtml(get_name_by_value("category", $category)) . "\" title=\"" . $escaper->escapeHtml(get_name_by_value("category", $category)) . "\" disabled=\"disabled\" />\n";
        echo "<br />\n";
        echo $escaper->escapeHtml($lang['Team']) .": \n";
        echo "<br />\n";
        echo "<input style=\"cursor: default;\" type=\"text\" name=\"team\" id=\"team\" size=\"50\" value=\"" . $escaper->escapeHtml(get_name_by_value("team", $team)) . "\" title=\"" . $escaper->escapeHtml(get_name_by_value("team", $team)) . "\" disabled=\"disabled\" />\n";
        echo "<br />\n";
        echo $escaper->escapeHtml($lang['Technology']) .": \n";
        echo "<br />\n";
        echo "<input style=\"cursor: default;\" type=\"text\" name=\"technology\" id=\"technology\" size=\"50\" value=\"" . $escaper->escapeHtml(get_name_by_value("technology", $technology)) . "\" title=\"" . $escaper->escapeHtml(get_name_by_value("technology", $technology)) . "\" disabled=\"disabled\" />\n";
        echo "<br />\n";
        echo $escaper->escapeHtml($lang['Owner']) .": \n";
        echo "<br />\n";
        echo "<input style=\"cursor: default;\" type=\"text\" name=\"owner\" id=\"owner\" size=\"50\" value=\"" . $escaper->escapeHtml(get_name_by_value("user", $owner)) . "\" title=\"" . $escaper->escapeHtml(get_name_by_value("user", $owner)) . "\" disabled=\"disabled\" />\n";
        echo "<br />\n";
        echo $escaper->escapeHtml($lang['OwnersManager']) .": \n";
        echo "<br />\n";
        echo "<input style=\"cursor: default;\" type=\"text\" name=\"manager\" id=\"manager\" size=\"50\" value=\"" . $escaper->escapeHtml(get_name_by_value("user", $manager)) . "\" title=\"" . $escaper->escapeHtml(get_name_by_value("user", $manager)) . "\" disabled=\"disabled\" />\n";
        echo "<br />\n";
        echo $escaper->escapeHtml($lang['RiskAssessment']) .": \n";
	echo "<br />\n";
        echo "<textarea style=\"cursor: default;\" name=\"assessment\" cols=\"50\" rows=\"3\" id=\"assessment\" title=\"" . $escaper->escapeHtml($assessment) . "\" disabled=\"disabled\">" . $escaper->escapeHtml($assessment) . "</textarea>\n";
	echo "<br />\n";
        echo $escaper->escapeHtml($lang['AdditionalNotes']) .": \n";
	echo "<br />\n";
        echo "<textarea style=\"cursor: default;\" name=\"notes\" cols=\"50\" rows=\"3\" id=\"notes\" title=\"" . $escaper->escapeHtml($notes) . "\" disabled=\"disabled\">" . $escaper->escapeHtml($notes) . "</textarea>\n";
	echo "<br />\n";
	echo $escaper->escapeHtml($lang['AffectedAssets']) .": \n";
	echo "<br />\n";
	echo "<input style=\"cursor: default;\" type=\"text\" name=\"assets\" id=\"assets\" size=\"50\" value=\"" . $escaper->escapeHtml(get_list_of_assets($id, false)) . "\" title=\"" . $escaper->escapeHtml(get_list_of_assets($id, false)) . "\" disabled=\"disabled\" />\n";
	echo "<br />\n";
	echo $escaper->escapeHtml($lang['SupportingDocumentation']) . ": \n";
	echo "<br />\n";
	supporting_documentation($id, "view");

	// If the page is the view.php page
	if (basename($_SERVER['PHP_SELF']) == "view.php")
	{
		// Give the option to edit the risk details
        	echo "<div class=\"form-actions\">\n";
        	echo "<button type=\"submit\" name=\"edit_details\" class=\"btn btn-primary\">". $escaper->escapeHtml($lang['EditDetails']) ."</button>\n";
        	echo "</div>\n";
	}
}

/*************************************
 * FUNCTION: VIEW PRINT RISK DETAILS *
 *************************************/
function view_print_risk_details($id, $submission_date, $subject, $reference_id, $regulation, $control_number, $location, $category, $team, $technology, $owner, $manager, $assessment, $notes)
{
        global $lang;
        global $escaper;

        echo "<h4>" . $escaper->escapeHtml($lang['Details']) . "</h4>\n";
	echo "<table border=\"1\" width=\"100%\" cellspacing=\"10\" cellpadding=\"10\">\n";

	echo "<tr>\n";
        echo "<td width=\"200\"><b>" . $escaper->escapeHtml($lang['SubmissionDate']) . ":</td>\n";
	echo "<td>" . $escaper->escapeHtml($submission_date) . "</td>\n";
	echo "</tr>\n";

	echo "<tr>\n";
	echo "<td width=\"200\"><b>" . $escaper->escapeHtml($lang['Subject']) . ":</td>\n";
	echo "<td>" . $escaper->escapeHtml($subject) . "</td>\n";
	echo "</tr>\n";

        echo "<tr>\n";
        echo "<td width=\"200\"><b>" . $escaper->escapeHtml($lang['ExternalReferenceId']) . ":</td>\n";
        echo "<td>" . $escaper->escapeHtml($reference_id) . "</td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td width=\"200\"><b>" . $escaper->escapeHtml($lang['ControlRegulation']) . ":</td>\n";
        echo "<td>" . $escaper->escapeHtml(get_name_by_value("regulation", $regulation)) . "</td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td width=\"200\"><b>" . $escaper->escapeHtml($lang['ControlNumber']) . ":</td>\n";
        echo "<td>" . $escaper->escapeHtml($control_number) . "</td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td width=\"200\"><b>" . $escaper->escapeHtml($lang['SiteLocation']) . ":</td>\n";
        echo "<td>" . $escaper->escapeHtml(get_name_by_value("location", $location)) . "</td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td width=\"200\"><b>" . $escaper->escapeHtml($lang['Category']) . ":</td>\n";
        echo "<td>" . $escaper->escapeHtml(get_name_by_value("category", $category)) . "</td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td width=\"200\"><b>" . $escaper->escapeHtml($lang['Team']) . ":</td>\n";
        echo "<td>" . $escaper->escapeHtml(get_name_by_value("team", $team)) . "</td>\n";
        echo "</tr>\n";

	echo "<tr>\n";
        echo "<td width=\"200\"><b>" . $escaper->escapeHtml($lang['Technology']) . ":</td>\n";
	echo "<td>" . $escaper->escapeHtml(get_name_by_value("technology", $technology)) . "</td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td width=\"200\"><b>" . $escaper->escapeHtml($lang['Owner']) . ":</td>\n";
        echo "<td>" . $escaper->escapeHtml(get_name_by_value("user", $owner)) . "</td>\n";
        echo "</tr>\n";
	
        echo "<tr>\n";
        echo "<td width=\"200\"><b>" . $escaper->escapeHtml($lang['OwnersManager']) . ":</td>\n";
        echo "<td>" . $escaper->escapeHtml(get_name_by_value("user", $manager)) . "</td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td width=\"200\"><b>" . $escaper->escapeHtml($lang['RiskAssessment']) . ":</td>\n";
        echo "<td>" . $escaper->escapeHtml($assessment) . "</td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td width=\"200\"><b>" . $escaper->escapeHtml($lang['AdditionalNotes']) . ":</td>\n";
        echo "<td>" . $escaper->escapeHtml($notes) . "</td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td width=\"200\"><b>" . $escaper->escapeHtml($lang['AffectedAssets']) . ":</td>\n";
	echo "<td>" . $escaper->escapeHtml(get_list_of_assets($id, false)) . "</td>\n";
	echo "</tr>\n";

	echo "</table>\n";
}

/*******************************
 * FUNCTION: EDIT RISK DETAILS *
 *******************************/
function edit_risk_details($id, $submission_date, $subject, $reference_id, $regulation, $control_number, $location, $category, $team, $technology, $owner, $manager, $assessment, $notes, $CLASSIC_likelihood, $CLASSIC_impact, $AccessVector, $AccessComplexity, $Authentication, $ConfImpact, $IntegImpact, $AvailImpact, $Exploitability, $RemediationLevel, $ReportConfidence, $CollateralDamagePotential, $TargetDistribution, $ConfidentialityRequirement, $IntegrityRequirement, $AvailabilityRequirement, $DREADDamagePotential, $DREADReproducibility, $DREADExploitability, $DREADAffectedUsers, $DREADDiscoverability, $OWASPSkillLevel, $OWASPMotive, $OWASPOpportunity, $OWASPSize, $OWASPEaseOfDiscovery, $OWASPEaseOfExploit, $OWASPAwareness, $OWASPIntrusionDetection, $OWASPLossOfConfidentiality, $OWASPLossOfIntegrity, $OWASPLossOfAvailability, $OWASPLossOfAccountability, $OWASPFinancialDamage, $OWASPReputationDamage, $OWASPNonCompliance, $OWASPPrivacyViolation, $custom, $assessment, $notes)
{
	global $lang;
	global $escaper;
	
	echo "<h4>". $escaper->escapeHtml($lang['Details']) ."</h4>\n";
        echo $escaper->escapeHtml($lang['SubmissionDate']) .": \n";
	echo "<br />\n";
        echo "<input style=\"cursor: default;\" type=\"text\" name=\"submission_date\" id=\"submission_date\" size=\"50\" value=\"" . $escaper->escapeHtml($submission_date) . "\" title=\"" . $escaper->escapeHtml($submission_date) . "\" disabled=\"disabled\" />\n";
        echo "<br />\n";
        echo $escaper->escapeHtml($lang['Subject']) .": \n";
	echo "<br />\n";
	echo "<input type=\"text\" name=\"subject\" id=\"subject\" size=\"50\" value=\"" . $escaper->escapeHtml($subject) . "\" />\n";
        echo "<br />\n";
        echo $escaper->escapeHtml($lang['ExternalReferenceId']) .": \n";
	echo "<br />\n";
	echo "<input type=\"text\" name=\"reference_id\" id=\"reference_id\" size=\"20\" value=\"" . $escaper->escapeHtml($reference_id) . "\" />\n";
        echo "<br />\n";
        echo $escaper->escapeHtml($lang['ControlRegulation']) .": \n";
	echo "<br />\n";
        create_dropdown("regulation", $regulation);
        echo "<br />\n";
        echo $escaper->escapeHtml($lang['ControlNumber']) .": \n";
	echo "<br />\n";
	echo "<input type=\"text\" name=\"control_number\" id=\"control_number\" size=\"20\" value=\"" . $escaper->escapeHtml($control_number) . "\" />\n";
        echo "<br />\n";
        echo $escaper->escapeHtml($lang['SiteLocation']) .": \n";
        echo "<br />\n";
        create_dropdown("location", $location);
        echo "<br />\n";
        echo $escaper->escapeHtml($lang['Category']) .": \n";
        echo "<br />\n";
        create_dropdown("category", $category);
        echo "<br />\n";
        echo $escaper->escapeHtml($lang['Team']) .": \n";
        echo "<br />\n";
        create_dropdown("team", $team);
        echo "<br />\n";
        echo $escaper->escapeHtml($lang['Technology']) .": \n";
        echo "<br />\n";
        create_dropdown("technology", $technology);
        echo "<br />\n";
        echo $escaper->escapeHtml($lang['Owner']) .": \n";
        echo "<br />\n";
        create_dropdown("user", $owner, "owner");
        echo "<br />\n";
        echo $escaper->escapeHtml($lang['OwnersManager']) .": \n";
        echo "<br />\n";
        create_dropdown("user", $manager, "manager");
        echo "<br />\n";
        echo $escaper->escapeHtml($lang['RiskAssessment']) .": \n";
        echo "<br />\n";
        echo "<textarea name=\"assessment\" cols=\"50\" rows=\"3\" id=\"assessment\">" . $escaper->escapeHtml($assessment) . "</textarea>\n";
	echo "<br />\n";
        echo $escaper->escapeHtml($lang['AdditionalNotes']) .": \n";
        echo "<br />\n";
        echo "<textarea name=\"notes\" cols=\"50\" rows=\"3\" id=\"notes\">" . $escaper->escapeHtml($notes) . "</textarea>\n";
        echo "<br />\n";
	echo $escaper->escapeHtml($lang['AffectedAssets']) .": \n";
	echo "<br />\n";
	echo "<div class=\"ui-widget\"><input type=\"text\" id=\"assets\" name=\"assets\" value=\"" . $escaper->escapeHtml(get_list_of_assets($id)) . "\" /></div>\n";
	echo "<br />\n";
        echo $escaper->escapeHtml($lang['SupportingDocumentation']) . ": \n";
        echo "<br />\n";
        supporting_documentation($id, "edit");
        echo "<div class=\"form-actions\">\n";
        echo "<button type=\"submit\" name=\"update_details\" class=\"btn btn-primary\">". $escaper->escapeHtml($lang['Update']) ."</button>\n";
        echo "</div>\n";
}

/*************************************
 * FUNCTION: VIEW MITIGATION DETAILS *
 *************************************/
function view_mitigation_details($mitigation_date, $planning_strategy, $mitigation_effort, $current_solution, $security_requirements, $security_recommendations)
{
	global $lang;
	global $escaper;
	
        echo "<h4>". $escaper->escapeHtml($lang['Mitigation']) ."</h4>\n";
        echo $escaper->escapeHtml($lang['MitigationDate']) .": \n";
        echo "<br />\n";
        echo "<input style=\"cursor: default;\" type=\"text\" name=\"mitigation_date\" id=\"mitigation_date\" size=\"50\" value=\"" . $escaper->escapeHtml($mitigation_date) . "\" title=\"" . $escaper->escapeHtml($mitigation_date) . "\" disabled=\"disabled\" />\n";
        echo "<br />\n";
        echo $escaper->escapeHtml($lang['PlanningStrategy']) .": \n";
        echo "<br />\n";
        echo "<input style=\"cursor: default;\" type=\"text\" name=\"planning_strategy\" id=\"planning_strategy\" size=\"50\" value=\"" . $escaper->escapeHtml(get_name_by_value("planning_strategy", $planning_strategy)) . "\" title=\"" . $escaper->escapeHtml(get_name_by_value("planning_strategy", $planning_strategy)) . "\" disabled=\"disabled\" />\n";
        echo "<br />\n";
        echo $escaper->escapeHtml($lang['MitigationEffort']) .": \n";
        echo "<br />\n";
        echo "<input style=\"cursor: default;\" type=\"text\" name=\"mitigation_effort\" id=\"mitigation_effort\" size=\"50\" value=\"" . $escaper->escapeHtml(get_name_by_value("mitigation_effort", $mitigation_effort)) . "\" title=\"" . $escaper->escapeHtml(get_name_by_value("mitigation_effort", $mitigation_effort)) . "\" disabled=\"disabled\" />\n";
        echo "<br />\n";
        echo $escaper->escapeHtml($lang['CurrentSolution']) .": \n";
        echo "<br />\n";
        echo "<textarea style=\"cursor: default;\" name=\"current_solution\" cols=\"50\" rows=\"3\" id=\"current_solution\" title=\"" . $escaper->escapeHtml($current_solution) . "\" disabled=\"disabled\">" . $escaper->escapeHtml($current_solution) . "</textarea>\n";
        echo "<br />\n";
        echo $escaper->escapeHtml($lang['SecurityRequirements']) .": \n";
        echo "<br />\n";
        echo "<textarea style=\"cursor: default;\" name=\"security_requirements\" cols=\"50\" rows=\"3\" id=\"security_requirements\" title=\"" . $escaper->escapeHtml($security_requirements) . "\" disabled=\"disabled\">" . $escaper->escapeHtml($security_requirements) . "</textarea>\n";
        echo "<br />\n";
        echo $escaper->escapeHtml($lang['SecurityRecommendations']) .": \n";
        echo "<br />\n";
        echo "<textarea style=\"cursor: default;\" name=\"security_recommendations\" cols=\"50\" rows=\"3\" id=\"security_recommendations\" title=\"" . $escaper->escapeHtml($security_recommendations) . "\" disabled=\"disabled\">" . $escaper->escapeHtml($security_recommendations) . "</textarea>\n";

        // If the page is the view.php page
        if (basename($_SERVER['PHP_SELF']) == "view.php")
        {
                // Give the option to edit the mitigation details
	        echo "<div class=\"form-actions\">\n";
        	echo "<button type=\"submit\" name=\"edit_mitigation\" class=\"btn btn-primary\">". $escaper->escapeHtml($lang['EditMitigation']) ."</button>\n";
        	echo "</div>\n";
        }
}

/*******************************************
 * FUNCTION: VIEW PRINT MITIGATION DETAILS *
 *******************************************/
function view_print_mitigation_details($mitigation_date, $planning_strategy, $mitigation_effort, $current_solution, $security_requirements, $security_recommendations)
{
        global $lang;
        global $escaper;

        echo "<h4>". $escaper->escapeHtml($lang['Mitigation']) ."</h4>\n";
        echo "<table border=\"1\" width=\"100%\" cellspacing=\"10\" cellpadding=\"10\">\n";

        echo "<tr>\n";
        echo "<td width=\"200\"><b>" . $escaper->escapeHtml($lang['MitigationDate']) . ":</td>\n";
        echo "<td>" . $escaper->escapeHtml($mitigation_date) . "</td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td width=\"200\"><b>" . $escaper->escapeHtml($lang['PlanningStrategy']) . ":</td>\n";
        echo "<td>" . $escaper->escapeHtml(get_name_by_value("planning_strategy", $planning_strategy)) . "</td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td width=\"200\"><b>" . $escaper->escapeHtml($lang['MitigationEffort']) . ":</td>\n";
        echo "<td>" . $escaper->escapeHtml(get_name_by_value("mitigation_effort", $mitigation_effort)) . "</td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td width=\"200\"><b>" . $escaper->escapeHtml($lang['CurrentSolution']) . ":</td>\n";
        echo "<td>" . $escaper->escapeHtml($current_solution) . "</td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td width=\"200\"><b>" . $escaper->escapeHtml($lang['SecurityRequirements']) . ":</td>\n";
        echo "<td>" . $escaper->escapeHtml($security_requirements) . "</td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td width=\"200\"><b>" . $escaper->escapeHtml($lang['SecurityRecommendations']) . ":</td>\n";
        echo "<td>" . $escaper->escapeHtml($security_recommendations) . "</td>\n";
        echo "</tr>\n";

	echo "</table>\n";
}

/*************************************
 * FUNCTION: EDIT MITIGATION DETAILS *
 *************************************/
function edit_mitigation_details($mitigation_date, $planning_strategy, $mitigation_effort, $current_solution, $security_requirements, $security_recommendations)
{
	global $lang;
	global $escaper;
	
	echo "<h4>". $escaper->escapeHtml($lang['Mitigation']) ."</h4>\n";
        echo $escaper->escapeHtml($lang['MitigationDate']) .": \n";
	echo "<br />\n";
        echo "<input style=\"cursor: default;\" type=\"text\" name=\"mitigation_date\" id=\"mitigation_date\" size=\"50\" value=\"" . $escaper->escapeHtml($mitigation_date) . "\" title=\"" . $escaper->escapeHtml($mitigation_date) . "\" disabled=\"disabled\" />\n";
        echo "<br />\n";
        echo $escaper->escapeHtml($lang['PlanningStrategy']) .": \n";
        echo "<br />\n";
        create_dropdown("planning_strategy", $planning_strategy);
        echo "<br />\n";
        echo $escaper->escapeHtml($lang['MitigationEffort']) .": \n";
        echo "<br />\n";
        create_dropdown("mitigation_effort", $mitigation_effort);
        echo "<br />\n";
        echo $escaper->escapeHtml($lang['CurrentSolution']) .": \n";
        echo "<br />\n";
        echo "<textarea name=\"current_solution\" cols=\"50\" rows=\"3\" id=\"current_solution\">" . $escaper->escapeHtml($current_solution) . "</textarea>\n";
	echo "<br />\n";
        echo $escaper->escapeHtml($lang['SecurityRequirements']) .": \n";
        echo "<br />\n";
        echo "<textarea name=\"security_requirements\" cols=\"50\" rows=\"3\" id=\"security_requirements\">" . $escaper->escapeHtml($security_requirements) . "</textarea>\n";
	echo "<br />\n";
        echo $escaper->escapeHtml($lang['SecurityRecommendations']) .": \n";
        echo "<br />\n";
        echo "<textarea name=\"security_recommendations\" cols=\"50\" rows=\"3\" id=\"security_recommendations\">" . $escaper->escapeHtml($security_recommendations) . "</textarea>\n";
        echo "<div class=\"form-actions\">\n";
        echo "<button type=\"submit\" name=\"update_mitigation\" class=\"btn btn-primary\">". $escaper->escapeHtml($lang['Update']) ."</button>\n";
        echo "</div>\n";
}

/*********************************
 * FUNCTION: view_review_details *
 *********************************/
function view_review_details($id, $review_date, $reviewer, $review, $next_step, $next_review, $comments)
{
	global $lang;
	global $escaper;
	
	echo "<h4>". $escaper->escapeHtml($lang['LastReview']) ."</h4>\n";
        echo $escaper->escapeHtml($lang['ReviewDate']) .": \n";
        echo "<br />\n";
        echo "<input style=\"cursor: default;\" type=\"text\" name=\"review_date\" id=\"review_date\" size=\"50\" value=\"" . $escaper->escapeHtml($review_date) . "\" title=\"" . $escaper->escapeHtml($review_date) . "\" disabled=\"disabled\" />\n";
        echo "<br />\n";
        echo $escaper->escapeHtml($lang['Reviewer']) .": \n";
        echo "<br />\n";
        echo "<input style=\"cursor: default;\" type=\"text\" name=\"reviewer\" id=\"reviewer\" size=\"50\" value=\"" . $escaper->escapeHtml(get_name_by_value("user", $reviewer)) . "\" title=\"" . $escaper->escapeHtml(get_name_by_value("user", $reviewer)) . "\" disabled=\"disabled\" />\n";
        echo "<br />\n";
        echo $escaper->escapeHtml($lang['Review']) .": \n";
        echo "<br />\n";
        echo "<input style=\"cursor: default;\" type=\"text\" name=\"review\" id=\"review\" size=\"50\" value=\"" . $escaper->escapeHtml(get_name_by_value("review", $review)) . "\" title=\"" . $escaper->escapeHtml(get_name_by_value("review", $review)) . "\" disabled=\"disabled\" />\n";
        echo "<br />\n";
        echo $escaper->escapeHtml($lang['NextStep']) .": \n";
        echo "<br />\n";
        echo "<input style=\"cursor: default;\" type=\"text\" name=\"next_step\" id=\"next_step\" size=\"50\" value=\"" . $escaper->escapeHtml(get_name_by_value("next_step", $next_step)) . "\" title=\"" . $escaper->escapeHtml(get_name_by_value("next_step", $next_step)) . "\" disabled=\"disabled\" />\n";
	echo "<br />\n";
	echo $escaper->escapeHtml($lang['NextReviewDate']) .": \n";
	echo "<br />\n";
	echo "<input style=\"cursor: default;\" type=\"text\" name=\"next_review\" id=\"next_review\" size=\"50\" value=\"" . $escaper->escapeHtml($next_review) . "\" title=\"" . $escaper->escapeHtml($next_review) . "\" disabled=\"disabled\" />\n";
        echo "<br />\n";
        echo $escaper->escapeHtml($lang['Comments']) .": \n";
        echo "<br />\n";
        echo "<textarea style=\"cursor: default;\" name=\"comments\" cols=\"50\" rows=\"3\" id=\"comments\" title=\"" . $escaper->escapeHtml($comments) . "\" disabled=\"disabled\">" . $escaper->escapeHtml($comments) . "</textarea>\n";
        echo "<p><a href=\"reviews.php?id=". $escaper->escapeHtml($id) ."\">". $escaper->escapeHtml($lang['ViewAllReviews']) ."</a></p>";
}

/***************************************
 * FUNCTION: VIEW PRINT REVIEW DETAILS *
 ***************************************/
function view_print_review_details($id, $review_date, $reviewer, $review, $next_step, $next_review, $comments)
{
        global $lang;
        global $escaper;

        echo "<h4>". $escaper->escapeHtml($lang['LastReview']) ."</h4>\n";
        echo "<table border=\"1\" width=\"100%\" cellspacing=\"10\" cellpadding=\"10\">\n";

        echo "<tr>\n";
        echo "<td width=\"200\"><b>" . $escaper->escapeHtml($lang['ReviewDate']) . ":</td>\n";
        echo "<td>" . $escaper->escapeHtml($review_date) . "</td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
	echo "<td width=\"200\"><b>" . $escaper->escapeHtml($lang['Reviewer']) . ":</td>\n";
        echo "<td>" . $escaper->escapeHtml(get_name_by_value("user", $reviewer)) . "</td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
	echo "<td width=\"200\"><b>" . $escaper->escapeHtml($lang['Review']) . ":</td>\n";
        echo "<td>" . $escaper->escapeHtml(get_name_by_value("review", $review)) . "</td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
	echo "<td width=\"200\"><b>" . $escaper->escapeHtml($lang['NextStep']) . ":</td>\n";
        echo "<td>" . $escaper->escapeHtml(get_name_by_value("next_step", $next_step)) . "</td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td width=\"200\"><b>" . $escaper->escapeHtml($lang['NextReviewDate']) . ":</td>\n";
	echo "<td>" . $escaper->escapeHtml($next_review) . "</td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
	echo "<td width=\"200\"><b>" . $escaper->escapeHtml($lang['Comments']) . ":</td>\n";
	echo "<td>" . $escaper->escapeHtml($comments) . "</td>\n";
	echo "</tr>\n";

	echo "</table>\n";
}

/****************************************
 * FUNCTION: edit_mitigation_submission *
 ****************************************/
function edit_mitigation_submission($planning_strategy, $mitigation_effort, $current_solution, $security_requirements, $security_recommendations)
{
	global $lang;
	global $escaper;
	
	echo "<h4>". $escaper->escapeHtml($lang['SubmitRiskMitigation']) ."</h4>\n";
        echo "<form name=\"submit_mitigation\" method=\"post\" action=\"\">\n";
	
        echo $escaper->escapeHtml($lang['PlanningStrategy']) .": \n";
        echo "<br />\n";
	create_dropdown("planning_strategy", $planning_strategy, NULL, true);
        echo "<br />\n";
        echo $escaper->escapeHtml($lang['MitigationEffort']) .": \n";
        echo "<br />\n";
	create_dropdown("mitigation_effort", $mitigation_effort, NULL, true);
        echo "<br />\n";
        echo $escaper->escapeHtml($lang['CurrentSolution']) .": \n";
        echo "<br />\n";
        echo "<textarea name=\"current_solution\" cols=\"50\" rows=\"3\" id=\"current_solution\">" . $escaper->escapeHtml($current_solution) . "</textarea>\n";
        echo "<br />\n";
        echo $escaper->escapeHtml($lang['SecurityRequirements']) .": \n";
        echo "<br />\n";
        echo "<textarea name=\"security_requirements\" cols=\"50\" rows=\"3\" id=\"security_requirements\">" . $escaper->escapeHtml($security_requirements) . "</textarea>\n";
        echo "<br />\n";
        echo $escaper->escapeHtml($lang['SecurityRecommendations']) .": \n";
        echo "<br />\n";
        echo "<textarea name=\"security_recommendations\" cols=\"50\" rows=\"3\" id=\"security_recommendations\">" . $escaper->escapeHtml($security_recommendations) . "</textarea>\n";
        echo "<br />\n";
        echo "<div class=\"form-actions\">\n";
        echo "<button type=\"submit\" name=\"submit\" class=\"btn btn-primary\">". $escaper->escapeHtml($lang['Submit']) ."</button>\n";
        echo "<input class=\"btn\" value=\"". $lang['Reset'] ."\" type=\"reset\">\n";
        echo "</div>\n";
        echo "</form>\n";
}

/************************************
 * FUNCTION: edit_review_submission *
 ************************************/
function edit_review_submission($review, $next_step, $next_review, $comments)
{
	global $lang;
	global $escaper;
	
	echo "<h4>". $escaper->escapeHtml($lang['SubmitManagementReview']) ."</h4>\n";
        echo "<form name=\"submit_management_review\" method=\"post\" action=\"\">\n";
        echo $escaper->escapeHtml($lang['Review']) .": \n";
        echo "<br />\n";
	create_dropdown("review", $review, NULL, true);
        echo "<br />\n";
        echo $escaper->escapeHtml($lang['NextStep']) .": \n";
        echo "<br />\n";
	create_dropdown("next_step", $next_step, NULL, true);
	echo "<br />\n";
        echo $escaper->escapeHtml($lang['Comments']) .": \n";
        echo "<br />\n";
        echo "<textarea name=\"comments\" cols=\"50\" rows=\"3\" id=\"comments\">" . $escaper->escapeHtml($comments) . "</textarea>\n";
	echo "<br />\n";
	echo $escaper->escapeHtml($lang['BasedOnTheCurrentRiskScore']) . $escaper->escapeHtml($next_review) . "<br />\n";
	echo $escaper->escapeHtml($lang['WouldYouLikeToUseADifferentDate']) . "&nbsp;<input type=\"radio\" name=\"custom_date\" value=\"no\" onclick=\"hideNextReview()\" checked />&nbsp" . $escaper->escapeHtml($lang['No']) . "&nbsp;<input type=\"radio\" name=\"custom_date\" value=\"yes\" onclick=\"showNextReview()\" />&nbsp" . $escaper->escapeHtml($lang['Yes']) . "<br />\n";
	echo "<div id=\"nextreview\" style=\"display:none;\">\n";
	echo "<br />\n";
	echo $escaper->escapeHtml($lang['NextReviewDate']) .": \n";
	echo "<br />\n";
	echo "<input type=\"text\" name=\"next_review\" value=\"" . $escaper->escapeHtml($next_review) . "\" />\n";
	echo "<br />\n";
	echo "</div>\n";
        echo "<div class=\"form-actions\">\n";
        echo "<button type=\"submit\" name=\"submit\" class=\"btn btn-primary\">". $escaper->escapeHtml($lang['Submit']) ."</button>\n";
        echo "<input class=\"btn\" value=\"". $escaper->escapeHtml($lang['Reset']) ."\" type=\"reset\">\n";
        echo "</div>\n";
        echo "</form>\n";
}

/********************************
 * FUNCTION: edit_classic_score *
 ********************************/
function edit_classic_score($CLASSIC_likelihood, $CLASSIC_impact)
{
	global $lang;
	global $escaper;

	echo "<h4>" . $escaper->escapeHtml($lang['UpdateClassicScore']) . "</h4>\n";
	echo "<form name=\"update_classic\" method=\"post\" action=\"\">\n";
        echo "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" style=\"border:none;\">\n";

        echo "<tr>\n";
        echo "<td width=\"150\" height=\"10\">" . $escaper->escapeHtml($lang['CurrentLikelihood']) . ":</td>\n";
	echo "<td width=\"125\">\n";
        create_dropdown("likelihood", $CLASSIC_likelihood, NULL, false);
	echo "</td>\n";
        echo "<td width=\"50\"><img src=\"../images/helpicon.jpg\" width=\"25\" height=\"18\" align=\"absmiddle\" onClick=\"javascript:showHelp('likelihoodHelp');\"></td>\n";
        echo "<td rowspan=\"3\" style=\"vertical-align:top;\">\n";
        view_classic_help();
        echo "</td>\n";
	echo "</tr>\n";

        echo "<tr>\n";
        echo "<td width=\"150\" height=\"10\">" . $escaper->escapeHtml($lang['CurrentImpact']) . ":</td>\n";
        echo "<td width=\"125\">\n";
        create_dropdown("impact", $CLASSIC_impact, NULL, false);
        echo "</td>\n";
	echo "<td width=\"50\"><img src=\"../images/helpicon.jpg\" width=\"25\" height=\"18\" align=\"absmiddle\" onClick=\"javascript:showHelp('impactHelp');\"></td>\n";
        echo "</tr>\n";

	echo "<tr><td colspan=\"3\">&nbsp;</td></tr>\n";

	echo "</table>\n";

        echo "<div class=\"form-actions\">\n";
        echo "<button type=\"submit\" name=\"update_classic\" class=\"btn btn-primary\">" . $escaper->escapeHtml($lang['Update']) . "</button>\n";
        echo "</div>\n";
        echo "</form>\n";
}

/*****************************
 * FUNCTION: edit_cvss_score *
 *****************************/
function edit_cvss_score($AccessVector, $AccessComplexity, $Authentication, $ConfImpact, $IntegImpact, $AvailImpact, $Exploitability, $RemediationLevel, $ReportConfidence, $CollateralDamagePotential, $TargetDistribution, $ConfidentialityRequirement, $IntegrityRequirement, $AvailabilityRequirement)
{
	global $lang;
	global $escaper;

        echo "<h4>" . $escaper->escapeHtml($lang['UpdateCVSSScore']) . "</h4>\n";
        echo "<form name=\"update_cvss\" method=\"post\" action=\"\">\n";
	echo "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" style=\"border:none;\">\n";

	echo "<tr>\n";
        echo "<td colspan=\"4\"><b><u>" . $escaper->escapeHtml($lang['BaseScore']) . "</u></b></td>\n";
        echo "<td rowspan=\"19\" style=\"vertical-align:top;\">\n";
        view_cvss_help();
        echo "</td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td width=\"200\">" . $escaper->escapeHtml($lang['AttackVector']) . ":</td>\n";
        echo "<td width=\"125\">\n";
        create_cvss_dropdown("AccessVector", $AccessVector, false);
        echo "</td>\n";
	echo "<td width=\"50\"><img src=\"../images/helpicon.jpg\" width=\"25\" height=\"18\" align=\"absmiddle\" onClick=\"javascript:showHelp('AccessVectorHelp');\"></td>\n";
	echo "<td>&nbsp;</td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td width=\"150\">" . $escaper->escapeHtml($lang['AttackComplexity']) . ":</td>\n";
        echo "<td>\n";
        create_cvss_dropdown("AccessComplexity", $AccessComplexity, false);
        echo "</td>\n";
        echo "<td width=\"50\"><img src=\"../images/helpicon.jpg\" width=\"25\" height=\"18\" align=\"absmiddle\" onClick=\"javascript:showHelp('AccessComplexityHelp');\"></td>\n";
        echo "<td>&nbsp;</td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td width=\"150\">" . $escaper->escapeHtml($lang['Authentication']) . ":</td>\n";
        echo "<td>\n";
        create_cvss_dropdown("Authentication", $Authentication, false);
        echo "</td>\n";
        echo "<td width=\"50\"><img src=\"../images/helpicon.jpg\" width=\"25\" height=\"18\" align=\"absmiddle\" onClick=\"javascript:showHelp('AuthenticationHelp');\"></td>\n";
        echo "<td>&nbsp;</td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td width=\"150\">" . $escaper->escapeHtml($lang['ConfidentialityImpact']) . ":</td>\n";
        echo "<td>\n";
        create_cvss_dropdown("ConfImpact", $ConfImpact, false);
        echo "</td>\n";
        echo "<td width=\"50\"><img src=\"../images/helpicon.jpg\" width=\"25\" height=\"18\" align=\"absmiddle\" onClick=\"javascript:showHelp('ConfImpactHelp');\"></td>\n";
        echo "<td>&nbsp;</td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td width=\"150\">" . $escaper->escapeHtml($lang['IntegrityImpact']) . ":</td>\n";
        echo "<td>\n";
        create_cvss_dropdown("IntegImpact", $IntegImpact, false);
        echo "</td>\n";
        echo "<td width=\"50\"><img src=\"../images/helpicon.jpg\" width=\"25\" height=\"18\" align=\"absmiddle\" onClick=\"javascript:showHelp('IntegImpactHelp');\"></td>\n";
        echo "<td>&nbsp;</td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td width=\"150\">" . $escaper->escapeHtml($lang['AvailabilityImpact']) . ":</td>\n";
        echo "<td>\n";
        create_cvss_dropdown("AvailImpact", $AvailImpact, false);
        echo "</td>\n";
        echo "<td width=\"50\"><img src=\"../images/helpicon.jpg\" width=\"25\" height=\"18\" align=\"absmiddle\" onClick=\"javascript:showHelp('AvailImpactHelp');\"></td>\n";
        echo "<td>&nbsp;</td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td colspan=\"4\">&nbsp;</td>\n";
        echo "</tr>\n";

	echo "<tr>\n";
        echo "<td colspan=\"4\"><b><u>" . $escaper->escapeHtml($lang['TemporalScoreMetrics']) . "</u></b></td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td width=\"150\">" . $escaper->escapeHtml($lang['Exploitability']) . ":</td>\n";
        echo "<td>\n";
        create_cvss_dropdown("Exploitability", $Exploitability, false);
        echo "</td>\n";
        echo "<td width=\"50\"><img src=\"../images/helpicon.jpg\" width=\"25\" height=\"18\" align=\"absmiddle\" onClick=\"javascript:showHelp('ExploitabilityHelp');\"></td>\n";
        echo "<td>&nbsp;</td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td width=\"150\">" . $escaper->escapeHtml($lang['RemediationLevel']) . ":</td>\n";
        echo "<td>\n";
        create_cvss_dropdown("RemediationLevel", $RemediationLevel, false);
        echo "</td>\n";
        echo "<td width=\"50\"><img src=\"../images/helpicon.jpg\" width=\"25\" height=\"18\" align=\"absmiddle\" onClick=\"javascript:showHelp('RemediationLevelHelp');\"></td>\n";
        echo "<td>&nbsp;</td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td width=\"150\">" . $escaper->escapeHtml($lang['ReportConfidence']) . ":</td>\n";
        echo "<td>\n";
        create_cvss_dropdown("ReportConfidence", $ReportConfidence, false);
        echo "</td>\n";
        echo "<td width=\"50\"><img src=\"../images/helpicon.jpg\" width=\"25\" height=\"18\" align=\"absmiddle\" onClick=\"javascript:showHelp('ReportConfidenceHelp');\"></td>\n";
        echo "<td>&nbsp;</td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td colspan=\"4\">&nbsp;</td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td colspan=\"4\"><b><u>" . $escaper->escapeHtml($lang['EnvironmentalScoreMetrics']) . "</u></b></td>\n";
	echo "</tr>\n";

        echo "<tr>\n";
        echo "<td width=\"150\">" . $escaper->escapeHtml($lang['CollateralDamagePotential']) . ":</td>\n";
        echo "<td>\n";
        create_cvss_dropdown("CollateralDamagePotential", $CollateralDamagePotential, false);
        echo "</td>\n";
        echo "<td width=\"50\"><img src=\"../images/helpicon.jpg\" width=\"25\" height=\"18\" align=\"absmiddle\" onClick=\"javascript:showHelp('CollateralDamagePotentialHelp');\"></td>\n";
        echo "<td>&nbsp;</td>\n";
	echo "</tr>\n";

        echo "<tr>\n";
        echo "<td width=\"150\">" . $escaper->escapeHtml($lang['TargetDistribution']) . ":</td>\n";
        echo "<td>\n";
	create_cvss_dropdown("TargetDistribution", $TargetDistribution, false);
        echo "</td>\n";
        echo "<td width=\"50\"><img src=\"../images/helpicon.jpg\" width=\"25\" height=\"18\" align=\"absmiddle\" onClick=\"javascript:showHelp('TargetDistributionHelp');\"></td>\n";
        echo "<td>&nbsp;</td>\n";
	echo "</tr>\n";

        echo "<tr>\n";
        echo "<td width=\"150\">" . $escaper->escapeHtml($lang['ConfidentialityRequirement']) . ":</td>\n";
        echo "<td>\n";
	create_cvss_dropdown("ConfidentialityRequirement", $ConfidentialityRequirement, false);
        echo "</td>\n";
        echo "<td width=\"50\"><img src=\"../images/helpicon.jpg\" width=\"25\" height=\"18\" align=\"absmiddle\" onClick=\"javascript:showHelp('ConfidentialityRequirementHelp');\"></td>\n";
        echo "<td>&nbsp;</td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td width=\"150\">" . $escaper->escapeHtml($lang['IntegrityRequirement']) . ":</td>\n";
        echo "<td>\n";
	create_cvss_dropdown("IntegrityRequirement", $IntegrityRequirement, false);
        echo "</td>\n";
        echo "<td width=\"50\"><img src=\"../images/helpicon.jpg\" width=\"25\" height=\"18\" align=\"absmiddle\" onClick=\"javascript:showHelp('IntegrityRequirementHelp');\"></td>\n";
        echo "<td>&nbsp;</td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td width=\"150\">" . $escaper->escapeHtml($lang['AvailabilityRequirement']) . ":</td>\n";
        echo "<td>\n";
	create_cvss_dropdown("AvailabilityRequirement", $AvailabilityRequirement, false);
        echo "</td>\n";
        echo "<td width=\"50\"><img src=\"../images/helpicon.jpg\" width=\"25\" height=\"18\" align=\"absmiddle\" onClick=\"javascript:showHelp('AvailabilityRequirementHelp');\"></td>\n";
        echo "<td>&nbsp;</td>\n";
        echo "</tr>\n";

	echo "</table>\n";

        echo "<div class=\"form-actions\">\n";
        echo "<button type=\"submit\" name=\"update_cvss\" class=\"btn btn-primary\">" . $escaper->escapeHtml($lang['Update']) . "</button>\n";
        echo "</div>\n";
        echo "</form>\n";
}

/******************************
 * FUNCTION: edit_dread_score *
 ******************************/
function edit_dread_score($DamagePotential, $Reproducibility, $Exploitability, $AffectedUsers, $Discoverability)
{
	global $lang;
	global $escaper;

        echo "<h4>" . $escaper->escapeHtml($lang['UpdateDREADScore']) . "</h4>\n";
        echo "<form name=\"update_dread\" method=\"post\" action=\"\">\n";
        echo "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" style=\"border:none;\">\n";

        echo "<tr>\n";
        echo "<td width=\"150\">" . $escaper->escapeHtml($lang['DamagePotential']) . ":</td>\n";
        echo "<td width=\"75\">\n";
	create_numeric_dropdown("DamagePotential", $DamagePotential, false);
        echo "</td>\n";
	echo "<td width=\"50\"><img src=\"../images/helpicon.jpg\" width=\"25\" height=\"18\" align=\"absmiddle\" onClick=\"javascript:showHelp('DamagePotentialHelp');\"></td>\n";
	echo "<td rowspan=\"5\" style=\"vertical-align:top;\">\n";
	view_dread_help();
	echo "</td>\n";
	echo "</tr>\n";

	echo "<tr>\n";
        echo "<td width=\"150\">" . $escaper->escapeHtml($lang['Reproducibility']) . ":</td>\n";
        echo "<td width=\"75\">\n";
	create_numeric_dropdown("Reproducibility", $Reproducibility, false);
        echo "</td>\n";
        echo "<td width=\"50\"><img src=\"../images/helpicon.jpg\" width=\"25\" height=\"18\" align=\"absmiddle\" onClick=\"javascript:showHelp('ReproducibilityHelp');\"></td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td width=\"150\">" . $escaper->escapeHtml($lang['Exploitability']) . ":</td>\n";
        echo "<td width=\"75\">\n";
        create_numeric_dropdown("Exploitability", $Exploitability, false);
        echo "</td>\n";
        echo "<td width=\"50\"><img src=\"../images/helpicon.jpg\" width=\"25\" height=\"18\" align=\"absmiddle\" onClick=\"javascript:showHelp('ExploitabilityHelp');\"></td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td width=\"150\">" . $escaper->escapeHtml($lang['AffectedUsers']) . ":</td>\n";
        echo "<td width=\"75\">\n";
	create_numeric_dropdown("AffectedUsers", $AffectedUsers, false);
        echo "</td>\n";
        echo "<td width=\"50\"><img src=\"../images/helpicon.jpg\" width=\"25\" height=\"18\" align=\"absmiddle\" onClick=\"javascript:showHelp('AffectedUsersHelp');\"></td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td width=\"150\">" . $escaper->escapeHtml($lang['Discoverability']) . ":</td>\n";
        echo "<td width=\"75\">\n";
        create_numeric_dropdown("Discoverability", $Discoverability, false);
        echo "</td>\n";
        echo "<td width=\"50\"><img src=\"../images/helpicon.jpg\" width=\"25\" height=\"18\" align=\"absmiddle\" onClick=\"javascript:showHelp('DiscoverabilityHelp');\"></td>\n";
        echo "</tr>\n";

        echo "</table>\n";

        echo "<div class=\"form-actions\">\n";
        echo "<button type=\"submit\" name=\"update_dread\" class=\"btn btn-primary\">" . $escaper->escapeHtml($lang['Update']) . "</button>\n";
        echo "</div>\n";
        echo "</form>\n";
}

/******************************
 * FUNCTION: edit_owasp_score *
 ******************************/
function edit_owasp_score($OWASPSkillLevel, $OWASPMotive, $OWASPOpportunity, $OWASPSize, $OWASPEaseOfDiscovery, $OWASPEaseOfExploit, $OWASPAwareness, $OWASPIntrusionDetection, $OWASPLossOfConfidentiality, $OWASPLossOfIntegrity, $OWASPLossOfAvailability, $OWASPLossOfAccountability, $OWASPFinancialDamage, $OWASPReputationDamage, $OWASPNonCompliance, $OWASPPrivacyViolation)
{
	global $lang;
	global $escaper;

	echo "<h4>" . $escaper->escapeHtml($lang['UpdateOWASPScore']) . "</h4>\n";
        echo "<form name=\"update_owasp\" method=\"post\" action=\"\">\n";
        echo "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" style=\"border:none;\">\n";

        echo "<tr>\n";
        echo "<td colspan=\"4\"><b><u>" . $escaper->escapeHtml($lang['ThreatAgentFactors']) . "</u></b></td>\n";
        echo "<td rowspan=\"20\" style=\"vertical-align:top;\">\n";
        view_owasp_help();
        echo "</td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td width=\"175\">" . $escaper->escapeHtml($lang['SkillLevel']) . ":</td>\n";
        echo "<td width=\"75\">\n";
	create_numeric_dropdown("SkillLevel", $OWASPSkillLevel, false);
        echo "</td>\n";
        echo "<td width=\"50\"><img src=\"../images/helpicon.jpg\" width=\"25\" height=\"18\" align=\"absmiddle\" onClick=\"javascript:showHelp('SkillLevelHelp');\"></td>\n";
        echo "<td>&nbsp;</td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td width=\"175\">" . $escaper->escapeHtml($lang['Motive']) . ":</td>\n";
        echo "<td width=\"75\">\n";
        create_numeric_dropdown("Motive", $OWASPMotive, false);
        echo "</td>\n";
        echo "<td width=\"50\"><img src=\"../images/helpicon.jpg\" width=\"25\" height=\"18\" align=\"absmiddle\" onClick=\"javascript:showHelp('MotiveHelp');\"></td>\n";
        echo "<td>&nbsp;</td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td width=\"175\">" . $escaper->escapeHtml($lang['Opportunity']) . ":</td>\n";
        echo "<td width=\"75\">\n";
        create_numeric_dropdown("Opportunity", $OWASPOpportunity, false);
        echo "</td>\n";
        echo "<td width=\"50\"><img src=\"../images/helpicon.jpg\" width=\"25\" height=\"18\" align=\"absmiddle\" onClick=\"javascript:showHelp('OpportunityHelp');\"></td>\n";
        echo "<td>&nbsp;</td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td width=\"175\">" . $escaper->escapeHtml($lang['Size']) . ":</td>\n";
        echo "<td width=\"75\">\n";
        create_numeric_dropdown("Size", $OWASPSize, false);
        echo "</td>\n";
        echo "<td width=\"50\"><img src=\"../images/helpicon.jpg\" width=\"25\" height=\"18\" align=\"absmiddle\" onClick=\"javascript:showHelp('SizeHelp');\"></td>\n";
        echo "<td>&nbsp;</td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td colspan=\"4\">&nbsp;</td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td colspan=\"4\"><b><u>" . $escaper->escapeHtml($lang['VulnerabilityFactors']) . "</u></b></td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td width=\"175\">" . $escaper->escapeHtml($lang['EaseOfDiscovery']) . ":</td>\n";
        echo "<td width=\"75\">\n";
	create_numeric_dropdown("EaseOfDiscovery", $OWASPEaseOfDiscovery, false);
        echo "</td>\n";
        echo "<td width=\"50\"><img src=\"../images/helpicon.jpg\" width=\"25\" height=\"18\" align=\"absmiddle\" onClick=\"javascript:showHelp('EaseOfDiscoveryHelp');\"></td>\n";
        echo "<td>&nbsp;</td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td width=\"175\">" . $escaper->escapeHtml($lang['EaseOfExploit']) . ":</td>\n";
        echo "<td width=\"75\">\n";
        create_numeric_dropdown("EaseOfExploit", $OWASPEaseOfExploit, false);
        echo "</td>\n";
        echo "<td width=\"50\"><img src=\"../images/helpicon.jpg\" width=\"25\" height=\"18\" align=\"absmiddle\" onClick=\"javascript:showHelp('EaseOfExploitHelp');\"></td>\n";
        echo "<td>&nbsp;</td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td width=\"175\">" . $escaper->escapeHtml($lang['Awareness']) . ":</td>\n";
        echo "<td width=\"75\">\n";
        create_numeric_dropdown("Awareness", $OWASPAwareness, false);
        echo "</td>\n";
        echo "<td width=\"50\"><img src=\"../images/helpicon.jpg\" width=\"25\" height=\"18\" align=\"absmiddle\" onClick=\"javascript:showHelp('AwarenessHelp');\"></td>\n";
        echo "<td>&nbsp;</td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td width=\"175\">" . $escaper->escapeHtml($lang['IntrusionDetection']) . ":</td>\n";
        echo "<td width=\"75\">\n";
        create_numeric_dropdown("IntrusionDetection", $OWASPIntrusionDetection, false);
        echo "</td>\n";
        echo "<td width=\"50\"><img src=\"../images/helpicon.jpg\" width=\"25\" height=\"18\" align=\"absmiddle\" onClick=\"javascript:showHelp('IntrusionDetectionHelp');\"></td>\n";
        echo "<td>&nbsp;</td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td colspan=\"4\">&nbsp;</td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td colspan=\"4\"><b><u>" . $escaper->escapeHtml($lang['TechnicalImpact']) . "</u></b></td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td width=\"175\">" . $escaper->escapeHtml($lang['LossOfConfidentiality']) . ":</td>\n";
        echo "<td width=\"75\">\n";
	create_numeric_dropdown("LossOfConfidentiality", $OWASPLossOfConfidentiality, false);
        echo "</td>\n";
        echo "<td width=\"50\"><img src=\"../images/helpicon.jpg\" width=\"25\" height=\"18\" align=\"absmiddle\" onClick=\"javascript:showHelp('EaseOfDiscoveryHelp');\"></td>\n";
        echo "<td>&nbsp;</td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td width=\"175\">" . $escaper->escapeHtml($lang['LossOfIntegrity']) . ":</td>\n";
        echo "<td width=\"75\">\n";
        create_numeric_dropdown("LossOfIntegrity", $OWASPLossOfIntegrity, false);
        echo "</td>\n";
        echo "<td width=\"50\"><img src=\"../images/helpicon.jpg\" width=\"25\" height=\"18\" align=\"absmiddle\" onClick=\"javascript:showHelp('LossOfIntegrityHelp');\"></td>\n";
        echo "<td>&nbsp;</td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td width=\"175\">" . $escaper->escapeHtml($lang['LossOfAvailability']) . ":</td>\n";
        echo "<td width=\"75\">\n";
        create_numeric_dropdown("LossOfAvailability", $OWASPLossOfAvailability, false);
        echo "</td>\n";
        echo "<td width=\"50\"><img src=\"../images/helpicon.jpg\" width=\"25\" height=\"18\" align=\"absmiddle\" onClick=\"javascript:showHelp('LossOfAvailabilityHelp');\"></td>\n";
        echo "<td>&nbsp;</td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td width=\"175\">" . $escaper->escapeHtml($lang['LossOfAccountability']) . ":</td>\n";
        echo "<td width=\"75\">\n";
        create_numeric_dropdown("LossOfAccountability", $OWASPLossOfAccountability, false);
        echo "</td>\n";
        echo "<td width=\"50\"><img src=\"../images/helpicon.jpg\" width=\"25\" height=\"18\" align=\"absmiddle\" onClick=\"javascript:showHelp('LossOfAccountabilityHelp');\"></td>\n";
        echo "<td>&nbsp;</td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td colspan=\"4\">&nbsp;</td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td colspan=\"4\"><b><u>" . $escaper->escapeHtml($lang['BusinessImpact']) . "</u></b></td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td width=\"175\">" . $escaper->escapeHtml($lang['FinancialDamage']) . ":</td>\n";
        echo "<td width=\"75\">\n";
	create_numeric_dropdown("FinancialDamage", $OWASPFinancialDamage, false);
        echo "</td>\n";
        echo "<td width=\"50\"><img src=\"../images/helpicon.jpg\" width=\"25\" height=\"18\" align=\"absmiddle\" onClick=\"javascript:showHelp('EaseOfDiscoveryHelp');\"></td>\n";
        echo "<td>&nbsp;</td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td width=\"175\">" . $escaper->escapeHtml($lang['ReputationDamage']) . ":</td>\n";
        echo "<td width=\"75\">\n";
        create_numeric_dropdown("ReputationDamage", $OWASPReputationDamage, false);
        echo "</td>\n";
        echo "<td width=\"50\"><img src=\"../images/helpicon.jpg\" width=\"25\" height=\"18\" align=\"absmiddle\" onClick=\"javascript:showHelp('ReputationDamageHelp');\"></td>\n";
        echo "<td>&nbsp;</td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td width=\"175\">" . $escaper->escapeHtml($lang['NonCompliance']) . ":</td>\n";
        echo "<td width=\"75\">\n";
        create_numeric_dropdown("NonCompliance", $OWASPNonCompliance, false);
        echo "</td>\n";
        echo "<td width=\"50\"><img src=\"../images/helpicon.jpg\" width=\"25\" height=\"18\" align=\"absmiddle\" onClick=\"javascript:showHelp('NonComplianceHelp');\"></td>\n";
        echo "<td>&nbsp;</td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td width=\"175\">" . $escaper->escapeHtml($lang['PrivacyViolation']) . ":</td>\n";
        echo "<td width=\"75\">\n";
        create_numeric_dropdown("PrivacyViolation", $OWASPPrivacyViolation, false);
        echo "</td>\n";
        echo "<td width=\"50\"><img src=\"../images/helpicon.jpg\" width=\"25\" height=\"18\" align=\"absmiddle\" onClick=\"javascript:showHelp('PrivacyViolationHelp');\"></td>\n";
        echo "<td>&nbsp;</td>\n";
        echo "</tr>\n";

        echo "</table>\n";

        echo "<div class=\"form-actions\">\n";
        echo "<button type=\"submit\" name=\"update_owasp\" class=\"btn btn-primary\">" . $escaper->escapeHtml($lang['Update']) . "</button>\n";
        echo "</div>\n";
        echo "</form>\n";
}

/*******************************
 * FUNCTION: edit_custom_score *
 *******************************/
function edit_custom_score($custom)
{
	global $lang;
	global $escaper;

        echo "<h4>" . $escaper->escapeHtml($lang['UpdateCustomScore']) . "</h4>\n";
        echo "<form name=\"update_custom\" method=\"post\" action=\"\">\n";
        echo "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" style=\"border:none;\">\n";

        echo "<tr>\n";
        echo "<td width=\"165\" height=\"10\">" . $escaper->escapeHtml($lang['ManuallyEnteredValue']) . ":</td>\n";
        echo "<td width=\"60\"><input type=\"text\" name=\"Custom\" id=\"Custom\" style=\"width:30px;\" value=\"" . $escaper->escapeHtml($custom) . "\"></td>\n";
	echo "<td>(Must be a numeric value between 0 and 10)</td>\n";
        echo "</tr>\n";

        echo "</table>\n";

        echo "<div class=\"form-actions\">\n";
        echo "<button type=\"submit\" name=\"update_custom\" class=\"btn btn-primary\">" . $escaper->escapeHtml($lang['Update']) . "</button>\n";
        echo "</div>\n";
        echo "</form>\n";
}

/***********************************
 * FUNCTION: CLASSIC SCORING TABLE *
 ***********************************/
function classic_scoring_table($id, $calculated_risk, $CLASSIC_likelihood, $CLASSIC_impact)
{
	global $lang;
	global $escaper;
	
        echo "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" style=\"border:none;\">\n";

        echo "<tr>\n";
        echo "<td colspan=\"3\"><h4>". $escaper->escapeHtml($lang['ClassicRiskScoring']) ."</h4></td>\n";
        echo "<td colspan=\"1\" style=\"vertical-align:top;\">\n";
        echo "<div class=\"btn-group pull-right\">\n";
        echo "<a class=\"btn dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\">". $escaper->escapeHtml($lang['RiskScoringActions']) ."<span class=\"caret\"></span></a>\n";
        echo "<ul class=\"dropdown-menu\">\n";
        echo "<li><a href=\"#\" onclick=\"javascript:updateScore()\">". $escaper->escapeHtml($lang['UpdateClassicScore']) ."</a></li>\n";
        echo "<li><a href=\"view.php?id=". $escaper->escapeHtml($id) ."&scoring_method=2\">". $escaper->escapeHtml($lang['ScoreByCVSS']) ."</a></li>\n";
        echo "<li><a href=\"view.php?id=". $escaper->escapeHtml($id) ."&scoring_method=3\">". $escaper->escapeHtml($lang['ScoreByDREAD']) ."</a></li>\n";
        echo "<li><a href=\"view.php?id=". $escaper->escapeHtml($id) ."&scoring_method=4\">". $escaper->escapeHtml($lang['ScoreByOWASP']) ."</a></li>\n";
        echo "<li><a href=\"view.php?id=". $escaper->escapeHtml($id) ."&scoring_method=5\">". $escaper->escapeHtml($lang['ScoreByCustom']) ."</a></li>\n";
        echo "</ul>\n";
        echo "</div>\n";
        echo "</td>\n";
        echo "</tr>\n";


        echo "<tr>\n";
        echo "<td width=\"90\">". $escaper->escapeHtml($lang['Likelihood']) .":</td>\n";
        echo "<td width=\"25\">[ " . $escaper->escapeHtml($CLASSIC_likelihood) . " ]</td>\n";
        echo "<td>" . $escaper->escapeHtml(get_name_by_value("likelihood", $CLASSIC_likelihood)) . "</td>\n";
	echo "<td>&nbsp;</td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td width=\"90\">". $escaper->escapeHtml($lang['Impact']) .":</td>\n";
        echo "<td width=\"25\">[ " . $escaper->escapeHtml($CLASSIC_impact) . " ]</td>\n";
        echo "<td>" . $escaper->escapeHtml(get_name_by_value("impact", $CLASSIC_impact)) . "</td>\n";
        echo "<td>&nbsp;</td>\n";
        echo "</tr>\n";

        echo "<tr><td colspan=\"4\">&nbsp;</td></tr>\n";

        if (get_setting("risk_model") == 1)
        {
        	echo "<tr>\n";
        	echo "<td colspan=\"3\"><b>". $escaper->escapeHtml($lang['RISKClassicExp1']) ." x ( 10 / 35 ) = " . $escaper->escapeHtml($calculated_risk) . "</b></td>\n";
        	echo "</tr>\n";
        }
        else if (get_setting("risk_model") == 2)
        {
                echo "<tr>\n";
                echo "<td colspan=\"3\"><b>". $escaper->escapeHtml($lang['RISKClassicExp2']) ." x ( 10 / 30 ) = " . $escaper->escapeHtml($calculated_risk) . "</b></td>\n";
                echo "</tr>\n";
        }
        else if (get_setting("risk_model") == 3)
        {
                echo "<tr>\n";
                echo "<td colspan=\"3\"><b>". $escaper->escapeHtml($lang['RISKClassicExp3']) ." x ( 10 / 25 ) = " . $escaper->escapeHtml($calculated_risk) . "</b></td>\n";
                echo "</tr>\n";
        }
        else if (get_setting("risk_model") == 4)
        {
                echo "<tr>\n";
                echo "<td colspan=\"3\"><b>". $escaper->escapeHtml($lang['RISKClassicExp4']) ." x ( 10 / 30 ) = " . $escaper->escapeHtml($calculated_risk) . "</b></td>\n";
                echo "</tr>\n";
        }
        else if (get_setting("risk_model") == 5)
        {
                echo "<tr>\n";
                echo "<td colspan=\"3\"><b>". $escaper->escapeHtml($lang['RISKClassicExp5']) ." x ( 10 / 35 ) = " . $escaper->escapeHtml($calculated_risk) . "</b></td>\n";
                echo "</tr>\n";
        }

        echo "</table>\n";
}

/********************************
 * FUNCTION: CVSS SCORING TABLE *
 ********************************/
function cvss_scoring_table($id, $calculated_risk, $AccessVector, $AccessComplexity, $Authentication, $ConfImpact, $IntegImpact, $AvailImpact, $Exploitability, $RemediationLevel, $ReportConfidence, $CollateralDamagePotential, $TargetDistribution, $ConfidentialityRequirement, $IntegrityRequirement, $AvailabilityRequirement)
{
	global $lang;
	global $escaper;

        echo "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" style=\"border:none;\">\n";

        echo "<tr>\n";
        echo "<td colspan=\"4\"><h4>" . $escaper->escapeHtml($lang['CVSSRiskScoring']) . "</h4></td>\n";
        echo "<td colspan=\"3\" style=\"vertical-align:top;\">\n";
        echo "<div class=\"btn-group pull-right\">\n";
        echo "<a class=\"btn dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\">" . $escaper->escapeHtml($lang['RiskScoringActions']) . "<span class=\"caret\"></span></a>\n";
        echo "<ul class=\"dropdown-menu\">\n";
        echo "<li><a href=\"#\" onclick=\"javascript:updateScore()\">" . $escaper->escapeHtml($lang['UpdateCVSSScore']) . "</a></li>\n";
        echo "<li><a href=\"view.php?id=". $escaper->escapeHtml($id) ."&scoring_method=1\">" . $escaper->escapeHtml($lang['ScoreByClassic']) . "</a></li>\n";
        echo "<li><a href=\"view.php?id=". $escaper->escapeHtml($id) ."&scoring_method=3\">" . $escaper->escapeHtml($lang['ScoreByDREAD']) . "</a></li>\n";
        echo "<li><a href=\"view.php?id=". $escaper->escapeHtml($id) ."&scoring_method=4\">" . $escaper->escapeHtml($lang['ScoreByOWASP']) . "</a></li>\n";
        echo "<li><a href=\"view.php?id=". $escaper->escapeHtml($id) ."&scoring_method=5\">" . $escaper->escapeHtml($lang['ScoreByCustom']) . "</a></li>\n";
        echo "</ul>\n";
        echo "</div>\n";
        echo "</td>\n";
        echo "</tr>\n";

	echo "<tr>\n";
	echo "<td colspan=\"7\">" . $escaper->escapeHtml($lang['BaseVector']) . ": AV:" . $escaper->escapeHtml($AccessVector) . "/AC:" . $escaper->escapeHtml($AccessComplexity) . "/Au:" . $escaper->escapeHtml($Authentication) . "/C:" . $escaper->escapeHtml($ConfImpact) . "/I:" . $escaper->escapeHtml($IntegImpact) . "/A:" . $escaper->escapeHtml($AvailImpact) . "</td>\n";
	echo "</tr>\n";

        echo "<tr>\n";
        echo "<td colspan=\"7\">" . $escaper->escapeHtml($lang['TemporalVector']) . ": E:" . $escaper->escapeHtml($Exploitability) . "/RL:" . $escaper->escapeHtml($RemediationLevel) . "/RC:" . $escaper->escapeHtml($ReportConfidence) . "</td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td colspan=\"7\">" . $escaper->escapeHtml($lang['EnvironmentalVector']) . ": CDP:" . $escaper->escapeHtml($CollateralDamagePotential) . "/TD:" . $escaper->escapeHtml($TargetDistribution) . "/CR:" . $escaper->escapeHtml($ConfidentialityRequirement) . "/IR:" . $escaper->escapeHtml($IntegrityRequirement) . "/AR:" . $escaper->escapeHtml($AvailabilityRequirement) . "</td>\n";
        echo "<td>&nbsp;</td>\n";
        echo "</tr>\n";

	echo "<tr><td colspan=\"8\">&nbsp;</td></tr>\n";

	echo "<tr>\n";
	echo "<td colspan=\"2\"><b><u>" . $escaper->escapeHtml($lang['BaseScoreMetrics']) . "</u></b></td>\n";
	echo "<td colspan=\"2\"><b><u>" . $escaper->escapeHtml($lang['TemporalScoreMetrics']) . "</u></b></td>\n";
        echo "<td colspan=\"2\"><b><u>" . $escaper->escapeHtml($lang['EnvironmentalScoreMetrics']) . "</u></b></td>\n";
	echo "<td>&nbsp;</td>\n";
	echo "</tr>\n";

        echo "<tr>\n";
        echo "<td width=\"175\">" . $escaper->escapeHtml($lang['AttackVector']) . ":</td>\n";
	echo "<td width=\"100\">" . $escaper->escapeHtml(get_cvss_name("AccessVector", $AccessVector)) . "</td>\n";
        echo "<td width=\"150\">" . $escaper->escapeHtml($lang['Exploitability']) . ":</td>\n";
        echo "<td width=\"100\">" . $escaper->escapeHtml(get_cvss_name("Exploitability", $Exploitability)) . "</td>\n";
        echo "<td width=\"200\">" . $escaper->escapeHtml($lang['CollateralDamagePotential']) . ":</td>\n";
        echo "<td width=\"100\">" . $escaper->escapeHtml(get_cvss_name("CollateralDamagePotential", $CollateralDamagePotential)) . "</td>\n";
	echo "<td>&nbsp</td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td width=\"175\">" . $escaper->escapeHtml($lang['AttackComplexity']) . ":</td>\n";
        echo "<td width=\"100\">" . $escaper->escapeHtml(get_cvss_name("AccessComplexity", $AccessComplexity)) . "</td>\n";
        echo "<td width=\"150\">" . $escaper->escapeHtml($lang['RemediationLevel']) . ":</td>\n";
        echo "<td width=\"100\">" . $escaper->escapeHtml(get_cvss_name("RemediationLevel", $RemediationLevel)) . "</td>\n";
        echo "<td width=\"200\">" . $escaper->escapeHtml($lang['TargetDistribution']) . ":</td>\n";
        echo "<td width=\"100\">" . $escaper->escapeHtml(get_cvss_name("TargetDistribution", $TargetDistribution)) . "</td>\n";
        echo "<td>&nbsp</td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td width=\"175\">" . $escaper->escapeHtml($lang['Authentication']) . ":</td>\n";
        echo "<td width=\"100\">" . $escaper->escapeHtml(get_cvss_name("Authentication", $Authentication)) . "</td>\n";
        echo "<td width=\"150\">" . $escaper->escapeHtml($lang['ReportConfidence']) . ":</td>\n";
        echo "<td width=\"100\">" . $escaper->escapeHtml(get_cvss_name("ReportConfidence", $ReportConfidence)) . "</td>\n";
        echo "<td width=\"200\">" . $escaper->escapeHtml($lang['ConfidentialityRequirement']) . ":</td>\n";
        echo "<td width=\"100\">" . $escaper->escapeHtml(get_cvss_name("ConfidentialityRequirement", $ConfidentialityRequirement)) . "</td>\n";
        echo "<td>&nbsp</td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td width=\"175\">" . $escaper->escapeHtml($lang['ConfidentialityImpact']) . ":</td>\n";
        echo "<td width=\"100\">" . $escaper->escapeHtml(get_cvss_name("ConfImpact", $ConfImpact)) . "</td>\n";
        echo "<td width=\"150\">&nbsp;</td>\n";
	echo "<td width=\"100\">&nbsp</td>\n";
        echo "<td width=\"200\">" . $escaper->escapeHtml($lang['IntegrityRequirement']) . ":</td>\n";
        echo "<td width=\"100\">" . $escaper->escapeHtml(get_cvss_name("IntegrityRequirement", $IntegrityRequirement)) . "</td>\n";
        echo "<td>&nbsp</td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td width=\"175\">". $escaper->escapeHtml($lang['IntegrityImpact']) . ":</td>\n";
        echo "<td width=\"100\">" . $escaper->escapeHtml(get_cvss_name("IntegImpact", $IntegImpact)) . "</td>\n";
        echo "<td width=\"150\">&nbsp;</td>\n";
        echo "<td width=\"100\">&nbsp</td>\n";
        echo "<td width=\"200\">" . $escaper->escapeHtml($lang['AvailabilityRequirement']) . ":</td>\n";
        echo "<td width=\"100\">" . $escaper->escapeHtml(get_cvss_name("AvailabilityRequirement", $AvailabilityRequirement)) . "</td>\n";
        echo "<td>&nbsp</td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td width=\"175\">" . $escaper->escapeHtml($lang['AvailabilityImpact']) . ":</td>\n";
        echo "<td width=\"100\">" . $escaper->escapeHtml(get_cvss_name("AvailImpact", $AvailImpact)) . "</td>\n";
        echo "<td width=\"150\">&nbsp;</td>\n";
        echo "<td width=\"100\">&nbsp</td>\n";
        echo "<td width=\"200\">&nbsp;</td>\n";
        echo "<td width=\"100\">&nbsp</td>\n";
        echo "<td>&nbsp</td>\n";
        echo "</tr>\n";

	echo "<tr>\n";
	echo "<td colspan=\"7\">&nbsp;</td>\n";
	echo "</tr>\n";

        echo "<tr>\n";
        echo "<td colspan=\"7\">Full details of CVSS Version 2.0 scoring can be found <a href=\"http://www.first.org/cvss/cvss-guide.html\" target=\"_blank\">here</a>.</td>\n";
        echo "</tr>\n";

        echo "</table>\n";
}

/*********************************
 * FUNCTION: DREAD SCORING TABLE *
 *********************************/
function dread_scoring_table($id, $calculated_risk, $DREADDamagePotential, $DREADReproducibility, $DREADExploitability, $DREADAffectedUsers, $DREADDiscoverability)
{
        global $lang;
        global $escaper;

        echo "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" style=\"border:none;\">\n";

        echo "<tr>\n";
        echo "<td colspan=\"2\"><h4>" . $escaper->escapeHtml($lang['DREADRiskScoring']) . "</h4></td>\n";
        echo "<td colspan=\"1\" style=\"vertical-align:top;\">\n";
        echo "<div class=\"btn-group pull-right\">\n";
        echo "<a class=\"btn dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\">" . $escaper->escapeHtml($lang['RiskScoringActions']) . "<span class=\"caret\"></span></a>\n";
        echo "<ul class=\"dropdown-menu\">\n";
        echo "<li><a href=\"#\" onclick=\"javascript:updateScore()\">" . $escaper->escapeHtml($lang['UpdateDREADScore']) . "</a></li>\n";
        echo "<li><a href=\"view.php?id=". $escaper->escapeHtml($id) ."&scoring_method=1\">" . $escaper->escapeHtml($lang['ScoreByClassic']) . "</a></li>\n";
        echo "<li><a href=\"view.php?id=". $escaper->escapeHtml($id) ."&scoring_method=2\">" . $escaper->escapeHtml($lang['ScoreByCVSS']) . "</a></li>\n";
        echo "<li><a href=\"view.php?id=". $escaper->escapeHtml($id) ."&scoring_method=4\">" . $escaper->escapeHtml($lang['ScoreByOWASP']) . "</a></li>\n";
        echo "<li><a href=\"view.php?id=". $escaper->escapeHtml($id) ."&scoring_method=5\">" . $escaper->escapeHtml($lang['ScoreByCustom']) . "</a></li>\n";
        echo "</ul>\n";
        echo "</div>\n";
        echo "</td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td width=\"150\">" . $escaper->escapeHtml($lang['DamagePotential']) . ":</td>\n";
        echo "<td>" . $escaper->escapeHtml($DREADDamagePotential) . "</td>\n";
	echo "<td>&nbsp;</td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td width=\"150\">" . $escaper->escapeHtml($lang['Reproducibility']) . ":</td>\n";
        echo "<td>" . $escaper->escapeHtml($DREADReproducibility) . "</td>\n";
        echo "<td>&nbsp;</td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td width=\"150\">" . $escaper->escapeHtml($lang['Exploitability']) . ":</td>\n";
        echo "<td>" . $escaper->escapeHtml($DREADExploitability) . "</td>\n";
        echo "<td>&nbsp;</td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td width=\"150\">" . $escaper->escapeHtml($lang['AffectedUsers']) . ":</td>\n";
        echo "<td>" . $escaper->escapeHtml($DREADAffectedUsers) . "</td>\n";
        echo "<td>&nbsp;</td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td width=\"150\">" . $escaper->escapeHtml($lang['Discoverability']) . ":</td>\n";
        echo "<td>" . $escaper->escapeHtml($DREADDiscoverability) . "</td>\n";
        echo "<td>&nbsp;</td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td colspan=\"3\">&nbsp;</td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td colspan=\"3\"><b>RISK = ( " . $escaper->escapeHtml($DREADDamagePotential) . " + " . $escaper->escapeHtml($DREADReproducibility) . " + " . $escaper->escapeHtml($DREADExploitability) . " + " . $escaper->escapeHtml($DREADAffectedUsers) . " + " . $escaper->escapeHtml($DREADDiscoverability) . " ) / 5 = " . $escaper->escapeHtml($calculated_risk) . "</b></td>\n";
        echo "</tr>\n";

        echo "</table>\n";
}

/*********************************
 * FUNCTION: OWASP SCORING TABLE *
 *********************************/
function owasp_scoring_table($id, $calculated_risk, $OWASPSkillLevel, $OWASPEaseOfDiscovery, $OWASPLossOfConfidentiality, $OWASPFinancialDamage, $OWASPMotive, $OWASPEaseOfExploit, $OWASPLossOfIntegrity, $OWASPReputationDamage, $OWASPOpportunity, $OWASPAwareness, $OWASPLossOfAvailability, $OWASPNonCompliance, $OWASPSize, $OWASPIntrusionDetection, $OWASPLossOfAccountability, $OWASPPrivacyViolation)
{
        global $lang;
        global $escaper;

        echo "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" style=\"border:none;\">\n";

        echo "<tr>\n";
        echo "<td colspan=\"4\"><h4>" . $escaper->escapeHtml($lang['OWASPRiskScoring']) . "</h4></td>\n";
        echo "<td colspan=\"5\" style=\"vertical-align:top;\">\n";
        echo "<div class=\"btn-group pull-right\">\n";
        echo "<a class=\"btn dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\">" . $escaper->escapeHtml($lang['RiskScoringActions']) . "<span class=\"caret\"></span></a>\n";
        echo "<ul class=\"dropdown-menu\">\n";
        echo "<li><a href=\"#\" onclick=\"javascript:updateScore()\">" . $escaper->escapeHtml($lang['UpdateOWASPScore']) . "</a></li>\n";
        echo "<li><a href=\"view.php?id=". $escaper->escapeHtml($id) ."&scoring_method=1\">" . $escaper->escapeHtml($lang['ScoreByClassic']) . "</a></li>\n";
        echo "<li><a href=\"view.php?id=". $escaper->escapeHtml($id) ."&scoring_method=2\">" . $escaper->escapeHtml($lang['ScoreByCVSS']) . "</a></li>\n";
        echo "<li><a href=\"view.php?id=". $escaper->escapeHtml($id) ."&scoring_method=3\">" . $escaper->escapeHtml($lang['ScoreByDREAD']) . "</a></li>\n";
        echo "<li><a href=\"view.php?id=". $escaper->escapeHtml($id) ."&scoring_method=5\">" . $escaper->escapeHtml($lang['ScoreByCustom']) . "</a></li>\n";
        echo "</ul>\n";
        echo "</div>\n";
        echo "</td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td colspan=\"2\"><b><u>" . $escaper->escapeHtml($lang['ThreatAgentFactors']) . "</u></b></td>\n";
        echo "<td colspan=\"2\"><b><u>" . $escaper->escapeHtml($lang['VulnerabilityFactors']) . "</u></b></td>\n";
        echo "<td colspan=\"2\"><b><u>" . $escaper->escapeHtml($lang['TechnicalImpact']) . "</u></b></td>\n";
        echo "<td colspan=\"2\"><b><u>" . $escaper->escapeHtml($lang['BusinessImpact']) . "</u></b></td>\n";
	echo "<td>&nbsp;</td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td width=\"175\">" . $escaper->escapeHtml($lang['SkillLevel']) . ":</td>\n";
        echo "<td width=\"50\">" . $escaper->escapeHtml($OWASPSkillLevel) . "</td>\n";
        echo "<td width=\"175\">" . $escaper->escapeHtml($lang['EaseOfDiscovery']) . ":</td>\n";
        echo "<td width=\"50\">" . $escaper->escapeHtml($OWASPEaseOfDiscovery) . "</td>\n";
        echo "<td width=\"175\">" . $escaper->escapeHtml($lang['LossOfConfidentiality']) . ":</td>\n";
        echo "<td width=\"50\">" . $escaper->escapeHtml($OWASPLossOfConfidentiality) . "</td>\n";
        echo "<td width=\"175\">" . $escaper->escapeHtml($lang['FinancialDamage']) . ":</td>\n";
        echo "<td width=\"50\">" . $escaper->escapeHtml($OWASPFinancialDamage) . "</td>\n";
        echo "<td>&nbsp;</td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td width=\"125\">" . $escaper->escapeHtml($lang['Motive']) . ":</td>\n";
        echo "<td width=\"10\">" . $escaper->escapeHtml($OWASPMotive) . "</td>\n";
        echo "<td width=\"125\">" . $escaper->escapeHtml($lang['EaseOfExploit']) . ":</td>\n";
        echo "<td width=\"10\">" . $escaper->escapeHtml($OWASPEaseOfExploit) . "</td>\n";
        echo "<td width=\"125\">" . $escaper->escapeHtml($lang['LossOfIntegrity']) . ":</td>\n";
        echo "<td width=\"10\">" . $escaper->escapeHtml($OWASPLossOfIntegrity) . "</td>\n";
        echo "<td width=\"125\">" . $escaper->escapeHtml($lang['ReputationDamage']) . ":</td>\n";
        echo "<td width=\"10\">" . $escaper->escapeHtml($OWASPReputationDamage) . "</td>\n";
        echo "<td>&nbsp;</td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td width=\"125\">" . $escaper->escapeHtml($lang['Opportunity']) . ":</td>\n";
        echo "<td width=\"10\">" . $escaper->escapeHtml($OWASPOpportunity) . "</td>\n";
        echo "<td width=\"125\">" . $escaper->escapeHtml($lang['Awareness']) . ":</td>\n";
        echo "<td width=\"10\">" . $escaper->escapeHtml($OWASPAwareness) . "</td>\n";
        echo "<td width=\"125\">" . $escaper->escapeHtml($lang['LossOfAvailability']) . ":</td>\n";
        echo "<td width=\"10\">" . $escaper->escapeHtml($OWASPLossOfAvailability) . "</td>\n";
        echo "<td width=\"125\">" . $escaper->escapeHtml($lang['NonCompliance']) . ":</td>\n";
        echo "<td width=\"10\">" . $escaper->escapeHtml($OWASPNonCompliance) . "</td>\n";
        echo "<td>&nbsp;</td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td width=\"125\">" . $escaper->escapeHtml($lang['Size']) . ":</td>\n";
        echo "<td width=\"10\">" . $escaper->escapeHtml($OWASPSize) . "</td>\n";
        echo "<td width=\"125\">" . $escaper->escapeHtml($lang['IntrusionDetection']) . ":</td>\n";
        echo "<td width=\"10\">" . $escaper->escapeHtml($OWASPIntrusionDetection) . "</td>\n";
        echo "<td width=\"125\">" . $escaper->escapeHtml($lang['LossOfAccountability']) . ":</td>\n";
        echo "<td width=\"10\">" . $escaper->escapeHtml($OWASPLossOfAccountability) . "</td>\n";
        echo "<td width=\"125\">" . $escaper->escapeHtml($lang['PrivacyViolation']) . ":</td>\n";
        echo "<td width=\"10\">" . $escaper->escapeHtml($OWASPPrivacyViolation) . "</td>\n";
        echo "<td>&nbsp;</td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td colspan=\"9\">&nbsp;</td>\n";
        echo "<tr>\n";

        echo "<tr>\n";
        echo "<td colspan=\"4\"><b><u>" . $escaper->escapeHtml($lang['Likelihood']) . "</u></b></td>\n";
        echo "<td colspan=\"4\"><b><u>" . $escaper->escapeHtml($lang['Impact']) . "</u></b></td>\n";
        echo "<td>&nbsp;</td>\n";
        echo "<tr>\n";

        echo "<tr>\n";
        echo "<td colspan=\"4\">" . $escaper->escapeHtml($lang['ThreatAgentFactors']) . " = ( " . $escaper->escapeHtml($OWASPSkillLevel) . " + " . $escaper->escapeHtml($OWASPMotive) . " + " . $escaper->escapeHtml($OWASPOpportunity) . " + " . $escaper->escapeHtml($OWASPSize) . " ) / 4</td>\n";
        echo "<td colspan=\"4\">" . $escaper->escapeHtml($lang['TechnicalImpact']) . " = ( " . $escaper->escapeHtml($OWASPLossOfConfidentiality) . " + " . $escaper->escapeHtml($OWASPLossOfIntegrity) . " + " . $escaper->escapeHtml($OWASPLossOfAvailability) . " + " . $escaper->escapeHtml($OWASPLossOfAccountability) . " ) / 4</td>\n";
        echo "<td>&nbsp;</td>\n";
        echo "<tr>\n";

        echo "<tr>\n";
        echo "<td colspan=\"4\">" . $escaper->escapeHtml($lang['VulnerabilityFactors']) . " = ( " . $escaper->escapeHtml($OWASPEaseOfDiscovery) . " + " . $escaper->escapeHtml($OWASPEaseOfExploit) . " + " . $escaper->escapeHtml($OWASPAwareness) . " + " . $escaper->escapeHtml($OWASPIntrusionDetection) . " ) / 4</td>\n";
        echo "<td colspan=\"4\">" . $escaper->escapeHtml($lang['BusinessImpact']) . " = ( " . $escaper->escapeHtml($OWASPFinancialDamage) . " + " . $escaper->escapeHtml($OWASPReputationDamage) . " + " . $escaper->escapeHtml($OWASPNonCompliance) . " + " . $escaper->escapeHtml($OWASPPrivacyViolation) . " ) / 4</td>\n";
        echo "<td>&nbsp;</td>\n";
        echo "<tr>\n";

        echo "<tr>\n";
        echo "<td colspan=\"9\">&nbsp;</td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td colspan=\"9\">Full details of the OWASP Risk Rating Methodology can be found <a href=\"https://www.owasp.org/index.php/OWASP_Risk_Rating_Methodology\" target=\"_blank\">here</a>.</td>\n";
        echo "</tr>\n";

        echo "</table>\n";
}

/**********************************
 * FUNCTION: CUSTOM SCORING TABLE *
 **********************************/
function custom_scoring_table($id, $custom)
{
        global $lang;
        global $escaper;

        echo "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" style=\"border:none;\">\n";

        echo "<tr>\n";
        echo "<td colspan=\"2\"><h4>" . $escaper->escapeHtml($lang['CustomRiskScoring']) . "</h4></td>\n";
        echo "<td colspan=\"1\" style=\"vertical-align:top;\">\n";
        echo "<div class=\"btn-group pull-right\">\n";
        echo "<a class=\"btn dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\">" . $escaper->escapeHtml($lang['RiskScoringActions']) . "<span class=\"caret\"></span></a>\n";
        echo "<ul class=\"dropdown-menu\">\n";
        echo "<li><a href=\"#\" onclick=\"javascript:updateScore()\">" . $escaper->escapeHtml($lang['UpdateCustomScore']) . "</a></li>\n";
        echo "<li><a href=\"view.php?id=". $escaper->escapeHtml($id) ."&scoring_method=1\">" . $escaper->escapeHtml($lang['ScoreByClassic']) . "</a></li>\n";
        echo "<li><a href=\"view.php?id=". $escaper->escapeHtml($id) ."&scoring_method=2\">" . $escaper->escapeHtml($lang['ScoreByCVSS']) . "</a></li>\n";
        echo "<li><a href=\"view.php?id=". $escaper->escapeHtml($id) ."&scoring_method=3\">" . $escaper->escapeHtml($lang['ScoreByDREAD']) . "</a></li>\n";
        echo "<li><a href=\"view.php?id=". $escaper->escapeHtml($id) ."&scoring_method=4\">" . $escaper->escapeHtml($lang['ScoreByOWASP']) . "</a></li>\n";
        echo "</ul>\n";
        echo "</div>\n";
        echo "</td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td width=\"175\">" . $escaper->escapeHtml($lang['ManuallyEnteredValue']) . ":</td>\n";
        echo "<td width=\"10\">" . $escaper->escapeHtml($custom) . "</td>\n";
        echo "<td>&nbsp;</td>\n";
        echo "<tr>\n";

        echo "</table>\n";
}

/*******************************
 * FUNCTION: VIEW CLASSIC HELP *
 *******************************/
function view_classic_help()
{
        echo "<div id=\"divHelp\" style=\"width:100%;overflow:auto\"></div>\n";

        echo "<div id=\"likelihoodHelp\"  style=\"display:none; visibility:hidden\">\n";
        echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
        echo "<tr>\n";
        echo "<td class=\"cal-text\">\n";
        echo "<p><b>Remote:</b> May only occur in exceptional circumstances.</p>\n";
	echo "<p><b>Unlikely:</b> Expected to occur in a few circumstances.</p>\n";
	echo "<p><b>Credible:</b> Expected to occur in some circumstances.</p>\n";
	echo "<p><b>Likely:</b> Expected to occur in many circumstances.</p>\n";
	echo "<p><b>Almost Certain:</b> Expected to occur frequently and in most circumstances.</p>\n";
        echo "</td>\n";
        echo "</tr>\n";
        echo "</table>\n";
        echo "</div>\n";

        echo "<div id=\"impactHelp\"  style=\"display:none; visibility:hidden\">\n";
        echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
        echo "<tr>\n";
        echo "<td class=\"cal-text\">\n";
	echo "<p><b>Insignificant:</b> No impact on service, no impact on reputation, complaint unlikely, or litigation risk remote.</p>\n";
	echo "<p><b>Minor:</b> Slight impact on service, slight impact on reputation, complaint possible, or litigation possible.</p>\n";
	echo "<p><b>Moderate:</b> Some service disruption, potential for adverse publicity (avoidable with careful handling), complaint probable, or litigation probably.</p>\n";
	echo "<p><b>Major:</b> Service disrupted, adverse publicity not avoidable (local media), complaint probably, or litigation probable.</p>\n";
	echo "<p><b>Extreme/Catastrophic:</b> Service interrupted for significant time, major adverse publicity not avoidable (national media), major litigation expected, resignation of senior management and board, or loss of benficiary confidence.</p>\n";
        echo "</td>\n";
        echo "</tr>\n";
        echo "</table>\n";
        echo "</div>\n";

        echo "<script language=\"javascript\">\n";
        echo "function showHelp(divId) {\n";
        echo "getRef(\"divHelp\").innerHTML=getRef(divId).innerHTML;\n";
        echo "}\n";
        echo "function hideHelp() {\n";
        echo "getRef(\"divHelp\").innerHTML=\"\";\n";
        echo "}\n";
        echo "</script>\n";
}

/*****************************
 * FUNCTION: VIEW OWASP HELP *
 *****************************/
function view_owasp_help()
{
        echo "<div id=\"divHelp\" style=\"width:100%;overflow:auto\"></div>\n";

        echo "<div id=\"SkillLevelHelp\"  style=\"display:none; visibility:hidden\">\n";
        echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
        echo "<tr>\n";
        echo "<td class=\"cal-text\">\n";
        echo "<br /><p><b>How technically skilled is this group of threat agents?</b></p>\n";
        echo "<p>1 = Security Penetration Skills</p>\n";
        echo "<p>4 = Network and Programming Skills</p>\n";
        echo "<p>6 = Advanced Computer User</p>\n";
        echo "<p>7 = Some Technical Skills</p>\n";
        echo "<p>9 = No Technical Skills</p>\n";
        echo "</td>\n";
        echo "</tr>\n";
        echo "</table>\n";
        echo "</div>\n";

        echo "<div id=\"MotiveHelp\"  style=\"display:none; visibility:hidden\">\n";
        echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
        echo "<tr>\n";          
        echo "<td class=\"cal-text\">\n";
        echo "<br /><p><b>How motivated is this group of threat agents to find and exploit this vulnerability?</b></p>\n";
        echo "<p>1 = Low or No Reward</p>\n";
        echo "<p>4 = Possible Reward</p>\n";
        echo "<p>9 = High Reward</p>\n";
        echo "</td>\n";           
        echo "</tr>\n";         
        echo "</table>\n";
        echo "</div>\n";

        echo "<div id=\"OpportunityHelp\"  style=\"display:none; visibility:hidden\">\n";
        echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
        echo "<tr>\n";          
        echo "<td class=\"cal-text\">\n";
        echo "<br /><p><b>What resources and opportunity are required for this group of threat agents to find and exploit this vulnerability?</b></p>\n";
        echo "<p>0 = Full Access or Expensive Resources Required</p>\n";
        echo "<p>4 = Special Access or Resources Required</p>\n";
        echo "<p>7 = Some Access or Resources Required</p>\n";
        echo "<p>9 = No Access or Resources Required</p>\n";
        echo "</td>\n";
        echo "</tr>\n";
        echo "</table>\n";
        echo "</div>\n";

        echo "<div id=\"SizeHelp\"  style=\"display:none; visibility:hidden\">\n";
        echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
        echo "<tr>\n";          
        echo "<td class=\"cal-text\">\n";
        echo "<br /><p><b>How large is this group of threat agents?</b></p>\n";
        echo "<p>2 = Developers</p>\n";
        echo "<p>2 = System Administrators</p>\n";
        echo "<p>4 = Intranet Users</p>\n";
        echo "<p>5 = Partners</p>\n";
        echo "<p>6 = Authenticated Users</p>\n";
        echo "<p>9 = Anonymous Internet Users</p>\n";
        echo "</td>\n";
        echo "</tr>\n";
        echo "</table>\n";
        echo "</div>\n";

        echo "<div id=\"EaseOfDiscoveryHelp\"  style=\"display:none; visibility:hidden\">\n";
        echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
        echo "<tr>\n";          
        echo "<td class=\"cal-text\">\n";
        echo "<br /><p><b>How easy is it for this group of threat agents to discover this vulnerability?</b></p>\n";
        echo "<p>1 = Practically Impossible</p>\n";
        echo "<p>3 = Difficult</p>\n";
        echo "<p>7 = Easy</p>\n";
        echo "<p>9 = Automated Tools Available</p>\n";
        echo "</td>\n";
        echo "</tr>\n";
        echo "</table>\n";
        echo "</div>\n";

        echo "<div id=\"EaseOfExploitHelp\"  style=\"display:none; visibility:hidden\">\n";
        echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
        echo "<tr>\n";          
        echo "<td class=\"cal-text\">\n";
        echo "<br /><p><b>How easy is it for this group of threat agents to actually exploit this vulnerability?</b></p>\n";
        echo "<p>1 = Theoretical</p>\n";
        echo "<p>3 = Difficult</p>\n";
        echo "<p>5 = Easy</p>\n";
        echo "<p>9 = Automated Tools Available</p>\n";
        echo "</td>\n";
        echo "</tr>\n";
        echo "</table>\n";
        echo "</div>\n";

        echo "<div id=\"AwarenessHelp\"  style=\"display:none; visibility:hidden\">\n";
        echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
        echo "<tr>\n";
        echo "<td class=\"cal-text\">\n";
        echo "<br /><p><b>How well known is this vulnerability to this group of threat agents?</b></p>\n";
        echo "<p>1 = Unknown</p>\n";
        echo "<p>4 = Hidden</p>\n";
        echo "<p>6 = Obvious</p>\n";
        echo "<p>9 = Public Knowledge</p>\n";
        echo "</td>\n";
        echo "</tr>\n";
        echo "</table>\n";
        echo "</div>\n";

        echo "<div id=\"IntrusionDetectionHelp\"  style=\"display:none; visibility:hidden\">\n";
        echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
        echo "<tr>\n";          
        echo "<td class=\"cal-text\">\n";
        echo "<br /><p><b>How likely is an exploit to be detected?</b></p>\n";
        echo "<p>1 = Active Detection in Application</p>\n";
        echo "<p>3 = Logged and Reviewed</p>\n";
        echo "<p>8 = Logged Without Review</p>\n";
        echo "<p>9 = Not Logged</p>\n";
        echo "</td>\n";
        echo "</tr>\n";
        echo "</table>\n";
        echo "</div>\n";

        echo "<div id=\"LossOfConfidentialityHelp\"  style=\"display:none; visibility:hidden\">\n";
        echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
        echo "<tr>\n";          
        echo "<td class=\"cal-text\">\n";
        echo "<br /><p><b>How much data could be disclosed and how sensitive is it?</b></p>\n";
        echo "<p>2 = Minimal Non-Sensitive Data Disclosed</p>\n";
        echo "<p>6 = Minimal Critical Data Disclosed</p>\n";
        echo "<p>7 = Extensive Critical Data Disclosed</p>\n";
        echo "<p>9 = All Data Disclosed</p>\n";
        echo "</td>\n";
        echo "</tr>\n";
        echo "</table>\n";
        echo "</div>\n";

        echo "<div id=\"LossOfIntegrityHelp\"  style=\"display:none; visibility:hidden\">\n";
        echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
        echo "<tr>\n";          
        echo "<td class=\"cal-text\">\n";
        echo "<br /><p><b>How much data could be corrupted and how damaged is it?</b></p>\n";
        echo "<p>1 = Minimal Slightly Corrupt Data</p>\n";
        echo "<p>3 = Minimal Seriously Corrupt Data</p>\n";
        echo "<p>5 = Extensive Slightly Corrupt Data</p>\n";
        echo "<p>7 = Extensive Seriously Corrupt Data</p>\n";
        echo "<p>9 = All Data Totally Corrupt</p>\n";
        echo "</td>\n";
        echo "</tr>\n";
        echo "</table>\n";
        echo "</div>\n";

        echo "<div id=\"LossOfAvailabilityHelp\"  style=\"display:none; visibility:hidden\">\n";
        echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
        echo "<tr>\n";          
        echo "<td class=\"cal-text\">\n";
        echo "<br /><p><b>How much service could be lost and how vital is it?</b></p>\n";
        echo "<p>1 = Minimal Secondary Services Interrupted</p>\n";
        echo "<p>5 = Minimal Primary Services Interrupted</p>\n";
        echo "<p>5 = Extensive Secondary Services Interrupted</p>\n";
        echo "<p>7 = Extensive Primary Services Interrupted</p>\n";
        echo "<p>9 = All Services Completely Lost</p>\n";
        echo "</td>\n";
        echo "</tr>\n";
        echo "</table>\n";
        echo "</div>\n";

        echo "<div id=\"LossOfAccountabilityHelp\"  style=\"display:none; visibility:hidden\">\n";
        echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
        echo "<tr>\n";          
        echo "<td class=\"cal-text\">\n";
        echo "<br /><p><b>Are the threat agents' actions traceable to an individual?</b></p>\n";
        echo "<p>1 = Fully Traceable</p>\n";
        echo "<p>7 = Possibly Traceable</p>\n";
        echo "<p>9 = Completely Anonymous</p>\n";
        echo "</td>\n";
        echo "</tr>\n";
        echo "</table>\n";
        echo "</div>\n";

        echo "<div id=\"FinancialDamageHelp\"  style=\"display:none; visibility:hidden\">\n";
        echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
        echo "<tr>\n";          
        echo "<td class=\"cal-text\">\n";
        echo "<br /><p><b>How much financial damage will result from an exploit?</b></p>\n";
        echo "<p>1 = Less than the Cost to Fix the Vulnerability</p>\n";
        echo "<p>3 = Minor Effect on Annual Profit</p>\n";
        echo "<p>7 = Significant Effect on Annual Profit</p>\n";
        echo "<p>9 = Bankruptcy</p>\n";
        echo "</td>\n";
        echo "</tr>\n";
        echo "</table>\n";
        echo "</div>\n";

        echo "<div id=\"ReputationDamageHelp\"  style=\"display:none; visibility:hidden\">\n";
        echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
        echo "<tr>\n";          
        echo "<td class=\"cal-text\">\n";
        echo "<br /><p><b>Would an exploit result in reputation damage that would harm the business?</b></p>\n";
        echo "<p>1 = Minimal Damage</p>\n";
        echo "<p>4 = Loss of Major Accounts</p>\n";
        echo "<p>5 = Loss of Goodwill</p>\n";
        echo "<p>9 = Brand Damage</p>\n";
        echo "</td>\n";
        echo "</tr>\n";
        echo "</table>\n";
        echo "</div>\n";

        echo "<div id=\"NonComplianceHelp\"  style=\"display:none; visibility:hidden\">\n";
        echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
        echo "<tr>\n";          
        echo "<td class=\"cal-text\">\n";
        echo "<br /><p><b>How much exposure does non-compliance introduce?</b></p>\n";
        echo "<p>2 = Minor Violation</p>\n";
        echo "<p>5 = Clear Violation</p>\n";
        echo "<p>7 = High Profile Violation</p>\n";
        echo "</td>\n";
        echo "</tr>\n";
        echo "</table>\n";
        echo "</div>\n";

        echo "<div id=\"PrivacyViolationHelp\"  style=\"display:none; visibility:hidden\">\n";
        echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
        echo "<tr>\n";          
        echo "<td class=\"cal-text\">\n";
        echo "<br /><p><b>How much personally identifiable information could be disclosed?</b></p>\n";
        echo "<p>3 = One Individual</p>\n";
        echo "<p>5 = Hundreds of People</p>\n";
        echo "<p>7 = Thousands of People</p>\n";
        echo "<p>9 = Millions of People</p>\n";
        echo "</td>\n";
        echo "</tr>\n";
        echo "</table>\n";
        echo "</div>\n";

        echo "<script language=\"javascript\">\n";
        echo "function showHelp(divId) {\n";
        echo "getRef(\"divHelp\").innerHTML=getRef(divId).innerHTML;\n";
        echo "}\n";
        echo "function hideHelp() {\n";
        echo "getRef(\"divHelp\").innerHTML=\"\";\n";
        echo "}\n";
        echo "</script>\n";
}

/*****************************
 * FUNCTION: VIEW CVSS HELP *
 *****************************/
function view_cvss_help()
{
        echo "<div id=\"divHelp\" style=\"width:100%;overflow:auto\"></div>\n";

        echo "<div id=\"AccessVectorHelp\"  style=\"display:none; visibility:hidden\">\n";
        echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
        echo "<tr>\n";
	echo "<td class=\"cal-head\"><b>Local</b></td>\n";
	echo "</tr>\n";
	echo "<tr>\n";
        echo "<td class=\"cal-text\">A vulnerability exploitable with only local access requires the attacker to have either physical access to the vulnerable system or a local (shell) account.  Examples of locally exploitable vulnerabilities are peripheral attacks such as Firewire/USB DMA attacks, and local privilege escalations (e.g., sudo).</td>\n";
	echo "</tr>\n";
	echo "<tr><td>&nbsp;</td></tr>\n";
        echo "<tr>\n";
        echo "<td class=\"cal-head\"><b>Adjacent Network</b></td>\n";
        echo "</tr>\n";
        echo "<tr>\n";
        echo "<td class=\"cal-text\">A vulnerability exploitable with adjacent network access requires the attacker to have access to either the broadcast or collision domain of the vulnerable software.  Examples of local networks include local IP subnet, Bluetooth, IEEE 802.11, and local Ethernet segment.</td>\n";
        echo "</tr>\n";
        echo "<tr><td>&nbsp;</td></tr>\n";
        echo "<tr>\n";
        echo "<td class=\"cal-head\"><b>Network</b></td>\n";
        echo "</tr>\n";
        echo "<tr>\n";
        echo "<td class=\"cal-text\">A vulnerability exploitable with network access means the vulnerable software is bound to the network stack and the attacker does not require local network access or local access.  Such a vulnerability is often termed \"remotely exploitable\".  An example of a network attack is an RPC buffer overflow.</td>\n";
        echo "</tr>\n";
        echo "</table>\n";
        echo "</div>\n";

        echo "<div id=\"AccessComplexityHelp\"  style=\"display:none; visibility:hidden\">\n";
        echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
        echo "<tr>\n";
        echo "<td class=\"cal-head\"><b>High</b></td>\n";
        echo "</tr>\n";
        echo "<tr>\n";
        echo "<td class=\"cal-text\">Specialized access conditions exist. For example:<ul><li>In most configurations, the attacking party must already have elevated privileges or spoof additional systems in addition to the attacking system (e.g., DNS hijacking).</li><li>The attack depends on social engineering methods that would be easily detected by knowledgeable people. For example, the victim must perform several suspicious or atypical actions.</li><li>The vulnerable configuration is seen very rarely in practice.</li><li>If a race condition exists, the window is very narrow.</li></ul></td>\n";
        echo "</tr>\n";
        echo "<tr><td>&nbsp;</td></tr>\n";
        echo "<tr>\n";
        echo "<td class=\"cal-head\"><b>Medium</b></td>\n";
        echo "</tr>\n";
        echo "<tr>\n";
        echo "<td class=\"cal-text\">The access conditions are somewhat specialized; the following are examples:<ul><li>The attacking party is limited to a group of systems or users at some level of authorization, possibly untrusted.</li><li>Some information must be gathered before a successful attack can be launched.</li><li>The affected configuration is non-default, and is not commonly configured (e.g., a vulnerability present when a server performs user account authentication via a specific scheme, but not present for another authentication scheme).</li><li>The attack requires a small amount of social engineering that might occasionally fool cautious users (e.g., phishing attacks that modify a web browsers status bar to show a false link, having to be on someones buddy list before sending an IM exploit).</li></ul></td>\n";
        echo "</tr>\n";
        echo "<tr><td>&nbsp;</td></tr>\n";
        echo "<tr>\n";
        echo "<td class=\"cal-head\"><b>Low</b></td>\n";
        echo "</tr>\n";
        echo "<tr>\n";
        echo "<td class=\"cal-text\">Specialized access conditions or extenuating circumstances do not exist. The following are examples:<ul><li>The affected product typically requires access to a wide range of systems and users, possibly anonymous and untrusted (e.g., Internet-facing web or mail server).</li><li>The affected configuration is default or ubiquitous.</li><li>The attack can be performed manually and requires little skill or additional information gathering.</li><li>The race condition is a lazy one (i.e., it is technically a race but easily winnable).</li></ul></td>\n";
        echo "</tr>\n";
        echo "</table>\n";
        echo "</div>\n";

        echo "<div id=\"AuthenticationHelp\"  style=\"display:none; visibility:hidden\">\n";
        echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
        echo "<tr>\n";
        echo "<td class=\"cal-head\"><b>None</b></td>\n";
        echo "</tr>\n";
        echo "<tr>\n";
        echo "<td class=\"cal-text\">Authentication is not required to exploit the vulnerability.</td>\n";
        echo "</tr>\n";
        echo "<tr><td>&nbsp;</td></tr>\n";
        echo "<tr>\n";
        echo "<td class=\"cal-head\"><b>Single Instance</b></td>\n";
        echo "</tr>\n";
        echo "<tr>\n";
        echo "<td class=\"cal-text\">The vulnerability requires an attacker to be logged into the system (such as at a command line or via a desktop session or web interface).</td>\n";
        echo "</tr>\n";
        echo "<tr><td>&nbsp;</td></tr>\n";
        echo "<tr>\n";
        echo "<td class=\"cal-head\"><b>Multiple Instances</b></td>\n";
        echo "</tr>\n";
        echo "<tr>\n";        
        echo "<td class=\"cal-text\">Exploiting the vulnerability requires that the attacker authenticate two or more times, even if the same credentials are used each time. An example is an attacker authenticating to an operating system in addition to providing credentials to access an application hosted on that system.</td>\n";
        echo "</tr>\n";
        echo "</table>\n";
        echo "</div>\n";

        echo "<div id=\"ConfImpactHelp\"  style=\"display:none; visibility:hidden\">\n";
        echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
        echo "<tr>\n";
        echo "<td class=\"cal-head\"><b>None</b></td>\n";
        echo "</tr>\n";
        echo "<tr>\n";
        echo "<td class=\"cal-text\">There is no impact to the confidentiality of the system.</td>\n";
        echo "</tr>\n";
        echo "<tr><td>&nbsp;</td></tr>\n";
        echo "<tr>\n";
        echo "<td class=\"cal-head\"><b>Partial</b></td>\n";
        echo "</tr>\n";
        echo "<tr>\n";
        echo "<td class=\"cal-text\">There is considerable informational disclosure. Access to some system files is possible, but the attacker does not have control over what is obtained, or the scope of the loss is constrained. An example is a vulnerability that divulges only certain tables in a database.</td>\n";
        echo "</tr>\n";
        echo "<tr><td>&nbsp;</td></tr>\n";
        echo "<tr>\n";
        echo "<td class=\"cal-head\"><b>Complete</b></td>\n";
        echo "</tr>\n";
        echo "<tr>\n";
        echo "<td class=\"cal-text\">There is total information disclosure, resulting in all system files being revealed. The attacker is able to read all of the system's data (memory, files, etc.)</td>\n";
        echo "</tr>\n";
        echo "</table>\n";
        echo "</div>\n";

        echo "<div id=\"IntegImpactHelp\"  style=\"display:none; visibility:hidden\">\n";
        echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
        echo "<tr>\n";
        echo "<td class=\"cal-head\"><b>None</b></td>\n";
        echo "</tr>\n";
        echo "<tr>\n";        
        echo "<td class=\"cal-text\">There is no impact to the integrity of the system.</td>\n";
        echo "</tr>\n";
        echo "<tr><td>&nbsp;</td></tr>\n";
        echo "<tr>\n";
        echo "<td class=\"cal-head\"><b>Partial</b></td>\n";
        echo "</tr>\n";
        echo "<tr>\n";
        echo "<td class=\"cal-text\">Modification of some system files or information is possible, but the attacker does not have control over what can be modified, or the scope of what the attacker can affect is limited. For example, system or application files may be overwritten or modified, but either the attacker has no control over which files are affected or the attacker can modify files within only a limited context or scope.</td>\n";
        echo "</tr>\n";
        echo "<tr><td>&nbsp;</td></tr>\n";
        echo "<tr>\n";
        echo "<td class=\"cal-head\"><b>Complete</b></td>\n";
        echo "</tr>\n";
        echo "<tr>\n";
        echo "<td class=\"cal-text\">There is a total compromise of system integrity. There is a complete loss of system protection,resulting in the entire system being compromised. The attacker is able to modify any files on the target system.</td>\n";
        echo "</tr>\n";
        echo "</table>\n";
        echo "</div>\n";

        echo "<div id=\"AvailImpactHelp\"  style=\"display:none; visibility:hidden\">\n";
        echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
        echo "<tr>\n";
        echo "<td class=\"cal-head\"><b>None</b></td>\n";
        echo "</tr>\n";
        echo "<tr>\n";
        echo "<td class=\"cal-text\">There is no impact to the availability of the system.</td>\n";
        echo "</tr>\n";
        echo "<tr><td>&nbsp;</td></tr>\n";
        echo "<tr>\n";
        echo "<td class=\"cal-head\"><b>Partial</b></td>\n";
        echo "</tr>\n";
        echo "<tr>\n";
        echo "<td class=\"cal-text\">There is reduced performance or interruptions in resource availability. An example is a network-based flood attack that permits a limited number of successful connections to an Internet service.</td>\n";
        echo "</tr>\n";
        echo "<tr><td>&nbsp;</td></tr>\n";
        echo "<tr>\n";
        echo "<td class=\"cal-head\"><b>Complete</b></td>\n";
        echo "</tr>\n";
        echo "<tr>\n";
        echo "<td class=\"cal-text\">There is a total shutdown of the affected resource. The attacker can render the resource completely unavailable.</td>\n";
        echo "</tr>\n";
        echo "</table>\n";
        echo "</div>\n";

        echo "<div id=\"ExploitabilityHelp\"  style=\"display:none; visibility:hidden\">\n";
        echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
        echo "<tr>\n";
        echo "<td class=\"cal-head\"><b>Unproven that exploit exists</b></td>\n";
        echo "</tr>\n";
        echo "<tr>\n";
        echo "<td class=\"cal-text\">No exploit code is available, or an exploit is entirely theoretical.</td>\n";
        echo "</tr>\n";
        echo "<tr><td>&nbsp;</td></tr>\n";
        echo "<tr>\n";
        echo "<td class=\"cal-head\"><b>Proof of concept code</b></td>\n";
        echo "</tr>\n";
        echo "<tr>\n";
        echo "<td class=\"cal-text\">Proof-of-concept exploit code or an attack demonstration that is not practical for most systems is available. The code or technique is not functional in all situations and may require substantial modification by a skilled attacker.</td>\n";
        echo "</tr>\n";
        echo "<tr><td>&nbsp;</td></tr>\n";
        echo "<tr>\n";
        echo "<td class=\"cal-head\"><b>Functional exploit exists</b></td>\n";
        echo "</tr>\n";
        echo "<tr>\n";
        echo "<td class=\"cal-text\">Functional exploit code is available. The code works in most situations where the vulnerability exists.</td>\n";
        echo "</tr>\n";
        echo "<tr><td>&nbsp;</td></tr>\n";
        echo "<tr>\n";
        echo "<td class=\"cal-head\"><b>Widespread</b></td>\n";
        echo "</tr>\n";
        echo "<tr>\n";
        echo "<td class=\"cal-text\">Either the vulnerability is exploitable by functional mobile autonomous code, or no exploit is required (manual trigger) and details are widely available. The code works in every situation, or is actively being delivered via a mobile autonomous agent (such as a worm or virus).</td>\n";
        echo "</tr>\n";
        echo "</table>\n";
        echo "</div>\n";

        echo "<div id=\"RemediationLevelHelp\"  style=\"display:none; visibility:hidden\">\n";
        echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
        echo "<tr>\n";
        echo "<td class=\"cal-head\"><b>Official Fix</b></td>\n";
        echo "</tr>\n";
        echo "<tr>\n";
        echo "<td class=\"cal-text\">A complete vendor solution is available. Either the vendor has issued an official patch, or an upgrade is available.</td>\n";
        echo "</tr>\n";
        echo "<tr><td>&nbsp;</td></tr>\n";
        echo "<tr>\n";
        echo "<td class=\"cal-head\"><b>Temporary Fix</b></td>\n";
        echo "</tr>\n";
        echo "<tr>\n";
        echo "<td class=\"cal-text\">There is an official but temporary fix available. This includes instances where the vendor issues a temporary hotfix, tool, or workaround.</td>\n";
        echo "</tr>\n";
        echo "<tr><td>&nbsp;</td></tr>\n";
        echo "<tr>\n";
        echo "<td class=\"cal-head\"><b>Workaround</b></td>\n";
        echo "</tr>\n";
        echo "<tr>\n";
        echo "<td class=\"cal-text\">There is an unofficial, non-vendor solution available. In some cases, users of the affected technology will create a patch of their own or provide steps to work around or otherwise mitigate the vulnerability.</td>\n";
        echo "</tr>\n";
        echo "<tr><td>&nbsp;</td></tr>\n";
        echo "<tr>\n";
        echo "<td class=\"cal-head\"><b>Unavailable</b></td>\n";
        echo "</tr>\n";
        echo "<tr>\n";
        echo "<td class=\"cal-text\">There is either no solution available or it is impossible to apply.</td>\n";
        echo "</tr>\n";
        echo "</table>\n";
        echo "</div>\n";

        echo "<div id=\"ReportConfidenceHelp\"  style=\"display:none; visibility:hidden\">\n";
        echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
        echo "<tr>\n";
        echo "<td class=\"cal-head\"><b>Not Confirmed</b></td>\n";
        echo "</tr>\n";
        echo "<tr>\n";
        echo "<td class=\"cal-text\">There is a single unconfirmed source or possibly multiple conflicting reports. There is little confidence in the validity of the reports. An example is a rumor that surfaces from the hacker underground.</td>\n";
        echo "</tr>\n";
        echo "<tr><td>&nbsp;</td></tr>\n";
        echo "<tr>\n";
        echo "<td class=\"cal-head\"><b>Uncorroborated</b></td>\n";
        echo "</tr>\n";
        echo "<tr>\n";
        echo "<td class=\"cal-text\">There are multiple non-official sources, possibly including independent security companies or research organizations. At this point there may be conflicting technical details or some other lingering ambiguity.</td>\n";
        echo "</tr>\n";
        echo "<tr><td>&nbsp;</td></tr>\n";
        echo "<tr>\n";
        echo "<td class=\"cal-head\"><b>Confirmed</b></td>\n";
        echo "</tr>\n";
        echo "<tr>\n";
        echo "<td class=\"cal-text\">The vulnerability has been acknowledged by the vendor or author of the affected technology. The vulnerability may also be ?Confirmed? when its existence is confirmed from an external event such as publication of functional or proof-of-concept exploit code or widespread exploitation.</td>\n";
        echo "</tr>\n";
        echo "</table>\n";
        echo "</div>\n";

        echo "<div id=\"CollateralDamagePotentialHelp\"  style=\"display:none; visibility:hidden\">\n";
        echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
        echo "<tr>\n";
        echo "<td class=\"cal-head\"><b>None</b></td>\n";
        echo "</tr>\n";
        echo "<tr>\n";
        echo "<td class=\"cal-text\">There is no potential for loss of life, physical assets, productivity or revenue.</td>\n";
        echo "</tr>\n";
        echo "<tr><td>&nbsp;</td></tr>\n";
        echo "<tr>\n";
        echo "<td class=\"cal-head\"><b>Low</b></td>\n";
        echo "</tr>\n";
        echo "<tr>\n";
        echo "<td class=\"cal-text\">A successful exploit of this vulnerability may result in slight physical or property damage. Or, there may be a slight loss of revenue or productivity to the organization.</td>\n";
        echo "</tr>\n";
        echo "<tr><td>&nbsp;</td></tr>\n";
        echo "<tr>\n";
        echo "<td class=\"cal-head\"><b>Low-Medium</b></td>\n";
        echo "</tr>\n";
        echo "<tr>\n";
        echo "<td class=\"cal-text\">A successful exploit of this vulnerability may result in moderate physical or property damage. Or, there may be a moderate loss of revenue or productivity to the organization.</td>\n";
        echo "</tr>\n";
        echo "<tr><td>&nbsp;</td></tr>\n";
        echo "<tr>\n";
        echo "<td class=\"cal-head\"><b>Medium-High</b></td>\n";
        echo "</tr>\n";
        echo "<tr>\n";
        echo "<td class=\"cal-text\">A successful exploit of this vulnerability may result in significant physical or property damage or loss. Or, there may be a significant loss of revenue or productivity.</td>\n";
        echo "</tr>\n";
        echo "<tr><td>&nbsp;</td></tr>\n";
        echo "<tr>\n";
        echo "<td class=\"cal-head\"><b>High</b></td>\n";
        echo "</tr>\n";
        echo "<tr>\n";
        echo "<td class=\"cal-text\">A successful exploit of this vulnerability may result in catastrophic physical or property damage and loss. Or, there may be a catastrophic loss of revenue or productivity.</td>\n";
        echo "</tr>\n";
        echo "</table>\n";
        echo "</div>\n";

        echo "<div id=\"TargetDistributionHelp\"  style=\"display:none; visibility:hidden\">\n";
        echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
        echo "<tr>\n";
        echo "<td class=\"cal-head\"><b>None</b></td>\n";
        echo "</tr>\n";
        echo "<tr>\n";
        echo "<td class=\"cal-text\">No target systems exist, or targets are so highly specialized that they only exist in a laboratory setting. Effectively 0% of the environment is at risk.</td>\n";
        echo "</tr>\n";
        echo "<tr><td>&nbsp;</td></tr>\n";
        echo "<tr>\n";
        echo "<td class=\"cal-head\"><b>Low</b></td>\n";
        echo "</tr>\n";
        echo "<tr>\n";
        echo "<td class=\"cal-text\">Targets exist inside the environment, but on a small scale. Between 1% - 25% of the total environment is at risk.</td>\n";
        echo "</tr>\n";
        echo "<tr><td>&nbsp;</td></tr>\n";
        echo "<tr>\n";
        echo "<td class=\"cal-head\"><b>Medium</b></td>\n";
        echo "</tr>\n";
        echo "<tr>\n";
        echo "<td class=\"cal-text\">Targets exist inside the environment, but on a medium scale. Between 26% - 75% of the total environment is at risk.</td>\n";
        echo "</tr>\n";
        echo "<tr><td>&nbsp;</td></tr>\n";
        echo "<tr>\n";
        echo "<td class=\"cal-head\"><b>High</b></td>\n";
        echo "</tr>\n";
        echo "<tr>\n";
        echo "<td class=\"cal-text\">Targets exist inside the environment on a considerable scale. Between 76% - 100% of the total environment is considered at risk.</td>\n";
        echo "</tr>\n";
        echo "</table>\n";
        echo "</div>\n";

        echo "<div id=\"ConfidentialityRequirementHelp\"  style=\"display:none; visibility:hidden\">\n";
        echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
        echo "<tr>\n";
        echo "<td class=\"cal-head\"><b>Low</b></td>\n";
        echo "</tr>\n";
        echo "<tr>\n";
        echo "<td class=\"cal-text\">Loss of confidentiality is likely to have only a limited adverse effect on the organization or individuals associated with the organization (e.g., employees, customers).</td>\n";
        echo "</tr>\n";
        echo "<tr><td>&nbsp;</td></tr>\n";
        echo "<tr>\n";
        echo "<td class=\"cal-head\"><b>Medium</b></td>\n";
        echo "</tr>\n";
        echo "<tr>\n";
        echo "<td class=\"cal-text\">Loss of confidentiality is likely to have a serious adverse effect on the organization or individuals associated with the organization (e.g., employees, customers).</td>\n";
        echo "</tr>\n";
        echo "<tr><td>&nbsp;</td></tr>\n";
        echo "<tr>\n";
        echo "<td class=\"cal-head\"><b>High</b></td>\n";
        echo "</tr>\n";
        echo "<tr>\n";
        echo "<td class=\"cal-text\">Loss of confidentiality is likely to have a catastrophic adverse effect on the organization or individuals associated with the organization (e.g., employees, customers).</td>\n";
        echo "</tr>\n";
        echo "</table>\n";
        echo "</div>\n";

        echo "<div id=\"IntegrityRequirementHelp\"  style=\"display:none; visibility:hidden\">\n";
        echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
        echo "<tr>\n";
        echo "<td class=\"cal-head\"><b>Low</b></td>\n";
        echo "</tr>\n";
        echo "<tr>\n";
        echo "<td class=\"cal-text\">Loss of integrity is likely to have only a limited adverse effect on the organization or individuals associated with the organization (e.g., employees, customers).</td>\n";
        echo "</tr>\n";
        echo "<tr><td>&nbsp;</td></tr>\n";
        echo "<tr>\n";
        echo "<td class=\"cal-head\"><b>Medium</b></td>\n";
        echo "</tr>\n";
        echo "<tr>\n";
        echo "<td class=\"cal-text\">Loss of integrity is likely to have a serious adverse effect on the organization or individuals associated with the organization (e.g., employees, customers).</td>\n";
        echo "</tr>\n";
        echo "<tr><td>&nbsp;</td></tr>\n";
        echo "<tr>\n";
        echo "<td class=\"cal-head\"><b>High</b></td>\n";
        echo "</tr>\n";
        echo "<tr>\n";
        echo "<td class=\"cal-text\">Loss of integrity is likely to have a catastrophic adverse effect on the organization or individuals associated with the organization (e.g., employees, customers).</td>\n";
        echo "</tr>\n";
        echo "</table>\n";
        echo "</div>\n";

        echo "<div id=\"AvailabilityRequirementHelp\"  style=\"display:none; visibility:hidden\">\n";
        echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
        echo "<tr>\n";
        echo "<td class=\"cal-head\"><b>Low</b></td>\n";
        echo "</tr>\n";
        echo "<tr>\n";
        echo "<td class=\"cal-text\">Loss of availability is likely to have only a limited adverse effect on the organization or individuals associated with the organization (e.g., employees, customers).</td>\n";
        echo "</tr>\n";
        echo "<tr><td>&nbsp;</td></tr>\n";
        echo "<tr>\n";
        echo "<td class=\"cal-head\"><b>Medium</b></td>\n";
        echo "</tr>\n";
        echo "<tr>\n";
        echo "<td class=\"cal-text\">Loss of availability is likely to have a serious adverse effect on the organization or individuals associated with the organization (e.g., employees, customers).</td>\n";
        echo "</tr>\n";
        echo "<tr><td>&nbsp;</td></tr>\n";
        echo "<tr>\n";
        echo "<td class=\"cal-head\"><b>High</b></td>\n";
        echo "</tr>\n";
        echo "<tr>\n";
        echo "<td class=\"cal-text\">Loss of availability is likely to have a catastrophic adverse effect on the organization or individuals associated with the organization (e.g., employees, customers).</td>\n";
        echo "</tr>\n";
        echo "</table>\n";
        echo "</div>\n";

        echo "<script language=\"javascript\">\n";
        echo "function showHelp(divId) {\n";
        echo "getRef(\"divHelp\").innerHTML=getRef(divId).innerHTML;\n";
        echo "}\n";
        echo "function hideHelp() {\n";
        echo "getRef(\"divHelp\").innerHTML=\"\";\n";
        echo "}\n";
        echo "</script>\n";
}

/*****************************
 * FUNCTION: VIEW DREAD HELP *
 *****************************/
function view_dread_help()
{
	echo "<div id=\"divHelp\" style=\"width:100%;overflow:auto\"></div>\n";

        echo "<div id=\"DamagePotentialHelp\"  style=\"display:none; visibility:hidden\">\n";
        echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
        echo "<tr>\n";
        echo "<td class=\"cal-text\">\n";
        echo "<br /><p><b>If a threat exploit occurs, how much damage will be caused?</b></p>\n";
        echo "<p>0 = Nothing</p>\n";
        echo "<p>5 = Individual user data is compromised or affected.</p>\n";
        echo "<p>10 = Complete system or data destruction</p>\n";
        echo "</td>\n";
        echo "</tr>\n";
        echo "</table>\n";
        echo "</div>\n";

        echo "<div id=\"ReproducibilityHelp\"  style=\"display:none; visibility:hidden\">\n";
        echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
        echo "<tr>\n";
        echo "<td class=\"cal-text\">\n";
        echo "<br /><p><b>How easy is it to reproduce the threat exploit?</b></p>\n";
        echo "<p>0 = Very hard or impossible, even for administrators of the application.</p>\n";
        echo "<p>5 = One or two steps required, may need to be an authorized user.</p>\n";
        echo "<p>10 = Just a web browser and the address bar is sufficient, without authentication.</p>\n";
        echo "</td>\n";
        echo "</tr>\n";
        echo "</table>\n";
        echo "</div>\n";

        echo "<div id=\"ExploitabilityHelp\"  style=\"display:none; visibility:hidden\">\n";
        echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
        echo "<tr>\n";
        echo "<td class=\"cal-text\">\n";
        echo "<br /><p><b>What is needed to exploit this threat?</b></p>\n";
        echo "<p>0 = Advanced programming and networking knowledge, with custom or advanced attack tools.</p>\n";
        echo "<p>5 = Malware exists on the Internet, or an exploit is easily performed, using available attack tools.</p>\n";
        echo "<p>10 = Just a web browser</p>\n";
        echo "</td>\n";
        echo "</tr>\n";
        echo "</table>\n";
        echo "</div>\n";

        echo "<div id=\"AffectedUsersHelp\"  style=\"display:none; visibility:hidden\">\n";
        echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
        echo "<tr>\n";
        echo "<td class=\"cal-text\">\n";
        echo "<br /><p><b>How many users will be affected?</b></p>\n";
        echo "<p>0 = None</p>\n";
        echo "<p>5 = Some users, but not all</p>\n";
        echo "<p>10 = All users</p>\n";
        echo "</td>\n";
        echo "</tr>\n";
        echo "</table>\n";
        echo "</div>\n";

        echo "<div id=\"DiscoverabilityHelp\"  style=\"display:none; visibility:hidden\">\n";
        echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
        echo "<tr>\n";
        echo "<td class=\"cal-text\">\n";
        echo "<br /><p><b>How easy is it to discover this threat?</b></p>\n";
        echo "<p>0 = Very hard to impossible; requires source code or administrative access.</p>\n";
        echo "<p>5 = Can figure it out by guessing or by monitoring network traces.</p>\n";
        echo "<p>9 = Details of faults like this are already in the public domain and can be easily discovered using a search engine.</p>\n";
        echo "<p>10 = The information is visible in the web browser address bar or in a form.</p>\n";
        echo "</td>\n";
        echo "</tr>\n";
        echo "</table>\n";
        echo "</div>\n";

        echo "<script language=\"javascript\">\n";
        echo "function showHelp(divId) {\n";
        echo "getRef(\"divHelp\").innerHTML=getRef(divId).innerHTML;\n";
        echo "}\n";
        echo "function hideHelp() {\n";
        echo "getRef(\"divHelp\").innerHTML=\"\";\n";
        echo "}\n";
        echo "</script>\n";
}

/***************************
 * FUNCTION: VIEW TOP MENU *
 ***************************/
function view_top_menu($active)
{
	global $lang;
	global $escaper;

	echo "<div class=\"navbar\">\n";
	echo "<div class=\"navbar-inner\">\n";
	echo "<div class=\"container\">\n";
	echo "<a class=\"brand\" href=\"http://www.simplerisk.org/\">SimpleRisk</a>\n";
	echo "<div class=\"navbar-content\">\n";
	echo "<ul class=\"nav\">\n";

	// If the page is in the root directory
	if ($active == "Home")
	{
		echo "<li class=\"active\">\n";
		echo "<a href=\"index.php\">" . $escaper->escapeHtml($lang['Home']) . "</a>\n";
		echo "</li>\n";
		echo "<li>\n";
		echo "<a href=\"management/index.php\">" . $escaper->escapeHtml($lang['RiskManagement']) . "</a>\n";
		echo "</li>\n";

		// If the user has asset management permissions
		if (isset($_SESSION["asset"]) && $_SESSION["asset"] == "1")
		{
			echo ($active == "AssetManagement" ? "<li class=\"active\">\n" : "<li>\n");
			echo "<a href=\"assets/index.php\">" . $escaper->escapeHtml($lang['AssetManagement']) . "</a>\n";
			echo "</li>\n";
		}

		echo "<li>\n";
		echo "<a href=\"reports/index.php\">" . $escaper->escapeHtml($lang['Reporting']) . "</a>\n";
		echo "</li>\n";

		// If the user is logged in as an administrator
		if (isset($_SESSION["admin"]) && $_SESSION["admin"] == "1")
		{
			echo ($active == "Configure" ? "<li class=\"active\">\n" : "<li>\n");
			echo "<a href=\"admin/index.php\">". $escaper->escapeHtml($lang['Configure']) ."</a>\n";
			echo "</li>\n";
		}

                echo "</ul>\n";
                echo "</div>\n";

                // If the user is logged in
                if (isset($_SESSION["access"]) && $_SESSION["access"] == "granted")
                {
                        // Show the user profile menu
                        echo "<div class=\"btn-group pull-right\">\n";
                        echo "<a class=\"btn dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\">" . $escaper->escapeHtml($_SESSION['name']) . "<span class=\"caret\"></span></a>\n";
                        echo "<ul class=\"dropdown-menu\">\n";
                        echo "<li>\n";
                        echo "<a href=\"account/profile.php\">". $escaper->escapeHtml($lang['MyProfile']) ."</a>\n";
                        echo "</li>\n";
                        echo "<li>\n";
                        echo "<a href=\"logout.php\">". $escaper->escapeHtml($lang['Logout']) ."</a>\n";
                        echo "</li>\n";
                        echo "</ul>\n";
                        echo "</div>\n";
                }
	}
	// If the page is in another sub-directory
	else
	{
		echo ($active == "Home" ? "<li class=\"active\">\n" : "<li>\n");
		echo "<a href=\"../index.php\">" . $escaper->escapeHtml($lang['Home']) . "</a>\n";
		echo "</li>\n";

		echo ($active == "RiskManagement" ? "<li class=\"active\">\n" : "<li>\n");
		echo "<a href=\"../management/index.php\">" . $escaper->escapeHtml($lang['RiskManagement']) . "</a>\n";
		echo "</li>\n";

		// If the user has asset management permissions
		if (isset($_SESSION["asset"]) && $_SESSION["asset"] == "1")
		{
			echo ($active == "AssetManagement" ? "<li class=\"active\">\n" : "<li>\n");
			echo "<a href=\"../assets/index.php\">" . $escaper->escapeHtml($lang['AssetManagement']) . "</a>\n";
			echo "</li>\n";
		}

		echo ($active == "Reporting" ? "<li class=\"active\">\n" : "<li>\n");
		echo "<a href=\"../reports/index.php\">" . $escaper->escapeHtml($lang['Reporting']) . "</a>\n";
		echo "</li>\n";

		// If the user is logged in as an administrator
		if (isset($_SESSION["admin"]) && $_SESSION["admin"] == "1")
		{
			echo ($active == "Configure" ? "<li class=\"active\">\n" : "<li>\n");
			echo "<a href=\"../admin/index.php\">". $escaper->escapeHtml($lang['Configure']) ."</a>\n";
			echo "</li>\n";
		}

		echo "<li>\n";
		echo "<div style=\"width:150px; height:35px; line-height:45px; text-align:center;\">\n";
		echo "<form name=\"search\" action=\"../management/view.php\" method=\"get\">\n";
		echo "<input type=\"text\" size=\"6\" name=\"id\" value=\"ID#\" style=\"border-style: inset; font-size:10px; height:15px; line-height:35px; width:25px; text-align:center;\" onClick=\"this.setSelectionRange(0, this.value.length)\" />\n";
		echo "<a href=\"javascript:document.search.submit()\"><img src=\"../images/search.png\" width=\"20px\" heigh=\"20px\" style=\"margin-top: -10px;\" alt=\"Search\" /></a>\n";
		echo "</form>\n";
		echo "</div>\n";
		echo "</li>\n";

		echo "</ul>\n";
		echo "</div>\n";

		// If the user is logged in
		if (isset($_SESSION["access"]) && $_SESSION["access"] == "granted")
		{
                	// Show the user profile menu
                	echo "<div class=\"btn-group pull-right\">\n";
                	echo "<a class=\"btn dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\">" . $escaper->escapeHtml($_SESSION['name']) . "<span class=\"caret\"></span></a>\n";
                	echo "<ul class=\"dropdown-menu\">\n";
                	echo "<li>\n";
                	echo "<a href=\"../account/profile.php\">". $escaper->escapeHtml($lang['MyProfile']) ."</a>\n";
                	echo "</li>\n";
                	echo "<li>\n";
                	echo "<a href=\"../logout.php\">". $escaper->escapeHtml($lang['Logout']) ."</a>\n";
                	echo "</li>\n";
                	echo "</ul>\n";
                	echo "</div>\n";
		}
	}
		
	echo "</div>\n";
	echo "</div>\n";
	echo "</div>\n";
}

/***************************************
 * FUNCTION: VIEW RISK MANAGEMENT MENU *
 ***************************************/
function view_risk_management_menu($active)
{
	global $lang;
	global $escaper;

        echo "<ul class=\"nav nav-pills nav-stacked\">\n";
        echo ($active == "SubmitYourRisks" ? "<li class=\"active\">\n" : "<li>\n");
        echo "<a href=\"index.php\">I. " . $escaper->escapeHtml($lang['SubmitYourRisks']) . "</a>\n";
        echo "</li>\n";
        echo ($active == "PlanYourMitigations" ? "<li class=\"active\">\n" : "<li>\n");
        echo "<a href=\"plan_mitigations.php\">II. " . $escaper->escapeHtml($lang['PlanYourMitigations']) . "</a>\n";
        echo "</li>\n";
        echo ($active == "PerformManagementReviews" ? "<li class=\"active\">\n" : "<li>\n");
        echo "<a href=\"management_review.php\">III. " . $escaper->escapeHtml($lang['PerformManagementReviews']) . "</a>\n";
        echo "</li>\n";
        echo ($active == "PrioritizeForProjectPlanning" ? "<li class=\"active\">\n" : "<li>\n");
        echo "<a href=\"prioritize_planning.php\">IV. " . $escaper->escapeHtml($lang['PrioritizeForProjectPlanning']) . "</a>\n";
        echo "</li>\n";
        echo ($active == "ReviewRisksRegularly" ? "<li class=\"active\">\n" : "<li>\n");
        echo "<a href=\"review_risks.php\">V. " . $escaper->escapeHtml($lang['ReviewRisksRegularly']) . "</a>\n";
        echo "</li>\n";
	echo "</ul>\n";
}

/***************************************
 * FUNCTION: VIEW ASSET MANAGEMENT MENU *
 ***************************************/
function view_asset_management_menu($active)
{
        global $lang;
        global $escaper;

        echo "<ul class=\"nav nav-pills nav-stacked\">\n";
        echo ($active == "AutomatedDiscovery" ? "<li class=\"active\">\n" : "<li>\n");
        echo "<a href=\"index.php\">I. " . $escaper->escapeHtml($lang['AutomatedDiscovery']) . "</a>\n";
        echo "</li>\n";
        echo ($active == "BatchImport" ? "<li class=\"active\">\n" : "<li>\n");
        echo "<a href=\"batch.php\">II. " . $escaper->escapeHtml($lang['BatchImport']) . "</a>\n";
        echo "</li>\n";
        echo ($active == "ManageAssets" ? "<li class=\"active\">\n" : "<li>\n");
        echo "<a href=\"manage.php\">III. " . $escaper->escapeHtml($lang['ManageAssets']) . "</a>\n";
        echo "</li>\n";
        echo ($active == "AssetValuation" ? "<li class=\"active\">\n" : "<li>\n");
        echo "<a href=\"valuation.php\">IV. " . $escaper->escapeHtml($lang['AssetValuation']) . "</a>\n";
        echo "</li>\n";
	echo "</ul>\n";
}

/*********************************
 * FUNCTION: VIEW REPORTING MENU *
 *********************************/
function view_reporting_menu($active)
{
	global $lang;
	global $escaper;

        echo "<ul class=\"nav nav-pills nav-stacked\">\n";
        echo ($active == "RiskDashboard" ? "<li class=\"active\">\n" : "<li>\n");
        echo "<a href=\"index.php\">" . $escaper->escapeHtml($lang['RiskDashboard']) . "</a>\n";
        echo "</li>\n";
        echo ($active == "RiskTrend" ? "<li class=\"active\">\n" : "<li>\n");
        echo "<a href=\"trend.php\">" . $escaper->escapeHtml($lang['RiskTrend']) . "</a>\n";
        echo "</li>\n";
	echo ($active == "DynamicRiskReport" ? "<li class=\"active\">\n" : "<li>\n");
	echo "<a href=\"dynamic_risk_report.php\">" . $escaper->escapeHtml($lang['DynamicRiskReport']) . "</a>\n";
	echo "</li>\n";
        echo ($active == "AllOpenRisksAssignedToMeByRiskLevel" ? "<li class=\"active\">\n" : "<li>\n");
        echo "<a href=\"my_open.php\">" . $escaper->escapeHtml($lang['AllOpenRisksAssignedToMeByRiskLevel']) . "</a>\n";
        echo "</li>\n";
        echo ($active == "AllOpenRisksNeedingReview" ? "<li class=\"active\">\n" : "<li>\n");
        echo "<a href=\"review_needed.php\">" . $escaper->escapeHtml($lang['AllOpenRisksNeedingReview']) . "</a>\n";
        echo "</li>\n";
        echo ($active == "HighRiskReport" ? "<li class=\"active\">\n" : "<li>\n");
        echo "<a href=\"high.php\">" . $escaper->escapeHtml($lang['HighRiskReport']) . "</a>\n";
        echo "</li>\n";
        echo ($active == "SubmittedRisksByDate" ? "<li class=\"active\">\n" : "<li>\n");
        echo "<a href=\"submitted_by_date.php\">" . $escaper->escapeHtml($lang['SubmittedRisksByDate']) . "</a>\n";
        echo "</li>\n";
        echo ($active == "MitigationsByDate" ? "<li class=\"active\">\n" : "<li>\n");
        echo "<a href=\"mitigations_by_date.php\">" . $escaper->escapeHtml($lang['MitigationsByDate']) . "</a>\n";
        echo "</li>\n";
        echo ($active == "ManagementReviewsByDate" ? "<li class=\"active\">\n" : "<li>\n");
        echo "<a href=\"mgmt_reviews_by_date.php\">" . $escaper->escapeHtml($lang['ManagementReviewsByDate']) . "</a>\n";
        echo "</li>\n";
        echo ($active == "ClosedRisksByDate" ? "<li class=\"active\">\n" : "<li>\n");
        echo "<a href=\"closed_by_date.php\">" . $escaper->escapeHtml($lang['ClosedRisksByDate']) . "</a>\n";
        echo "</li>\n";

	// Obsolete Reports
	echo "<li id=\"obsolete_menu\"><a href=\"#\" onclick=\"javascript:showObsolete()\">" . $escaper->escapeHtml($lang['ObsoleteReports']) . "</a></li>\n";
	echo ($active == "AllOpenRisksByRiskLevel" ? "<li class=\"active obsolete\" style=\"display:none;\">\n" : "<li class=\"obsolete\" style=\"display:none;\">\n");
        echo "<a href=\"open.php\">" . $escaper->escapeHtml($lang['AllOpenRisksByRiskLevel']) . "</a>\n";
        echo "</li>\n";
	echo ($active == "AllClosedRisksByRiskLevel" ? "<li class=\"active obsolete\" style=\"display:none;\">\n" : "<li class=\"obsolete\" style=\"display:none;\">\n");
        echo "<a href=\"closed.php\">" . $escaper->escapeHtml($lang['AllClosedRisksByRiskLevel']) . "</a>\n";
        echo "</li>\n";
	echo ($active == "AllOpenRisksByTeam" ? "<li class=\"active obsolete\" style=\"display:none;\">\n" : "<li class=\"obsolete\" style=\"display:none;\">\n");
	echo "<a href=\"teams.php\">" . $escaper->escapeHtml($lang['AllOpenRisksByTeam']) . "</a>\n";
        echo "</li>\n";
        echo ($active == "AllOpenRisksByTechnology" ? "<li class=\"active obsolete\" style=\"display:none;\">\n" : "<li class=\"obsolete\" style=\"display:none;\">\n");
        echo "<a href=\"technologies.php\">" . $escaper->escapeHtml($lang['AllOpenRisksByTechnology']) . "</a>\n";
        echo "</li>\n";
        echo ($active == "AllOpenRisksByScoringMethod" ? "<li class=\"active osbolete\" style=\"display:none;\">\n" : "<li class=\"obsolete\" style=\"display:none;\">\n");
        echo "<a href=\"risk_scoring.php\">" . $escaper->escapeHtml($lang['AllOpenRisksByScoringMethod']) . "</a>\n";
        echo "</li>\n";
        echo ($active == "AllOpenRisksConsideredForProjectsByRiskLevel" ? "<li class=\"active osbolete\" style=\"display:none;\">\n" : "<li class=\"obsolete\" style=\"display:none;\">\n");
        echo "<a href=\"projects.php\">" . $escaper->escapeHtml($lang['AllOpenRisksConsideredForProjectsByRiskLevel']) . "</a>\n";
        echo "</li>\n";
        echo ($active == "AllOpenRisksAcceptedUntilNextReviewByRiskLevel" ? "<li class=\"active osbolete\" style=\"display:none;\">\n" : "<li class=\"obsolete\" style=\"display:none;\">\n");
        echo "<a href=\"next_review.php\">" . $escaper->escapeHtml($lang['AllOpenRisksAcceptedUntilNextReviewByRiskLevel']) . "</a>\n";
        echo "</li>\n";
        echo ($active == "AllOpenRisksToSubmitAsAProductionIssueByRiskLevel" ? "<li class=\"active osbolete\" style=\"display:none;\">\n" : "<li class=\"obsolete\" style=\"display:none;\">\n");
        echo "<a href=\"production_issues.php\">" . $escaper->escapeHtml($lang['AllOpenRisksToSubmitAsAProductionIssueByRiskLevel']) . "</a>\n";
        echo "</li>\n";
	echo ($active == "ProjectsAndRisksAssigned" ? "<li class=\"active obsolete\" style=\"display:none;\">\n" : "<li class=\"obsolete\" style=\"display:none;\">\n");
        echo "<a href=\"projects_and_risks.php\">" . $escaper->escapeHtml($lang['ProjectsAndRisksAssigned']) . "</a>\n";
	echo "</li>\n";
	echo "</ul>\n";
}

/*********************************
 * FUNCTION: VIEW CONFIGURE MENU *
 *********************************/
function view_configure_menu($active)
{
	global $lang;
	global $escaper;

	echo "<ul class=\"nav nav-pills nav-stacked\">\n";
	echo ($active == "ConfigureRiskFormula" ? "<li class=\"active\">\n" : "<li>\n");
        echo "<a href=\"index.php\">" . $escaper->escapeHtml($lang['ConfigureRiskFormula']) . "</a>\n";
        echo "</li>\n";
	echo ($active == "ConfigureReviewSettings" ? "<li class=\"active\">\n" : "<li>\n");
        echo "<a href=\"review_settings.php\">" . $escaper->escapeHtml($lang['ConfigureReviewSettings']) . "</a>\n";
        echo "</li>\n";
	echo ($active == "AddAndRemoveValues" ? "<li class=\"active\">\n" : "<li>\n");
	echo "<a href=\"add_remove_values.php\">" . $escaper->escapeHtml($lang['AddAndRemoveValues']) . "</a>\n";
        echo "</li>\n";
	echo ($active == "UserManagement" ? "<li class=\"active\">\n" : "<li>\n");
        echo "<a href=\"user_management.php\">" . $escaper->escapeHtml($lang['UserManagement']) . "</a>\n";
        echo "</li>\n";
	echo ($active == "RedefineNamingConventions" ? "<li class=\"active\">\n" : "<li>\n");
        echo "<a href=\"custom_names.php\">" . $escaper->escapeHtml($lang['RedefineNamingConventions']) . "</a>\n";
        echo "</li>\n";
	echo ($active == "DeleteRisks" ? "<li class=\"active\">\n" : "<li>\n");
	echo "<a href=\"delete_risks.php\">" . $escaper->escapeHtml($lang['DeleteRisks']) . "</a>\n";
	echo "</li>\n";
	echo ($active == "AuditTrail" ? "<li class=\"active\">\n" : "<li>\n");
        echo "<a href=\"audit_trail.php\">" . $escaper->escapeHtml($lang['AuditTrail']) . "</a>\n";
        echo "</li>\n";

	// If the Import/Export Extra is enabled
	if (import_export_extra())
	{
		echo ($active == "ImportExport" ? "<li class=\"active\">\n" : "<li>\n");
		echo "<a href=\"importexport.php\">" . $escaper->escapeHtml($lang['Import']) . "/" . $escaper->escapeHtml($lang['Export']) . "</a>\n";
		echo "</li>\n";
	}

	echo ($active == "Extras" ? "<li class=\"active\">\n" : "<li>\n");
        echo "<a href=\"extras.php\">" . $escaper->escapeHtml($lang['Extras']) . "</a>\n";
        echo "</li>\n";
	echo ($active == "Announcements" ? "<li class=\"active\">\n" : "<li>\n");
        echo "<a href=\"announcements.php\">" . $escaper->escapeHtml($lang['Announcements']) . "</a>\n";
        echo "</li>\n";
	echo ($active == "About" ? "<li class=\"active\">\n" : "<li>\n");
        echo "<a href=\"about.php\">" . $escaper->escapeHtml($lang['About']) . "</a>\n";
        echo "</li>\n";
        echo "</ul>\n";
}

/******************************************
 * FUNCTION: VIEW GET RISKS BY SELECTIONS *
 ******************************************/
function view_get_risks_by_selections($status=0, $group=0, $sort=0, $id=true, $risk_status=false, $subject=true, $reference_id=false, $regulation=false, $control_number=false, $location=false, $category=false, $team=false, $technology=false, $owner=false, $manager=false, $submitted_by=false, $scoring_method=false, $calculated_risk=true, $submission_date=true, $review_date=false, $project=false, $mitigation_planned=true, $management_review=true, $days_open=false, $next_review_date=false, $next_step=false)
{
	global $lang;
	global $escaper;

	echo "<form name=\"get_risks_by\" method=\"post\" action=\"\">\n";
	echo "<div class=\"row-fluid\">\n";
	echo "<div class=\"span12\">\n";
        echo "<a href=\"javascript:;\" onclick=\"javascript: closeSearchBox()\"><img src=\"../images/X-100.png\" width=\"10\" height=\"10\" align=\"right\" /></a>\n";
        echo "</div>\n";
	echo "</div>\n";
	echo "<div class=\"row-fluid\">\n";

	// Risk Status Selection
	echo "<div class=\"span4\">\n";
        echo "<div class=\"well\">\n";
	echo "<h4>" . $escaper->escapeHtml($lang['Status']) . ":</h4>\n";
	echo "<select id=\"status\" name=\"status\" onchange=\"javascript: submit()\">\n";
	echo "<option value=\"0\"" . ($status == 0 ? " selected" : "") . ">" . $escaper->escapeHtml($lang['OpenRisks']) . "</option>\n";
	echo "<option value=\"1\"" . ($status == 1 ? " selected" : "") . ">" . $escaper->escapeHtml($lang['ClosedRisks']) . "</option>\n";
	echo "<option value=\"2\"" . ($status == 2 ? " selected" : "") . ">" . $escaper->escapeHtml($lang['AllRisks']) . "</option>\n";
	echo "</select>\n";
        echo "</div>\n";
	echo "</div>\n";

	// Group By Selection
        echo "<div class=\"span4\">\n";
        echo "<div class=\"well\">\n";
	echo "<h4>" . $escaper->escapeHtml($lang['GroupBy']) . ":</h4>\n";
        echo "<select id=\"group\" name=\"group\" onchange=\"javascript: submit()\">\n";
        echo "<option value=\"0\"" . ($group == 0 ? " selected" : "") . ">" . $escaper->escapeHtml($lang['None']) . "</option>\n";
	echo "<option value=\"1\"" . ($group == 1 ? " selected" : "") . ">" . $escaper->escapeHtml($lang['RiskLevel']) . "</option>\n";
	echo "<option value=\"2\"" . ($group == 2 ? " selected" : "") . ">" . $escaper->escapeHtml($lang['Status']) . "</option>\n";
	echo "<option value=\"3\"" . ($group == 3 ? " selected" : "") . ">" . $escaper->escapeHtml($lang['SiteLocation']) . "</option>\n";
	echo "<option value=\"4\"" . ($group == 4 ? " selected" : "") . ">" . $escaper->escapeHtml($lang['Category']) . "</option>\n";
	echo "<option value=\"5\"" . ($group == 5 ? " selected" : "") . ">" . $escaper->escapeHtml($lang['Team']) . "</option>\n";
	echo "<option value=\"6\"" . ($group == 6 ? " selected" : "") . ">" . $escaper->escapeHtml($lang['Technology']) . "</option>\n";
	echo "<option value=\"7\"" . ($group == 7 ? " selected" : "") . ">" . $escaper->escapeHtml($lang['Owner']) . "</option>\n";
	echo "<option value=\"8\"" . ($group == 8 ? " selected" : "") . ">" . $escaper->escapeHtml($lang['OwnersManager']) . "</option>\n";
	echo "<option value=\"9\"" . ($group == 9 ? " selected" : "") . ">" . $escaper->escapeHtml($lang['RiskScoringMethod']) . "</option>\n";
	echo "<option value=\"10\"" . ($group == 10 ? " selected" : "") . ">" . $escaper->escapeHtml($lang['ControlRegulation']) . "</option>\n";
	echo "<option value=\"11\"" . ($group == 11 ? " selected" : "") . ">" . $escaper->escapeHtml($lang['Project']) . "</option>\n";
	echo "<option value=\"12\"" . ($group == 12 ? " selected" : "") . ">" . $escaper->escapeHtml($lang['NextStep']) . "</option>\n";
	echo "<option value=\"13\"" . ($group == 13 ? " selected" : "") . ">" . $escaper->escapeHtml($lang['MonthSubmitted']) . "</option>\n";
	echo "</select>\n";
        echo "</div>\n";
        echo "</div>\n";

	// Sort By Selection
	echo "<div class=\"span4\">\n";
	echo "<div class=\"well\">\n";
	echo "<h4>" . $escaper->escapeHtml($lang['SortBy']) . ":</h4>\n";
	echo "<select id=\"sort\" name=\"sort\" onchange=\"javascript: submit()\">\n";
	echo "<option value=\"0\"" . ($sort == 0 ? " selected" : "") . ">" . $escaper->escapeHtml($lang['CalculatedRisk']) . "</option>\n";
	echo "<option value=\"1\"" . ($sort == 1 ? " selected" : "") . ">" . $escaper->escapeHtml($lang['ID']) . "</option>\n";
	echo "<option value=\"2\"" . ($sort == 2 ? " selected" : "") . ">" . $escaper->escapeHtml($lang['Subject']) . "</option>\n";
	echo "</select>\n";
	echo "</div>\n";
	echo "</div>\n";

	echo "</div>\n";
	echo "<div class=\"row-fluid\">\n";

	// Included Columns Selection
        echo "<div class=\"span12\">\n";
        echo "<div class=\"well\">\n";
	echo "<h4>" . $lang['IncludedColumns'] . ":</h4>\n";
	echo "<table border=\"0\">\n";
	echo "<tr>\n";
	echo "<td><input type=\"checkbox\" name=\"id\" id=\"checkbox_id\"" . ($id == true ? " checked=\"yes\"" : "") . " onchange=\"javascript: check_id()\" /></td><td>" . $escaper->escapeHtml($lang['ID']) . "</td>\n";
	echo "<td width=\"10px\"></td>\n";
	echo "<td><input type=\"checkbox\" name=\"risk_status\" id=\"checkbox_risk_status\"" . ($risk_status == true ? " checked=\"yes\"" : "") . " onchange=\"javascript: check_status()\" onchange=\"javascript: submit()\" /></td><td>" . $escaper->escapeHtml($lang['Status']) . "</td>\n";
	echo "<td width=\"10px\"></td>\n";
	echo "<td><input type=\"checkbox\" name=\"subject\" id=\"checkbox_subject\"" . ($subject == true ? " checked=\"yes\"" : "") . " onchange=\"javascript: check_subject()\" /></td><td>" . $escaper->escapeHtml($lang['Subject']) . "</td>\n";
	echo "<td width=\"10px\"></td>\n";
	echo "<td><input type=\"checkbox\" name=\"reference_id\" id=\"checkbox_reference_id\"" . ($reference_id == true ? " checked=\"yes\"" : "") . " onchange=\"javascript: check_reference_id()\" /></td><td>" . $escaper->escapeHtml($lang['ExternalReferenceId']) . "</td>\n";
	echo "<td><input type=\"checkbox\" name=\"regulation\" id=\"checkbox_regulation\"" . ($regulation == true ? " checked=\"yes\"" : "") . " onchange=\"javascript: check_regulation()\" /></td><td>" . $escaper->escapeHtml($lang['ControlRegulation']) . "</td>\n";
	echo "<td width=\"10px\"></td>\n";
	echo "<td><input type=\"checkbox\" name=\"control_number\" id=\"checkbox_control_number\"" . ($control_number == true ? " checked=\"yes\"" : "") . " onchange=\"javascript: check_control_number()\" /></td><td>" . $escaper->escapeHtml($lang['ControlNumber']) . "</td>\n";
	echo "<td width=\"10px\"></td>\n";
	echo "<td><input type=\"checkbox\" name=\"location\" id=\"checkbox_location\"" . ($location == true ? " checked=\"yes\"" : "") . " onchange=\"javascript: check_location()\" /></td><td>" . $escaper->escapeHtml($lang['SiteLocation']) . "</td>\n";
	echo "<td width=\"10px\"></td>\n";
	echo "<td><input type=\"checkbox\" name=\"category\" id=\"checkbox_category\"" . ($category == true ? " checked=\"yes\"" : "") . " onchange=\"javascript: check_category()\" /></td><td>" . $escaper->escapeHtml($lang['Category']) . "</td>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "<td><input type=\"checkbox\" name=\"team\" id=\"checkbox_team\"" . ($team == true ? " checked=\"yes\"" : "") . " onchange=\"javascript: check_team()\" /></td><td>" . $escaper->escapeHtml($lang['Team']) . "</td>\n";
	echo "<td width=\"10px\"></td>\n";
	echo "<td><input type=\"checkbox\" name=\"technology\" id=\"checkbox_technology\"" . ($technology == true ? " checked=\"yes\"" : "") . " onchange=\"javascript: check_technology()\" /></td><td>" . $escaper->escapeHtml($lang['Technology']) . "</td>\n";
	echo "<td width=\"10px\"></td>\n";
	echo "<td><input type=\"checkbox\" name=\"owner\" id=\"checkbox_owner\"" . ($owner == true ? " checked=\"yes\"" : "") . " onchange=\"javascript: check_owner()\" /></td><td>" . $escaper->escapeHtml($lang['Owner']) . "</td>\n";
	echo "<td width=\"10px\"></td>\n";
	echo "<td><input type=\"checkbox\" name=\"manager\" id=\"checkbox_manager\"" . ($manager == true ? " checked=\"yes\"" : "") . " onchange=\"javascript: check_manager()\" /></td><td>" . $escaper->escapeHtml($lang['OwnersManager']) . "</td>\n";
	echo "<td><input type=\"checkbox\" name=\"submitted_by\" id=\"checkbox_submitted_by\"" . ($submitted_by == true ? " checked=\"yes\"" : "") . " onchange=\"javascript: check_submitted_by()\" /></td><td>" . $escaper->escapeHtml($lang['SubmittedBy']) . "</td>\n";
	echo "<td width=\"10px\"></td>\n";
	echo "<td><input type=\"checkbox\" name=\"scoring_method\" id=\"checkbox_scoring_method\"" . ($scoring_method == true ? " checked=\"yes\"" : "") . " onchange=\"javascript: check_scoring_method()\" /></td><td>" . $escaper->escapeHtml($lang['RiskScoringMethod']) . "</td>\n";
	echo "<td width=\"10px\"></td>\n";
	echo "<td><input type=\"checkbox\" name=\"calculated_risk\" id=\"checkbox_calculated_risk\"" . ($calculated_risk == true ? " checked=\"yes\"" : "") . " onchange=\"javascript: check_calculated_risk()\" /></td><td>" . $escaper->escapeHtml($lang['CalculatedRisk']) . "</td>\n";
	echo "<td width=\"10px\"></td>\n";
	echo "<td><input type=\"checkbox\" name=\"submission_date\" id=\"checkbox_submission_date\"" . ($submission_date == true ? " checked=\"yes\"" : "") . " onchange=\"javascript: check_submission_date()\" /></td><td>" . $escaper->escapeHtml($lang['SubmissionDate']) . "</td>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "<td><input type=\"checkbox\" name=\"review_date\" id=\"checkbox_review_date\"" . ($review_date == true ? " checked=\"yes\"" : "") . " onchange=\"javascript: check_review_date()\" /></td><td>" . $escaper->escapeHtml($lang['ReviewDate']) . "</td>\n";
	echo "<td width=\"10px\"></td>\n";
	echo "<td><input type=\"checkbox\" name=\"project\" id=\"checkbox_project\"" . ($project == true ? " checked=\"yes\"" : "") . " onchange=\"javascript: check_project()\" /></td><td>" . $escaper->escapeHtml($lang['Project']) . "</td>\n";
	echo "<td width=\"10px\"></td>\n";
	echo "<td><input type=\"checkbox\" name=\"mitigation_planned\" id=\"checkbox_mitigation_planned\"" . ($mitigation_planned == true ? " checked=\"yes\"" : "") . " onchange=\"javascript: check_mitigation_planned()\" /></td><td>" . $escaper->escapeHtml($lang['MitigationPlanned']) . "</td>\n";
	echo "<td width=\"10px\"></td>\n";
	echo "<td><input type=\"checkbox\" name=\"management_review\" id=\"checkbox_management_review\"" . ($management_review == true ? " checked=\"yes\"" : "") . " onchange=\"javascript: check_management_review()\" /></td><td>" . $escaper->escapeHtml($lang['ManagementReview']) . "</td>\n";
	echo "<td><input type=\"checkbox\" name=\"days_open\" id=\"checkbox_days_open\"" . ($days_open == true ? " checked=\"yes\"" : "") . " onchange=\"javascript: check_days_open()\" /></td><td>" . $escaper->escapeHtml($lang['DaysOpen']) . "</td>\n";
	echo "<td width=\"10px\"></td>\n";
	echo "<td><input type=\"checkbox\" name=\"next_review_date\" id=\"checkbox_next_review_date\"" . ($next_review_date == true ? " checked=\"yes\"" : "") . " onchange=\"javascript: check_next_review_date()\" /></td><td>" . $escaper->escapeHtml($lang['NextReviewDate']) . "</td>\n";
	echo "<td width=\"10px\"></td>\n";
	echo "<td><input type=\"checkbox\" name=\"next_step\" id=\"checkbox_next_step\"" . ($next_step == true ? " checked=\"yes\"" : "") . " onchange=\"javascript: check_next_step()\" /></td><td>" . $escaper->escapeHtml($lang['NextStep']) . "</td>\n";
	echo "<td width=\"10px\"></td>\n";
	echo "<td></td><td></td>\n";
	echo "</table>\n";
        echo "</div>\n";
        echo "</div>\n";

	echo "</div>\n";
	echo "</form>\n";
}

/************************************************
 * FUNCTION: DISPLAY SIMPLE AUTOCOMPLETE SCRIPT *
 ************************************************/
function display_simple_autocomplete_script($assets)
{
	global $escaper;

        echo "<script>\n";
        echo "  $(function() {\n";
        echo "    var availableAssets = [\n";

        // For each asset
        foreach ($assets as $asset)
        {
                // Display the asset name as an available asset
                echo "      \"" . $escaper->escapeHtml($asset['name']) . "\",\n";
        }

        echo "    ];\n";
        echo "    function split( val ) {\n";
        echo "      return val.split( /,\s*/ );\n";
        echo "    }\n";
        echo "    function extractLast( term ) {\n";
        echo "      return split( term ).pop();\n";
        echo "    }\n";
        echo "    $( \"#asset_name\" )\n";
        echo "      // don't navigate away from the field on tab when selecting an item\n";
        echo "      .bind( \"keydown\", function( event ) {\n";
        echo "        if ( event.keyCode === $.ui.keyCode.TAB && $( this ).autocomplete( \"instance\" ).menu.active ) {\n";
        echo "          event.preventDefault();\n";
        echo "        }\n";
        echo "      })\n";
        echo "      .autocomplete({\n";
        echo "        minLength: 0,\n";
        echo "        source: function( request, response ) {\n";
        echo "        // delegate back to autocomplete, but extract the last term\n";
        echo "        response( $.ui.autocomplete.filter(\n";
        echo "        availableAssets, extractLast( request.term ) ) );\n";
        echo "      },\n";
        echo "      select: function( event, ui ) {\n";
        echo "        var terms = split( this.value );\n";
        echo "        // remove the current input\n";
        echo "        terms.pop();\n";
        echo "        // add the selected item\n";
        echo "        terms.push( ui.item.value );\n";
        echo "        return false;\n";
        echo "      }\n";
        echo "    });\n";
        echo "  });\n";
        echo "</script>\n";
}

/***********************************************
 * FUNCTION: DISPLAY ASSET AUTOCOMPLETE SCRIPT *
 ***********************************************/
function display_asset_autocomplete_script($assets)
{
	global $escaper;

	echo "<script>\n";
	echo "  $(function() {\n";
        echo "    var availableAssets = [\n";

	// For each asset
	foreach ($assets as $asset)
	{
		// Display the asset name as an available asset
		echo "      \"" . $escaper->escapeHtml($asset['name']) . "\",\n";
	}

        echo "    ];\n";
        echo "    function split( val ) {\n";
        echo "      return val.split( /,\s*/ );\n";
        echo "    }\n";
        echo "    function extractLast( term ) {\n";
        echo "      return split( term ).pop();\n";
        echo "    }\n";
        echo "    $( \"#assets\" )\n";
        echo "      // don't navigate away from the field on tab when selecting an item\n";
        echo "      .bind( \"keydown\", function( event ) {\n";
        echo "        if ( event.keyCode === $.ui.keyCode.TAB && $( this ).autocomplete( \"instance\" ).menu.active ) {\n";
        echo "          event.preventDefault();\n";
        echo "        }\n";
        echo "      })\n";
        echo "      .autocomplete({\n";
        echo "        minLength: 0,\n";
        echo "        source: function( request, response ) {\n";
        echo "        // delegate back to autocomplete, but extract the last term\n";
        echo "        response( $.ui.autocomplete.filter(\n";
        echo "        availableAssets, extractLast( request.term ) ) );\n";
        echo "      },\n";
        echo "      focus: function() {\n";
        echo "        // prevent value inserted on focus\n";
        echo "        return false;\n";
        echo "      },\n";
        echo "      select: function( event, ui ) {\n";
        echo "        var terms = split( this.value );\n";
        echo "        // remove the current input\n";
        echo "        terms.pop();\n";
        echo "        // add the selected item\n";
        echo "        terms.push( ui.item.value );\n";
        echo "        // add placeholder to get the comma-and-space at the end\n";
        echo "        terms.push( \"\" );\n";
        echo "        this.value = terms.join( \", \" );\n";
        echo "        return false;\n";
        echo "      }\n";
        echo "    });\n";
        echo "  });\n";
    	echo "</script>\n";
}

?>
