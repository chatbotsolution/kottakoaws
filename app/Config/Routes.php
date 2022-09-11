<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('home', 'Home::index');

$myroutes = [];

$myroutes['aboutus'] = 'Home::aboutus';
$myroutes['service'] = 'Home::service';
$myroutes['blog'] = 'Home::blog';
$myroutes['contact'] = 'Home::contact';
$myroutes['sales'] = 'Home::sales';
$myroutes['salesagent'] = 'Home::salesAgent';
$myroutes['teamlead'] = 'Home::teamlead';
$myroutes['login'] = 'Home::login';

/*------------------------ADMIN PANEL-----------------------*/
$myroutes['adminLogin'] = 'AdminLoginController::index';
$myroutes['officialLogin'] = 'AdminLoginController::official';
$myroutes['logout'] = 'AdminLoginController::logout';
$myroutes['secure/dashboard'] = 'AdminDashboardController::index';
$myroutes['secure/permissionletterrequest'] = 'AdminDashboardController::letterrequest';
//i add a route for downlaod the database
$myroutes['secure/downloaddatabase'] = 'AdminDashboardController::downloaddatabase'; 
//---------------------------------------------------------------------------
$myroutes['secure/addsalesmanager'] = 'SalesManagerController::addSalesManager';
$myroutes['secure/managesalesmanager'] = 'SalesManagerController::manageSalesManager';
$myroutes['secure/addfastag'] = 'FastTagController::index';
$myroutes['secure/addfastagexcel'] = 'FastTagController::uploadCSV';
$myroutes['secure/managefasttag'] = 'FastTagController::managefasttag';

//sales territory route
$myroutes['secure/salesterritory'] = 'SalesTerritoryController::salesterritory';//////////////////////////////////////////////////////////////////////////
$myroutes['secure/managesalesterritory'] = 'SalesTerritoryController::managesalesterritory';
$myroutes['secure/salesterritoryexcel'] = 'SalesTerritoryController::uploadCSV';

$myroutes['secure/managefasttag/(:any)'] = 'FastTagController::managefasttagspecific/$1';

$myroutes['secure/classofbarcode'] = 'FastTagController::classofbarcode';
$myroutes['secure/addoem'] = 'OEMController::index';
$myroutes['secure/manageoem'] = 'OEMController::managemanageoem';
$myroutes['secure/editoem/(:any)'] = 'OEMController::editProfileAdmin/$1';
$myroutes['secure/updtoemstatus/(:any)/(:any)'] = 'OEMController::updateStatus/$1/$2';
$myroutes['secure/manageoem/(:any)'] = 'OEMController::viewoemProfile/$1';
$myroutes['secure/approveoem'] = 'OEMController::oemAproval';
$myroutes['secure/editProfile'] = 'profileController::editProfile';
$myroutes['secure/Profile'] = 'profileController::viewProfile';
$myroutes['secure/addofficialuser'] = 'OfficialUserController::addOfficialUsers';
$myroutes['secure/editofficialusers/(:any)'] = 'OfficialUserController::editOfficialUsers/$1';

$myroutes['secure/manageofficialuser'] = 'OfficialUserController::manageusers';
$myroutes['secure/updateofficialuser/(:any)/(:any)'] = 'OfficialUserController::updateStatus/$1/$2';
$myroutes['secure/passwork'] = 'OfficialUserController::updtPass';
$myroutes['admin/profileview/(:any)/(:any)'] = 'AllViewProfileController::viewProfile/$1/$2';
$myroutes['secure/approveteamlead'] = 'TeamLeadController::adminAproval';
$myroutes['secure/manageteamlead'] = 'TeamLeadController::manageTeamLeadAdmin';

$myroutes['secure/approvesalesagent'] = 'SalesAgentController::adminAproval';
$myroutes['secure/managesalesagent'] = 'SalesAgentController::manageSalesAgentAdmin';
$myroutes['secure/updtsalesagentstatus/(:any)/(:any)'] = 'SalesAgentController::updateStatus/$1/$2';
$myroutes['secure/managesalesagent/(:any)'] = 'SalesAgentController::viewoemProfile/$1';
$myroutes['secure/editsalesagent/(:any)'] = 'SalesAgentController::editProfileAdmin/$1';


