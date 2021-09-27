<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();
Route::post('zoom-webhook', 'ZoomWebhookController@index')->name('zoom-webhook');

//SAAS Front routes start
Route::group(
    ['namespace' => 'SaasFront'],
    function () {
        Route::get('/', 'SaasFrontController@index')->name('index');
        Route::post('/', 'SaasFrontController@submitContact')->name('contact');
        Route::post('/company-register', 'SaasFrontController@companyRegister')->name('company-register');
        Route::get('/email-verification/{code}', 'SaasFrontController@getEmailVerification')->name('get-email-verification');
        Route::post('change-language/{code}', 'SaasFrontController@changeLanguage')->name('changeLanguage');
        Route::get('page/{slug?}', 'SaasFrontController@page')->name('page');
    }
);

//Front routes end

//Front routes start
Route::group(
    ['namespace' => 'Front', 'as' => 'jobs.'],
    function () {
        Route::get('/careers/{slug?}', 'FrontJobsController@jobOpenings')->name('jobOpenings');
        Route::post('/more-data', 'FrontJobsController@moreData')->name('more-data');
        Route::post('/search-job', 'FrontJobsController@searchJob')->name('search-job');

        Route::get('/job/{slug}', 'FrontJobsController@jobDetail')->name('jobDetail');
        Route::get('/job/{slug}/apply', 'FrontJobsController@jobApply')->name('jobApply');

        Route::get('/job-offer/{slug}', 'FrontJobOfferController@index')->name('job-offer');
        Route::post('/save-offer', 'FrontJobOfferController@saveOffer')->name('save-offer');
        Route::post('/job/saveApplication', 'FrontJobsController@saveApplication')->name('saveApplication');
        Route::post('/job/fetch-country-state', 'FrontJobsController@fetchCountryState')->name('fetchCountryState');
        /*Route::get('/redirect/linkedin', ['uses' => 'FrontJobsController@redirectToProvider', 'as' => 'social.login']);
        Route::get('/linkedin/callback', ['uses' => 'FrontJobsController@callback']);*/
        Route::get('auth/callback/{provider}', 'FrontJobsController@callback')->name('linkedinCallback');
        Route::get('auth/redirect/{provider}', 'FrontJobsController@redirect')->name('linkedinRedirect');

    }
);

//Front routes end
// Paypal IPN Confirm
Route::post('verify-billing-ipn', array('as' => 'verify-billing-ipn','uses' => 'PaypalIPNController@verifyBillingIPN'));
Route::post('/save-invoices', ['as' => 'save_webhook', 'uses' => 'StripeWebhookController@saveInvoices']);
Route::post('/save-razorpay-invoices', ['as' => 'save_razorpay-webhook', 'uses' => 'RazorpayWebhookController@saveInvoices']);
Route::get('/check-razorpay-invoices', ['as' => 'check_razorpay-webhook', 'uses' => 'RazorpayWebhookController@checkInvoices']);


