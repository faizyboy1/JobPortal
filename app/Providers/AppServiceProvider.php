<?php

namespace App\Providers;

use App\ApplicationStatus;
use App\Company;
use App\Department;
use App\Designation;
use App\Document;
use App\FrontCmsHeader;
use App\FrontImageFeature;
use App\InterviewSchedule;
use App\InterviewScheduleEmployee;
use App\JobApplication;
use App\JobApplicationAnswer;
use App\JobCategory;
use App\JobLocation;
use App\JobQuestion;
use App\JobSkill;
use App\Job;
use App\Observers\ApplicationStatusObserver;
use App\Observers\CompanyObserver;
use App\Observers\DepartmentObserver;
use App\Observers\DesignationObserver;
use App\Observers\DocumentObserver;
use App\Observers\FrontCmsHeaderObserver;
use App\Observers\FrontImageFeatureObserver;
use App\Observers\InterviewScheduleCommentObserver;
use App\Observers\InterviewScheduleEmployeeObserver;
use App\Observers\InterviewScheduleObserver;
use App\Observers\JobApplicationAnswerObserver;
use App\Observers\JobApplicationObserver;
use App\Observers\JobCategoryObserver;
use App\Observers\JobLocationObserver;
use App\Observers\JobObserver;
use App\Observers\JobQuestionObserver;
use App\Observers\JobSkillObserver;
use App\Observers\OnBoardFilesObserver;
use App\Observers\OnBoardObserver;
use App\Observers\QuestionObserver;
use App\Observers\RoleObserver;
use App\Observers\SkillObserver;
use App\Observers\ThemeSettingObserver;
use App\Observers\TodoItemObserver;
use App\Observers\UserObserver;
use App\Observers\ZoomCategoryObserver;
use App\Observers\ZoomMeetingObserver;
use App\Observers\ZoomSettingObserver;
use App\Onboard;
use App\OnboardFiles;
use App\Question;
use App\Role;
use App\ScheduleComments;
use App\Skill;
use App\ThemeSetting;
use App\TodoItem;
use App\User;
use App\ZoomMeeting;
use App\ZoomSetting;
use App\Category;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Laravel\Cashier\Cashier;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (env('REDIRECT_HTTPS')) {
            \URL::forceScheme('https');
        }
        Schema::defaultStringLength(191);
        FrontCmsHeader::observe(FrontCmsHeaderObserver::class);
        Company::observe(CompanyObserver::class);
        ScheduleComments::observe(InterviewScheduleCommentObserver::class);
        InterviewScheduleEmployee::observe(InterviewScheduleEmployeeObserver::class);
        InterviewSchedule::observe(InterviewScheduleObserver::class);
        JobApplicationAnswer::observe(JobApplicationAnswerObserver::class);
        JobApplication::observe(JobApplicationObserver::class);
        JobCategory::observe(JobCategoryObserver::class);
        JobLocation::observe(JobLocationObserver::class);
        JobQuestion::observe(JobQuestionObserver::class);
        JobSkill::observe(JobSkillObserver::class);
        Job::observe(JobObserver::class);
        Question::observe(QuestionObserver::class);
        Role::observe(RoleObserver::class);
        Skill::observe(SkillObserver::class);
        ThemeSetting::observe(ThemeSettingObserver::class);
        User::observe(UserObserver::class);
        ApplicationStatus::observe(ApplicationStatusObserver::class);
        FrontImageFeature::observe(FrontImageFeatureObserver::class);
        Department::observe(DepartmentObserver::class);
        Designation::observe(DesignationObserver::class);
        Onboard::observe(OnBoardObserver::class);
        OnboardFiles::observe(OnBoardFilesObserver::class);
        TodoItem::observe(TodoItemObserver::class);
        Document::observe(DocumentObserver::class);
        Category::observe(ZoomCategoryObserver::class);
        ZoomMeeting::observe(ZoomMeetingObserver::class);
        ZoomSetting::observe(ZoomSettingObserver::class);


        Validator::extend('sub_domain', function ($attribute, $value, $parameters, $validator) {
            $value = explode('.'.get_domain(), $value)[0];
            return preg_match('/[^A-Za-z0-9]+/i', $value) === 0;
        }, 'The :attribute can only contain alphabets and numbers');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Cashier::ignoreMigrations();
    }
}