$myroutes['secure/updtfasttag/(:any)/(:any)'] = 'FastTagController::updateStatus/$1/$2';
$myroutes['secure/updtsalesmanager/(:any)/(:any)'] = 'SalesManagerController::updateStatus/$1/$2';

$myroutes['secure/managesalesmanager/(:any)'] = 'SalesManagerController::viewsalesmanagerProfile/$1';
$myroutes['secure/editsalesmanager/(:any)'] = 'SalesManagerController::editProfileAdmin/$1';

$myroutes['secure/manageteamlead/(:any)'] = 'TeamLeadController::viewteamleadProfile/$1';
$myroutes['secure/updtstatus/(:any)/(:any)'] = 'TeamLeadController::updateStatus/$1/$2';
$myroutes['secure/updtstatusothr/(:any)/(:any)'] = 'TeamLeadController::updateStatus1/$1/$2';
$myroutes['secure/editteamlead/(:any)'] = 'TeamLeadController::editProfileAdmin/$1';

$myroutes['secure/addProduct'] = 'ProductController::index';
$myroutes['secure/manageProduct'] = 'ProductController::manageproduct';
$myroutes['secure/updtproduct/(:any)/(:any)'] = 'ProductController::updateStatus/$1/$2';
$myroutes['secure/editproduct/(:any)'] = 'ProductController::editproduct/$1';

$myroutes['secure/otplist/(:any)'] = 'AdminDashboardController::otplist/$1';

$myroutes['secure/addpayment/(:any)'] = 'AdminDashboardController::addpayment/$1';
$myroutes['secure/returntag'] = 'FastTagController::returntag';
$myroutes['secure/regstrdnumfstg'] = 'FastTagController::regstrdnumfstg';
$myroutes['secure/managewallet'] = 'AdminDashboardController::walletactivation';

$myroutes['secure/manageallwallet'] = 'SalesAgentWalletController::viewwalletdata';
$myroutes['secure/manageallwallet/(:any)'] = 'SalesAgentWalletController::manageshowdata/$1';

$myroutes['secure/newuserdata'] = 'DataDashboardController::newusrdata';
$myroutes['secure/existinguserdata'] = 'DataDashboardController::existingusrdata';

$myroutes['secure/vehclupdtreqst'] = 'OEMVehicleNoUpdateController::viewupdtata';

$myroutes['secure/oemstockrequest'] = 'OEMController::oemtagreqst';
$myroutes['secure/updtreqstoemstatus/(:any)/(:any)'] = 'OEMController::updaterequestStatus/$1/$2';

$myroutes['secure/manufacturer'] = 'AdminDashboardController::manufacturer';
$myroutes['secure/updatestatus/(:any)/(:any)'] = 'AdminDashboardController::updateStatus/$1/$2';

$myroutes['secure/newcustomer'] = 'AdminReportController::newCustomer';
$myroutes['secure/smreportdetails/(:any)'] = 'AdminReportController::smreportdetails/$1';
$myroutes['secure/tlreportdetails/(:any)'] = 'AdminReportController::tlreportdetails/$1';
$myroutes['secure/sareportdetails/(:any)'] = 'AdminReportController::sareportdetails/$1';

$myroutes['secure/existingcustomer'] = 'AdminReportController::existingCustomer';
$myroutes['secure/smextreportdetails/(:any)'] = 'AdminReportController::smextreportdetails/$1';
$myroutes['secure/tlextreportdetails/(:any)'] = 'AdminReportController::tlextreportdetails/$1';
$myroutes['secure/saextreportdetails/(:any)'] = 'AdminReportController::saextreportdetails/$1';

$myroutes['secure/customerdownload/(:any)'] = 'AdminReportController::customerdownload/$1';
$myroutes['secure/smdownload/(:any)/(:any)'] = 'AdminReportController::smdownload/$1/$2';
$myroutes['secure/tldownload/(:any)/(:any)'] = 'AdminReportController::tldownload/$1/$2';
$myroutes['secure/sadownload/(:any)/(:any)'] = 'AdminReportController::sadownload/$1/$2';