// Admin routes
Route::group(['middleware' => 'auth'], function () {

    Route::post('mark-notification-read', ['uses' => 'NotificationController@markAllRead'])->name('mark-notification-read');

    // Admin routes
    Route::group(
        ['namespace' => 'Admin', 'prefix' => 'admin', 'as' => 'admin.'],
        function () {
            Route::group(['middleware' => ['active-package']], function () {
                Route::get('/dashboard', 'AdminDashboardController@index')->name('dashboard');

                Route::get('job-categories/data', 'AdminJobCategoryController@data')->name('job-categories.data');
                Route::get('job-categories/getSkills/{categoryId}', 'AdminJobCategoryController@getSkills')->name('job-categories.getSkills');
                Route::resource('job-categories', 'AdminJobCategoryController');

                //Questions
                Route::get('questions/data', 'AdminQuestionController@data')->name('questions.data');
                Route::resource('questions', 'AdminQuestionController');

                // company settings
                Route::group(
                    ['prefix' => 'settings'],
                    function () {

                        Route::get('settings/delete-account', ['as' => 'settings.delete-account', 'uses' => 'CompanySettingsController@deleteAccount']);
                        Route::post('settings/delete-account-store', ['as' => 'settings.delete-account-store', 'uses' => 'CompanySettingsController@deleteAccountStore']);
//                        Route::post('settings/delete-account-cancel', ['as' => 'settings.delete-account-cancel', 'uses' => 'ApplicationSettingsController@deleteAccountStore']);

                        Route::resource('settings', 'CompanySettingsController', ['only' => ['edit', 'update', 'index']]);

                        // Application Form routes
                        Route::resource('application-setting', 'ApplicationSettingsController');


                        // Role permission routes
                        Route::resource('settings', 'CompanySettingsController', ['only' => ['edit', 'update', 'index']]);
                        Route::post('role-permission/assignAllPermission', ['as' => 'role-permission.assignAllPermission', 'uses' => 'ManageRolePermissionController@assignAllPermission']);
                        Route::post('role-permission/removeAllPermission', ['as' => 'role-permission.removeAllPermission', 'uses' => 'ManageRolePermissionController@removeAllPermission']);
                        Route::post('role-permission/assignRole', ['as' => 'role-permission.assignRole', 'uses' => 'ManageRolePermissionController@assignRole']);
                        Route::post('role-permission/detachRole', ['as' => 'role-permission.detachRole', 'uses' => 'ManageRolePermissionController@detachRole']);
                        Route::post('role-permission/storeRole', ['as' => 'role-permission.storeRole', 'uses' => 'ManageRolePermissionController@storeRole']);
                        Route::post('role-permission/deleteRole', ['as' => 'role-permission.deleteRole', 'uses' => 'ManageRolePermissionController@deleteRole']);
                        Route::get('role-permission/showMembers/{id}', ['as' => 'role-permission.showMembers', 'uses' => 'ManageRolePermissionController@showMembers']);
                        Route::resource('role-permission', 'ManageRolePermissionController');

                        Route::resource('theme-settings', 'AdminThemeSettingsController');
                        Route::post('theme-settings/rtlTheme', ['uses' => 'AdminThemeSettingsController@rtlTheme'])->name('theme-settings.rtlTheme');
                        Route::resource('linkedin-settings', 'AdminLinkedInSettingsController');

                        Route::resource('zoom-setting', 'ZoomMeetingSettingController');
                        Route::post('zoom-setting/change-status/{id}', 'ZoomMeetingSettingController@changeStatus')->name('zoom-setting.change-status');
                    }
                );
                //zoom
                Route::get('zoom-meeting/table', 'AdminZoomMeetingController@tableView')->name('zoom-meeting.table-view');
                Route::get('zoom-meeting/data', 'AdminZoomMeetingController@data')->name('zoom-meeting.data');
                Route::get('zoom-meeting/start-meeting/{id}', 'AdminZoomMeetingController@startMeeting')->name('zoom-meeting.startMeeting');
                Route::post('zoom-meeting/cancel-meeting', 'AdminZoomMeetingController@cancelMeeting')->name('zoom-meeting.cancelMeeting');
                Route::post('zoom-meeting/end-meeting', 'AdminZoomMeetingController@endMeeting')->name('zoom-meeting.endMeeting');
                Route::post('zoom-meeting/updateOccurrence/{id}', 'AdminZoomMeetingController@updateOccurrence')->name('zoom-meeting.updateOccurrence');
                Route::resource('zoom-meeting', 'AdminZoomMeetingController');
                Route::resource('category', 'CategoryController');



                Route::get('skills/data', 'AdminSkillsController@data')->name('skills.data');
                Route::resource('skills', 'AdminSkillsController');

                Route::get('locations/data', 'AdminLocationsController@data')->name('locations.data');
                Route::resource('locations', 'AdminLocationsController');

                Route::post('jobs/refresh-date/{id}', 'AdminJobsController@refreshDate')->name('jobs.refreshDate');
                Route::get('jobs/data', 'AdminJobsController@data')->name('jobs.data');
                Route::get('jobs/application-data', 'AdminJobsController@applicationData')->name('jobs.applicationData');
                Route::post('jobs/send-emails', 'AdminJobsController@sendEmails')->name('jobs.sendEmails');
                Route::get('jobs/send-email', 'AdminJobsController@sendEmail')->name('jobs.sendEmail');
                Route::resource('jobs', 'AdminJobsController');

                Route::get('job-company/data', 'AdminJobsCompanyController@data')->name('job-company.data');
                Route::resource('job-company', 'AdminJobsCompanyController');

                Route::post('job-applications/rating-save/{id?}', 'AdminJobApplicationController@ratingSave')->name('job-applications.rating-save');
                Route::post('job-applications/viewDetails', 'AdminJobApplicationController@viewDetails')->name('job-applications.viewDetails');
                Route::get('job-applications/create-schedule/{id?}', 'AdminJobApplicationController@createSchedule')->name('job-applications.create-schedule');
                Route::post('job-applications/store-schedule', 'AdminJobApplicationController@storeSchedule')->name('job-applications.store-schedule');
                Route::get('job-applications/question/{jobID?}/{applicationId?}', 'AdminJobApplicationController@jobQuestion')->name('job-applications.question');
                Route::get('job-applications/export/{status}/{location}/{startDate}/{endDate}/{jobs}', 'AdminJobApplicationController@export')->name('job-applications.export');
                Route::get('job-applications/data', 'AdminJobApplicationController@data')->name('job-applications.data');
                Route::get('job-applications/table-view', 'AdminJobApplicationController@table')->name('job-applications.table');
                Route::post('job-applications/updateIndex', 'AdminJobApplicationController@updateIndex')->name('job-applications.updateIndex');
                Route::post('job-applications/archive-job-application/{application}', 'AdminJobApplicationController@archiveJobApplication')->name('job-applications.archiveJobApplication');
                Route::post('job-applications/unarchive-job-application/{application}', 'AdminJobApplicationController@unarchiveJobApplication')->name('job-applications.unarchiveJobApplication');
                Route::post('job-applications/add-skills/{applicationId}', 'AdminJobApplicationController@addSkills')->name('job-applications.addSkills');    
                Route::post('job-applications/get-jobs/{jobCompanyId}', 'AdminJobApplicationController@getJob')->name('job-applications.get-jobs');    
                Route::resource('job-applications', 'AdminJobApplicationController');

                Route::get('applications-archive/data', 'AdminApplicationArchiveController@data')->name('applications-archive.data');
                Route::get('applications-archive/export/{skill}', 'AdminApplicationArchiveController@export')->name('applications-archive.export');
                Route::resource('applications-archive', 'AdminApplicationArchiveController');
    
                Route::get('job-onboard/data', 'AdminJobOnboardController@data')->name('job-onboard.data');
                Route::get('job-onboard/send-offer/{id?}', 'AdminJobOnboardController@sendOffer')->name('job-onboard.send-offer');
                Route::get('job-onboard/update-status/{id?}', 'AdminJobOnboardController@updateStatus')->name('job-onboard.update-status');
                Route::resource('job-onboard', 'AdminJobOnboardController');

                Route::resource('profile', 'AdminProfileController');
                Route::resource('application-status', 'AdminApplicationStatusController');

                Route::get('interview-schedule/data', 'InterviewScheduleController@data')->name('interview-schedule.data');
                Route::get('interview-schedule/table-view', 'InterviewScheduleController@table')->name('interview-schedule.table-view');
                Route::post('interview-schedule/change-status', 'InterviewScheduleController@changeStatus')->name('interview-schedule.change-status');
                Route::post('interview-schedule/change-status-multiple', 'InterviewScheduleController@changeStatusMultiple')->name('interview-schedule.change-status-multiple');
                Route::get('interview-schedule/notify/{id}/{type}', 'InterviewScheduleController@notify')->name('interview-schedule.notify');
                Route::get('interview-schedule/response/{id}/{type}', 'InterviewScheduleController@employeeResponse')->name('interview-schedule.response');
                Route::resource('interview-schedule', 'InterviewScheduleController');

                Route::get('team/data', 'AdminTeamController@data')->name('team.data');
                Route::post('team/change-role', 'AdminTeamController@changeRole')->name('team.changeRole');
                Route::resource('team', 'AdminTeamController');

                Route::resource('applicant-note', 'ApplicantNoteController');
                Route::resource('sticky-note', 'AdminStickyNotesController');

                Route::resource('departments', 'AdminDepartmentController');

                Route::resource('designations', 'AdminDesignationController');

                Route::get('documents/data', 'AdminDocumentController@data')->name('documents.data');
                Route::get('documents/download-document/{document}', 'AdminDocumentController@downloadDoc')->name('documents.downloadDoc');
                Route::resource('documents', 'AdminDocumentController');
            });

            Route::get('paypal-recurring', array('as' => 'paypal-recurring','uses' => 'AdminPaypalController@payWithPaypalRecurrring',));
            Route::get('paypal-invoice-download/{id}', array('as' => 'paypal.invoice-download','uses' => 'AdminPaypalController@paypalInvoiceDownload',));

            // route for view/blade file
            Route::get('paywithpaypal', array('as' => 'paywithpaypal','uses' => 'AdminPaypalController@payWithPaypal',));
            // route for post request
            Route::get('paypal/{packageId}/{type}', array('as' => 'paypal','uses' => 'AdminPaypalController@paymentWithpaypal',));
            Route::get('paypal/cancel-subscription', array('as' => 'paypal.cancel-subscription','uses' => 'AdminPaypalController@cancelSubscription',));
            Route::get('paypal/cancel-agreement', array('as' => 'paypal.cancel-agreement','uses' => 'AdminPaypalController@cancelAgreement',));

            // route for check status responce
            Route::get('paypal', array('as' => 'status','uses' => 'AdminPaypalController@getPaymentStatus',));
            Route::get('subscribe/invoice', 'ManageSubscriptionController@invoice')->name('subscribe.invoice');
            Route::get('subscribe/data', 'ManageSubscriptionController@data')->name('subscribe.data');
            Route::get('subscribe/history-data', 'ManageSubscriptionController@historyData')->name('subscribe.history-data');
            Route::get('subscribe/cancel-subscription/{type?}', 'ManageSubscriptionController@cancelSubscription')->name('subscribe.cancel-subscription');
            Route::post('subscribe/payment-stripe', 'ManageSubscriptionController@payment')->name('payments.stripe');
            Route::get('subscribe/select-package/{packageID}',  'ManageSubscriptionController@selectPackage')->name('subscribe.select-package');
            Route::get('subscribe/invoice-download/{invoice}', 'ManageSubscriptionController@download')->name('subscribe.invoice-download');
            Route::get('subscribe/default-invoice-download/{invoice}', 'ManageSubscriptionController@invoiceDownload')->name('subscribe.default-invoice-download');
            Route::get('subscribe/paypal-invoice-download/{id}', array('as' => 'subscribe.paypal-invoice-download','uses' => 'ManageSubscriptionController@paypalInvoiceDownload',));
            Route::get('subscribe/history', array('as' => 'subscribe.history','uses' => 'ManageSubscriptionController@history',));
            Route::get('subscribe/razorpay-invoice-download/{id}', 'ManageSubscriptionController@razorpayInvoiceDownload')->name('subscribe.razorpay-invoice-download');
            Route::post('subscribe/razorpay-payment',  'ManageSubscriptionController@razorpayPayment')->name('subscribe.razorpay-payment');
            Route::post('subscribe/razorpay-subscription',  'ManageSubscriptionController@razorpaySubscription')->name('subscribe.razorpay-subscription');
            Route::resource('subscribe', 'ManageSubscriptionController');

            Route::post('todo-items/update-todo-item', 'AdminTodoItemController@updateTodoItem')->name('todo-items.updateTodoItem');
            Route::resource('todo-items', 'AdminTodoItemController');
            Route::resource('report', 'AdminReportController');
        }
    );
    
    Route::group(
        ['namespace' => 'SuperAdmin', 'prefix' => 'super-admin', 'as' => 'superadmin.', 'middleware' => ['super-admin']],
        function () {
            Route::resource('profile', 'SuperAdminProfileController');
            Route::resource('dashboard', 'SuperAdminDashboardController');
            Route::get('smtp-settings/sent-test-email', ['uses' => 'SuperAdminSmtpSettingController@sendTestEmail'])->name('smtp-settings.sendTestEmail');
            Route::resource('smtp-settings', 'SuperAdminSmtpSettingController');

            //language settings
            Route::post('language-settings/change-language', ['uses' => 'LanguageSettingsController@changeLanguage'])->name('language-settings.change-language');
            Route::put('language-settings/change-language-status/{id}', 'LanguageSettingsController@changeStatus')->name('language-settings.changeStatus');
            Route::resource('language-settings', 'LanguageSettingsController');

            Route::resource('theme-settings', 'SuperAdminThemeSettingsController')
            ;
            Route::post('theme-settings/rtlTheme', ['uses' => 'SuperAdminThemeSettingsController@rtlTheme'])->name('theme-settings.rtlTheme');
            Route::put('footer-settings/update-footer-menu/{id}', 'SuperAdminFooterSettingsController@updateFooterMenu')->name('footer-settings.updateFooterMenu');
            Route::post('footer-settings/store-footer-menu', 'SuperAdminFooterSettingsController@storeFooterMenu')->name('footer-settings.storeFooterMenu');
            Route::get('footer-settings/data', 'SuperAdminFooterSettingsController@data')->name('footer-settings.data');
            Route::resource('footer-settings', 'SuperAdminFooterSettingsController');

            Route::post('update-application/deleteFile', ['uses' => 'UpdateApplicationController@deleteFile'])->name('update-application.deleteFile');
            Route::get('update-application/update', ['as' => 'update-application.updateApp', 'uses' => 'UpdateApplicationController@update']);
            Route::get('update-application/download', ['as' => 'update-application.download', 'uses' => 'UpdateApplicationController@download']);
            Route::get('update-application/downloadPercent', ['as' => 'update-application.downloadPercent', 'uses' => 'UpdateApplicationController@downloadPercent']);
            Route::get('update-application/checkIfFileExtracted', ['as' => 'update-application.checkIfFileExtracted', 'uses' => 'UpdateApplicationController@checkIfFileExtracted']);
            Route::get('update-application/install', ['as' => 'update-application.install', 'uses' => 'UpdateApplicationController@install']);
            Route::resource('update-application', 'UpdateApplicationController');


            Route::post('company/updateCompanyPackage/{id}', 'SuperAdminCompanyController@updateCompanyPackage')->name('company.updateCompanyPackage');
            Route::get('company/changePackage/{id}', 'SuperAdminCompanyController@changePackage')->name('company.changePackage');
            Route::get('company/data', 'SuperAdminCompanyController@data')->name('company.data');
            Route::post('company/{id}/login', 'SuperAdminCompanyController@loginAsCompany')->name('company.loginAsCompany');
            Route::resource('company', 'SuperAdminCompanyController');

            Route::resource('global-settings', 'GlobalSettingController');
            Route::get('linkedin-settings/update-status/{id}', 'LinkedInSettingController@updateStatus')->name('updateStatus');
            Route::resource('linkedin-settings', 'LinkedInSettingController');

            Route::get('front-cms/index', ['as' => 'front-cms.index', 'uses' => 'SuperAdminFrontCmsController@index']);
            Route::get('front-cms/common', ['as' => 'front-cms.common', 'uses' => 'SuperAdminFrontCmsController@commonSetting']);
            Route::get('front-cms/change-form', 'SuperAdminFrontCmsController@changeForm')->name('front-cms.changeForm');
            Route::post('front-cms/update-common-header', ['as' => 'front-cms.updateCommonHeader', 'uses' => 'SuperAdminFrontCmsController@updateCommonHeader']);
            Route::post('front-cms/update-header', ['as' => 'front-cms.updateHeader', 'uses' => 'SuperAdminFrontCmsController@updateHeader']);
            Route::get('front-cms/features', ['as' => 'front-cms.features', 'uses' => 'SuperAdminFrontCmsController@imageFeatures']);
            Route::post('front-cms/features', ['as' => 'front-cms.savefeatures', 'uses' => 'SuperAdminFrontCmsController@saveImageFeatures']);
            Route::post('front-cms/features/{id}', ['as' => 'front-cms.updatefeatures', 'uses' => 'SuperAdminFrontCmsController@updatefeatures']);
            Route::get('front-cms/features/{id}', ['as' => 'front-cms.editfeatures', 'uses' => 'SuperAdminFrontCmsController@editImageFeatures']);
            Route::post('front-cms/deleteFeature/{id}', ['as' => 'front-cms.deleteFeature', 'uses' => 'SuperAdminFrontCmsController@deleteFeature']);

            Route::resource('icon-features', 'FrontIconFeatureController');

            Route::resource('client-feedbacks', 'ClientFeedbackController');

            Route::resource('packages', 'PackageController');
            Route::resource('currency-settings', 'SuperAdminCurrencyController');
            Route::resource('/payment-settings', 'SuperAdminPaymentSettingsController', ['only' => ['index', 'update']]);
            Route::resource('/sms-settings', 'SuperAdminSmsSettingsController', ['only' => ['index', 'update']]);

            Route::get('invoices/invoice-download/{invoice}', 'InvoiceController@download')->name('invoices.invoice-download');
            Route::get('invoices/paypal-invoice-download/{id}', array('as' => 'invoices.paypal-invoice-download','uses' => 'InvoiceController@paypalInvoiceDownload',));
            Route::get('invoices/razorpay-invoice-download/{id}', 'InvoiceController@razorpayInvoiceDownload')->name('invoices.razorpay-invoice-download');
            Route::get('invoices/data', 'InvoiceController@data')->name('invoices.data');

            Route::resource('invoices', 'InvoiceController');

            // Custom Modules
            Route::post('custom-modules/verify-purchase', ['uses' => 'CustomModuleController@verifyingModulePurchase'])->name('custom-modules.verify-purchase');
            Route::resource('custom-modules', 'CustomModuleController');
            
            Route::get('superadmins/data', 'SuperadminController@data')->name('superadmins.data');
            Route::resource('superadmins', 'SuperadminController');
        }
    );

    Route::get('change-mobile', 'VerifyMobileController@changeMobile')->name('changeMobile');
    Route::post('/send-otp-code', 'VerifyMobileController@sendVerificationCode')->name('sendOtpCode');
    Route::post('/send-otp-code/account', 'VerifyMobileController@sendVerificationCode')->name('sendOtpCode.account');
    Route::post('/verify-otp-phone', 'VerifyMobileController@verifyOtpCode')->name('verifyOtpCode');
    Route::post('/verify-otp-phone/account', 'VerifyMobileController@verifyOtpCode')->name('verifyOtpCode.account');
    Route::get('/remove-session', 'VerifyMobileController@removeSession')->name('removeSession');
});