$myroutes['secure/sasrchdownload/(:any)/(:any)/(:any)/(:any)'] = 'AdminReportController::sasrchdownload/$1/$2/$3/$4';
$myroutes['secure/tlsrchdownload/(:any)/(:any)/(:any)/(:any)'] = 'AdminReportController::tlsrchdownload/$1/$2/$3/$4';
$myroutes['secure/smsrchdownload/(:any)/(:any)/(:any)/(:any)'] = 'AdminReportController::smsrchdownload/$1/$2/$3/$4';
$myroutes['secure/customersrchdownload/(:any)/(:any)/(:any)'] = 'AdminReportController::customersrchdownload/$1/$2/$3';

$myroutes['secure/managepincode'] = 'AdminDashboardController::managepincode';


$myroutes['secure/requestid'] = 'IciciBankController::adminrequestid';
$myroutes['secure/iciciwallet'] = 'IciciBankController::adminwallet';

/*--------------------------SALES MANAGER----------------------*/

$myroutes['salesmanagerLogin'] = 'SalesManagerController::index';
$myroutes['salesmanager/logout'] = 'SalesManagerController::logout';
$myroutes['salesmanager/sendotp'] = 'SalesManagerController::sendotp';
$myroutes['salesmanager/fastaginventory'] = 'SalesManagerController::fastagInventory';
$myroutes['salesmanager/dashboard'] = 'SalesManagerDashboardController::index';
$myroutes['salesmanager/requestoem'] = 'SalesManagerOEMController::index';
$myroutes['salesmanager/viewrequestedoem'] = 'SalesManagerOEMController::viewoem';
$myroutes['salesmanager/editprofile'] = 'SalesManagerProfileController::editProfile';
$myroutes['salesmanager/profile'] = 'SalesManagerProfileController::viewProfile';
$myroutes['salesmanager/viewrequestedoem/(:any)'] = 'SalesManagerOEMController::viewoemid/$1';
$myroutes['salesmanager/addteamlead'] = 'TeamLeadController::addTeamLead';
$myroutes['salesmanager/manageteamlead'] = 'TeamLeadController::manageTeamLead';
$myroutes['salesmanager/manageteamlead/(:any)'] = 'TeamLeadController::viewteamleadProfile/$1';
$myroutes['salesmanager/managesalesagent'] = 'SalesAgentController::managesalesagent';
$myroutes['salesmanager/managesalesagent/(:any)'] = 'SalesAgentController::viewoemProfile/$1';
$myroutes['salesmanager/approvesalesagent'] = 'SalesAgentController::salesManagerAproval';
$myroutes['salesmanager/updtsalesagentstatus/(:any)/(:any)'] = 'SalesAgentController::updateStatus1/$1/$2';
$myroutes['salesmanager/fastaginventory/(:any)'] = 'SalesManagerController::managefasttagspecific/$1';


$myroutes['salesmanager/tagrequest'] = 'SalesAgentController::satagreqst';
$myroutes['salesmanager/updtreqstoemstatus/(:any)/(:any)'] = 'SalesAgentController::updaterequestStatus/$1/$2';

$myroutes['salesmanager/newcustomerreport'] = 'SalesManagerReportController::smteamleadreport';
$myroutes['salesmanager/newcustomertlreport/(:any)'] = 'SalesManagerReportController::newcustomertl/$1';
$myroutes['salesmanager/newcustomerreport/(:any)'] = 'SalesManagerReportController::individualagentreport/$1';
$myroutes['salesmanager/downloadreportnewtl'] = 'SalesManagerReportController::downloadtl';
$myroutes['salesmanager/downloadindvtl/(:any)'] = 'SalesManagerReportController::downloadindvtl/$1';
$myroutes['salesmanager/downloadreportindvl/(:any)'] = 'SalesManagerReportController::downloadreportindvl/$1';

$myroutes['salesmanager/existingcustomerreport'] = 'SalesManagerReportController::existingtl';
$myroutes['salesmanager/downloadreportexestngtl'] = 'SalesManagerReportController::downloadexttl';
$myroutes['salesmanager/existingcustomertlreport/(:any)'] = 'SalesManagerReportController::existingcustomertl/$1';
$myroutes['salesmanager/downloadindvtlexisting/(:any)'] = 'SalesManagerReportController::downloadindvtlexisting/$1';
$myroutes['salesmanager/existingcustomerreport/(:any)'] = 'SalesManagerReportController::individualagentreportexisting/$1';
$myroutes['salesmanager/downloadreportindvlext/(:any)'] = 'SalesManagerReportController::downloadreportindvlext/$1';

$myroutes['salesmanager/searchdate/(:any)'] = 'SalesManagerReportController::searchdata/$1';
$myroutes['salesmanager/downloadreportextindvdte/(:any)/(:any)/(:any)'] = 'SalesManagerReportController::downloadreportextcustomerindvdate/$1/$2/$3';
$myroutes['salesmanager/searchdate/(:any)'] = 'SalesManagerReportController::newcustomersrch/$1';
$myroutes['salesmanager/downloadreportnewdate/(:any)/(:any)/(:any)'] = 'SalesManagerReportController::downloadreportnewcustomerdate/$1/$2/$3';
$myroutes['salesmanager/searchh'] = 'SalesManagerReportController::searchh';

$myroutes['salesmanager/searchhdownload/(:any)/(:any)'] = 'SalesManagerReportController::searchhdownload/$1/$2';
$myroutes['salesmanager/searchhext'] = 'SalesManagerReportController::searchhext';
$myroutes['salesmanager/srchhindvext/(:any)'] = 'SalesManagerReportController::individualagentreportexistingext/$1';
$myroutes['salesmanager/downloadreportinext/(:any)/(:any)/(:any)'] = 'SalesManagerReportController::downloadreportinext/$1/$2/$3';
$myroutes['salesmanager/existingcustomertlextreport/(:any)'] = 'SalesManagerReportController::existingcustomertlext/$1';
$myroutes['salesmanager/existingcustomertlextreportdwn/(:any)/(:any)/(:any)'] = 'SalesManagerReportController::downloadindvtlexistingdwn/$1/$2/$3';
$myroutes['salesmanager/searchhdownloadext/(:any)/(:any)'] = 'SalesManagerReportController::searchhdownloadext/$1/$2';


/*---------------------------TEAM LEAD-------------------------------*/

$myroutes['teamleadLogin'] = 'TeamLeadController::index';
$myroutes['teamlead/logout'] = 'TeamLeadController::logout';
$myroutes['teamlead/sendotp'] = 'TeamLeadController::sendotp';
$myroutes['teamlead/fastaginventory'] = 'TeamLeadController::fastagInventory';
$myroutes['teamlead/dashboard'] = 'TeamLeadDashboardController::index';
$myroutes['teamlead/addsalesagent'] = 'SalesAgentController::addSalesAgent';
$myroutes['teamlead/managesalesagent'] = 'SalesAgentController::manageSalesAgent';
$myroutes['teamlead/managesalesagent/(:any)'] = 'SalesAgentController::viewoemProfile/$1';
$myroutes['teamlead/editprofile'] = 'TeamLeadProfileController::editProfile';
$myroutes['teamlead/profile'] = 'TeamLeadProfileController::viewProfile';

$myroutes['teamlead/fastaginventory/(:any)'] = 'TeamLeadController::managefasttagspecific/$1';

$myroutes['teamlead/getbalance'] = 'TeamLeadReportController::getBalance';

$myroutes['teamlead/newcustomerreport'] = 'TeamLeadReportController::newcustomer';
$myroutes['teamlead/existingcustomerreport'] = 'TeamLeadReportController::existingcustomer';

$myroutes['teamlead/newcustomerreport/(:any)'] = 'TeamLeadReportController::individualagentreport/$1';
$myroutes['teamlead/existingcustomerreport/(:any)'] = 'TeamLeadReportController::individualagentexereport/$1';

$myroutes['teamlead/downloadreportnew'] = 'TeamLeadReportController::downloadreportnewcustomer';
$myroutes['teamlead/downloadreportext'] = 'TeamLeadReportController::downloadreportexestingcustomer';

$myroutes['teamlead/downloadreportnewindv/(:any)'] = 'TeamLeadReportController::downloadreportnewcustomerindv/$1';
$myroutes['teamlead/downloadreportextindv/(:any)'] = 'TeamLeadReportController::downloadreportextcustomerindv/$1';
$myroutes['teamlead/searchdate/(:any)'] = 'TeamLeadReportController::searchdata/$1';
$myroutes['teamlead/searchdateii/(:any)/(:any)/(:any)'] = 'TeamLeadReportController::searchdataii/$1/$2/$3';

$myroutes['teamlead/downloadreportextindvdte/(:any)/(:any)/(:any)'] = 'TeamLeadReportController::downloadreportextcustomerindvdate/$1/$2/$3';
$myroutes['teamlead/downloadreportnewdate/(:any)/(:any)'] = 'TeamLeadReportController::downloadreportnewcustomerdate/$1/$2';
$myroutes['teamlead/searchdate'] = 'TeamLeadReportController::newcustomersrch';
$myroutes['teamlead/searchdateext/(:any)'] = 'TeamLeadReportController::existingcustomersrch/$1';

$myroutes['teamlead/downloadreportextindvext/(:any)/(:any)/(:any)'] = 'TeamLeadReportController::downloadreportextcustomerindvsr/$1/$2/$3';

$myroutes['teamlead/existingcustomerreporte/(:any)/(:any)/(:any)'] = 'TeamLeadReportController::individualagentexereporte/$1/$2/$3';
$myroutes['teamlead/existingcustomerreportesrrch/(:any)/(:any)'] = 'TeamLeadReportController::downloadreportexestingcustomersrch/$1/$2';


/*---------------------------SALES AGENT-------------------------------*/

$myroutes['salesagentLogin'] = 'SalesAgentController::index';
$myroutes['salesagent/logout'] = 'SalesAgentController::logout';
$myroutes['salesagent/sendotp'] = 'SalesAgentController::sendotp';
$myroutes['salesagent/ncpitag'] = 'SalesAgentController::ncpitag';
$myroutes['salesagent/tagactivation'] = 'SalesAgentController::tagActivation';
$myroutes['salesagent/fastaginventory'] = 'SalesAgentController::fastagInventory';
$myroutes['salesagent/dashboard'] = 'SalesAgentDashboardController::index';
$myroutes['salesagent/editprofile'] = 'SalesAgentProfileController::editProfile';
$myroutes['salesagent/profile'] = 'SalesAgentProfileController::viewProfile';
$myroutes['salesagent/paymentstatus'] = 'SalesAgentController::stats';

$myroutes['salesagent/pendingtagActivation'] = 'SalesAgentController::activatepending';
$myroutes['salesagent/pendingtagActivation/(:any)'] = 'SalesAgentController::allotTags/$1';

$myroutes['salesagent/tagactivationexisting'] = 'SalesAgentController::activateexisting';
$myroutes['salesagent/activatinguser'] = 'SalesAgentController::activateexistingUsers';

$myroutes['salesagent/paymentstatusindividual'] = 'SalesAgentController::statsindividual';

$myroutes['salesagent/newcustomerreport'] = 'SalesAgentReportController::newcustomer';
$myroutes['salesagent/existingcustomerreport'] = 'SalesAgentReportController::existingcustomer';
  
$myroutes['salesagent/newtagactivation'] = 'SalesAgentTagController::newuseractivation';
$myroutes['salesagent/verifyotp'] = 'SalesAgentTagController::verifyotp';
$myroutes['salesagent/verifycustomerdetails'] = 'SalesAgentTagController::verifycustomer';
$myroutes['salesagent/allotbarcode'] = 'SalesAgentTagController::allotbarcode';
$myroutes['salesagent/finalpaymentstatus'] = 'SalesAgentTagController::paymentstatus';

$myroutes['salesagent/verifyregstrnum'] = 'SalesAgentTagController::verifyregstrnum';
$myroutes['salesagent/wallet'] = 'SalesAgentWalletController::wallet';
$myroutes['salesagent/paymentnotation'] = 'SalesAgentWalletController::paymentnotation';
$myroutes['salesagent/caceltransactions'] = 'SalesAgentTagController::cancelTrans';

$myroutes['salesagent/wallet/(:any)'] = 'SalesAgentWalletController::manageshowdatawllt/$1';

$myroutes['salesagent/successtagactivation'] = 'SalesAgentTagController::successtagactive';
$myroutes['salesagent/failedtagactivation'] = 'SalesAgentTagController::failtagactive';
$myroutes['salesagent/successv2activation'] = 'SalesAgentTagController::successv2active';

$myroutes['salesagent/requestfastag'] = 'SalesAgentDashboardController::requestfastag';

$myroutes['salesagent/downloadreportnew'] = 'SalesAgentReportController::downloadreportnewcustomer';
$myroutes['salesagent/downloadreportext'] = 'SalesAgentReportController::downloadreportexestingcustomer';

$myroutes['salesagent/customeronboarding'] = 'CustometrOnboardingController::customeronboarding';
$myroutes['salesagent/newcustomeronboarding'] = 'CustometrOnboardingController::newcustomeronboarding';
$myroutes['salesagent/existingcustomeronboarding'] = 'CustometrOnboardingController::existingcustomeronboarding';
$myroutes['salesagent/verifynewcustomeronboarding'] = 'CustometrOnboardingController::verifycustomer';
$myroutes['salesagent/allotbarcodenewcustomeronboarding'] = 'CustometrOnboardingController::allotbarcode';
$myroutes['salesagent/requestcustomeronboarding'] = 'CustometrOnboardingController::requestcustomeronboarding';

/*---------------------------ICICI Sales Agent-------------------------------*/
/* %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%% */

$myroutes['salesagent/requestid'] = 'IciciBankController::requestid';
$myroutes['salesagent/iciciwallet'] = 'IciciBankController::salesagentwallet';
$myroutes['salesagent/walletnotification'] = 'IciciBankController::walletnotification';
$myroutes['salesagent/iciciwalletpaymentsuccess'] = 'IciciBankController::successtagactive';
$myroutes['salesagent/iciciwalletpaymentfailed'] = 'IciciBankController::failtagactive';


//requestpermission routes of salesagent
$myroutes['salesagent/requestpermission'] = 'SalesAgentRequestPermissionController::requestpermission';


$myroutes['secure/fsebanner'] = 'SalesAgentDashboardController::fsebanner';

/*---------------------------OEM-------------------------------*/
/* %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%% */
$myroutes['oemLogin'] = 'OEMController::login';
$myroutes['oem/logout'] = 'OEMController::logout';
$myroutes['oem/sendotp'] = 'OEMController::sendotp';
$myroutes['oem/dashboard'] = 'OEMDashboardController::index';
$myroutes['oem/ncpitag'] = 'OEMController::ncpitag';
$myroutes['oem/tagactivation'] = 'OEMController::tagActivation';
$myroutes['oem/fastaginventory'] = 'OEMController::fastagInventory';
$myroutes['oem/editprofile'] = 'oemProfileController::editProfile';
$myroutes['oem/profile'] = 'oemProfileController::viewProfile';
$myroutes['oem/requestfastag'] = 'OEMController::requestfastag';
$myroutes['oem/topup'] = 'OEMController::topup';

//OEM VEHICLE NO. UPDATE ROUTES
$myroutes['oem/vehiclenoupdate'] = 'OEMVehicleNoUpdateController::index';
$myroutes['oem/vehiclenoupdatedata'] = 'OEMVehicleNoUpdateController::viewdata';


$myroutes['oem/newcustomerreport'] = 'OEMController::newcustomer';
$myroutes['oem/existingcustomerreport'] = 'OEMController::existingcustomer';
$myroutes['oem/tagactivationexisting'] = 'OEMTagController::activateexisting';


$myroutes['oem/newtagactivation'] = 'OEMTagController::newuseractivation';
$myroutes['oem/activatinguser'] = 'OEMTagController::activateexistingUsers';
$myroutes['oem/verifyotp'] = 'OEMTagController::verifyotp';
$myroutes['oem/verifycustomerdetails'] = 'OEMTagController::verifycustomer';
$myroutes['oem/allotbarcode'] = 'OEMTagController::allotbarcode';

$myroutes['oem/fitmenchallan/(:any)'] = 'OEMdownloadController::fitmenchallan/$1'; // this route is for the fitmenchallan
$myroutes['oem/fitmenchallanreceipt/(:any)'] = 'OEMdownloadController::fitmenchallanreceipt/$1'; // this route is for fitmenchallanreceipt


$myroutes['oem/fitmenchallann/(:any)'] = 'OEMdownloadController::fitmenchallanexisting/$1'; // this route is for the fitmenchallan
$myroutes['oem/fitmenchallannreceipt/(:any)'] = 'OEMdownloadController::fitmenchallanreceiptexisting/$1'; // this route is for fitmenchallanreceipt

$myroutes['oem/verifyregstrnum'] = 'OEMTagController::verifyregstrnum';

$myroutes['oem/downloadreportnew'] = 'OEMTagController::downloadreportnewcustomer';
$myroutes['oem/downloadreportext'] = 'OEMTagController::downloadreportexestingcustomer';
$myroutes['oem/searchdate'] = 'OEMController::searchdata';

$myroutes['oem/downloadreportnewsrch/(:any)/(:any)'] = 'OEMTagController::downloadreportnewsrch/$1/$2';
$myroutes['oem/downloadreportlstwek'] = 'OEMTagController::downloadreportlstwek';
$myroutes['oem/searchdataext'] = 'OEMController::searchdataext';

$myroutes['oem/downloadreportextsrch/(:any)/(:any)'] = 'OEMTagController::downloadreportextsrch/$1/$2';
$myroutes['oem/downloadreportlstwekext'] = 'OEMTagController::downloadreportlstwekext';





// ROUTS FOR API

$myroutes['adminapiLogin'] = 'apiController::apilogin';
$myroutes['salesagentlogin'] = 'apiController::saleagentapilogin';
$myroutes['salesagentverifyotp'] = 'apiController::saleagentapiverifyotp';
$myroutes['addbalance'] = 'apiController::addwalletbalance';
$myroutes['getwalletbalance'] = 'apiController::getwalletbalance';
$myroutes['viewinventory'] = 'apiController::fastagInventory';
$myroutes['newcustomerreport'] = 'apiController::newcustomerreport';
$myroutes['existingcustomerreport'] = 'apiController::existingcustomerreport';
$myroutes['todayactivationreport'] = 'apiController::todayactivation';
$myroutes['yesterdayactivationreport'] = 'apiController::yesterdayactivation';
$myroutes['gettranshistory'] = 'apiController::gettranshistory';
$myroutes['getfastagclass'] = 'apiController::getfastagclass';
$myroutes['fastagrequesthistory'] = 'apiController::fastagrequesthistory';
$myroutes['requestfastag'] = 'apiController::requestfastag';
$myroutes['actvateexistingcustomerr'] = 'apiController::existinguser';
$myroutes['updatetransaction'] = 'apiController::updatetransaction';
$myroutes['transactionhistory'] = 'apiController::getindvWalletTransactionHistory';

$myroutes['dashboarddata'] = 'apiController::dashboarddata';

// TAG ACTIVATION API
$myroutes['addcontactnumberr'] = 'apiController::addcontactnumber';
$myroutes['getproduct'] = 'apiController::getproduct';
$myroutes['getbarcode'] = 'apiController::getbarcode';
$myroutes['getappversion'] = 'apiController::getappversion';
$myroutes['setappversion'] = 'apiController::setappversion';


$myroutes['VIIformactivation'] = 'apiController::VIIformactivation';
$myroutes['iciciidrequest'] = 'apiController::iciciidrequest';
$myroutes['sendotpidrequest'] = 'apiController::sendotpiciciidrequest';
$myroutes['verifyotpiciciidrequest'] = 'apiController::verifyotpiciciidrequest';
$myroutes['getstatusidrequest'] = 'apiController::getstatus';
$myroutes['paymentidrequest'] = 'apiController::paymentidrequest';
$myroutes['getindividualwalletdata'] = 'apiController::getindividualwalletdata';
$myroutes['getwalletdata'] = 'apiController::getwalletdata';

$myroutes['productdetials'] = 'apiController::productclassofbarcode';
$myroutes['nametoshowdetails'] = 'apiController::nametoshowdetails';
$myroutes['getprdctdetls'] = 'apiController::getprdctdetls';
$myroutes['getpincode'] = 'apiController::getpincode';



$routes->map($myroutes);


/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
